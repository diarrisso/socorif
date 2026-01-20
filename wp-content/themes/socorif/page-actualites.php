<?php
/**
 * Template Name: Actualites / Blog
 * Template Post Type: page
 *
 * Page template for News/Blog listing
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

get_header();

// Pagination
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

<main class="bg-white dark:bg-gray-900 transition-colors" role="main">
    <?php while (have_posts()) : the_post(); ?>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-secondary via-secondary-dark to-secondary py-20 md:py-28 overflow-hidden">
        <!-- Decorative elements -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-96 h-96 bg-primary rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-primary rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
        </div>

        <div class="container relative z-10">
            <div class="max-w-3xl mx-auto text-center">
                <p class="text-primary font-semibold uppercase tracking-wider mb-4 text-sm">
                    Notre Blog
                </p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white mb-6">
                    <?php the_title(); ?>
                </h1>
                <p class="text-gray-300 text-lg md:text-xl max-w-2xl mx-auto">
                    Restez informe des dernieres nouvelles et tendances du marche immobilier en Guinee
                </p>
            </div>
        </div>
    </section>

    <!-- Blog Grid -->
    <section class="py-16 md:py-24 bg-gray-50 dark:bg-gray-800">
        <div class="container">
            <?php
            // Query blog posts
            $blog_posts = new WP_Query([
                'post_type' => 'post',
                'posts_per_page' => 9,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
            ]);

            if ($blog_posts->have_posts()) :
            ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ($blog_posts->have_posts()) : $blog_posts->the_post(); ?>
                        <article class="group bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1">
                            <!-- Image -->
                            <div class="relative aspect-[16/10] overflow-hidden bg-gray-200 dark:bg-gray-700">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('card', [
                                        'class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-500',
                                    ]); ?>
                                <?php else : ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-primary/20 to-secondary/20">
                                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </div>

                            <div class="p-6">
                                <!-- Category & Date -->
                                <div class="flex items-center gap-3 text-sm text-gray-500 dark:text-gray-400 mb-3">
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories) :
                                    ?>
                                        <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-semibold uppercase tracking-wide">
                                            <?php echo esc_html($categories[0]->name); ?>
                                        </span>
                                    <?php endif; ?>
                                    <time datetime="<?php echo get_the_date('c'); ?>" class="text-gray-400">
                                        <?php echo get_the_date('d M Y'); ?>
                                    </time>
                                </div>

                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3 group-hover:text-primary transition-colors line-clamp-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-primary">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <p class="text-gray-600 dark:text-gray-400 line-clamp-3 mb-4">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </p>

                                <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-primary font-semibold hover:text-primary-dark transition-colors group/link">
                                    Lire la suite
                                    <svg class="w-4 h-4 ml-2 group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <!-- Pagination -->
                <?php if ($blog_posts->max_num_pages > 1) : ?>
                    <nav class="mt-16 flex justify-center" aria-label="Pagination">
                        <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-900 rounded-xl shadow-lg px-4 py-3">
                            <?php
                            $pagination_args = [
                                'total' => $blog_posts->max_num_pages,
                                'current' => $paged,
                                'prev_text' => '<span class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></span>',
                                'next_text' => '<span class="flex items-center justify-center w-10 h-10 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></span>',
                                'before_page_number' => '',
                                'type' => 'plain',
                            ];
                            echo paginate_links($pagination_args);
                            ?>
                        </div>
                    </nav>
                <?php endif; ?>

            <?php else : ?>
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Aucun article disponible</h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        Nous travaillons sur de nouveaux contenus. Revenez bientot pour decouvrir nos dernieres actualites.
                    </p>
                </div>
            <?php endif; ?>

            <?php wp_reset_postdata(); ?>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>