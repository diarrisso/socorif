# BEKA - Stellenangebote Security Documentation

## Aperçu de la sécurité

Le système Stellenangebote a été développé avec un accent particulier sur la sécurité, suivant les meilleures pratiques WordPress.

## Mesures de sécurité implémentées

### 1. Utilisation des fonctions WordPress natives

Au lieu d'exécuter des requêtes SQL brutes, nous utilisons exclusivement les fonctions WordPress:

```php
// SECURISE - Utilise les fonctions WordPress
wp_insert_post()      // Création sécurisée de posts
wp_insert_term()      // Création sécurisée de taxonomies
update_field()        // Mise à jour sécurisée des champs ACF
get_field()           // Récupération sécurisée des données
wp_set_object_terms() // Association sécurisée des taxonomies
```

Ces fonctions incluent automatiquement:
- Échappement des données
- Prepared statements
- Validation des types
- Sanitization automatique

### 2. Protection contre les injections SQL

Aucune requête SQL brute n'est utilisée dans le code. Toutes les opérations passent par:

```php
// Évite complètement les injections SQL
global $wpdb;
$wpdb->prepare()  // Si nécessaire, mais non utilisé ici
```

### 3. Validation et sanitization des données

#### Email Validation
```php
function beka_stellenangebote_sanitize_data(int|string $post_id): void {
    $email = get_field('application_email', $post_id);
    if ($email && !is_email($email)) {
        update_field('application_email', '', $post_id);
    }
}
```

#### URL Sanitization
```php
$link = get_field('application_link', $post_id);
if ($link && is_array($link) && isset($link['url'])) {
    $sanitized_url = esc_url_raw($link['url']);
    if ($sanitized_url !== $link['url']) {
        $link['url'] = $sanitized_url;
        update_field('application_link', $link, $post_id);
    }
}
```

### 4. Vérifications de permissions

```php
// Vérification des capacités utilisateur
if (!current_user_can('manage_options')) {
    wp_die(__('Sie haben keine Berechtigung für diese Seite.', 'beka'));
}

// Vérification des permissions d'édition
if (!current_user_can('edit_post', $post_id)) {
    return;
}
```

### 5. Protection CSRF avec Nonces

Dans l'interface admin:

```php
// Génération du nonce
wp_nonce_field('beka_create_examples', 'beka_examples_nonce');

// Vérification du nonce
if (isset($_POST['create_examples']) &&
    check_admin_referer('beka_create_examples', 'beka_examples_nonce')) {
    // Action sécurisée
}
```

Pour les actions GET:

```php
wp_verify_nonce(
    sanitize_text_field(wp_unslash($_GET['_wpnonce'])),
    'delete_examples'
)
```

### 6. Protection contre l'autosave

```php
if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return;
}
```

### 7. Échappement en sortie

Dans les templates:

```php
// Échappement HTML
echo esc_html($variable);

// Échappement d'attributs
echo esc_attr($variable);

// Échappement d'URLs
echo esc_url($url);

// Échappement de texte traduit
echo esc_html__('Texte', 'beka');
```

### 8. Sanitization des inputs utilisateur

```php
// Sanitization de texte
sanitize_text_field($_POST['field']);

// Sanitization d'email
sanitize_email($_POST['email']);

// Sanitization d'URL
esc_url_raw($_POST['url']);

// wp_unslash pour les données $_POST/$_GET
wp_unslash($_POST['data']);
```

## Fichiers sécurisés

### 1. inc/post-types/stellenangebote.php
- ✅ Utilise uniquement des fonctions WordPress natives
- ✅ Validation des emails et URLs
- ✅ Vérifications de permissions
- ✅ Protection contre l'autosave

### 2. inc/acf-fields/stellenangebote-fields.php
- ✅ ACF gère automatiquement la sanitization
- ✅ Conditional logic pour les champs
- ✅ Types de champs validés

### 3. inc/helpers/create-stellenangebote-examples.php
- ✅ Utilise `wp_insert_post()` au lieu de SQL brut
- ✅ Utilise `update_field()` pour les champs ACF
- ✅ Option pour éviter les duplications
- ✅ Pas d'input utilisateur direct

### 4. inc/admin/stellenangebote-admin.php
- ✅ Vérification des capacités utilisateur
- ✅ Protection CSRF avec nonces
- ✅ Sanitization de tous les inputs
- ✅ Utilise `wp_delete_post()` au lieu de DELETE SQL
- ✅ Redirection sécurisée avec `wp_redirect()`

### 5. single-stellenangebote.php
- ✅ Échappement de toutes les sorties
- ✅ Utilisation de `get_field()` sécurisé
- ✅ Protection XSS

