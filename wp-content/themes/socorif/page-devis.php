<?php
/**
 * Template Name: Demande de devis
 *
 * Template pour la page de demande de devis avec formulaire multi-etapes
 *
 * @package Socorif
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<main id="main" class="site-main" role="main">
    <?php
    while (have_posts()) :
        the_post();
    ?>

    <!-- Section Hero -->
    <section class="bg-gradient-to-br from-secondary to-secondary-dark text-white py-16 md:py-20 lg:py-24">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
                    <?php the_title(); ?>
                </h1>

                <?php if (get_the_content()): ?>
                <div class="text-lg md:text-xl text-gray-100 leading-relaxed">
                    <?php the_content(); ?>
                </div>
                <?php endif; ?>

                <!-- Avantages -->
                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6">
                        <div class="w-12 h-12 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Reponse rapide</h3>
                        <p class="text-sm text-gray-200">Retour sous 24 heures</p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6">
                        <div class="w-12 h-12 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Sans engagement</h3>
                        <p class="text-sm text-gray-200">Premiere consultation gratuite</p>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-6">
                        <div class="w-12 h-12 bg-primary rounded-3xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h3 class="font-semibold mb-2">Confidentiel</h3>
                        <p class="text-sm text-gray-200">Vos donnees sont securisees</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Zone Formulaire -->

    <!-- Elements de confiance -->
    <section class="py-16 md:py-20 bg-white dark:bg-neutral-800">
        <div class="container">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    Pourquoi SOCORIF ?
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary/10 rounded-3xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Plus de 25 ans d'experience</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Beneficiez de notre savoir-faire de longue date dans l'immobilier.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary/10 rounded-3xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Equipe qualifiee</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Notre equipe est composee de professionnels experimentes et certifies.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary/10 rounded-3xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Qualite garantie</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Nous garantissons les plus hauts standards de qualite pour tous nos projets.
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-primary/10 rounded-3xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg mb-2 text-gray-900 dark:text-white">Prix justes</h3>
                            <p class="text-gray-600 dark:text-gray-400">
                                Tarification transparente et sans frais caches.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section FAQ -->
    <section class="py-16 md:py-20 bg-gray-50 dark:bg-neutral-900">
        <div class="container">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-bold text-center mb-12 text-gray-900 dark:text-white">
                    Questions frequentes
                </h2>

                <div class="space-y-4" x-data="{ openFaq: null }">
                    <!-- FAQ Item 1 -->
                    <div class="group bg-white dark:bg-neutral-800 rounded-3xl shadow-lg hover:shadow-xl overflow-hidden transition-all duration-300 border border-transparent"
                         :class="{ 'border-primary/20 shadow-primary/10': openFaq === 1 }">
                        <button @click="openFaq = openFaq === 1 ? null : 1"
                                class="w-full px-6 py-5 md:px-8 md:py-6 text-left flex justify-between items-center hover:bg-gray-50/50 dark:hover:bg-neutral-700/50 transition-all duration-300 cursor-pointer">
                            <span class="font-bold text-base md:text-lg text-gray-900 dark:text-white pr-6 transition-colors duration-300"
                                  :class="{ 'text-primary': openFaq === 1 }">
                                Combien de temps pour recevoir un devis ?
                            </span>
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="openFaq === 1 ? 'bg-primary/10' : 'bg-gray-100 dark:bg-neutral-700 group-hover:bg-primary/10'">
                                <svg class="w-5 h-5 transition-all duration-300"
                                     :class="openFaq === 1 ? 'text-primary rotate-180' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaq === 1" x-collapse class="border-t border-gray-100 dark:border-neutral-700">
                            <div class="px-6 py-5 md:px-8 md:py-6">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    En general, vous recevez un premier retour sous 24 heures.
                                    Un devis detaille suit apres une visite sur place sous 2-3 jours ouvrables.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 2 -->
                    <div class="group bg-white dark:bg-neutral-800 rounded-3xl shadow-lg hover:shadow-xl overflow-hidden transition-all duration-300 border border-transparent"
                         :class="{ 'border-primary/20 shadow-primary/10': openFaq === 2 }">
                        <button @click="openFaq = openFaq === 2 ? null : 2"
                                class="w-full px-6 py-5 md:px-8 md:py-6 text-left flex justify-between items-center hover:bg-gray-50/50 dark:hover:bg-neutral-700/50 transition-all duration-300 cursor-pointer">
                            <span class="font-bold text-base md:text-lg text-gray-900 dark:text-white pr-6 transition-colors duration-300"
                                  :class="{ 'text-primary': openFaq === 2 }">
                                La demande de devis est-elle payante ?
                            </span>
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="openFaq === 2 ? 'bg-primary/10' : 'bg-gray-100 dark:bg-neutral-700 group-hover:bg-primary/10'">
                                <svg class="w-5 h-5 transition-all duration-300"
                                     :class="openFaq === 2 ? 'text-primary rotate-180' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaq === 2" x-collapse class="border-t border-gray-100 dark:border-neutral-700">
                            <div class="px-6 py-5 md:px-8 md:py-6">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    Non, la demande de devis et la premiere consultation sont entierement gratuites et sans engagement.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Item 3 -->
                    <div class="group bg-white dark:bg-neutral-800 rounded-3xl shadow-lg hover:shadow-xl overflow-hidden transition-all duration-300 border border-transparent"
                         :class="{ 'border-primary/20 shadow-primary/10': openFaq === 3 }">
                        <button @click="openFaq = openFaq === 3 ? null : 3"
                                class="w-full px-6 py-5 md:px-8 md:py-6 text-left flex justify-between items-center hover:bg-gray-50/50 dark:hover:bg-neutral-700/50 transition-all duration-300 cursor-pointer">
                            <span class="font-bold text-base md:text-lg text-gray-900 dark:text-white pr-6 transition-colors duration-300"
                                  :class="{ 'text-primary': openFaq === 3 }">
                                Que deviennent mes donnees ?
                            </span>
                            <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                 :class="openFaq === 3 ? 'bg-primary/10' : 'bg-gray-100 dark:bg-neutral-700 group-hover:bg-primary/10'">
                                <svg class="w-5 h-5 transition-all duration-300"
                                     :class="openFaq === 3 ? 'text-primary rotate-180' : 'text-gray-500 dark:text-gray-400 group-hover:text-primary'"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </button>
                        <div x-show="openFaq === 3" x-collapse class="border-t border-gray-100 dark:border-neutral-700">
                            <div class="px-6 py-5 md:px-8 md:py-6">
                                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                                    Vos donnees sont traitees de maniere confidentielle et utilisees uniquement pour traiter votre demande.
                                    Plus d'informations dans notre politique de confidentialite.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php endwhile; ?>
</main>

<?php
get_footer();
