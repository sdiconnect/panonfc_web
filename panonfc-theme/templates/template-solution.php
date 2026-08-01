<?php
/**
 * Template Name: PANONFC — La solution
 *
 * @package panonfc
 */

get_header();

/**
 * The 8 illustrated steps.
 * Uses the ACF repeater `solution_steps` (sub-fields: title, text, bullets, image)
 * when present, otherwise the bundled illustrations + prototype copy.
 */
$steps = array();
if ( function_exists( 'have_rows' ) && have_rows( 'solution_steps' ) ) {
	while ( have_rows( 'solution_steps' ) ) {
		the_row();
		$img     = get_sub_field( 'image' );
		$bullets = get_sub_field( 'bullets' );
		$steps[] = array(
			'title'   => (string) get_sub_field( 'title' ),
			'text'    => (string) get_sub_field( 'text' ),
			'bullets' => is_array( $bullets ) ? wp_list_pluck( $bullets, 'bullet' ) : array(),
			'image'   => is_array( $img ) ? $img['url'] : ( is_string( $img ) ? $img : '' ),
			'alt'     => is_array( $img ) && ! empty( $img['alt'] ) ? $img['alt'] : '',
		);
	}
}

if ( empty( $steps ) ) {
	$base = panonfc_asset( 'assets/img/steps/' );
	$steps = array(
		array( 'title' => 'Je commande mes panneaux', 'text' => 'Commandez en ligne pour les formats standards, ou demandez un devis personnalisé selon votre volume et vos formats.', 'bullets' => array(), 'image' => $base . '01-je-commande-mes-panneaux.jpg', 'alt' => 'Commande d\'un panneau connecté' ),
		array( 'title' => 'Je transmets mon identité graphique', 'text' => 'Logo, charte graphique ou modèle de panneau existant : nous partons de ce que vous avez déjà, sans repartir de zéro.', 'bullets' => array(), 'image' => $base . '02-je-transmets-mon-identite-graphique.jpg', 'alt' => 'Transmission de l\'identité graphique' ),
		array( 'title' => 'PANONFC crée votre maquette', 'text' => 'Nous intégrons votre identité visuelle, le QR code et l\'identifiant unique du panneau. Chaque panneau possède son propre identifiant, ce qui le rend administrable individuellement.', 'bullets' => array( 'Votre identité visuelle', 'Le QR code à la bonne échelle de lecture', 'L\'identifiant unique du panneau' ), 'image' => $base . '03-pano-nfc-cree-votre-maquette.jpg', 'alt' => 'Maquette du panneau créée par PANONFC' ),
		array( 'title' => 'Validation puis mise en production', 'text' => 'Une fois la maquette validée, nous générons l\'ensemble de vos panneaux avec leurs identifiants, puis lançons la production : impression UV haute qualité sur Akylux 5 mm.', 'bullets' => array(), 'image' => $base . '04-validation-mise-en-production.jpg', 'alt' => 'Validation du BAT et mise en production' ),
		array( 'title' => 'Je reçois mes panneaux', 'text' => 'Vos panneaux sont expédiés rapidement et livrés prêts à être utilisés. Vous créez ensuite gratuitement votre compte sur la console web PANONFC.', 'bullets' => array(), 'image' => $base . '05-je-recois-mes-panneaux.jpg', 'alt' => 'Application web PANONFC' ),
		array( 'title' => 'J\'active mes panneaux', 'text' => 'Depuis la console, vous activez chaque panneau grâce à son identifiant unique, vous le nommez, vous définissez sa destination — et vous modifiez le lien à tout moment.', 'bullets' => array( 'Activation par identifiant unique', 'Nom et groupe du panneau', 'Destination modifiable à volonté' ), 'image' => $base . '06-j-active-mes-panneaux.jpg', 'alt' => 'Activation d\'un panneau depuis la console' ),
		array( 'title' => 'Mon panneau est opérationnel', 'text' => 'Une fois activé, le panneau est immédiatement fonctionnel : un simple scan permet d\'accéder au contenu associé, sans application ni compte.', 'bullets' => array(), 'image' => $base . '07-mon-panneau-est-operationnel.jpg', 'alt' => 'Panneau connecté opérationnel' ),
		array( 'title' => 'Je pose mon panneau sur le terrain', 'text' => 'Pose classique, sur portail, clôture, palissade ou mât. Le support reste le même : c\'est son usage qui change.', 'bullets' => array(), 'image' => $base . '08-je-pose-mon-panneau-sur-le-terrain.jpg', 'alt' => 'Pose du panneau sur le terrain' ),
	);
}
?>

