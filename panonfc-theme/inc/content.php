<?php
/**
 * Shared editorial content for the v1.2.0 pages (Habitat & copropriété,
 * Compte Entreprise): FAQ sets reused by the templates AND by the FAQPage
 * structured data in inc/seo.php, so the visible answers and the schema never
 * drift apart.
 *
 * @package panonfc
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * FAQ items by key.
 *
 * @param string $key avis | bailleurs | syndics | plaques | entreprise | home.
 * @return array List of array( 'q' => string, 'a' => string ).
 */
function panonfc_faqs( $key ) {
	$faqs = array(
		'avis'       => array(
			array( 'q' => 'Les résidents doivent-ils installer une application ?', 'a' => 'Non. Le QR code se lit avec l\'appareil photo du téléphone et la puce NFC par simple approche. Le questionnaire s\'ouvre directement dans le navigateur.' ),
			array( 'q' => 'Les réponses sont-elles anonymes ?', 'a' => 'Oui. Aucune donnée personnelle des résidents n\'est demandée ni conservée : seules la réponse, l\'équipement concerné et la date sont enregistrés.' ),
			array( 'q' => 'Peut-on adapter les questions ?', 'a' => 'Oui. Les questionnaires sont paramétrés avec vous pour chaque type d\'équipement (ascenseur, porte de garage, hall…) : notes, questions oui / non, choix multiples et commentaire libre.' ),
			array( 'q' => 'Qui est prévenu en cas d\'avis négatif ?', 'a' => 'Les responsables de l\'agence qui gère l\'équipement reçoivent une alerte par e-mail. Vous réglez le seuil de déclenchement et pouvez ajouter des adresses de destinataires.' ),
			array( 'q' => 'Comment associer une plaque à un équipement ?', 'a' => 'Chaque plaque porte un identifiant unique. Depuis la plateforme, vous l\'associez à une résidence et à un équipement, ou vous importez tout votre parc en une fois à partir d\'un fichier.' ),
			array( 'q' => 'Et si une plaque est abîmée ?', 'a' => 'Vous la remplacez par une plaque neuve depuis la plateforme : l\'équipement garde tout son historique d\'avis et de scans, l\'ancienne plaque est désactivée.' ),
		),
		'bailleurs'  => array(
			array( 'q' => 'Est-ce compatible avec une organisation en agences ?', 'a' => 'Oui. Résidences et équipements sont rangés par agence. Chaque responsable ne voit que son périmètre ; la direction a la vue consolidée de tout le patrimoine.' ),
			array( 'q' => 'Peut-on démarrer par un pilote ?', 'a' => 'Oui, c\'est ce que nous recommandons : quelques résidences équipées pendant trois mois, avec accès complet à la plateforme et export des réponses.' ),
			array( 'q' => 'Qui pose les plaques ?', 'a' => 'Vos équipes ou vos prestataires. La pose est simple (adhésif) et chaque plaque est associée à son équipement depuis la plateforme au moment de la pose.' ),
			array( 'q' => 'Les données sont-elles exportables ?', 'a' => 'Oui, à tout moment, dans un format ouvert compatible Excel, et un export complet vous est remis en fin de contrat.' ),
		),
		'syndics'    => array(
			array( 'q' => 'À quoi sert une plaque dans les parties communes ?', 'a' => 'À recueillir l\'avis des occupants sur un équipement (ascenseur, porte de garage, hall, local) et à vous signaler rapidement ce qui ne va pas, équipement par équipement.' ),
			array( 'q' => 'Que voient les copropriétaires ?', 'a' => 'Un questionnaire court ou une page d\'information propre à l\'équipement scanné. Aucun compte à créer, aucune application.' ),
			array( 'q' => 'Peut-on gérer plusieurs immeubles ?', 'a' => 'Oui. Chaque immeuble est une résidence, rangée dans le portefeuille du gestionnaire ou de l\'agence qui la suit.' ),
		),
		'plaques'    => array(
			array( 'q' => 'Pourquoi une puce NFC « anti-métal » ?', 'a' => 'Une puce NFC classique posée sur une porte d\'ascenseur ou un portail métallique est mal lue. La version anti-métal intègre une couche isolante qui garantit la lecture sur ces supports.' ),
			array( 'q' => 'Le lien peut-il être modifié après la pose ?', 'a' => 'Oui. Le QR code et la puce pointent vers un lien dynamique : vous changez la destination ou réaffectez la plaque depuis la plateforme, sans la remplacer.' ),
			array( 'q' => 'La puce peut-elle être réécrite par un tiers ?', 'a' => 'Non. La puce est verrouillée après encodage : son contenu ne peut plus être modifié par un téléphone.' ),
			array( 'q' => 'Peut-on avoir les plaques à nos couleurs ?', 'a' => 'Oui. Nous préparons une maquette à votre charte et vous soumettons un BAT avant toute production.' ),
		),
		'entreprise' => array(
			array( 'q' => 'Le compte standard reste-t-il gratuit ?', 'a' => 'Oui. La gestion de vos panneaux depuis la console reste incluse dans le prix des panneaux. Le Compte Entreprise est une option pour les organisations multi-agences.' ),
			array( 'q' => 'Combien de collaborateurs peut-on inviter ?', 'a' => 'Autant que nécessaire : les collaborateurs sont illimités, avec des droits par agence (responsable, lecture seule…).' ),
			array( 'q' => 'Peut-on tester avant de s\'abonner ?', 'a' => 'Oui. Nous ouvrons un espace de démonstration complet, avec des agences, des panneaux et des statistiques fictifs.' ),
			array( 'q' => 'Y a-t-il un engagement ?', 'a' => 'L\'abonnement est annuel. Sans abonnement, vos panneaux restent pleinement fonctionnels avec la console standard.' ),
		),
	);

	return apply_filters( 'panonfc_faqs', isset( $faqs[ $key ] ) ? $faqs[ $key ] : array(), $key );
}

/**
 * Render a FAQ section (same markup as the home FAQ).
 *
 * @param string $key   FAQ set.
 * @param string $title Section title.
 */
function panonfc_faq_section( $key, $title = 'Questions fréquentes' ) {
	$items = panonfc_faqs( $key );
	if ( ! $items ) {
		return;
	}
	?>
	<section class="section section--surface section--bordered-top">
		<div class="container section__inner">
			<div class="split split--75-25 split--start">
				<div>
					<span class="eyebrow">Questions fréquentes</span>
					<h2 class="h2--sm"><?php echo esc_html( $title ); ?></h2>
					<p class="muted mt-4" style="font-size:15px;line-height:1.6">Une autre question ? Appelez-nous au <a class="link-strong" href="<?php echo esc_attr( panonfc_phone_href() ); ?>"><?php echo esc_html( panonfc_phone_display() ); ?></a>.</p>
				</div>
				<div class="faq-grid">
					<?php foreach ( $items as $item ) : ?>
						<div class="faq"><h3><?php echo esc_html( $item['q'] ); ?></h3><p><?php echo esc_html( $item['a'] ); ?></p></div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}

/**
 * Pages of the "Habitat & copropriété" universe do not claim the panel
 * production promises shown in the top bar (French print shop, 48–72 h).
 * Called at the top of those templates, before get_header().
 */
function panonfc_habitat_topbar() {
	add_filter(
		'panonfc_topbar_left_1',
		function () {
			return 'Plaques QR code et NFC anti-métal pour équipements';
		}
	);
	add_filter(
		'panonfc_topbar_left_2',
		function () {
			return 'Plateforme de suivi hébergée chez OVHcloud';
		}
	);
}
