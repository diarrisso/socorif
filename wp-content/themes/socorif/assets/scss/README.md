# SCSS Compilation - ACF Blocks

Ce dossier contient les fichiers SCSS pour tous les blocs ACF du thème Ossenberg-Engels.

## Structure

```
scss/
├── style.scss              # Fichier principal qui importe tous les blocs
└── blocks/                 # Dossier contenant un fichier SCSS par bloc
    ├── _accordion.scss
    ├── _fertigungsverfahren.scss
    ├── _banner.scss
    └── ... (47 fichiers au total)
```

## Compilation

### Mode développement (avec watch)

Pour compiler automatiquement à chaque modification:

```bash
npm run dev
```

Ou uniquement le SCSS:

```bash
npm run dev:scss
```

### Mode production

Pour compiler et minifier tous les fichiers:

```bash
npm run build
```

Ou uniquement le SCSS:

```bash
npm run build:scss
```

## Fichiers générés

La compilation génère:

- `dist/blocks.css` - Fichier CSS compilé et minifié contenant tous les styles des blocs

## Intégration WordPress

Le fichier CSS compilé est automatiquement enqueued dans WordPress via `functions.php`:

```php
wp_enqueue_style(
    'ossenberg-engels-blocks',
    get_template_directory_uri() . '/dist/blocks.css',
    array('ossenberg-engels-style'),
    wp_get_theme()->get('Version')
);
```

## Notes importantes

1. **Styles inline avec PHP**: Certains blocs nécessitent des styles inline avec des variables PHP (ex: IDs dynamiques). Ces styles restent dans les fichiers PHP et ne sont pas dans les fichiers SCSS.

2. **Syntaxe moderne**: Les fichiers utilisent `@use` au lieu de `@import` (deprecated).

3. **Source maps**: En mode développement, des source maps sont générées pour faciliter le debugging.

## Formatage

Pour formater tous les fichiers SCSS avec Prettier:

```bash
npx prettier --write "assets/scss/**/*.scss"
```

Ou uniquement les blocs:

```bash
npx prettier --write "assets/scss/blocks/**/*.scss"
```

## Ajout d'un nouveau bloc

1. Créer un nouveau fichier `scss/blocks/_nom-du-bloc.scss`
2. Le fichier sera automatiquement importé dans `scss/style.scss`
3. Compiler avec `npm run build:scss`
