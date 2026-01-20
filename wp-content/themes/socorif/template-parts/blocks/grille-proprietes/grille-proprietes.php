<?php
/**
 * Block: Grille Proprietes
 * Affiche les biens immobiliers avec filtres adaptes au marche guineen
 */

if (!defined('ABSPATH')) exit;

// Get block fields
$subtitle = get_sub_field('subtitle') ?: 'Nos biens';
$title = get_sub_field('title') ?: 'Proprietes disponibles';
$display_mode = get_sub_field('display_mode') ?: 'auto';
$posts_per_page = get_sub_field('posts_per_page') ?: 6;
$columns = get_sub_field('columns') ?: '3';
$show_filters = ($display_mode === 'auto') ? (get_sub_field('show_filters') ?? true) : false;
$bg_color = get_sub_field('bg_color') ?: 'white';
$selected_properties = get_sub_field('properties') ?: [];

// Background classes
$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-800',
    'secondary-dark' => 'bg-secondary-dark text-white',
];
$bg_class = $bg_classes[$bg_color] ?? $bg_classes['white'];

// Text color based on background
$text_dark = $bg_color === 'secondary-dark';

// Column classes
$column_classes = [
    '2' => 'md:grid-cols-2',
    '3' => 'md:grid-cols-2 lg:grid-cols-3',
    '4' => 'md:grid-cols-2 lg:grid-cols-4',
];
$grid_cols = $column_classes[$columns] ?? $column_classes['3'];

// Get filter values from URL
$filter_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : '';
$filter_commune = isset($_GET['commune']) ? sanitize_text_field($_GET['commune']) : '';
$filter_price_min = isset($_GET['prix_min']) ? intval($_GET['prix_min']) : '';
$filter_price_max = isset($_GET['prix_max']) ? intval($_GET['prix_max']) : '';

// Build query based on display mode
if ($display_mode === 'selection' && !empty($selected_properties)) {
    // Selection mode: Get only selected properties
    $property_ids = array_map(function($item) {
        return $item['property'] ?? 0;
    }, $selected_properties);
    $property_ids = array_filter($property_ids);

    $args = [
        'post_type' => 'property',
        'post__in' => $property_ids,
        'posts_per_page' => count($property_ids),
        'post_status' => 'publish',
        'orderby' => 'post__in',
    ];
} else {
    // Auto mode: Query with filters
    $args = [
        'post_type' => 'property',
        'posts_per_page' => $posts_per_page,
        'post_status' => 'publish',
        'meta_query' => ['relation' => 'AND'],
    ];

    // Apply filters
    if ($filter_type) {
        $args['tax_query'][] = [
            'taxonomy' => 'property_type',
            'field' => 'slug',
            'terms' => $filter_type,
        ];
    }

    if ($filter_commune) {
        $args['meta_query'][] = [
            'key' => 'property_commune',
            'value' => $filter_commune,
            'compare' => '=',
        ];
    }

    if ($filter_price_min) {
        $args['meta_query'][] = [
            'key' => 'property_price',
            'value' => $filter_price_min,
            'type' => 'NUMERIC',
            'compare' => '>=',
        ];
    }

    if ($filter_price_max) {
        $args['meta_query'][] = [
            'key' => 'property_price',
            'value' => $filter_price_max,
            'type' => 'NUMERIC',
            'compare' => '<=',
        ];
    }
}

$properties = new WP_Query($args);

// Get all property types for filter
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
?>

