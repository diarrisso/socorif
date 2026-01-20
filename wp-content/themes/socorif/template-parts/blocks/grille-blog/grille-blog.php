<?php
/**
 * Template du bloc Grille Blog
 *
 * Systeme complet de grille blog avec integration WordPress, filtres, pagination, et plus
 */

if (!defined('ABSPATH')) {
    exit;
}

// Charger la configuration du bloc
require_once __DIR__ . '/config.php';

// Recuperer les donnees du bloc
// Contenu
$section_title = socorif_get_field('section_title', 'Notre Blog');
$section_description = socorif_get_field('section_description', '');
$content_source = socorif_get_field('content_source', 'wordpress');

// Parametres des articles WordPress
$post_type = socorif_get_field('post_type', 'post');
$posts_per_page = socorif_get_field('posts_per_page', 6);
$orderby = socorif_get_field('orderby', 'date');
$selected_categories = socorif_get_field('categories', []);
$selected_tags = socorif_get_field('tags', []);

// Articles manuels
$manual_articles = socorif_get_field('articles', []);

// Filtre et recherche
$enable_filters = socorif_get_field('enable_filters');
$show_category_filter = socorif_get_field('show_category_filter');
$show_tag_filter = socorif_get_field('show_tag_filter');
$show_search = socorif_get_field('show_search');
$show_sort = socorif_get_field('show_sort');

// Pagination
$pagination_type = socorif_get_field('pagination_type', 'loadmore');

// Mise en page et affichage
$view_mode = socorif_get_field('view_mode', 'grid');
$allow_view_switch = socorif_get_field('allow_view_switch');
$columns = socorif_get_field('columns', '3');
$gap = socorif_get_field('gap', '8');

// Options d'affichage
$show_date = socorif_get_field('show_date') !== false ? socorif_get_field('show_date') : true;
$show_author = socorif_get_field('show_author') !== false ? socorif_get_field('show_author') : true;
$show_excerpt = socorif_get_field('show_excerpt');
$show_categories = socorif_get_field('show_categories');
$excerpt_length = socorif_get_field('excerpt_length') ?: 20;

// Styling
$card_style = socorif_get_field('card_style') ?: 'overlay';
$image_ratio = socorif_get_field('image_ratio') ?: 'auto';
$overlay_color = socorif_get_field('overlay_color') ?: 'dark';
$overlay_intensity = socorif_get_field('overlay_intensity') ?: 60;
$border_radius = socorif_get_field('border_radius') ?: 'xl';
$hover_effect = socorif_get_field('hover_effect') ?: 'scale';

// Champs standards
$spacing = socorif_get_field('spacing') ?: [];
$background = socorif_get_field('background') ?: [];
$animation = socorif_get_field('animation') ?: [];
$stagger_animation = socorif_get_field('stagger_animation') !== false ? socorif_get_field('stagger_animation') : true;

// Requete WordPress (si source WordPress)
$posts = [];
$max_pages = 1;
$total_posts = 0;

