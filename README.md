# panonfc_web — thème WordPress PANONFC

Thème WordPress sur-mesure de [panonfc.com](https://panonfc.com/) : panneaux
immobiliers et de chantier connectés NFC / QR. Refonte du site vitrine +
e-commerce à partir du **Pano NFC Design System**, en remplacement de la
maquette Elementor.

> Installation, configuration et **mises à jour sans conflit de version** :
> voir **[INSTALL.md](INSTALL.md)**.

## Ce que contient le thème

- **Thème classique PHP**, sans page builder (Elementor retiré).
- **7 gabarits** fidèles aux maquettes : Accueil, Immobilier, Chantier,
  La solution (8 étapes), Tarifs, Contact / Devis, et la **fiche produit
  WooCommerce** avec configurateur + carte de synthèse de prix.
- **WooCommerce** conservé comme tunnel d'achat ; balisage Schema.org produit
  préservé.
- **Design system en CSS** : `assets/css/tokens.css` (variables + Poppins
  auto-hébergé) puis `assets/css/main.css`. Pas de style inline massif.
- **Formulaire de devis** natif (nonce, honeypot, consentement RGPD, accusé de
  réception), sans dépendance externe.
- **Mise à jour automatique depuis GitHub Releases** — publier une v1.0.1 /
  v1.0.2 sans réuploader ni supprimer le thème.
- Contenus photo pilotables par **ACF** (facultatif) avec repli propre.

## Arborescence

```
panonfc_web/
├── panonfc-theme/               ← le thème à installer
│   ├── style.css                ← en-tête + numéro de version (source de vérité)
│   ├── functions.php
│   ├── header.php · footer.php · front-page.php · index.php · page.php …
│   ├── inc/                     ← setup, enqueue, helpers, menus, WooCommerce,
│   │                              formulaire de contact, updater GitHub
│   ├── templates/               ← gabarits de page (Template Name)
│   ├── template-parts/sections/
│   ├── woocommerce/single-product.php
│   └── assets/  css · js · fonts (Poppins woff2) · img (logos + 8 étapes)
├── bin/build-zip.sh             ← construit panonfc-theme.zip
├── .github/workflows/release-theme.yml   ← build + release auto sur tag vX.Y.Z
├── INSTALL.md
└── README.md
```

## Publier une nouvelle version

```bash
# éditer panonfc-theme/style.css → Version: 1.0.1
git commit -am "Release 1.0.1"
git tag v1.0.1 && git push origin main --tags
```

GitHub Actions construit et attache `panonfc-theme.zip` à la release ; le thème
installé la propose ensuite comme une mise à jour WordPress classique.

## Crédits

Design : Pano NFC Design System. Développement : Solutions Digitales Intégrées.
