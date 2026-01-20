<?php
/**
 * Composant de recherche et filtre d'offres d'emploi
 *
 * Systeme optionnel de recherche et filtrage pour les offres d'emploi
 * Peut etre active/desactive via un champ ACF
 *
 * @package Socorif
 * @since 1.0.0
 *
 * @param array $args {
 *     Optional. Array of arguments.
 *     @type bool $show_search Whether to show search input. Default true.
 *     @type bool $show_category_filter Whether to show category filter. Default true.
 *     @type bool $show_contract_filter Whether to show contract type filter. Default true.
 * }
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Parse arguments
$defaults = array(
    'show_filter' => true,
    'show_search' => true,
    'show_category_filter' => true,
    'show_contract_filter' => true,
);
$args = wp_parse_args($args, $defaults);

// Check if filter should be displayed
if (!$args['show_filter']) {
    return;
}

// Get current filters from URL
$current_search = isset($_GET['job_search']) ? sanitize_text_field($_GET['job_search']) : '';
$current_category = isset($_GET['job_category']) ? sanitize_text_field($_GET['job_category']) : '';
$current_contract = isset($_GET['job_contract']) ? sanitize_text_field($_GET['job_contract']) : '';

// Get categories
$categories = get_terms(array(
    'taxonomy' => 'emplois_category',
    'hide_empty' => true,
));

// Get contract types
$contract_types = get_terms(array(
    'taxonomy' => 'emplois_contract_type',
    'hide_empty' => true,
));

?>

<div class="job-search-filter-wrapper bg-gradient-to-br from-white to-gray-50 dark:from-gray-800 dark:to-gray-900 rounded-3xl border-2 border-gray-200 dark:border-gray-700 shadow-xl p-6 md:p-8 mb-12"
     x-data="jobFilter()"
     x-init="init()">

    <form method="get"
          class="flex flex-col lg:flex-row items-stretch gap-4 md:gap-6"
          @submit="handleSubmit">

        <?php if ($args['show_search']): ?>
            <!-- Search Input -->
            <div class="relative w-full lg:flex-1">
                <label for="job_search" class="block text-sm font-semibold dark:text-white mb-2">
                    <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Recherche
                </label>
                <div class="relative">
                    <input type="text"
                           id="job_search"
                           name="job_search"
                           value="<?php echo esc_attr($current_search); ?>"
                           placeholder="Ex: Technicien, Chef de projet..."
                           class="w-full px-4 py-3.5 pr-4 border-2 border-gray-300 dark:border-gray-600 rounded-3xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-base shadow-sm hover:border-primary/50 cursor-text"
                           x-model="search">
                </div>
            </div>
        <?php endif; ?>

        <?php if ($args['show_category_filter'] && !empty($categories) && !is_wp_error($categories)): ?>
            <!-- Category Filter -->
            <div class="w-full lg:w-auto lg:min-w-[240px]">
                <label for="job_category" class="block text-sm font-semibold dark:text-white mb-2">
                    <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Categorie
                </label>
                <select id="job_category"
                        name="job_category"
                        class="w-full appearance-none px-4 pr-10 py-3.5 border-2 border-gray-300 dark:border-gray-600 rounded-3xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 cursor-pointer text-base shadow-sm hover:border-primary/50"
                        style="background-image: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3e%3cpath stroke=%27%23FDB833%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M6 8l4 4 4-4%27/%3e%3c/svg%3e'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em;"
                        x-model="category">
                    <option value="">Toutes les categories</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?php echo esc_attr($category->slug); ?>"
                                <?php selected($current_category, $category->slug); ?>>
                            <?php echo esc_html($category->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <?php if ($args['show_contract_filter'] && !empty($contract_types) && !is_wp_error($contract_types)): ?>
            <!-- Contract Type Filter -->
            <div class="w-full lg:w-auto lg:min-w-[240px]">
                <label for="job_contract" class="block text-sm font-semibold dark:text-white mb-2">
                    <svg class="w-4 h-4 inline-block mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Type de contrat
                </label>
                <select id="job_contract"
                        name="job_contract"
                        class="w-full appearance-none px-4 pr-10 py-3.5 border-2 border-gray-300 dark:border-gray-600 rounded-3xl bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 cursor-pointer text-base shadow-sm hover:border-primary/50"
                        style="background-image: url('data:image/svg+xml,%3csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3e%3cpath stroke=%27%23FDB833%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M6 8l4 4 4-4%27/%3e%3c/svg%3e'); background-position: right 0.75rem center; background-repeat: no-repeat; background-size: 1.5em 1.5em;"
                        x-model="contract">
                    <option value="">Tous les types de contrat</option>
                    <?php foreach ($contract_types as $contract_type): ?>
                        <option value="<?php echo esc_attr($contract_type->slug); ?>"
                                <?php selected($current_contract, $contract_type->slug); ?>>
                            <?php echo esc_html($contract_type->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <!-- Submit and Reset Buttons -->
        <div class="flex flex-col justify-end w-full lg:w-auto">
            <label class="hidden lg:block text-sm font-semibold text-transparent mb-2 select-none pointer-events-none">.</label>
            <div class="flex items-stretch gap-3">
                <button type="submit"
                        class="flex-1 lg:flex-none px-8 py-3.5 bg-primary hover:bg-primary-dark text-white font-bold rounded-3xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-gray-800 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 hover:scale-105 active:scale-95 cursor-pointer text-base inline-flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                    </svg>
                    <span>Filtrer</span>
                </button>
                <button type="button"
                        @click="resetFilters"
                        x-show="hasActiveFilters"
                        x-transition
                        title="Reinitialiser les filtres"
                        class="px-4 py-3.5 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 font-semibold rounded-3xl transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800 cursor-pointer shadow-md hover:shadow-lg transform hover:-translate-y-0.5 hover:scale-105 active:scale-95">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Active Filters Display -->
<div x-data="jobFilter()" x-show="hasActiveFilters" x-transition class="-mt-8 mb-8">
    <div class="bg-primary/5 dark:bg-primary/10 border border-primary/20 dark:border-primary/30 rounded-3xl p-4">
        <div class="flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                </svg>
                <span class="text-sm font-semibold dark:text-white">Filtres actifs :</span>
            </div>

            <template x-if="search">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <span x-text="search"></span>
                    <button type="button"
                            @click="search = ''; $el.closest('div').previousElementSibling.querySelector('form').submit()"
                            class="ml-1 hover:bg-white/20 rounded-full p-0.5 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </span>
            </template>

            <template x-if="category">
                <span class="inline-flex items-center gap-2 px-4 py-2 dark:bg-secondary text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                    <span x-text="getCategoryLabel(category)"></span>
                    <button type="button"
                            @click="category = ''; $el.closest('div').previousElementSibling.querySelector('form').submit()"
                            class="ml-1 hover:bg-white/20 rounded-full p-0.5 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </span>
            </template>

            <template x-if="contract">
                <span class="inline-flex items-center gap-2 px-4 py-2 dark:bg-secondary text-white rounded-lg text-sm font-semibold shadow-sm hover:shadow-md transition-all duration-200">
                    <span x-text="getContractLabel(contract)"></span>
                    <button type="button"
                            @click="contract = ''; $el.closest('div').previousElementSibling.querySelector('form').submit()"
                            class="ml-1 hover:bg-white/20 rounded-full p-0.5 transition-colors">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </span>
            </template>
        </div>
    </div>
</div>

<script>
function jobFilter() {
    return {
        search: <?php echo wp_json_encode($current_search); ?>,
        category: <?php echo wp_json_encode($current_category); ?>,
        contract: <?php echo wp_json_encode($current_contract); ?>,

        get hasActiveFilters() {
            return this.search !== '' || this.category !== '' || this.contract !== '';
        },

        init() {
            // No scroll behavior needed - results are directly below filter
        },

        handleSubmit(event) {
            // Form will submit to current page without hash anchor
            // No need to scroll as results are directly below filter
        },

        resetFilters() {
            this.search = '';
            this.category = '';
            this.contract = '';
            // Redirect to clean URL
            window.location.href = window.location.pathname;
        },

        getCategoryLabel(slug) {
            const select = document.getElementById('job_category');
            const option = select?.querySelector('option[value="' + slug + '"]');
            return option ? option.textContent : slug;
        },

        getContractLabel(slug) {
            const select = document.getElementById('job_contract');
            const option = select?.querySelector('option[value="' + slug + '"]');
            return option ? option.textContent : slug;
        }
    };
}
</script>