if ($content_source === 'wordpress') {
    $query_args = [
        'post_type'      => $post_type,
        'posts_per_page' => $posts_per_page,
        'paged'          => 1,
        'orderby'        => $orderby,
        'order'          => 'DESC',
        'post_status'    => 'publish',
    ];

    if (!empty($selected_categories)) {
        $query_args['cat'] = $selected_categories;
    }

    if (!empty($selected_tags)) {
        $query_args['tag__in'] = $selected_tags;
    }

    $query = new WP_Query($query_args);
    $max_pages = $query->max_num_pages;
    $total_posts = $query->found_posts;

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $thumbnail = get_the_post_thumbnail_url($post_id, 'large');

            $posts[] = [
                'id'         => $post_id,
                'title'      => get_the_title(),
                'excerpt'    => wp_trim_words(get_the_excerpt(), $excerpt_length, '...'),
                'permalink'  => get_permalink(),
                'date'       => get_the_date('Y-m-d'),
                'date_formatted' => get_the_date('j. M Y'),
                'thumbnail'  => $thumbnail ?: '',
                'author'     => [
                    'name'   => get_the_author(),
                    'avatar' => get_avatar_url(get_the_author_meta('ID')),
                ],
                'categories' => get_the_category(),
            ];
        }
        wp_reset_postdata();
    }
} else {
    // Mode manuel
    $posts = array_map(function($article) use ($excerpt_length) {
        return [
            'title'      => $article['title'] ?? '',
            'excerpt'    => isset($article['excerpt']) ? wp_trim_words($article['excerpt'], $excerpt_length, '...') : '',
            'permalink'  => $article['link']['url'] ?? '#',
            'date'       => $article['date'] ?? '',
            'date_formatted' => isset($article['date']) ? date_i18n('j. M Y', strtotime($article['date'])) : '',
            'thumbnail'  => $article['image']['url'] ?? '',
            'author'     => [
                'name'   => $article['author_name'] ?? '',
                'avatar' => $article['author_avatar']['url'] ?? '',
            ],
            'categories' => [],
        ];
    }, $manual_articles);
}

// ID du bloc pour AJAX
$block_id = 'blog-grid-' . uniqid();

// Creer les classes
$spacing_classes = socorif_build_spacing_classes($spacing);

$columns_class = match($columns) {
    '2' => 'lg:grid-cols-2',
    '3' => 'lg:grid-cols-3',
    '4' => 'lg:grid-cols-4',
    default => 'lg:grid-cols-3',
};

$gap_class = 'gap-' . $gap;

$border_radius_class = match($border_radius) {
    'none' => '',
    'sm'   => 'rounded-lg',
    'md'   => 'rounded-xl',
    'lg'   => 'rounded-2xl',
    'xl'   => 'rounded-3xl',
    default => 'rounded-2xl',
};

$section_classes = [
    'blog-grid-block',
    'relative',
    'bg-white',
    'dark:bg-gray-900',
    $spacing_classes,
];

if (!empty($animation['enabled'])) {
    $section_classes[] = 'animate-on-scroll';
    $section_classes[] = 'animation-' . ($animation['type'] ?? 'fade-up');
}

$wrapper_attributes = get_block_wrapper_attributes([
    'class' => implode(' ', $section_classes),
    'id' => $block_id,
]);

// Donnees Alpine.js
$alpine_data = [
    'view' => $view_mode,
    'loading' => false,
    'currentPage' => 1,
    'maxPages' => $max_pages,
    'selectedCategories' => [],
    'selectedTags' => [],
    'searchQuery' => '',
    'sortBy' => $orderby,
    'posts' => $posts,
];

// Afficher le commentaire d'identification du bloc
socorif_block_comment_start('blog-grid');
?>

<section
    <?php echo $wrapper_attributes; ?>
    x-data='<?php echo wp_json_encode($alpine_data); ?>'
    x-init="$nextTick(() => { if (window.BlogGrid) { window.BlogGrid.init($el, '<?php echo $block_id; ?>') } })"
