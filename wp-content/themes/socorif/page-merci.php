<?php
/**
 * Template Name: Merci
 *
 * Template pour la page de remerciement apres soumission du formulaire
 *
 * @package Socorif
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Verifier si la demande a reussi
$demande_succes = isset($_GET['demande']) && $_GET['demande'] === 'success';
?>

<main id="main" class="site-main" role="main">
    <section class="py-16 md:py-20 lg:py-32">
        <div class="container">
            <div class="max-w-3xl mx-auto text-center">

                <?php if ($demande_succes) : ?>
                    <!-- Message de succes -->
                    <div class="mb-8">
                        <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>

                        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-4">
                            Merci pour votre demande !
                        </h1>

                        <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 mb-8">
                            Nous avons bien recu votre demande de devis et nous vous contacterons sous 24 heures.
                        </p>
                    </div>

                    <!-- Prochaines etapes -->
                    <div class="bg-gray-50 dark:bg-neutral-800 rounded-3xl p-8 mb-8 text-left">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 text-center">
                            Et maintenant ?
                        </h2>

                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-bold">1</span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        Email de confirmation
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Vous recevrez sous peu un email de confirmation avec les details de votre demande.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-bold">2</span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        Etude de votre demande
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Nos experts analysent vos besoins et preparent une offre personnalisee.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-bold">3</span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        Prise de contact personnelle
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Nous vous contactons pour repondre a vos questions et convenir d'un rendez-vous.
                                    </p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center">
                                        <span class="text-primary font-bold">4</span>
                                    </div>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-1">
                                        Votre devis
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        Apres la visite, vous recevez un devis detaille et gratuit.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php else : ?>
                    <!-- Page de remerciement par defaut -->
                    <?php the_content(); ?>
                <?php endif; ?>

                <!-- Retour a l'accueil -->
                <div class="mt-12">
                    <a href="<?php echo home_url('/'); ?>"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Retour a l'accueil
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
get_footer();
