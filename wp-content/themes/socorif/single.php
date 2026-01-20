<?php
/**
 * Single Post Template
 *
 * Template for displaying single blog posts/news articles
 *
 * @package Ossenberg_Engels
 */

get_header(); ?>

<?php
// Get current post ID and colors
$post_id = get_the_ID();
?>

<main class="site-main-single bg-white dark:bg-[#212121] transition-colors">
    <?php
    while (have_posts()) :
        the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">

                <div class="flex flex-col">

                    <?php
                    // Link zurück zur Beitragsübersicht (falls definiert)
                    $posts_page_id = get_option('page_for_posts');
                    if ($posts_page_id && function_exists('pll_get_post')) {
                        // Map the posts page to the current language (Polylang)
                        $mapped_id = pll_get_post($posts_page_id);
                        if ($mapped_id) {
                            $posts_page_id = $mapped_id;
                        }
                    }
                    $back_text = function_exists('pll__') ? pll__('Retour') : __('Retour aux articles', 'socorif');
                    $back_url = $posts_page_id ? get_permalink($posts_page_id) : get_post_type_archive_link('post');
                    ?>
                    <?php if (!empty($back_url)) : ?>
                        <div class="mb-8">
                            <a href="<?php echo esc_url($back_url); ?>"
                               class="group inline-flex items-center gap-2 px-5 py-2.5 rounded-3xl bg-gray-100 hover:bg-[#E1191E] dark:bg-[#212121] dark:hover:bg-[#E1191E] text-gray-700 hover:text-white dark:text-gray-300 dark:hover:text-white transition-all duration-300 ease-out hover:shadow-lg hover:scale-105 active:scale-95 hover:-translate-y-0.5 cursor-pointer font-medium italic">
                                <svg class="w-5 h-5 transition-transform duration-300 group-hover:-translate-x-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span><?php echo esc_html($back_text); ?></span>
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="entry-header mb-12">
                        <?php
                        // Categories
                        $categories = get_the_category();
                        if ($categories):
                            ?>
                            <div class="flex flex-wrap gap-2 mb-6">
                                <?php foreach ($categories as $category): ?>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>"
                                       class="inline-flex items-center px-3 py-1 rounded-3xl text-sm font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 hover:bg-red-200 dark:hover:bg-red-800 transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <h1 class=" mb-6">
                            <?php the_title(); ?>
                        </h1>

                        <div class="flex items-center gap-6 text-sm text-gray-600 dark:text-gray-400 italic">
                            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>" class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <?php echo esc_html(get_the_date('d. F Y')); ?>
                            </time>

                            <?php if (get_the_author()): ?>
                                <span class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <?php the_author(); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                    <div class="entry-content prose prose-lg max-w-none text-base  md:text-lg text-black dark:invert">
                        <?php
                        the_content();

                        wp_link_pages(array(
                                'before' => '<div class="page-links mt-8 flex flex-wrap gap-2">' . esc_html( function_exists('pll__') ? pll__('Seiten:') : __('Seiten:', 'ossenberg-engels') ),
                                'after'  => '</div>',
                                'link_before' => '<span class="inline-flex items-center px-3 py-2 rounded-3xl bg-gray-100 dark:bg-[#212121] text-gray-900 dark:text-white hover:bg-red-600 hover:text-white transition-all duration-300 hover:scale-105 active:scale-95 cursor-pointer">',
                                'link_after' => '</span>',
                        ));
                        ?>
                    </div>

            </div>

            <?php
            // Modern previous/next navigation
            $prev_post = get_previous_post();
            $next_post = get_next_post();
            if ($prev_post || $next_post):
            ?>
            <nav class="bg-white dark:bg-[#212121]/40 border-t border-gray-200 dark:border-gray-700 py-10 md:py-12" aria-label="<?php echo esc_attr__('Beitragsnavigation', 'ossenberg-engels'); ?>">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php if ($prev_post):
                            $prev_link = get_permalink($prev_post);
                            $prev_title = get_the_title($prev_post);
                            $prev_thumb_id = get_post_thumbnail_id($prev_post);
                            $prev_img = $prev_thumb_id ? wp_get_attachment_image($prev_thumb_id, 'medium_large', false, array(
                                'class' => 'absolute inset-0 w-full h-full object-cover',
                                'loading' => 'lazy',
                                'alt' => esc_attr($prev_title),
                            )) : '';
                        ?>
                        <a href="<?php echo esc_url($prev_link); ?>" class="group block rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#212121] transition-all duration-300 hover:-translate-y-0.5 hover:scale-105 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#E1191E] cursor-pointer">
                            <div class="grid grid-cols-[96px_1fr]">
                                <div class="relative aspect-square bg-gray-100 dark:bg-[#212121]">
                                    <?php if ($prev_img) { echo $prev_img; } else { ?>
                                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="p-4">
                                    <div class="text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 flex items-center gap-2">
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                                        <?php echo esc_html__('Vorheriger Artikel', 'ossenberg-engels'); ?>
                                    </div>
                                    <div class="mt-1 text-base md:text-lg font-bold text-gray-900 dark:text-white group-hover:text-[#E1191E] transition-colors line-clamp-2"><?php echo esc_html($prev_title); ?></div>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>

                        <?php if ($next_post):
                            $next_link = get_permalink($next_post);
                            $next_title = get_the_title($next_post);
                            $next_thumb_id = get_post_thumbnail_id($next_post);
                            $next_img = $next_thumb_id ? wp_get_attachment_image($next_thumb_id, 'medium_large', false, array(
                                'class' => 'absolute inset-0 w-full h-full object-cover',
                                'loading' => 'lazy',
                                'alt' => esc_attr($next_title),
                            )) : '';
                        ?>
                        <a href="<?php echo esc_url($next_link); ?>" class="group block rounded-3xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-[#212121] transition-all duration-300 hover:-translate-y-0.5 hover:scale-105 active:scale-95 focus:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#E1191E] md:text-right cursor-pointer">
                            <div class="grid grid-cols-[96px_1fr] md:grid-cols-[1fr_96px]">
                                <div class="order-2 md:order-1 p-4">
                                    <div class="text-xs uppercase tracking-wide text-gray-600 dark:text-gray-400 flex items-center gap-2 md:justify-end">
                                        <?php echo esc_html__('Nächster Artikel', 'ossenberg-engels'); ?>
                                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                    </div>
                                    <div class="mt-1 text-base md:text-lg font-bold text-gray-900 dark:text-white group-hover:text-[#E1191E] transition-colors line-clamp-2"><?php echo esc_html($next_title); ?></div>
                                </div>
                                <div class="order-1 md:order-2 relative aspect-square bg-gray-100 dark:bg-[#212121]">
                                    <?php if ($next_img) { echo $next_img; } else { ?>
                                        <div class="absolute inset-0 flex items-center justify-center text-gray-400 dark:text-gray-500">
                                            <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/></svg>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
            <?php endif; ?>

        </article>

    <?php endwhile; ?>
</main>

<?php get_footer(); ?>