<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-140px;top:-180px;width:660px;height:660px;border:1px solid rgba(254,132,27,0.14)"></span>
	<div class="container page-hero__inner">
		<div class="breadcrumb breadcrumb--on-navy">
			<?php
			panonfc_breadcrumb(
				array(
					array( 'label' => 'Accueil', 'url' => home_url( '/' ) ),
					array( 'label' => 'La solution' ),
				)
			);
			?>
		</div>
		<div class="measure" style="max-width:720px">
			<h1>Comment un panneau imprimé devient administrable</h1>
			<p class="page-hero__lead">Pas d'application, pas d'abonnement, pas de matériel supplémentaire. Un identifiant imprimé, une puce, une console web : le reste, c'est votre contenu.</p>
			<div class="page-hero__cta">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
				<a class="btn btn--on-navy btn--lg" href="#etapes">Le déroulé complet</a>
			</div>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">QR code et NFC</span>
			<h2 class="h2">Deux façons d'ouvrir la même information</h2>
			<p class="muted mt-4 section-lead">Vous choisissez l'une, l'autre, ou les deux sur le même panneau. Dans tous les cas, la destination est pilotée depuis votre console.</p>
		</div>
		<div class="compare">
			<div class="card">
				<span class="chip chip--navy mb-5 chip-inline">QR code</span>
				<h3>Lisible par tous les téléphones</h3>
				<p>L'appareil photo suffit, sur iOS comme sur Android. C'est le geste que le grand public maîtrise déjà, y compris à distance depuis le trottoir.</p>
				<ul class="marker-list">
					<li><span class="mk mk--navy">—</span>Fonctionne à travers une vitre ou un portail</li>
					<li><span class="mk mk--navy">—</span>Intégré au visuel, à la taille adaptée à la distance de lecture</li>
					<li><span class="mk mk--navy">—</span>Redirection modifiable sans réimprimer le code</li>
				</ul>
			</div>
			<div class="card card--accent">
				<span class="chip chip--orange mb-5 chip-inline">NFC</span>
				<h3>Un simple contact, sans viser</h3>
				<p>Le prospect approche son téléphone de la zone signalée : la page s'ouvre. Pas de cadrage, pas de lumière suffisante à trouver, y compris de nuit.</p>
				<ul class="marker-list">
					<li><span class="mk mk--orange">—</span>Puce intégrée au panneau en production</li>
					<li><span class="mk mk--orange">—</span>Aucune application, aucun compte pour le visiteur</li>
					<li><span class="mk mk--orange">—</span>Même destination que le QR code, ou différente</li>
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="section section--surface section--bordered-top" id="etapes">
	<div class="container section__inner--internal section__inner">
		<div class="measure mb-11">
			<span class="eyebrow">Le déroulé</span>
			<h2 class="h2">De la commande au panneau posé</h2>
		</div>
		<?php foreach ( $steps as $i => $step ) : ?>
			<?php $reverse = ( $i % 2 === 1 ); ?>
			<div class="istep<?php echo $reverse ? ' istep--reverse' : ''; ?>">
				<div class="istep__text">
					<div class="istep__num"><span><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span><span class="rule"></span></div>
					<h3><?php echo esc_html( $step['title'] ); ?></h3>
					<p><?php echo esc_html( $step['text'] ); ?></p>
					<?php if ( ! empty( $step['bullets'] ) ) : ?>
						<ul class="marker-list">
							<?php foreach ( $step['bullets'] as $b ) : ?>
								<li><span class="mk mk--orange">—</span><?php echo esc_html( $b ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $step['image'] ) ) : ?>
					<figure class="istep__media">
						<img src="<?php echo esc_url( $step['image'] ); ?>" alt="<?php echo esc_attr( $step['alt'] ); ?>" loading="lazy" width="1000" height="700">
					</figure>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<section class="section section--navy-deep">
	<div class="container section__inner--internal section__inner">
		<div class="console-band">
			<div>
				<span class="eyebrow eyebrow--on-navy">La console</span>
				<h2 class="h2--sm">Vos panneaux, vos groupes, vos redirections</h2>
				<p class="on-navy-dim mt-5 mb-7 section-lead">La console web est comprise dans le prix des panneaux. Vous y ajoutez un panneau par son identifiant unique, vous définissez où pointent son QR code et son tag NFC, et vous les organisez par groupe : agence, programme ou chantier.</p>
				<ul class="console-band__list">
					<li><span class="mk">✓</span>Ajouter un panneau en quelques secondes</li>
					<li><span class="mk">✓</span>Modifier la redirection à tout moment</li>
					<li><span class="mk">✓</span>Regrouper les panneaux par opération ou par agence</li>
					<li><span class="mk">✓</span>Voir d'un coup d'œil ce qui est actif ou en attente</li>
				</ul>
				<a class="btn btn--accent" href="<?php echo esc_url( panonfc_console_url() ); ?>">Accéder à la console</a>
			</div>
			<figure class="console-band__media">
				<img src="<?php echo esc_url( panonfc_image( 'console-shot' ) ); ?>" alt="Console web PANONFC ouverte sur la liste des panneaux" loading="lazy">
			</figure>
		</div>
	</div>