>

    <?php if (!empty($background['enabled'])): ?>
        <?php get_template_part('template-parts/components/background', null, $background); ?>
    <?php endif; ?>

    <div class="container mx-auto px-4 lg:px-8">

        <!-- En-tete -->
        <?php if ($section_title || $section_description): ?>
        <div class="mx-auto max-w-2xl text-center">
            <?php if ($section_title): ?>
                <h2 class="section-title">
                    <?php echo esc_html($section_title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($section_description): ?>
                <p class="section-description mt-2">
                    <?php echo esc_html($section_description); ?>
                </p>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- Filtres et controles -->
        <?php if ($enable_filters || $allow_view_switch): ?>
        <div class="mt-12 flex flex-wrap items-center justify-between gap-4">

            <!-- Filtres -->
            <?php if ($enable_filters): ?>
            <div class="flex flex-wrap items-center gap-4 flex-1">

                <!-- Recherche -->
                <?php if ($show_search): ?>
                <div class="relative flex-1 min-w-[200px] max-w-md">
                    <input
                        type="text"
                        x-model="searchQuery"
                        @input.debounce.500ms="$dispatch('blog-grid-filter')"
                        placeholder="Rechercher..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    >
                    <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <?php endif; ?>

                <!-- Filtre par categorie -->
                <?php if ($show_category_filter && $content_source === 'wordpress'): ?>
                    <?php
                    $all_categories = get_categories(['hide_empty' => true]);
                    if (!empty($all_categories)):
                    ?>
                    <select
                        x-model="selectedCategories"
                        @change="$dispatch('blog-grid-filter')"
                        class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-primary dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                    >
                        <option value="">Toutes les categories</option>
                        <?php foreach ($all_categories as $cat): ?>
                            <option value="<?php echo esc_attr($cat->term_id); ?>">
                                <?php echo esc_html($cat->name); ?> (<?php echo $cat->count; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php endif; ?>
                <?php endif; ?>

                <!-- Tri -->
                <?php if ($show_sort): ?>
                <select
                    x-model="sortBy"
                    @change="$dispatch('blog-grid-filter')"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent dark:bg-gray-800 dark:border-gray-700 dark:text-white"
                >
                    <option value="date">Plus recents</option>
                    <option value="title">Titre A-Z</option>
                    <option value="modified">Derniere mise a jour</option>
                    <option value="comment_count">Les plus populaires</option>
                </select>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <!-- Selecteur de vue -->
            <?php if ($allow_view_switch): ?>
            <div class="flex items-center gap-2 bg-gray-100 dark:bg-gray-800 rounded-lg p-1">
                <button
                    @click="view = 'grid'"
                    :class="view === 'grid' ? 'bg-white dark:bg-gray-700 shadow' : ''"
                    class="p-2 rounded transition-all"
                    title="Vue grille"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                </button>
                <button
                    @click="view = 'list'"
                    :class="view === 'list' ? 'bg-white dark:bg-gray-700 shadow' : ''"
                    class="p-2 rounded transition-all"
                    title="Vue liste"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <button
                    @click="view = 'slider'"
                    :class="view === 'slider' ? 'bg-white dark:bg-gray-700 shadow' : ''"
                    class="p-2 rounded transition-all"
                    title="Vue slider"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                </button>
            </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <!-- Grille/Liste des articles -->
        <div
            class="mt-16 sm:mt-20"
            :class="{
                'grid auto-rows-fr grid-cols-1 <?php echo esc_attr($columns_class . ' ' . $gap_class); ?>': view === 'grid',
                'flex flex-col <?php echo esc_attr($gap_class); ?>': view === 'list',
                'relative': view === 'slider'
            }"
        >
            <template x-for="(post, index) in posts" :key="post.id || index">
                <article
                    class="blog-grid-article"
                    :class="{
                        'blog-grid-card-overlay': view === 'grid' && '<?php echo $card_style; ?>' === 'overlay',
                        'blog-grid-card-classic': view === 'grid' && '<?php echo $card_style; ?>' === 'classic',
                        'blog-grid-card-list': view === 'list'
                    }"
                    <?php if ($stagger_animation): ?>
                    :style="`animation-delay: ${index * 100}ms`"
                    <?php endif; ?>
                >
                    <!-- Style grille overlay -->
                    <template x-if="view === 'grid' && '<?php echo $card_style; ?>' === 'overlay'">
                        <div class="relative isolate flex flex-col justify-end overflow-hidden <?php echo esc_attr($border_radius_class); ?> bg-gray-900 px-8 pt-80 pb-8 sm:pt-48 lg:pt-80 dark:bg-gray-800 transition-all duration-300 hover-<?php echo esc_attr($hover_effect); ?>">

                            <!-- Image de fond -->
                            <img
                                :src="post.thumbnail"
                                :alt="post.title"
                                class="absolute inset-0 -z-10 size-full object-cover"
                                loading="lazy"
                            />

                            <!-- Overlay gradient -->
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40 dark:from-black/80 dark:via-black/40"
                                 style="opacity: <?php echo esc_attr($overlay_intensity / 100); ?>"></div>

                            <!-- Bordure anneau -->
                            <div class="absolute inset-0 -z-10 <?php echo esc_attr($border_radius_class); ?> ring-1 ring-inset ring-gray-900/10 dark:ring-white/10"></div>

                            <!-- Metadonnees -->
                            <div class="flex flex-wrap items-center gap-y-1 overflow-hidden text-sm/6 text-gray-300">
                                <?php if ($show_date): ?>
                                <time :datetime="post.date" class="mr-8" x-text="post.date_formatted"></time>
                                <?php endif; ?>

                                <?php if ($show_author): ?>
                                <div class="-ml-4 flex items-center gap-x-4">
                                    <svg viewBox="0 0 2 2" class="-ml-0.5 size-0.5 flex-none fill-white/50 dark:fill-gray-300/50">
                                        <circle r="1" cx="1" cy="1" />
                                    </svg>
                                    <div class="flex gap-x-2.5 items-center">
                                        <img
                                            x-show="post.author.avatar"
                                            :src="post.author.avatar"
                                            :alt="post.author.name"
                                            class="size-6 flex-none rounded-full bg-white/10 dark:bg-gray-800/10 object-cover"
                                        />
                                        <span x-text="post.author.name"></span>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <!-- Titre -->
                            <h3 class="mt-3 text-lg/6 font-semibold text-white">
                                <a :href="post.permalink" class="hover:underline cursor-pointer">
                                    <span class="absolute inset-0"></span>
                                    <span x-text="post.title"></span>
                                </a>
                            </h3>

                            <?php if ($show_excerpt): ?>
                            <p class="mt-2 text-sm text-gray-300" x-text="post.excerpt"></p>
                            <?php endif; ?>

                        </div>
                    </template>

                    <!-- Style carte classique -->
                    <template x-if="view === 'grid' && '<?php echo $card_style; ?>' === 'classic'">
                        <div class="bg-white dark:bg-gray-800 <?php echo esc_attr($border_radius_class); ?> overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300">
                            <div class="aspect-video overflow-hidden">
                                <img
                                    :src="post.thumbnail"
                                    :alt="post.title"
                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                />
                            </div>
                            <div class="p-6">
                                <?php if ($show_categories && $content_source === 'wordpress'): ?>
                                <div class="flex gap-2 mb-3">
                                    <template x-for="cat in post.categories" :key="cat.id">
                                        <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded" x-text="cat.name"></span>
                                    </template>
                                </div>
                                <?php endif; ?>

                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    <a :href="post.permalink" class="hover:text-primary transition-colors cursor-pointer" x-text="post.title"></a>
                                </h3>

                                <?php if ($show_excerpt): ?>
                                <p class="text-gray-600 dark:text-gray-400 mb-4" x-text="post.excerpt"></p>
                                <?php endif; ?>

                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php if ($show_date): ?>
                                    <time :datetime="post.date" x-text="post.date_formatted"></time>
                                    <?php endif; ?>

                                    <?php if ($show_author): ?>
                                    <div class="flex items-center gap-2">
                                        <img
                                            x-show="post.author.avatar"
                                            :src="post.author.avatar"
                                            :alt="post.author.name"
                                            class="w-6 h-6 rounded-full object-cover"
                                        />
                                        <span x-text="post.author.name"></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Vue liste -->
                    <template x-if="view === 'list'">
                        <div class="flex flex-col md:flex-row gap-6 bg-white dark:bg-gray-800 <?php echo esc_attr($border_radius_class); ?> overflow-hidden shadow-lg p-6">
                            <div class="md:w-1/3 flex-shrink-0">
                                <img
                                    :src="post.thumbnail"
                                    :alt="post.title"
                                    class="w-full h-48 md:h-full object-cover <?php echo esc_attr($border_radius_class); ?>"
                                    loading="lazy"
                                />
                            </div>
                            <div class="flex-1">
                                <?php if ($show_categories && $content_source === 'wordpress'): ?>
                                <div class="flex gap-2 mb-3">
                                    <template x-for="cat in post.categories" :key="cat.id">
                                        <span class="text-xs px-2 py-1 bg-primary/10 text-primary rounded" x-text="cat.name"></span>
                                    </template>
                                </div>
                                <?php endif; ?>

                                <h3 class="text-2xl font-semibold text-gray-900 dark:text-white mb-3">
                                    <a :href="post.permalink" class="hover:text-primary transition-colors cursor-pointer" x-text="post.title"></a>
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 mb-4" x-text="post.excerpt"></p>

                                <div class="flex items-center gap-4 text-sm text-gray-500 dark:text-gray-400">
                                    <?php if ($show_date): ?>
                                    <time :datetime="post.date" x-text="post.date_formatted"></time>
                                    <?php endif; ?>

                                    <?php if ($show_author): ?>
                                    <div class="flex items-center gap-2">
                                        <img
                                            x-show="post.author.avatar"
                                            :src="post.author.avatar"
                                            :alt="post.author.name"
                                            class="w-6 h-6 rounded-full object-cover"
                                        />
                                        <span x-text="post.author.name"></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </template>

                </article>
            </template>
        </div>

        <!-- Pagination -->
        <?php if ($content_source === 'wordpress' && $pagination_type !== 'none'): ?>
        <div class="mt-12 flex justify-center" x-show="maxPages > 1">

            <?php if ($pagination_type === 'loadmore'): ?>
            <button
                @click="$dispatch('blog-grid-loadmore')"
                x-show="currentPage < maxPages"
                :disabled="loading"
                class="btn btn-primary px-8 py-3 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer"
            >
                <span x-show="!loading">Charger plus</span>
                <span x-show="loading">Chargement...</span>
            </button>
            <?php endif; ?>

            <?php if ($pagination_type === 'standard'): ?>
            <nav class="flex items-center gap-2">
                <button
                    @click="currentPage > 1 && $dispatch('blog-grid-page', {page: currentPage - 1})"
                    :disabled="currentPage === 1 || loading"
                    class="btn px-4 py-2 disabled:opacity-50"
                >
                    Precedent
                </button>

                <template x-for="page in Array.from({length: maxPages}, (_, i) => i + 1)" :key="page">
                    <button
                        @click="$dispatch('blog-grid-page', {page: page})"
                        :class="page === currentPage ? 'btn-primary' : 'btn'"
                        class="px-4 py-2"
                        x-text="page"
                    ></button>
                </template>

                <button
                    @click="currentPage < maxPages && $dispatch('blog-grid-page', {page: currentPage + 1})"
                    :disabled="currentPage === maxPages || loading"
                    class="btn px-4 py-2 disabled:opacity-50"
                >
                    Suivant
                </button>
            </nav>
            <?php endif; ?>

        </div>
        <?php endif; ?>

        <!-- Etat de chargement -->
        <div x-show="loading" class="mt-8 text-center">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-gray-300 border-t-primary"></div>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Chargement...</p>
        </div>

    </div>

</section>

<?php socorif_block_comment_end('blog-grid'); ?>

<?php
// Fournir les donnees pour JavaScript
if ($content_source === 'wordpress'):
?>
<script>
    window.blogGridConfig = window.blogGridConfig || {};
    window.blogGridConfig['<?php echo esc_js($block_id); ?>'] = {
        ajaxUrl: '<?php echo esc_url(admin_url('admin-ajax.php')); ?>',
        nonce: '<?php echo wp_create_nonce('socorif_blog_grid_nonce'); ?>',
        postsPerPage: <?php echo intval($posts_per_page); ?>,
        orderby: '<?php echo esc_js($orderby); ?>',
        selectedCategories: <?php echo wp_json_encode($selected_categories); ?>,
        selectedTags: <?php echo wp_json_encode($selected_tags); ?>,
        paginationType: '<?php echo esc_js($pagination_type); ?>',
    };
</script>
<?php endif; ?>
