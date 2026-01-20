<?php
/**
 * Projects Grid Block Template
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('projects-grid');

// Felder abrufen
$subtitle = socorif_get_field('subtitle');
$title = socorif_get_field('title');
$bg_color = socorif_get_field('bg_color', 'white');
$mode = socorif_get_field('projects_mode', 'auto');

// Projekte laden basierend auf Modus
$projects = [];

if ($mode === 'auto') {
    // Automatischer Modus: Projekte aus CPT laden
    $count = socorif_get_field('projects_count', 6);
    $category = socorif_get_field('projects_category');
    $type = socorif_get_field('projects_type');
    $featured_only = socorif_get_field('projects_featured_only', false);
    $orderby = socorif_get_field('projects_orderby', 'date');

    // Query-Args aufbauen
    $args = [
        'post_type' => 'projekte',
        'posts_per_page' => intval($count),
        'post_status' => 'publish',
        'orderby' => $orderby,
        'order' => ($orderby === 'title') ? 'ASC' : 'DESC',
    ];

    // Taxonomie-Filter
    $tax_query = [];
    if ($category) {
        $tax_query[] = [
            'taxonomy' => 'projekt_kategorie',
            'field' => 'term_id',
            'terms' => $category,
        ];
    }
    if ($type) {
        $tax_query[] = [
            'taxonomy' => 'projekt_typ',
            'field' => 'term_id',
            'terms' => $type,
        ];
    }
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    // Featured Filter
    if ($featured_only) {
        $args['meta_query'] = [
            [
                'key' => 'projekt_featured',
                'value' => '1',
                'compare' => '=',
            ],
        ];
    }

    // Query ausführen
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();

            // Projekt-Daten sammeln
            $kategorien = get_the_terms(get_the_ID(), 'projekt_kategorie');
            $category_name = ($kategorien && !is_wp_error($kategorien)) ? $kategorien[0]->name : '';

            $projects[] = [
                'image' => get_post_thumbnail_id(),
                'title' => get_the_title(),
                'category' => $category_name,
                'link' => [
                    'url' => get_permalink(),
                    'title' => get_the_title(),
                    'target' => '',
                ],
            ];
        }
        wp_reset_postdata();
    }
} else {
    // Selection mode: Use repeater with post_object
    $selected_projects = socorif_get_field('projects', []);

    if ($selected_projects) {
        foreach ($selected_projects as $item) {
            $project_id = $item['project'] ?? null;
            if (!$project_id) continue;

            // Get project data
            $kategorien = get_the_terms($project_id, 'projekt_kategorie');
            $category_name = ($kategorien && !is_wp_error($kategorien)) ? $kategorien[0]->name : '';

            // Use custom image if provided, otherwise use featured image
            $image = !empty($item['custom_image']) ? $item['custom_image'] : get_post_thumbnail_id($project_id);

            $projects[] = [
                'image' => $image,
                'title' => get_the_title($project_id),
                'category' => $category_name,
                'link' => [
                    'url' => get_permalink($project_id),
                    'title' => get_the_title($project_id),
                    'target' => '',
                ],
            ];
        }
    }
}

// Background classes avec dark mode
$bg_classes = [
    'white' => 'bg-white dark:bg-gray-900',
    'gray-50' => 'bg-gray-50 dark:bg-gray-800',
];

$section_classes = socorif_merge_classes(
    'projects-grid-block section',
    $bg_classes[$bg_color] ?? 'bg-white dark:bg-gray-900'
);
?>

<section class="<?php echo esc_attr($section_classes); ?>">
    <div class="container">

        <?php if ($subtitle || $title) : ?>
            <div class="text-center mb-8 md:mb-12">
                <?php if ($subtitle) : ?>
                    <p class="text-primary font-semibold uppercase tracking-wider mb-2 text-xs md:text-sm">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($title) : ?>
                    <h2 class="section-title text-gray-900 dark:text-white">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ($projects) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                <?php foreach ($projects as $project) : ?>
                    <div class="group relative overflow-hidden rounded-3xl aspect-[4/3] shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border-2 border-transparent hover:border-primary/20 cursor-pointer">
                        <?php if (!empty($project['image'])) : ?>
                            <?php echo socorif_image($project['image'], 'card', ['class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-110']); ?>
                        <?php endif; ?>

                        <!-- Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-3xl">
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 text-white transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                                <?php if (!empty($project['category'])) : ?>
                                    <span class="inline-block bg-gradient-to-r from-primary to-primary-dark text-white text-xs md:text-sm font-bold uppercase tracking-wider px-4 py-2 rounded-3xl mb-3 shadow-lg shadow-primary/30">
                                        <?php echo esc_html($project['category']); ?>
                                    </span>
                                <?php endif; ?>

                                <?php if (!empty($project['title'])) : ?>
                                    <h3 class="text-xl md:text-2xl font-bold border-l-4 border-primary pl-4">
                                        <?php if (!empty($project['link'])) : ?>
                                            <a href="<?php echo esc_url($project['link']['url']); ?>"
                                               class="text-primary dark:text-white hover:text-primary-dark dark:hover:text-gray-200 transition-colors flex items-center gap-2 cursor-pointer"
                                               <?php echo !empty($project['link']['target']) ? 'target="' . esc_attr($project['link']['target']) . '"' : ''; ?>>
                                                <?php echo esc_html($project['title']); ?>
                                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </a>
                                        <?php else : ?>
                                            <?php echo esc_html($project['title']); ?>
                                        <?php endif; ?>
                                    </h3>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php
// Block-Ende markieren
socorif_block_comment_end('projects-grid');
