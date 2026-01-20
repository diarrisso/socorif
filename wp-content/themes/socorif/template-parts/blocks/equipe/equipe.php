<?php
/**
 * Team Block Template - Modern Design mit Abteilungen
 */

if (!defined('ABSPATH')) exit;

// Block-Identifikation im HTML-Quellcode
socorif_block_comment_start('team');

// Konfiguration laden
require_once __DIR__ . '/config.php';

// Felder abrufen
$title = socorif_get_field('title', 'Notre equipe');
$description = socorif_get_field('description');
$members = socorif_get_field('members', []);

// Labels des departements
$department_labels = [
    'management' => 'Direction',
    'administration' => 'Administration / Secretariat',
    'training' => 'Formation',
    'finance' => 'Finances',
    'operations' => 'Operations',
    'sales' => 'Commercial',
    'technical' => 'Technique',
];

// Mitglieder nach Abteilung gruppieren
$grouped_members = [];
foreach ($members as $member) {
    $dept = $member['department'] ?? 'management';
    if (!isset($grouped_members[$dept])) {
        $grouped_members[$dept] = [];
    }
    $grouped_members[$dept][] = $member;
}

// Block-Attribute für Wrapper
$block_attrs = isset($block) ? get_block_wrapper_attributes(['class' => 'team-block']) : 'class="team-block"';
?>

<div <?php echo $block_attrs; ?>>
    <div class="relative isolate bg-white py-16 sm:py-20 lg:py-24 dark:bg-gray-900 overflow-hidden">

        <!-- Dekorative Hintergrundeffekte -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <div class="absolute left-[calc(50%-20rem)] top-0 -z-10 transform-gpu blur-3xl" aria-hidden="true">
                <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-primary/20 to-accent/20 opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
            </div>
            <div class="absolute right-[calc(50%-20rem)] top-[20rem] -z-10 transform-gpu blur-3xl" aria-hidden="true">
                <div class="aspect-[1108/632] w-[69.25rem] bg-gradient-to-r from-accent/20 to-primary/20 opacity-20" style="clip-path: polygon(73.6% 51.7%, 91.7% 11.8%, 100% 46.4%, 97.4% 82.2%, 92.5% 84.9%, 75.7% 64%, 55.3% 47.5%, 46.5% 49.4%, 45% 62.9%, 50.3% 87.2%, 21.3% 64.1%, 0.1% 100%, 5.4% 51.1%, 21.4% 63.9%, 58.9% 0.2%, 73.6% 51.7%)"></div>
            </div>
        </div>

        <div class="container mx-auto px-4 lg:px-8">

            <!-- Header Section -->
            <div class="mx-auto max-w-2xl text-center mb-12 lg:mb-16">
                <h2 class="section-title tracking-tight">
                    <?php echo esc_html($title); ?>
                </h2>
                <?php if ($description) : ?>
                    <p class="section-description mt-6">
                        <?php echo esc_html($description); ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php if (!empty($grouped_members)) : ?>
                <!-- Abteilungen durchlaufen -->
                <?php foreach ($department_labels as $dept_key => $dept_label) : ?>
                    <?php if (isset($grouped_members[$dept_key]) && !empty($grouped_members[$dept_key])) : ?>

                        <!-- Abteilungs-Header -->
                        <div class="mb-8 mt-16 first:mt-0">
                            <div class="flex items-center gap-4">
                                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                                <h3 class="section-subtitle px-4 py-2 bg-primary/10 dark:bg-primary/20 rounded-full">
                                    <?php echo esc_html($dept_label); ?>
                                </h3>
                                <div class="h-px flex-1 bg-gradient-to-r from-transparent via-gray-300 dark:via-gray-700 to-transparent"></div>
                            </div>
                        </div>

                        <!-- Team Members Grid -->
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 justify-items-center">
                            <?php foreach ($grouped_members[$dept_key] as $member) : ?>
                                <div class="group relative bg-white dark:bg-gray-800 rounded-3xl shadow-lg hover:shadow-2xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-500 cursor-pointer transform hover:-translate-y-2 hover:scale-105 w-full max-w-sm">

                                    <!-- Accent bar top -->
                                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-primary via-primary-dark to-primary transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>

                                    <!-- Photo Container -->
                                    <div class="relative aspect-square overflow-hidden bg-gray-100 dark:bg-gray-900">
                                        <?php if (!empty($member['photo'])) : ?>
                                            <img src="<?php echo esc_url($member['photo']['sizes']['large'] ?? $member['photo']['url']); ?>"
                                                 alt="<?php echo esc_attr($member['name'] ?? ''); ?>"
                                                 class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-110 group-hover:rotate-2" />

                                            <!-- Overlay gradient on hover -->
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/0 to-black/0 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <?php else : ?>
                                            <!-- Default avatar -->
                                            <div class="flex items-center justify-center h-full bg-gradient-to-br from-primary/20 to-accent/20">
                                                <svg class="w-24 h-24 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Badge Email -->
                                        <?php if (!empty($member['email'])) : ?>
                                            <a href="mailto:<?php echo esc_attr($member['email']); ?>"
                                               class="absolute top-3 right-3 w-10 h-10 bg-white dark:bg-gray-800 rounded-full shadow-lg flex items-center justify-center opacity-0 group-hover:opacity-100 transform translate-x-4 group-hover:translate-x-0 transition-all duration-500 hover:bg-primary hover:scale-110 z-10"
                                               onclick="event.stopPropagation();">
                                                <svg class="w-5 h-5 text-gray-700 dark:text-gray-300 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                                </svg>
                                            </a>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-5">
                                        <!-- Name -->
                                        <?php if (!empty($member['name'])) : ?>
                                            <h4 class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-primary dark:group-hover:text-primary transition-colors duration-300">
                                                <?php echo esc_html($member['name']); ?>
                                            </h4>
                                        <?php endif; ?>

                                        <!-- Role -->
                                        <?php if (!empty($member['role'])) : ?>
                                            <p class="mt-1 text-sm font-medium text-primary dark:text-primary">
                                                <?php echo esc_html($member['role']); ?>
                                            </p>
                                        <?php endif; ?>

                                        <!-- Location -->
                                        <?php if (!empty($member['location'])) : ?>
                                            <div class="mt-3 flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                </svg>
                                                <span class="truncate"><?php echo esc_html($member['location']); ?></span>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Decorative bottom bar -->
                                        <div class="mt-4 h-1 w-12 bg-gradient-to-r from-primary to-accent rounded-full transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-500"></div>
                                    </div>

                                </div>
                            <?php endforeach; ?>
                        </div>

                    <?php endif; ?>
                <?php endforeach; ?>

            <?php else : ?>
                <!-- Empty state -->
                <div class="mx-auto max-w-2xl">
                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900 border border-gray-200 dark:border-gray-700 rounded-3xl p-12 text-center shadow-lg">
                        <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">
                            Aucun membre d'equipe
                        </h3>
                        <p class="text-lg text-gray-600 dark:text-gray-400">
                            Ajoutez des membres via le champ ACF.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php
// Block-Ende markieren
socorif_block_comment_end('team');