<section class="py-16 lg:py-24 <?php echo esc_attr($bg_class); ?>">
    <div class="container mx-auto px-4 lg:px-8">

        <!-- Header -->
        <div class="text-center mb-12">
            <?php if ($subtitle) : ?>
                <p class="text-primary font-semibold text-sm uppercase tracking-wider mb-2">
                    <?php echo esc_html($subtitle); ?>
                </p>
            <?php endif; ?>

            <?php if ($title) : ?>
                <h2 class="text-3xl lg:text-4xl font-bold <?php echo $text_dark ? 'text-white' : 'text-gray-900 dark:text-white'; ?>">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>
        </div>

        <?php if ($show_filters) : ?>
        <!-- Filters -->
        <form method="get" class="mb-10 p-6 rounded-xl <?php echo $text_dark ? 'bg-white/10' : 'bg-gray-100 dark:bg-gray-800'; ?>">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <!-- Type filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 <?php echo $text_dark ? 'text-gray-200' : 'text-gray-700 dark:text-gray-300'; ?>">
                        Type de bien
                    </label>
                    <select name="type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">Tous les types</option>
                        <?php if (!is_wp_error($property_types) && !empty($property_types)) : ?>
                            <?php foreach ($property_types as $type) : ?>
                                <option value="<?php echo esc_attr($type->slug); ?>" <?php selected($filter_type, $type->slug); ?>>
                                    <?php echo esc_html($type->name); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <option value="terrain">Terrain</option>
                            <option value="maison">Maison</option>
                            <option value="villa">Villa</option>
                            <option value="appartement">Appartement</option>
                            <option value="immeuble">Immeuble</option>
                            <option value="bureau">Bureau</option>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Commune filter -->
                <div>
                    <label class="block text-sm font-medium mb-2 <?php echo $text_dark ? 'text-gray-200' : 'text-gray-700 dark:text-gray-300'; ?>">
                        Commune
                    </label>
                    <select name="commune" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary">
                        <option value="">Toutes les communes</option>
                        <?php foreach ($communes as $slug => $name) : ?>
                            <option value="<?php echo esc_attr($slug); ?>" <?php selected($filter_commune, $slug); ?>>
                                <?php echo esc_html($name); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Price min -->
                <div>
                    <label class="block text-sm font-medium mb-2 <?php echo $text_dark ? 'text-gray-200' : 'text-gray-700 dark:text-gray-300'; ?>">
                        Prix min (GNF)
                    </label>
                    <input type="number" name="prix_min" value="<?php echo esc_attr($filter_price_min); ?>"
                           placeholder="0"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary">
                </div>

                <!-- Price max -->
                <div>
                    <label class="block text-sm font-medium mb-2 <?php echo $text_dark ? 'text-gray-200' : 'text-gray-700 dark:text-gray-300'; ?>">
                        Prix max (GNF)
                    </label>
                    <input type="number" name="prix_max" value="<?php echo esc_attr($filter_price_max); ?>"
                           placeholder="Illimite"
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary">
                </div>

                <!-- Submit -->
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 hover:scale-105 active:scale-95">
                        Filtrer
                    </button>
                </div>
            </div>
        </form>
        <?php endif; ?>

        <!-- Properties Grid -->
        <?php if ($properties->have_posts()) : ?>
            <div class="grid grid-cols-1 <?php echo esc_attr($grid_cols); ?> gap-6 lg:gap-8">
                <?php while ($properties->have_posts()) : $properties->the_post();
                    $prix = get_field('property_price');
                    $surface = get_field('property_surface');
                    $chambres = get_field('property_bedrooms');
                    $commune = get_field('property_commune');
                    $quartier = get_field('property_quarter');
                    $statut = get_field('property_status') ?: 'disponible';
                ?>
                    <article class="group bg-white dark:bg-gray-800 rounded-xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 cursor-pointer relative">
                        <!-- Clickable overlay -->
                        <a href="<?php the_permalink(); ?>" class="absolute inset-0 z-10" aria-label="<?php the_title_attribute(); ?>"></a>

                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('card', ['class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500']); ?>
                            <?php else :
                                $property_type_field = get_field('property_type_field') ?: 'maison';
                                $placeholder_url = socorif_get_property_placeholder($property_type_field, 'card');
                            ?>
                                <img src="<?php echo esc_url($placeholder_url); ?>"
                                     alt="<?php the_title_attribute(); ?>"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                            <?php endif; ?>

                            <!-- Status badge -->
                            <?php
                            $statut_colors = [
                                'disponible' => 'bg-green-500',
                                'vendu' => 'bg-red-500',
                                'reserve' => 'bg-yellow-500',
                                'loue' => 'bg-blue-500',
                            ];
                            $statut_labels = [
                                'disponible' => 'Disponible',
                                'vendu' => 'Vendu',
                                'reserve' => 'Reserve',
                                'loue' => 'Loue',
                            ];
                            ?>
                            <span class="absolute top-4 left-4 <?php echo esc_attr($statut_colors[$statut] ?? 'bg-gray-500'); ?> text-white text-xs font-semibold px-3 py-1 rounded-full">
                                <?php echo esc_html($statut_labels[$statut] ?? 'Disponible'); ?>
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <!-- Price -->
                            <?php if ($prix) : ?>
                                <p class="text-primary font-bold text-xl mb-2">
                                    <?php echo number_format($prix, 0, ',', ' '); ?> GNF
                                </p>
                            <?php endif; ?>

                            <!-- Title -->
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                <?php the_title(); ?>
                            </h3>

                            <!-- Location -->
                            <?php if ($quartier || $commune) : ?>
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <?php
                                    echo esc_html($quartier);
                                    if ($quartier && $commune) echo ', ';
                                    echo esc_html($communes[$commune] ?? $commune);
                                    ?>
                                </p>
                            <?php endif; ?>

                            <!-- Features -->
                            <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 pt-4 border-t border-gray-100 dark:border-gray-700">
                                <?php if ($surface) : ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                        <?php echo esc_html($surface); ?> m²
                                    </span>
                                <?php endif; ?>

                                <?php if ($chambres) : ?>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <?php echo esc_html($chambres); ?> ch.
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- View all link -->
            <div class="text-center mt-10">
                <a href="<?php echo get_post_type_archive_link('property'); ?>"
                   class="inline-flex items-center gap-2 text-primary hover:text-primary-dark font-semibold transition-colors">
                    Voir tous les biens
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>

        <?php else : ?>
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                <p class="text-gray-500 dark:text-gray-400 text-lg">Aucune propriete trouvee</p>
                <p class="text-gray-400 dark:text-gray-500 mt-2">Essayez de modifier vos criteres de recherche</p>
            </div>
        <?php endif; ?>

        <?php wp_reset_postdata(); ?>
    </div>
</section>
