<?php
/**
 * 404.
 *
 * @package panonfc
 */

get_header();
?>
<section class="section page-hero section--clip">
	<span class="page-hero__arc" aria-hidden="true" style="right:-140px;top:-180px;width:660px;height:660px;border:1px solid rgba(254,132,27,0.14)"></span>
	<div class="container page-hero__inner">
		<div class="measure" style="max-width:640px">
			<span class="eyebrow eyebrow--on-navy">Erreur 404</span>
			<h1>Cette page a changé d'adresse</h1>
			<p class="page-hero__lead">La page recherchée n'existe plus ou a été déplacée. Reprenez depuis l'accueil ou demandez-nous un devis.</p>
			<div class="page-hero__cta">
				<a class="btn btn--accent btn--lg" href="<?php echo esc_url( home_url( '/' ) ); ?>">Retour à l'accueil</a>
				<a class="btn btn--on-navy btn--lg" href="<?php echo esc_url( panonfc_url( 'devis' ) ); ?>">Demander un devis</a>
			</div>
		</div>
	</div>
</section>
<?php
get_footer();
