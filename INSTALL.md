# Thème PANONFC — installation, configuration, mises à jour

Thème WordPress classique (PHP), **sans page builder**. Remplace la maquette
Elementor par un thème sur-mesure fidèle au Pano NFC Design System.

---

## 1. Installer le thème

### Option A — via une release GitHub (recommandé)

1. Sur GitHub, ouvrez **Releases** du dépôt `sdiconnect/panonfc_web`.
2. Téléchargez `panonfc-theme.zip` (généré automatiquement à chaque tag `vX.Y.Z`,
   voir §5).
3. WordPress → **Apparence → Thèmes → Ajouter → Téléverser un thème** →
   choisissez le zip → **Installer** → **Activer**.

### Option B — construire le zip localement

```bash
bin/build-zip.sh          # produit dist/panonfc-theme.zip
```

Le zip contient toujours un dossier `panonfc-theme/` : c'est le **slug stable**
du thème (voir §5, pourquoi ça évite « le dossier existe déjà »).

---

## 2. Configuration après activation

1. **Page d'accueil statique** : Réglages → Lecture → « Une page statique » →
   choisir la page d'accueil. Le thème utilise automatiquement `front-page.php`.
2. **Gabarits des pages internes** (préserve les URL existantes) : éditez chaque
   page et, dans **Attributs de page → Modèle**, choisissez :
   - Immobilier → `PANONFC — Immobilier`
   - Chantier → `PANONFC — Chantier`
   - Comment ça marche / La solution → `PANONFC — La solution`
   - Tarifs → `PANONFC — Tarifs`
   - **Contact** (formulaire simple) → `PANONFC — Contact`
   - **Demander un devis** (formulaire complet) → `PANONFC — Demander un devis`

   > Deux formulaires distincts : `Contact` = message court (nom, email,
   > téléphone, message) ; `Demander un devis` = chiffrage complet (société,
   > activité, volume…). Les deux sont protégés contre les robots (honeypot +
   > piège temporel signé + jeton de sécurité), sans reCAPTCHA ni service
   > externe. La même protection couvre le formulaire de commentaires.

   > Gardez le **slug d'URL existant** de chaque page (ex. `/comment-ca-marche/`).
   > Le thème ne change pas les URL ; il ne fait qu'appliquer un design.
3. **Menus** : Apparence → Menus. Emplacements disponibles :
   `Menu principal`, `Pied de page — Produits`, `Pied de page — Ressources`.
   Tant qu'aucun menu n'est assigné, un menu par défaut correct s'affiche.
4. **Logo** : Personnaliser → Identité du site → Logo (sinon le logo SVG fourni
   est utilisé).
5. **WooCommerce** : rien à faire, le tunnel d'achat reste WooCommerce. Les
   fiches produit **variables** prennent automatiquement la mise en page
   sur-mesure. Le configurateur à pastilles est généré **à partir de vos
   vraies variations** : chaque combinaison affiche le **prix réel** de la
   variation (lu depuis WooCommerce), et le bouton « Ajouter au panier » natif
   reste la source de vérité — le prix ferme et les remises dégressives sont
   calculés au panier. Aucun tarif n'est codé en dur : le configurateur
   s'adapte tout seul à vos attributs (dimensions, technologie, œillets…).
   - Les paliers de remise affichés dans la **carte d'estimation** sont
     paramétrables via le filtre `panonfc_discount_tiers` (par défaut : ceux du
     site actuel). Ils ne servent qu'à l'estimation ; le panier fait foi.
   - Pour revenir à la mise en page WooCommerce standard sur un produit précis,
     ajoutez-lui le champ personnalisé `_panonfc_default_layout = yes`.

---

## 3. Contenus éditoriaux (photos) — ACF facultatif

Le thème s'affiche **complet dès l'activation** (textes et visuels de la
maquette). Les emplacements photo « à fournir » restent masqués tant qu'ils sont
vides — aucun cadre gris en production.

Pour les activer, créez ces champs (ACF ou Meta Box) :

| Page | Champs image |
|---|---|
| Accueil | `home_gallery_1`, `home_gallery_2`, `home_gallery_3` |
| Immobilier | `immo_gallery_1`, `immo_gallery_2`, `immo_gallery_3` |
| Chantier | `chantier_gallery_1`, `chantier_gallery_2`, `chantier_gallery_3` |
| Fiche produit | `pdp_situation_1`, `pdp_situation_2` |
| Tarifs | `tarifs_atelier` |
| Contact | `contact_photo` |

Les 8 étapes de « La solution » peuvent aussi passer en **repeater ACF**
`solution_steps` (sous-champs : `title`, `text`, `bullets` [repeater `bullet`],
`image`). Sans ACF, les 8 illustrations fournies + textes de la maquette sont
utilisés.

Les autres visuels (héros, cartes produit, logos clients, capture console)
pointent par défaut vers votre médiathèque actuelle. Pour les changer sans ACF,
utilisez les filtres `panonfc_image_{clé}` / `panonfc_client_logos`.

---

## 4. Retirer Elementor proprement

