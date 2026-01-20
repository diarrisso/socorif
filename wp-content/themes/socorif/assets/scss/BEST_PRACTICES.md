# Guide des Bonnes Pratiques SCSS

## ✅ À FAIRE

### 1. Utiliser des noms de classes spécifiques

```scss
// ✅ BON
.fertigungsverfahren-card {
}
.accordion-item {
}
.teaser-image-default {
}

// ❌ MAUVAIS
.card {
}
.item {
}
.image {
}
```

### 2. Utiliser @apply pour Tailwind

```scss
.my-block {
  // ✅ BON - Réutilise Tailwind
  @apply relative overflow-hidden bg-white dark:bg-gray-900;
}

// ❌ MAUVAIS - Redéfinit tout
.my-block {
  position: relative;
  overflow: hidden;
  background-color: white;
}
```

### 3. Structurer avec BEM

```scss
.block-name {
  // Bloc principal

  &__element {
    // Élément du bloc
  }

  &--modifier {
    // Variante du bloc
  }

  &:hover {
    // État
  }
}
```

### 4. Dark Mode avec .dark &

```scss
.my-component {
  background: white;
  color: black;

  .dark & {
    background: var(--color-gray-900);
    color: white;
  }
}
```

### 5. Media Queries à la fin

```scss
.my-block {
  padding: 1rem;

  @media (min-width: 1024px) {
    padding: 2rem;
  }
}
```

## ❌ À ÉVITER

### 1. Ne PAS redéfinir les classes Tailwind

```scss
// ❌ TRÈS MAUVAIS
.bg-white {
  background-color: white;
}

.opacity-0 {
  opacity: 0;
}
```

### 2. Éviter !important (sauf cas justifiés)

```scss
// ❌ MAUVAIS
.my-class {
  color: red !important;
}

// ✅ BON - Augmenter la spécificité
.block-name .my-class {
  color: red;
}

// ✅ OK SEULEMENT pour override Tailwind si nécessaire
.teaser-image-default {
  border-radius: 0 200px 200px 0 !important;
}
```

### 3. Éviter les sélecteurs trop spécifiques

```scss
// ❌ MAUVAIS - Trop spécifique
.block .container .wrapper .item .title {
  color: red;
}

// ✅ BON - Max 2-3 niveaux
.block__title {
  color: red;
}
```

### 4. Ne PAS dupliquer les styles

```scss
// ❌ MAUVAIS
.block1 {
  transition: opacity 0.5s ease;
}
.block2 {
  transition: opacity 0.5s ease;
}
.block3 {
  transition: opacity 0.5s ease;
}

// ✅ BON - Créer un mixin
@mixin smooth-fade {
  transition: opacity 0.5s ease-in-out;
}

.block1 {
  @include smooth-fade;
}
.block2 {
  @include smooth-fade;
}
.block3 {
  @include smooth-fade;
}
```

## 📋 Template pour Nouveaux Blocs

```scss
/**
 * Block Name Styles
 *
 * Description: What this block does
 * Dependencies: List any required plugins or libs
 */

// 1. Block container
.block-name {
  @apply relative overflow-hidden bg-white dark:bg-gray-900;

  // Custom styles that can't use Tailwind
  background: linear-gradient(...);
}

// 2. Block elements
.block-name__header {
  // Styles
}

.block-name__content {
  // Styles
}

.block-name__footer {
  // Styles
}

// 3. Block modifiers
.block-name--large {
  // Styles
}

.block-name--compact {
  // Styles
}

// 4. Block states
.block-name:hover {
  // Styles
}

// 5. Dark mode (if needed)
.dark .block-name {
  // Only if @apply dark: doesn't work
}

// 6. Responsive (at the end)
@media (min-width: 768px) {
  .block-name {
    // Tablet styles
  }
}

@media (min-width: 1024px) {
  .block-name {
    // Desktop styles
  }
}
```

## 🔍 Checklist Avant Commit

- [ ] Le nom de classe est unique et spécifique
- [ ] Pas de redéfinition de classes Tailwind
- [ ] Maximum 3 niveaux de spécificité
- [ ] !important utilisé uniquement si justifié
- [ ] Dark mode testé
- [ ] Responsive testé (mobile, tablet, desktop)
- [ ] Code compilé sans erreurs: `npm run build:scss`
- [ ] Fichier compilé vérifié: `ls -lh dist/blocks.css`

## 📚 Ressources

- [Sass Guidelines](https://sass-guidelin.es/)
- [BEM Methodology](http://getbem.com/)
- [Tailwind CSS Docs](https://tailwindcss.com/docs)
