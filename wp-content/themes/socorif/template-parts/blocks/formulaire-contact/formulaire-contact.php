<?php
/**
 * Formulaire de contact Block Template
 *
 * Supporte le flexible content et le bloc ACF Gutenberg
 */

if (!defined('ABSPATH')) exit;

// Recuperer les champs (compatible flexible content et bloc ACF)
$heading = get_sub_field('heading') ?: get_field('heading') ?: 'Contactez-nous';
$description = get_sub_field('description') ?: get_field('description') ?: 'Nous sommes a votre ecoute.';

// Champs specifiques au flexible content
$address = get_sub_field('address') ?: '';
$phone = get_sub_field('phone') ?: '';
$email = get_sub_field('email') ?: '';
$button_text = get_sub_field('button_text') ?: 'Envoyer le message';
$show_decorative_bg = get_sub_field('show_decorative_bg') ?? true;
$show_gradient = get_sub_field('show_gradient') ?? true;

// CF7 form ID (pour le bloc ACF Gutenberg)
$cf7_form_id = get_sub_field('cf7_form') ?: get_field('cf7_form') ?: null;

// Si pas de CF7 specifie, chercher le formulaire general
if (!$cf7_form_id) {
    $general_form = get_page_by_title('Formulaire Contact General', OBJECT, 'wpcf7_contact_form');
    if ($general_form) {
        $cf7_form_id = $general_form->ID;
    }
}

// Block attributes
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'contact-form-block']) : 'class="contact-form-block"';

// Block comment for debugging
if (function_exists('socorif_block_comment_start')) {
    socorif_block_comment_start('formulaire-contact');
}
?>

<div <?php echo $block_attrs; ?>>
    <div class="relative isolate bg-white dark:bg-gray-900">
        <?php if ($show_decorative_bg) : ?>
        <!-- Decorative background pattern -->
        <svg class="absolute inset-0 -z-10 size-full stroke-gray-200 dark:stroke-gray-800 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="contact-pattern" width="200" height="200" x="50%" y="-64" patternUnits="userSpaceOnUse">
                    <path d="M100 200V.5M.5 .5H200" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#contact-pattern)" />
        </svg>
        <?php endif; ?>

        <?php if ($show_gradient) : ?>
        <div class="absolute inset-x-0 top-0 -z-10 h-[300px] bg-gradient-to-b from-gray-50 dark:from-gray-800/50" aria-hidden="true"></div>
        <?php endif; ?>

        <div class="container mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-2">
            <!-- Left Column: Contact Info -->
            <div class="relative px-6 pb-20 pt-24 sm:pt-32 lg:static lg:px-8 lg:py-48">
                <div class="mx-auto max-w-xl lg:mx-0 lg:max-w-lg">
                    <h2 class="text-pretty text-4xl font-semibold tracking-tight text-gray-900 dark:text-white sm:text-5xl">
                        <?php echo esc_html($heading); ?>
                    </h2>
                    <p class="mt-6 text-lg/8 text-gray-600 dark:text-gray-400">
                        <?php echo esc_html($description); ?>
                    </p>

                    <?php if ($address || $phone || $email) : ?>
                    <dl class="mt-10 space-y-4 text-base/7 text-gray-600 dark:text-gray-400">
                        <?php if ($address) : ?>
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Adresse</span>
                                <svg class="h-7 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                            </dt>
                            <dd class="whitespace-pre-line"><?php echo esc_html($address); ?></dd>
                        </div>
                        <?php endif; ?>

                        <?php if ($phone) : ?>
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Telephone</span>
                                <svg class="h-7 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                </svg>
                            </dt>
                            <dd>
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="hover:text-primary transition-colors">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </dd>
                        </div>
                        <?php endif; ?>

                        <?php if ($email) : ?>
                        <div class="flex gap-x-4">
                            <dt class="flex-none">
                                <span class="sr-only">Email</span>
                                <svg class="h-7 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                                </svg>
                            </dt>
                            <dd>
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="hover:text-primary transition-colors">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </dd>
                        </div>
                        <?php endif; ?>
                    </dl>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Form -->
            <div class="px-6 pb-24 pt-20 sm:pb-32 lg:px-8 lg:py-48">
                <div class="mx-auto max-w-xl lg:mr-0 lg:max-w-lg">
                    <?php
                    if ($cf7_form_id && function_exists('wpcf7_contact_form')) {
                        // Contact Form 7
                        echo do_shortcode('[contact-form-7 id="' . absint($cf7_form_id) . '"]');
                    } else {
                        // Fallback HTML form
                        $form_action = get_sub_field('form_action') ?: '';
                        ?>
                        <form action="<?php echo esc_url($form_action); ?>" method="POST" class="space-y-6">
                            <?php wp_nonce_field('socorif_contact_form', 'socorif_nonce'); ?>

                            <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">
                                <div>
                                    <label for="first-name" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                        Prenom
                                    </label>
                                    <div class="mt-2.5">
                                        <input type="text" name="first-name" id="first-name" required
                                            class="block w-full rounded-md bg-white dark:bg-gray-800 px-3.5 py-2 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                                    </div>
                                </div>
                                <div>
                                    <label for="last-name" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                        Nom
                                    </label>
                                    <div class="mt-2.5">
                                        <input type="text" name="last-name" id="last-name" required
                                            class="block w-full rounded-md bg-white dark:bg-gray-800 px-3.5 py-2 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                    Email
                                </label>
                                <div class="mt-2.5">
                                    <input type="email" name="email" id="email" required
                                        class="block w-full rounded-md bg-white dark:bg-gray-800 px-3.5 py-2 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                    Telephone
                                </label>
                                <div class="mt-2.5">
                                    <input type="tel" name="phone" id="phone"
                                        class="block w-full rounded-md bg-white dark:bg-gray-800 px-3.5 py-2 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-primary">
                                </div>
                            </div>

                            <div>
                                <label for="message" class="block text-sm font-semibold text-gray-900 dark:text-white">
                                    Message
                                </label>
                                <div class="mt-2.5">
                                    <textarea name="message" id="message" rows="4" required
                                        class="block w-full rounded-md bg-white dark:bg-gray-800 px-3.5 py-2 text-base text-gray-900 dark:text-white outline-1 -outline-offset-1 outline-gray-300 dark:outline-gray-700 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-primary"></textarea>
                                </div>
                            </div>

                            <div class="mt-8">
                                <button type="submit"
                                    class="block w-full rounded-md bg-primary px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-primary/90 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary transition-colors">
                                    <?php echo esc_html($button_text); ?>
                                </button>
                            </div>
                        </form>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (function_exists('socorif_block_comment_end')) {
    socorif_block_comment_end('formulaire-contact');
}
?>