1. Assignez d'abord les gabarits ci-dessus à chaque page (les pages ne
   dépendront plus d'Elementor pour leur mise en page).
2. Vérifiez le rendu, puis **désactivez puis supprimez** Elementor +
   Elementor Pro.
3. Les éventuels shortcodes `[elementor-*]` résiduels dans le contenu sont
   automatiquement masqués côté front (filtre `the_content`) — nettoyez-les
   ensuite à votre rythme.
4. Vérifiez le bandeau de consentement et le GTM (`GTM-PKKDVWN5`) après coup.

---

## 5. Mettre à jour sans conflit — v1.0.1, v1.0.2, …

> **Le point important demandé :** pouvoir publier une nouvelle version le jour
> même sans le message « le dossier existe déjà », sans switcher de thème, sans
> désinstaller / réuploader.

Trois mécanismes, du plus simple au plus manuel :

### a) Mise à jour automatique depuis GitHub (zéro upload)

Le thème embarque un **updater** qui interroge les releases GitHub du dépôt.
Dès qu'une release supérieure existe, WordPress affiche une mise à jour normale
dans **Tableau de bord → Mises à jour** et **Apparence → Thèmes** : un clic sur
**Mettre à jour**, et c'est fait — le dossier reste `panonfc-theme`.

Publier la version suivante :

```bash
# 1. bumpez la version
#    panonfc-theme/style.css  →  Version: 1.0.1
git commit -am "Release 1.0.1"
git tag v1.0.1
git push origin main --tags
```

Le workflow GitHub Actions construit `panonfc-theme.zip`, crée la release, et
l'updater la propose dans WordPress dans les heures qui suivent (ou
immédiatement via **Mises à jour → Vérifier de nouveau**).

> Dépôt privé ? Ajoutez dans `wp-config.php` :
> `define( 'PANONFC_GITHUB_TOKEN', 'ghp_…' );` (droit `contents:read`).

### b) Réupload manuel du zip (WordPress 5.5+)

Si vous téléversez `panonfc-theme.zip` alors que le thème existe déjà,
WordPress **propose de remplacer la version installée** (tableau comparatif
« Version actuelle / Version téléversée » → **Remplacer par la version
téléversée »**). Comme le dossier interne est toujours `panonfc-theme`, il n'y a
jamais de doublon `panonfc-theme-2` ni de blocage.

### c) Script local

```bash
bin/build-zip.sh    # regénère dist/panonfc-theme.zip depuis la version courante
```

**Pourquoi ça ne bloque plus :** le blocage « Destination folder already
exists » venait d'un dossier de thème figé. Ici (a) passe par le canal de mise à
jour officiel (remplacement en place), (b) utilise l'écrasement natif de WP, et
le zip garde toujours le **même slug** `panonfc-theme` — donc pas de version
suffixée dans le nom du dossier.

---

## 5 bis. Formulaires, cache & tracking des conversions

Les formulaires sont conçus pour rester fiables sur un site **fortement mis en
cache** (WP Rocket / Cloudflare) :

- **Post/Redirect/Get** : après envoi, le POST ne régénère pas la page — il
  redirige vers `…?envoi=ok`. Pas de double-soumission, état de succès fiable.
- **Tokens rafraîchis côté client** : le nonce et le jeton anti-bot sont
  régénérés au chargement via `…/wp-json/panonfc/v1/form-token`, donc le
  formulaire fonctionne même si la page HTML est servie depuis le cache
  (plus de « La session a expiré »).
- **Évènement conversion** : un `generate_lead` est poussé dans le `dataLayer`
  sur `?envoi=ok`. Dans **GTM**, crée un déclencheur « Évènement personnalisé »
  nommé `generate_lead` (ou un déclencheur sur l'URL contenant `envoi=ok`), et
  branche-y ta conversion Google Ads. C'est bien plus fiable que d'attendre le
  rendu d'un élément `.form-alert--ok`.

> **Important (hébergement, hors thème)** : si une page front **non cachée** met
> ~11 s à se générer, c'est un problème serveur, pas le thème. À faire vérifier
> par l'hébergeur : nombre de **workers PHP-FPM** et **slow log**. Il est aussi
> recommandé d'**exclure `/devis/` et `/contact/` du cache** (WP Rocket →
> Options avancées → « Ne jamais mettre en cache (URL) » ; et une page rule
> Cloudflare « Bypass cache ») — le rafraîchissement de token ci-dessus couvre
> déjà le cas, mais l'exclusion règle aussi les visiteurs sans JavaScript.

## 6. Accessibilité, perf, SEO — déjà pris en charge

- Poppins **auto-hébergé** (woff2, `font-display: swap`, préchargé).
- `tokens.css` chargé en premier, puis `main.css`. Aucun style inline massif.
- Images `loading="lazy"` (sauf héros), tailles explicites.
- Menu burger < 1000 px, cibles tactiles ≥ 44 px, `prefers-reduced-motion`.
- Balisage produit Schema.org conservé (WooCommerce).
- `title-tag` géré par WordPress ; compatible Yoast/Rank Math.
```
