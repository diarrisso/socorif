<?php
/**
 * Accordion Block Template
 */

if (!defined('ABSPATH')) exit;

// Konfiguration laden
require_once __DIR__ . '/config.php';

// Recuperation des champs
$title = socorif_get_field('accordion_title', 'Questions frequentes');
$items = socorif_get_field('accordion_items');

if (empty($items)) {
    echo '<p class="text-gray-500 italic">Aucun element d\'accordeon.</p>';
    return;
}

// Block-Attribute für Wrapper
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'accordion-block']) : 'class="accordion-block"';

// Block-Identifikationskommentar ausgeben
socorif_block_comment_start('accordion');
?>

<section <?php echo $block_attrs; ?>>
    <div class="bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4 lg:px-8 py-10 sm:py-12 lg:py-20">
            <div class="mx-auto max-w-4xl">

                <!-- Titel -->
                <h2 class="section-title tracking-tight">
                    <?php echo esc_html($title); ?>
                </h2>

                <!-- Accordion-Elemente -->
                <dl class="mt-16 divide-y divide-gray-900/10 dark:divide-white/10">
                    <?php foreach ($items as $index => $item) :
                        $disclosure_id = 'faq-' . $index;
                    ?>
                        <div class="py-6 first:pt-0 last:pb-0" x-data="{ open: <?php echo $index === 0 ? 'true' : 'false'; ?> }">
                            <dt>
                                <button type="button"
                                        @click="open = !open"
                                        :aria-expanded="open"
                                        class="flex w-full items-start justify-between text-left text-gray-900 dark:text-white cursor-pointer hover:text-primary dark:hover:text-primary transition-colors group">
                                    <span class="text-lg font-semibold leading-7">
                                        <?php echo esc_html($item['title']); ?>
                                    </span>
                                    <span class="ml-6 flex items-center">
                                        <!-- Plus-Icon (sichtbar wenn geschlossen) -->
                                        <svg x-show="!open"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2.5"
                                             aria-hidden="true"
                                             class="w-8 h-8 text-primary transition-transform duration-300 ease-in-out group-hover:scale-110"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 rotate-90"
                                             x-transition:enter-end="opacity-100 rotate-0">
                                            <path d="M12 6v12m6-6H6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <!-- Minus-Icon (sichtbar wenn geöffnet) -->
                                        <svg x-show="open"
                                             viewBox="0 0 24 24"
                                             fill="none"
                                             stroke="currentColor"
                                             stroke-width="2.5"
                                             aria-hidden="true"
                                             class="w-8 h-8 text-primary transition-transform duration-300 ease-in-out group-hover:scale-110"
                                             x-transition:enter="transition ease-out duration-200"
                                             x-transition:enter-start="opacity-0 rotate-90"
                                             x-transition:enter-end="opacity-100 rotate-0"
                                             x-cloak>
                                            <path d="M18 12H6" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </button>
                            </dt>
                            <dd x-show="open"
                                x-collapse
                                class="mt-4 pr-12">
                                <div class="text-base leading-7 text-gray-600 dark:text-gray-300 prose prose-sm dark:prose-invert max-w-none">
                                    <?php echo wp_kses_post($item['content']); ?>
                                </div>
                            </dd>
                        </div>
                    <?php endforeach; ?>
                </dl>

            </div>
        </div>
    </div>
</section>

<?php socorif_block_comment_end('accordion'); ?>
