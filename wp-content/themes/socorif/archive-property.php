<?php
/**
 * Template pour l'archive des biens immobiliers
 */

if (!defined('ABSPATH')) exit;

get_header();

// Breadcrumb
$breadcrumb = [
    ['label' => 'Accueil', 'link' => home_url('/')],
    ['label' => 'Biens Immobiliers', 'link' => ''],
];
?>

<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-secondary via-secondary/90 to-primary/70 py-20 md:py-28">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="container relative z-10">
        <!-- Breadcrumb -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2 text-sm">
                <?php foreach ($breadcrumb as $index => $item) :
                    $is_last = ($index === count($breadcrumb) - 1);
                ?>
                    <li class="flex items-center gap-2">
                        <?php if ($item['link'] && !$is_last) : ?>
                            <a href="<?php echo esc_url($item['link']); ?>"
                               class="text-gray-200 hover:text-white transition-colors duration-200 font-medium">
                                <?php echo esc_html($item['label']); ?>
                            </a>
                        <?php else : ?>
                            <span class="<?php echo $is_last ? 'text-primary font-semibold' : 'text-gray-200'; ?>">
                                <?php echo esc_html($item['label']); ?>
                            </span>
                        <?php endif; ?>

                        <?php if (!$is_last) : ?>
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ol>
        </nav>

        <div class="max-w-3xl">
            <span class="inline-block px-4 py-2 bg-primary text-white text-sm font-semibold rounded-full mb-6">
                Immobilier
            </span>
            <h1 class="page-title text-white mb-6">
                Nos Biens Immobiliers
            </h1>
            <p class="section-description text-gray-200">
                Decouvrez notre selection de terrains, maisons et proprietes a vendre ou a louer.
            </p>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-20">
    <div class="container py-4">
        <div class="flex flex-wrap gap-3 justify-center">
            <?php
            $categories = get_terms([
                'taxonomy' => 'property_category',
                'hide_empty' => true,
            ]);

            $types = get_terms([
                'taxonomy' => 'property_type',
                'hide_empty' => true,
            ]);

            $current_term = get_queried_object();
            $is_archive = is_post_type_archive('property');
            ?>

            <a href="<?php echo get_post_type_archive_link('property'); ?>"
               class="<?php echo $is_archive ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'; ?> px-4 py-2 rounded-full text-sm font-medium transition-colors">
                Tous les biens
            </a>

            <?php if ($categories && !is_wp_error($categories)) : ?>
                <?php foreach ($categories as $category) :
                    $is_active = (is_tax('property_category', $category->term_id));
                ?>
                    <a href="<?php echo get_term_link($category); ?>"
                       class="<?php echo $is_active ? 'bg-primary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'; ?> px-4 py-2 rounded-full text-sm font-medium transition-colors">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($types && !is_wp_error($types)) : ?>
                <span class="text-gray-300 dark:text-gray-600">|</span>
                <?php foreach ($types as $type) :
                    $is_active = (is_tax('property_type', $type->term_id));
                ?>
                    <a href="<?php echo get_term_link($type); ?>"
                       class="<?php echo $is_active ? 'bg-secondary text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700'; ?> px-4 py-2 rounded-full text-sm font-medium transition-colors">
                        <?php echo esc_html($type->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Liste des biens -->
<section class="section bg-gray-50 dark:bg-gray-800">
    <div class="container">
        <?php if (have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while (have_posts()) : the_post();
                    $featured_image = get_the_post_thumbnail_url(get_the_ID(), 'card');
                    $property_type_field = get_field('property_type_field') ?: 'maison';
                    if (!$featured_image) {
                        $featured_image = socorif_get_property_placeholder($property_type_field, 'card');
                    }
                    $categories = get_the_terms(get_the_ID(), 'property_category');
                    $types = get_the_terms(get_the_ID(), 'property_type');
                    $price = get_field('property_price');
                    $surface = get_field('property_surface');
                    $city = get_field('property_city') ?: 'Conakry';
                    $commune = get_field('property_commune');
                    $quartier = get_field('property_quarter');
                    $reference = get_field('property_reference');
                ?>
                    <article class="bg-white dark:bg-gray-900 rounded-2xl shadow-lg overflow-hidden group hover:shadow-xl transition-shadow duration-300">
                        <!-- Image -->
                        <div class="relative aspect-[4/3] overflow-hidden">
                            <img src="<?php echo esc_url($featured_image); ?>"
                                 alt="<?php echo esc_attr(get_the_title()); ?>"
                                 class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110"
                                 loading="lazy">

                            <!-- Badges -->
                            <div class="absolute top-4 left-4 flex flex-wrap gap-2">
                                <?php if ($categories) : ?>
                                    <?php foreach ($categories as $category) : ?>
                                        <span class="px-3 py-1 bg-primary text-white text-xs font-semibold rounded-full shadow">
                                            <?php echo esc_html($category->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if ($types) : ?>
                                    <?php foreach ($types as $type) : ?>
                                        <span class="px-3 py-1 bg-secondary text-white text-xs font-semibold rounded-full shadow">
                                            <?php echo esc_html($type->name); ?>
                                        </span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Prix -->
                            <?php if ($price) : ?>
                                <div class="absolute bottom-4 right-4">
                                    <span class="px-4 py-2 bg-white dark:bg-gray-900 text-primary font-bold rounded-lg shadow-lg">
                                        <?php echo number_format($price, 0, ',', ' '); ?> GNF
                                    </span>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Contenu -->
                        <div class="p-6">
                            <!-- Reference -->
                            <?php if ($reference) : ?>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                                    Ref: <?php echo esc_html($reference); ?>
                                </p>
                            <?php endif; ?>

                            <!-- Titre -->
                            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3 line-clamp-2">
                                <a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors">
                                    <?php the_title(); ?>
                                </a>
                            </h2>

                            <!-- Localisation -->
                            <?php
                            $communes_labels = [
                                'kaloum' => 'Kaloum',
                                'dixinn' => 'Dixinn',
                                'matam' => 'Matam',
                                'matoto' => 'Matoto',
                                'ratoma' => 'Ratoma',
                            ];
                            $location_parts = [];
                            if ($quartier) $location_parts[] = $quartier;
                            if ($commune && isset($communes_labels[$commune])) $location_parts[] = $communes_labels[$commune];
                            $location_parts[] = $city;
                            ?>
                            <?php if (!empty($location_parts)) : ?>
                                <div class="flex items-center gap-2 text-gray-600 dark:text-gray-400 mb-4">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    <span class="text-sm"><?php echo esc_html(implode(', ', array_unique($location_parts))); ?></span>
                                </div>
                            <?php endif; ?>

                            <!-- Caracteristiques -->
                            <?php if ($surface) : ?>
                                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400 mb-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/>
                                        </svg>
                                        <span><?php echo esc_html($surface); ?> m²</span>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Lien -->
                            <a href="<?php the_permalink(); ?>"
                               class="inline-flex items-center gap-2 text-primary hover:text-primary/80 font-semibold group/link transition-colors">
                                <span>Voir le bien</span>
                                <svg class="w-5 h-5 transition-transform group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                <?php
                the_posts_pagination([
                    'mid_size' => 2,
                    'prev_text' => '&larr; Precedent',
                    'next_text' => 'Suivant &rarr;',
                    'class' => 'flex justify-center gap-2',
                ]);
                ?>
            </div>

        <?php else : ?>
            <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Aucun bien disponible</h2>
                <p class="text-gray-600 dark:text-gray-400">
                    Aucun bien immobilier n'est disponible pour le moment. Revenez bientot!
                </p>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
