<?php
/**
 * Formulaire de demande de devis simple
 *
 * Composant pour les demandes de devis par service
 *
 * @package Socorif
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

// Parametres avec valeurs par defaut
$service_name = $args['service_name'] ?? 'Service';
$service_slug = $args['service_slug'] ?? 'service';
?>

<div class="simple-quote-form bg-white dark:bg-neutral-900 rounded-3xl shadow-2xl p-6 md:p-8 lg:p-10">
    <form class="space-y-6" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

        <!-- Champs caches -->
        <input type="hidden" name="action" value="socorif_quote_form">
        <input type="hidden" name="service_name" value="<?php echo esc_attr($service_name); ?>">
        <input type="hidden" name="service_slug" value="<?php echo esc_attr($service_slug); ?>">
        <?php wp_nonce_field('socorif_quote_form_nonce', 'quote_nonce'); ?>

        <!-- Donnees personnelles -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                Vos coordonnees
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="vorname" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Prenom *
                    </label>
                    <input type="text"
                           id="vorname"
                           name="vorname"
                           required
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>

                <div>
                    <label for="nachname" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Nom *
                    </label>
                    <input type="text"
                           id="nachname"
                           name="nachname"
                           required
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Adresse email *
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           required
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>

                <div>
                    <label for="telefon" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Numero de telephone *
                    </label>
                    <input type="tel"
                           id="telefon"
                           name="telefon"
                           required
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>
            </div>
        </div>

        <!-- Adresse du projet -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                Localisation du projet
            </h3>

            <div class="mb-4">
                <label for="adresse" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Adresse (rue, numero) *
                </label>
                <input type="text"
                       id="adresse"
                       name="adresse"
                       required
                       placeholder="Ex: 123 Rue Example"
                       class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="plz" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Code postal *
                    </label>
                    <input type="text"
                           id="plz"
                           name="plz"
                           required
                           placeholder="Ex: BP 12345"
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>

                <div>
                    <label for="ort" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                        Ville *
                    </label>
                    <input type="text"
                           id="ort"
                           name="ort"
                           required
                           placeholder="Ex: Dakar"
                           class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors" />
                </div>
            </div>
        </div>

        <!-- Details du projet -->
        <div>
            <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">
                Description du projet
            </h3>

            <div class="mb-4">
                <label for="projektbeschreibung" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Decrivez votre projet *
                </label>
                <textarea id="projektbeschreibung"
                          name="projektbeschreibung"
                          rows="6"
                          required
                          placeholder="Veuillez decrire le plus precisement possible ce qui doit etre fait..."
                          class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors resize-none"></textarea>
            </div>

            <div>
                <label for="zeitrahmen" class="block text-sm font-semibold text-gray-900 dark:text-white mb-2">
                    Delai souhaite
                </label>
                <select id="zeitrahmen"
                        name="zeitrahmen"
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-gray-700 rounded-xl focus:border-primary focus:outline-none dark:bg-neutral-800 dark:text-white transition-colors">
                    <option value="">Veuillez choisir</option>
                    <option value="Immediatement">Immediatement</option>
                    <option value="1-2 semaines">1-2 semaines</option>
                    <option value="1 mois">1 mois</option>
                    <option value="2-3 mois">2-3 mois</option>
                    <option value="A convenir">A convenir</option>
                </select>
            </div>
        </div>

        <!-- Protection des donnees -->
        <div class="border-t border-gray-200 dark:border-gray-700 pt-6">
            <label class="flex items-start cursor-pointer">
                <input type="checkbox"
                       name="datenschutz"
                       required
                       class="w-5 h-5 text-primary border-2 border-gray-300 rounded focus:ring-primary mt-0.5" />
                <span class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                    J'ai lu et j'accepte la <a href="<?php echo get_permalink(get_page_by_path('politique-confidentialite')); ?>"
                                    target="_blank"
                                    class="text-primary hover:underline font-semibold">politique de confidentialite</a>. *
                </span>
            </label>
        </div>

        <!-- Bouton d'envoi -->
        <div class="pt-6">
            <button type="submit"
                    class="w-full bg-primary hover:bg-primary-dark text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 shadow-lg hover:shadow-2xl hover:-translate-y-1 flex items-center justify-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <span>Demander un devis gratuit</span>
            </button>
        </div>

    </form>
</div>
