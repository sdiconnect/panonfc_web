# panonfc_web — consignes pour Claude Code

Thème WordPress sur mesure de panonfc.com (`panonfc-theme/`), PHP classique, sans page builder.

## Règles
- Français, ton professionnel. La marque s'écrit **PanoNFC** (un mot) dans tous les textes visibles.
- Les contenus des pages vivent dans les gabarits (`templates/`) : toute retouche de texte passe par une PR.
- Les FAQ des pages v1.2.0 sont dans `inc/content.php` (affichage + balisage FAQ) ; les titres / meta SEO dans `inc/seo.php` (`panonfc_seo_defaults()`).
- Liens internes : toujours `panonfc_url( 'role' )`, jamais d'URL en dur (rôles dans `inc/template-tags.php`).
- Ne jamais promettre ce qui n'est pas vérifié (délais, fabrication en France, hébergement…) : demander à Maxence.
- Pages Habitat (bailleurs, syndics, plaques, Avis Résidents) : appeler `panonfc_habitat_topbar()` avant `get_header()`.

## Vérifier avant de proposer une PR
1. `for f in $(find panonfc-theme -name '*.php'); do php -l "$f"; done`
2. Rendu réel dans un WordPress local (cœur WordPress cloné depuis github.com/WordPress/WordPress, thème en lien symbolique, `php -S` avec un routeur), captures desktop 1366 px et mobile 390 px.

## Branches et versions
- Travail sur une branche `feature/…`, PR vers la branche par défaut du dépôt.
- Publication : passer `Version:` dans `panonfc-theme/style.css`, fusionner, puis tag `vX.Y.Z` → GitHub Actions crée la release → WordPress propose la mise à jour (voir INSTALL.md §5).
- Le tag (= mise en production) est fait par Maxence.
