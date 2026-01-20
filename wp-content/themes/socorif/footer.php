<?php
/**
 * Footer Template - Style moderne inspire de You-Tax
 *
 * @package Socorif
 */

if (!defined('ABSPATH')) exit;

// Recuperer les options du footer depuis ACF
$footer_logo = get_field('footer_logo', 'option');
$footer_description = get_field('footer_description', 'option');
$footer_address = get_field('footer_address', 'option');
$footer_email = get_field('footer_email', 'option');
$footer_phone = get_field('footer_phone', 'option');
$social_facebook = get_field('footer_facebook', 'option');
$social_instagram = get_field('footer_instagram', 'option');
$social_linkedin = get_field('footer_linkedin', 'option');
$social_twitter = get_field('footer_twitter', 'option');
$social_youtube = get_field('footer_youtube', 'option');
$social_xing = get_field('footer_xing', 'option');
$copyright_text = get_field('footer_copyright', 'option');

// Verifier si des reseaux sociaux sont configures
$has_social = $social_facebook || $social_instagram || $social_linkedin || $social_twitter || $social_youtube || $social_xing;
?>

<!-- Footer Section - Style moderne -->
<footer class="bg-secondary-dark text-white relative overflow-hidden pt-8 md:pt-12 lg:pt-16">
    <div class="w-full px-4 lg:px-0">
        <div class="w-full lg:pl-[12%] lg:pr-[10%]">

            <!-- Ligne 1: Logo -->
            <div class="flex-shrink-0 mb-6 md:mb-8 lg:mb-12">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block transition-transform duration-300 hover:scale-105">
                    <?php if ($footer_logo && isset($footer_logo['url'])) : ?>
                        <img src="<?php echo esc_url($footer_logo['url']); ?>"
                             alt="<?php echo esc_attr($footer_logo['alt'] ?? get_bloginfo('name')); ?>"
                             class="h-[50px] md:h-16 w-auto object-contain" />
                    <?php else : ?>
                        <span class="text-2xl lg:text-3xl font-bold text-primary"><?php echo esc_html(get_bloginfo('name') ?: 'Socorif'); ?></span>
                    <?php endif; ?>
                </a>
            </div>

            <!-- Ligne 2: Grille 4 colonnes -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8 items-start">

                <!-- Colonne 1: Adresse -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-primary mb-4">Adresse</h4>
                    <?php if ($footer_address) : ?>
                        <p class="text-base font-normal leading-[22px]">
                            <?php echo wp_kses_post(nl2br($footer_address)); ?>
                        </p>
                    <?php else : ?>
                        <p class="text-base font-normal leading-[22px]">
                            Conakry, Guinee
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Colonne 2: Navigation -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-primary mb-4">Navigation</h4>
                    <?php if (has_nav_menu('footer')) : ?>
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'footer',
                            'container'       => false,
                            'menu_class'      => 'space-y-2',
                            'walker'          => new Socorif_Footer_Nav_Walker(),
                            'fallback_cb'     => false,
                        ));
                        ?>
                    <?php else : ?>
                        <ul class="space-y-2">
                            <li><a href="<?php echo esc_url(home_url('/services')); ?>" class="text-base hover:underline transition-colors">Services</a></li>
                            <li><a href="<?php echo esc_url(home_url('/proprietes')); ?>" class="text-base hover:underline transition-colors">Proprietes</a></li>
                            <li><a href="<?php echo esc_url(home_url('/projets')); ?>" class="text-base hover:underline transition-colors">Projets</a></li>
                            <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="text-base hover:underline transition-colors">Contact</a></li>
                        </ul>
                    <?php endif; ?>
                </div>

                <!-- Colonne 3: Contact -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-primary mb-4">Contact</h4>
                    <?php if ($footer_email) : ?>
                        <p class="text-base font-normal leading-[22px]">
                            <a href="mailto:<?php echo esc_attr($footer_email); ?>" class="hover:underline">
                                <?php echo esc_html($footer_email); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                    <?php if ($footer_phone) : ?>
                        <p class="text-base font-normal leading-[22px]">
                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $footer_phone)); ?>" class="hover:underline">
                                <?php echo esc_html($footer_phone); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Colonne 4: Reseaux sociaux -->
                <div class="space-y-3">
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-primary mb-4">Suivez-nous</h4>
                    <?php if ($has_social) : ?>
                        <div class="flex gap-4 sm:gap-6 justify-start">
                            <?php if ($social_facebook) : ?>
                                <a href="<?php echo esc_url($social_facebook); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform"
                                   aria-label="Facebook"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_linkedin) : ?>
                                <a href="<?php echo esc_url($social_linkedin); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform"
                                   aria-label="LinkedIn"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_instagram) : ?>
                                <a href="<?php echo esc_url($social_instagram); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform hover:rotate-6"
                                   aria-label="Instagram"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_twitter) : ?>
                                <a href="<?php echo esc_url($social_twitter); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform"
                                   aria-label="Twitter/X"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_youtube) : ?>
                                <a href="<?php echo esc_url($social_youtube); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform"
                                   aria-label="YouTube"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>

                            <?php if ($social_xing) : ?>
                                <a href="<?php echo esc_url($social_xing); ?>"
                                   class="text-gray-400 hover:text-white transition-all duration-300 flex items-center justify-center hover:scale-125 hover:-translate-y-1 transform"
                                   aria-label="Xing"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.188 0c-.517 0-.741.325-.927.66 0 0-7.455 13.224-7.702 13.657.015.024 4.919 9.023 4.919 9.023.17.308.436.66.967.66h3.454c.211 0 .375-.078.463-.22.089-.151.089-.346-.009-.536l-4.879-8.916c-.004-.006-.004-.016 0-.022L22.139.756c.095-.191.097-.387.006-.535C22.056.078 21.894 0 21.686 0h-3.498z"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Ligne 3: Copyright + Liens legaux -->
            <div class="py-6 md:py-8 lg:py-12 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <p class="text-sm font-normal leading-[20px] text-gray-400">
                    &copy; <?php echo esc_html(date('Y')); ?> <?php echo esc_html($copyright_text ?: 'Tous droits reserves. Conakry, Guinee'); ?>
                </p>

                <!-- Liens legaux -->
                <?php if (has_nav_menu('footer-legal')) : ?>
                    <nav class="flex flex-col sm:flex-row gap-3 sm:gap-6">
                        <?php
                        wp_nav_menu(array(
                            'theme_location'  => 'footer-legal',
                            'container'       => false,
                            'items_wrap'      => '%3$s',
                            'walker'          => new Socorif_Footer_Legal_Inline_Walker(),
                            'fallback_cb'     => false,
                        ));
                        ?>
                    </nav>
                <?php endif; ?>
            </div>

        </div>
    </div>
</footer>

<!-- Bouton retour en haut - Style You-Tax -->
<button
    x-data="{ show: false }"
    x-init="window.addEventListener('scroll', () => show = window.pageYOffset > 300)"
    x-show="show"
    x-transition
    @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="fixed bottom-8 right-8 z-50 w-14 h-14 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-50 hover:shadow-xl transition-all duration-300 hover:scale-110 active:scale-95 cursor-pointer"
    style="display: none;"
    aria-label="Retour en haut">
    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<?php wp_footer(); ?>

</body>
</html>
