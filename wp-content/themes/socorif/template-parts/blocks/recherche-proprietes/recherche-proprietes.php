<?php
/**
 * Block: Recherche Proprietes
 * Formulaire de recherche avance pour biens immobiliers - Marche guineen
 */

if (!defined('ABSPATH')) exit;

// Get block fields
$title = get_sub_field('title') ?: 'Trouvez votre bien ideal a Conakry';
$subtitle = get_sub_field('subtitle') ?: 'Recherche avancee';
$description = get_sub_field('description') ?: 'Utilisez nos filtres pour trouver le bien qui correspond a vos criteres dans les 5 communes de Conakry.';
$background_image = get_sub_field('background_image');
$overlay_opacity = get_sub_field('overlay_opacity') ?: 60;
$show_advanced = get_sub_field('show_advanced_filters') ?? true;
$layout = get_sub_field('layout') ?: 'hero';

// Get property types for filter
$property_types = get_terms([
    'taxonomy' => 'property_type',
    'hide_empty' => false,
]);

// Communes de Conakry
$communes = [
    'kaloum' => 'Kaloum',
    'dixinn' => 'Dixinn',
    'matam' => 'Matam',
    'matoto' => 'Matoto',
    'ratoma' => 'Ratoma',
];

// Transaction types
$transactions = [
    'vente' => 'Achat',
    'location' => 'Location',
    'gestion' => 'Gestion',
];

// Property types fallback
$property_types_fallback = [
    'terrain' => 'Terrain',
    'maison' => 'Maison',
    'villa' => 'Villa',
    'appartement' => 'Appartement',
    'immeuble' => 'Immeuble',
    'local_commercial' => 'Local Commercial',
    'bureau' => 'Bureau',
    'entrepot' => 'Entrepot',
];

// Price ranges (in GNF - adapted to Guinean market)
$price_ranges = [
    '' => 'Tous les prix',
    '0-50000000' => 'Moins de 50 M GNF',
    '50000000-100000000' => '50 M - 100 M GNF',
    '100000000-200000000' => '100 M - 200 M GNF',
    '200000000-500000000' => '200 M - 500 M GNF',
    '500000000-1000000000' => '500 M - 1 Md GNF',
    '1000000000-' => 'Plus de 1 Md GNF',
];

// Surface ranges
$surface_ranges = [
    '' => 'Toutes surfaces',
    '0-100' => 'Moins de 100 m²',
    '100-200' => '100 - 200 m²',
    '200-500' => '200 - 500 m²',
    '500-1000' => '500 - 1000 m²',
    '1000-' => 'Plus de 1000 m²',
];

$archive_url = get_post_type_archive_link('property');
?>

