<?php
/**
 * Self-hosted theme updates from GitHub Releases.
 *
 * Goal (client requirement): install v1.0.1, v1.0.2 … without the
 * "Destination folder already exists" error and without having to switch
 * theme, delete and re-upload. Once this theme is installed once, every new
 * GitHub release surfaces as a normal "Update available" in
 * Appearance → Themes / Dashboard → Updates — one click, folder slug stays
 * `panonfc-theme`, no re-upload.
 *
 * How it works:
 *   - Reads the latest GitHub release for the configured repo.
 *   - Compares its tag (e.g. v1.0.2 → 1.0.2) with the installed version.
 *   - Offers the release asset `panonfc-theme.zip` (built by CI) if present,
 *     otherwise the source zipball.
 *   - Normalises the extracted folder name back to the theme slug on install.
 *
 * Private repo? Define PANONFC_GITHUB_TOKEN (a fine-grained/classic PAT with
 * `contents:read`) in wp-config.php. Public repo needs no token.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Panonfc_GitHub_Updater {

	/** @var string owner/repo */
	protected $repo;
	/** @var string theme slug (folder name) */
	protected $slug;
	/** @var string current installed version */
	protected $version;
	/** @var array|null cached release payload */
	protected $release = null;

	const CACHE_KEY = 'panonfc_github_release';
	const CACHE_TTL = 6 * HOUR_IN_SECONDS;

	/**
	 * Bootstrap.
	 */
	public static function init( $repo, $slug, $version ) {
		$instance = new self( $repo, $slug, $version );
		add_filter( 'pre_set_site_transient_update_themes', array( $instance, 'check_update' ) );
		add_filter( 'themes_api', array( $instance, 'themes_api' ), 10, 3 );
		add_filter( 'upgrader_source_selection', array( $instance, 'fix_source_dir' ), 10, 4 );
		add_action( 'upgrader_process_complete', array( $instance, 'flush_cache' ), 10, 0 );
		return $instance;
	}

	public function __construct( $repo, $slug, $version ) {
		$this->repo    = $repo;
		$this->slug    = $slug;
		$this->version = $version;
	}

	/**
	 * Request headers, incl. optional auth token for private repos.
	 */
	protected function request_args() {
		$headers = array(
			'Accept'     => 'application/vnd.github+json',
			'User-Agent' => 'panonfc-theme-updater',
		);
		if ( defined( 'PANONFC_GITHUB_TOKEN' ) && PANONFC_GITHUB_TOKEN ) {
			$headers['Authorization'] = 'Bearer ' . PANONFC_GITHUB_TOKEN;
		}
		return array(
			'headers' => $headers,
			'timeout' => 15,
		);
	}

	/**
	 * Fetch (and cache) the latest release.
	 *
	 * @return array|null
	 */
	protected function get_latest_release() {
		if ( null !== $this->release ) {
			return $this->release;
		}

		$cached = get_transient( self::CACHE_KEY );
		if ( is_array( $cached ) ) {
			$this->release = $cached;
			return $cached;
		}

		$url      = sprintf( 'https://api.github.com/repos/%s/releases/latest', $this->repo );
		$response = wp_remote_get( $url, $this->request_args() );

		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			// Cache the failure briefly so we don't hammer the API.
			set_transient( self::CACHE_KEY, array(), 30 * MINUTE_IN_SECONDS );
			return null;
		}

		$data = json_decode( wp_remote_retrieve_body( $response ), true );
		if ( empty( $data['tag_name'] ) ) {
			set_transient( self::CACHE_KEY, array(), 30 * MINUTE_IN_SECONDS );
			return null;
		}

		$release = array(
			'version'      => ltrim( $data['tag_name'], 'vV' ),
			'zip'          => $this->pick_package( $data ),
			'html_url'     => isset( $data['html_url'] ) ? $data['html_url'] : '',
			'body'         => isset( $data['body'] ) ? $data['body'] : '',
			'published_at' => isset( $data['published_at'] ) ? $data['published_at'] : '',
		);

		set_transient( self::CACHE_KEY, $release, self::CACHE_TTL );
		$this->release = $release;
		return $release;
	}

	/**
	 * Prefer a built `panonfc-theme.zip` release asset; fall back to zipball.
	 */
	protected function pick_package( $data ) {
		if ( ! empty( $data['assets'] ) && is_array( $data['assets'] ) ) {
			foreach ( $data['assets'] as $asset ) {
				if ( isset( $asset['name'] ) && preg_match( '/(panonfc-theme|panonfc).*\.zip$/i', $asset['name'] ) ) {
					return $asset['browser_download_url'];
				}
			}
		}
		return isset( $data['zipball_url'] ) ? $data['zipball_url'] : '';
	}

	/**
	 * Inject the update into the themes update transient.
	 */
	public function check_update( $transient ) {
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$release = $this->get_latest_release();
		if ( empty( $release ) || empty( $release['zip'] ) ) {
			return $transient;
		}

		if ( version_compare( $release['version'], $this->version, '>' ) ) {
			$transient->response[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $release['version'],
				'url'         => $release['html_url'],
				'package'     => $release['zip'],
			);
		} else {
			// No update — record as up to date so core stops nagging.
			$transient->no_update[ $this->slug ] = array(
				'theme'       => $this->slug,
				'new_version' => $this->version,
				'url'         => $release['html_url'],
				'package'     => '',
			);
		}

		return $transient;
	}

	/**
	 * Provide the "View version details" popup content.
	 */
	public function themes_api( $result, $action, $args ) {
		if ( 'theme_information' !== $action || empty( $args->slug ) || $args->slug !== $this->slug ) {
			return $result;
		}
		$release = $this->get_latest_release();
		if ( empty( $release ) ) {
			return $result;
		}
		return (object) array(
			'name'     => 'PANONFC',
			'slug'     => $this->slug,
			'version'  => $release['version'],
			'download_link' => $release['zip'],
			'sections' => array(
				'changelog' => $release['body'] ? wpautop( wp_kses_post( $release['body'] ) ) : __( 'Voir la release sur GitHub.', 'panonfc' ),
			),
		);
	}

	/**
	 * GitHub zip archives extract to a folder named like `owner-repo-hash` or
	 * `panonfc-theme-1.0.2`. Rename it back to the stable theme slug so the
	 * install lands in the same folder every time (no duplicate themes, no
	 * "folder already exists").
	 */
	public function fix_source_dir( $source, $remote_source, $upgrader, $hook_extra = array() ) {
		global $wp_filesystem;

		if ( empty( $hook_extra['theme'] ) || $hook_extra['theme'] !== $this->slug ) {
			// Also handle the manual-upload / generic case where the source
			// clearly belongs to this theme.
			if ( false === strpos( (string) $source, $this->slug ) && false === strpos( (string) $source, 'panonfc' ) ) {
				return $source;
			}
		}

		if ( ! $wp_filesystem ) {
			return $source;
		}

		$desired = trailingslashit( $remote_source ) . $this->slug;
		if ( trailingslashit( $source ) === trailingslashit( $desired ) ) {
			return $source;
		}

		if ( $wp_filesystem->move( $source, $desired, true ) ) {
			return trailingslashit( $desired );
		}

		return $source;
	}

	/**
	 * Clear the cached release after any upgrade completes.
	 */
	public function flush_cache() {
		delete_transient( self::CACHE_KEY );
	}
}
