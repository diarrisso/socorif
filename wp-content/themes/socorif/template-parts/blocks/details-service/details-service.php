<?php
/**
 * Block Template: Service Details
 *
 * Detaillierte Service-Seite mit Hero, Vorteilen, Vertrauenselementen und FAQ
 *
 * @package Beka
 */

// Direktzugriff verhindern
if (!defined('ABSPATH')) {
    exit;
}

// Block-Attribute und Klassen abrufen
$block_wrapper_attributes = socorif_get_block_wrapper_attributes($block);
$spacing_classes = socorif_get_acf_spacing_classes('spacing_top', 'spacing_bottom');

// Felder abrufen
$hero_bg_color = get_field('hero_bg_color') ?: 'gradient-to-br from-secondary to-secondary-dark';
$hero_title = get_field('hero_title') ?: 'Demander un devis';
$hero_content = get_field('hero_content');
$hero_show_benefits = get_field('hero_show_benefits');
$hero_benefits = get_field('hero_benefits');

$form_show = get_field('form_show');
$form_cf7_id = get_field('form_cf7_id') ?: '123';

$trust_show = get_field('trust_show');
$trust_title = get_field('trust_title') ?: 'Pourquoi nous choisir ?';
$trust_items = get_field('trust_items');

$faq_show = get_field('faq_show');
$faq_title = get_field('faq_title') ?: 'Questions frequentes';
$faq_items = get_field('faq_items');

// Icon SVG Helper Funktion
function socorif_get_icon_svg(string $icon_name): string {
    $icons = [
        'lightning' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>',
        'check-circle' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'shield' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>',
        'clock' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'check' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
        'users' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>',
        'badge' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
        'currency' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
        'award' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
    ];
    
    return $icons[$icon_name] ?? $icons['check'];
}
?>

<div <?php echo $block_wrapper_attributes; ?>>

    <!-- Hero Bereich -->
    <section class="<?php echo esc_attr($hero_bg_color); ?> text-white py-16 md:py-20 lg:py-24">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    <?php echo esc_html($hero_title); ?>
                </h1>

                <?php if ($hero_content): ?>
                <div class="text-lg md:text-xl text-gray-100 leading-relaxed">
                    <?php echo wp_kses_post(nl2br($hero_content)); ?>
                </div>
                <?php endif; ?>

                <!-- Vorteile -->
                <?php if ($hero_show_benefits && $hero_benefits): ?>
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php foreach ($hero_benefits as $benefit): 
                        $icon = $benefit['icon'] ?? 'lightning';
                        $title = $benefit['title'] ?? '';
                        $desc = $benefit['description'] ?? '';
                    ?>
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6 hover:scale-105 active:scale-95 transition-all duration-300">
                        <div class="w-12 h-12 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-4 shadow-md">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <?php echo socorif_get_icon_svg($icon); ?>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2"><?php echo esc_html($title); ?></h3>
                        <p class="text-sm text-gray-200"><?php echo esc_html($desc); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>


    <!-- Vertrauenselemente -->
    <?php if ($trust_show && $trust_items): ?>
    <section class="py-16 md:py-20 bg-white dark:bg-neutral-800">
        <div class="container">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    <?php echo esc_html($trust_title); ?>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php foreach ($trust_items as $item): 
                        $icon = $item['icon'] ?? 'check';
                        $title = $item['title'] ?? '';
                        $description = $item['description'] ?? '';
                    ?>
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary/10 rounded-3xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <?php echo socorif_get_icon_svg($icon); ?>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">
                                <?php echo esc_html($title); ?>
                            </h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                <?php echo esc_html($description); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- FAQ Bereich -->
    <?php if ($faq_show && $faq_items): ?>
    <section class="py-16 md:py-20 bg-gray-50 dark:bg-neutral-900">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    <?php echo esc_html($faq_title); ?>
                </h2>

                <div class="space-y-4" x-data="{ openFaq: null }">
                    <?php foreach ($faq_items as $index => $faq): 
                        $question = $faq['question'] ?? '';
                        $answer = $faq['answer'] ?? '';
                        $faq_id = $index + 1;
                    ?>
                    <div class="bg-white dark:bg-neutral-800 rounded-3xl shadow-sm overflow-hidden">
                        <button @click="openFaq = openFaq === <?php echo $faq_id; ?> ? null : <?php echo $faq_id; ?>"
                                class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 dark:hover:bg-neutral-700 transition-all duration-300 cursor-pointer">
                            <span class="font-semibold text-gray-900 dark:text-white">
                                <?php echo esc_html($question); ?>
                            </span>
                            <svg class="w-5 h-5 text-gray-500 transition-transform duration-200"
                                 :class="{ 'rotate-180': openFaq === <?php echo $faq_id; ?> }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openFaq === <?php echo $faq_id; ?>" x-collapse class="px-6 pb-4">
                            <p class="text-gray-600 dark:text-gray-400">
                                <?php echo esc_html($answer); ?>
                            </p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>

</div>

<?php
// Block-Ende markieren
socorif_block_comment_end('service-details');