</section>

<section class="section section--white">
	<div class="container section__inner--internal section__inner">
		<div class="split split--75-25 split--start">
			<div>
				<span class="eyebrow">Questions fréquentes</span>
				<h2 class="h2--sm">Ce qu'on nous demande le plus</h2>
				<p class="muted mt-4" style="font-size:15px;line-height:1.6">Une autre question ? <a class="link-strong" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a></p>
			</div>
			<div class="faq-grid">
				<div class="faq"><h3>Faut-il une application ?</h3><p>Non, ni pour vous ni pour le prospect. La console est un site web, le scan se fait avec le téléphone tel quel.</p></div>
				<div class="faq"><h3>Y a-t-il un abonnement ?</h3><p>Non. La console et la gestion de vos redirections sont comprises dans le prix des panneaux.</p></div>
				<div class="faq"><h3>La puce NFC dure-t-elle ?</h3><p>Elle est passive : pas de pile, pas d'entretien. Elle est intégrée au panneau en production.</p></div>
				<div class="faq"><h3>Vers quoi peut pointer un panneau ?</h3><p>Vers n'importe quelle page web : fiche de votre logiciel métier, portail d'annonces, formulaire, PDF ou page de programme.</p></div>
				<div class="faq"><h3>Et si le bien est vendu ?</h3><p>Vous réaffectez le panneau à un autre bien depuis la console. Le support est réutilisable tant qu'il est en bon état.</p></div>
				<div class="faq"><h3>Plusieurs collaborateurs ?</h3><p>Les panneaux se regroupent par agence ou par opération, ce qui permet à chacun de retrouver les siens.</p></div>
			</div>
		</div>
	</div>
</section>

<?php
get_template_part(
	'template-parts/sections/cta-navy',
	null,
	array(
		'title'     => 'Un premier panneau pour tester ?',
		'lead'      => 'Commandez à l\'unité, posez-le sur un mandat, jugez sur pièce. Le tarif dégressif s\'appliquera au réassort.',
		'primary'   => array( 'label' => 'Configurer un panneau', 'url' => panonfc_url( 'produit' ) ),
		'secondary' => array( 'label' => 'Parler à un conseiller', 'url' => panonfc_url( 'devis' ) ),
		'small'     => true,
	)
);

get_footer();