## Comparaison: Avant vs Après

### ❌ AVANT (Non sécurisé)
```sql
-- Script SQL direct - DANGEREUX
INSERT INTO wp_posts (post_title, ...) VALUES ('Titre', ...);
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (@job_id, 'email', 'email@example.com');
```

**Problèmes:**
- Pas de validation
- Pas d'échappement
- Injection SQL possible
- Pas de vérification de permissions

### ✅ APRÈS (Sécurisé)
```php
// Utilisation de fonctions WordPress
$job_id = wp_insert_post(array(
    'post_title'  => sanitize_text_field($title),
    'post_status' => 'publish',
    'post_type'   => 'stellenangebote',
));

if (!is_wp_error($job_id)) {
    update_field('email', sanitize_email($email), $job_id);
}
```

**Avantages:**
- Validation automatique
- Prepared statements intégrés
- Échappement automatique
- Type checking

## Bonnes pratiques suivies

### 1. Principe du moindre privilège
```php
// Seuls les administrateurs peuvent créer des exemples
if (!current_user_can('manage_options')) {
    wp_die('Unauthorized');
}
```

### 2. Defense in depth
- Multiples couches de validation
- Sanitization en entrée ET en sortie
- Vérifications de type
- Nonces pour CSRF

### 3. Fail securely
```php
// Si la validation échoue, on n'exécute rien
if (!is_email($email)) {
    update_field('application_email', '', $post_id);
    return; // Arrêt sécurisé
}
```

### 4. Input validation
- Tous les inputs sont validés
- Types stricts (PHP 8+)
- Validation métier (format email, URL)

### 5. Output encoding
- Tous les outputs sont échappés
- Contexte approprié (HTML, attr, URL)

## Utilisation sécurisée

### Créer des exemples (Interface Admin)

1. Aller dans **Stellenangebote → Beispiele erstellen**
2. Cliquer sur "Beispiele erstellen"
3. Le système vérifie:
   - Permissions utilisateur
   - Nonce CSRF
   - Option de duplication

### Créer des exemples (Programmatique)

```php
// Charger la fonction
require_once BEKA_DIR . '/inc/helpers/create-stellenangebote-examples.php';

// Appeler de manière sécurisée
if (current_user_can('manage_options')) {
    beka_create_stellenangebote_examples();
}
```

## Audit de sécurité

### Points vérifiés ✅

- [x] Pas de requêtes SQL brutes
- [x] Utilisation exclusive de l'API WordPress
- [x] Validation de tous les inputs
- [x] Échappement de tous les outputs
- [x] Protection CSRF
- [x] Vérifications de permissions
- [x] Sanitization des données
- [x] Protection contre l'autosave
- [x] Type hinting strict
- [x] Pas de `eval()` ou code dynamique
- [x] Pas de `extract()` dangereux
- [x] Pas de `serialize()`/`unserialize()` non contrôlé

### Outils recommandés

Pour vérifier la sécurité:

```bash
# Plugin WordPress
# Install "Wordfence Security" pour scan de sécurité

# PHP CodeSniffer avec WordPress Standards
composer require --dev wp-coding-standards/wpcs
phpcs --standard=WordPress inc/
```

## Maintenance et mises à jour

### Checklist régulière

- [ ] Vérifier les mises à jour ACF
- [ ] Vérifier les mises à jour WordPress
- [ ] Scanner avec Wordfence
- [ ] Vérifier les logs d'erreurs
- [ ] Tester les formulaires avec des données malveillantes
- [ ] Vérifier les permissions des fichiers

### En cas de découverte de vulnérabilité

1. Isoler le code problématique
2. Appliquer un patch temporaire
3. Tester en environnement de développement
4. Déployer le correctif
5. Documenter la vulnérabilité et la correction

## Ressources

- [WordPress Plugin Handbook - Security](https://developer.wordpress.org/plugins/security/)
- [Data Validation](https://developer.wordpress.org/apis/security/data-validation/)
- [Escaping](https://developer.wordpress.org/apis/security/escaping/)
- [Nonces](https://developer.wordpress.org/apis/security/nonces/)

## Conclusion

Le système Stellenangebote utilise exclusivement les meilleures pratiques de sécurité WordPress:

- ✅ **Pas de SQL brut** - 100% API WordPress
- ✅ **Validation stricte** - Tous les inputs validés
- ✅ **Échappement complet** - Tous les outputs échappés
- ✅ **Protection CSRF** - Nonces partout
- ✅ **Permissions** - Vérifications appropriées

Le code est prêt pour la production et suit les standards de sécurité WordPress.