<?php if ($layout === 'hero') : ?>
<!-- Hero Layout with Background -->
<section class="relative min-h-[500px] lg:min-h-[600px] flex items-center justify-center py-20 lg:py-32">
    <!-- Background Image -->
    <?php if ($background_image) : ?>
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($background_image['sizes']['hero'] ?? $background_image['url']); ?>"
                 alt=""
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-secondary-dark" style="opacity: <?php echo esc_attr($overlay_opacity / 100); ?>"></div>
        </div>
    <?php else : ?>
        <div class="absolute inset-0 z-0 bg-gradient-to-br from-secondary-dark via-secondary to-primary/30"></div>
    <?php endif; ?>

    <div class="container mx-auto px-4 lg:px-8 relative z-10">
        <!-- Header -->
        <div class="text-center mb-10">
            <?php if ($subtitle) : ?>
                <p class="text-primary font-semibold text-sm uppercase tracking-wider mb-3">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="text-3xl lg:text-5xl font-bold text-white mb-4">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($description) : ?>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    <?php echo esc_html($description); ?>
                </p>
            <?php endif; ?>
        </div>

        <!-- Search Form -->
        <form action="<?php echo esc_url($archive_url); ?>" method="get"
              class="bg-white dark:bg-gray-900 rounded-2xl shadow-2xl p-6 lg:p-8 max-w-5xl mx-auto"
              x-data="{ showAdvanced: false }">

            <!-- Main Search Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Transaction Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type de transaction
                    </label>
                    <select name="transaction" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <option value="">Achat ou Location</option>
                        <?php foreach ($transactions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Property Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Type de bien
                    </label>
                    <select name="type" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <option value="">Tous les types</option>
                        <?php if (!is_wp_error($property_types) && !empty($property_types)) : ?>
                            <?php foreach ($property_types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php foreach ($property_types_fallback as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Commune -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Commune
                    </label>
                    <select name="commune" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <option value="">Toute la ville</option>
                        <?php foreach ($communes as $slug => $name) : ?>
                            <option value="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price Range -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Budget
                    </label>
                    <select name="prix" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <?php foreach ($price_ranges as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if ($show_advanced) : ?>
            <!-- Advanced Filters Toggle -->
            <div class="text-center mb-4">
                <button type="button"
                        @click="showAdvanced = !showAdvanced"
                        class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-medium transition-colors cursor-pointer">
                    <span x-text="showAdvanced ? 'Masquer les filtres avances' : 'Afficher les filtres avances'"></span>
                    <svg class="w-5 h-5 transition-transform duration-300" :class="{ 'rotate-180': showAdvanced }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
            </div>

            <!-- Advanced Filters -->
            <div x-show="showAdvanced"
                 x-collapse
                 class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700 mb-4">

                <!-- Surface -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Surface
                    </label>
                    <select name="surface" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <?php foreach ($surface_ranges as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Chambres -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Chambres minimum
                    </label>
                    <select name="chambres" class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                        <option value="">Peu importe</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                    </select>
                </div>

                <!-- Quartier -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Quartier
                    </label>
                    <input type="text" name="quartier"
                           placeholder="Ex: Kipe, Cosa, Nongo..."
                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                </div>

                <!-- Reference -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Reference
                    </label>
                    <input type="text" name="ref"
                           placeholder="REF-XXXXX"
                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary py-3">
                </div>
            </div>
            <?php endif; ?>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold py-4 px-10 rounded-xl transition-all duration-300 hover:scale-105 active:scale-95 shadow-lg shadow-primary/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Rechercher
                </button>

                <a href="<?php echo esc_url($archive_url); ?>"
                   class="inline-flex items-center justify-center gap-2 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium py-4 px-8 rounded-xl transition-all duration-300">
                    Voir tous les biens
                </a>
            </div>
        </form>

        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-12 max-w-4xl mx-auto">
            <?php
            $total_properties = wp_count_posts('property')->publish;
            $available = new WP_Query([
                'post_type' => 'property',
                'posts_per_page' => -1,
                'fields' => 'ids',
                'meta_query' => [['key' => 'property_status', 'value' => 'disponible']],
            ]);
            ?>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-white"><?php echo esc_html($total_properties ?: '50'); ?>+</p>
                <p class="text-gray-300 text-sm">Biens au catalogue</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-white"><?php echo esc_html($available->found_posts ?: '30'); ?></p>
                <p class="text-gray-300 text-sm">Disponibles</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-white">5</p>
                <p class="text-gray-300 text-sm">Communes couvertes</p>
            </div>
            <div class="text-center">
                <p class="text-3xl lg:text-4xl font-bold text-white">24h</p>
                <p class="text-gray-300 text-sm">Reponse garantie</p>
            </div>
            <?php wp_reset_postdata(); ?>
        </div>
    </div>
</section>

<?php else : ?>
<!-- Compact Layout -->
<section class="py-12 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-4 lg:px-8">
        <form action="<?php echo esc_url($archive_url); ?>" method="get"
              class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6">

            <div class="flex flex-col lg:flex-row gap-4 items-end">
                <!-- Transaction -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Transaction</label>
                    <select name="transaction" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">Achat ou Location</option>
                        <?php foreach ($transactions as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Type -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
                    <select name="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">Tous</option>
                        <?php if (!is_wp_error($property_types) && !empty($property_types)) : ?>
                            <?php foreach ($property_types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>"><?php echo esc_html($type->name); ?></option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <?php foreach ($property_types_fallback as $value => $label) : ?>
                                <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Commune -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Commune</label>
                    <select name="commune" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">Toutes</option>
                        <?php foreach ($communes as $slug => $name) : ?>
                            <option value="<?php echo esc_attr($slug); ?>"><?php echo esc_html($name); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Budget -->
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Budget</label>
                    <select name="prix" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:ring-primary focus:border-primary">
                        <?php foreach ($price_ranges as $value => $label) : ?>
                            <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-8 rounded-lg transition-all duration-300 hover:scale-105 active:scale-95 whitespace-nowrap">
                    Rechercher
                </button>
            </div>
        </form>
    </div>
</section>
<?php endif; ?>
