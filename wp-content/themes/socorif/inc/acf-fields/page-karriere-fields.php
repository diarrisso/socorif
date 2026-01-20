<?php
/**
 * Champs ACF pour le template de page Carrieres
 *
 * Definit les champs pour personnaliser la page Carrieres/Offres d'emploi
 *
 * @package Socorif
 * @since 1.0.0
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enregistrer les champs ACF pour la page Carrieres
 */
function socorif_page_carrieres_register_acf_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_page_carrieres_settings',
        'title' => 'Parametres de la page Carrieres',
        'fields' => array(

            // Onglet: Parametres de la section Offres d'emploi
            array(
                'key' => 'field_page_carrieres_tab_emplois',
                'label' => 'Section Offres d\'emploi',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Sous-texte
            array(
                'key' => 'field_page_carrieres_emplois_subtext',
                'label' => 'Sous-titre',
                'name' => 'stellenangebote_subtext',
                'type' => 'text',
                'instructions' => 'Petit texte au-dessus du titre principal (ex: "CARRIERES CHEZ SOCORIF")',
                'required' => 0,
                'placeholder' => 'Ex: CARRIERES CHEZ SOCORIF',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Titre
            array(
                'key' => 'field_page_carrieres_emplois_title',
                'label' => 'Titre principal',
                'name' => 'stellenangebote_title',
                'type' => 'text',
                'instructions' => 'Titre principal de la section offres d\'emploi',
                'required' => 0,
                'placeholder' => 'Ex: Postes ouverts',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Sous-titre
            array(
                'key' => 'field_page_carrieres_emplois_subtitle',
                'label' => 'Description',
                'name' => 'stellenangebote_subtitle',
                'type' => 'textarea',
                'instructions' => 'Texte descriptif sous le titre',
                'required' => 0,
                'rows' => 3,
                'placeholder' => 'Ex: Rejoignez notre equipe...',
                'wrapper' => array(
                    'width' => '100',
                ),
            ),

            // Onglet: Parametres de recherche et filtre
            array(
                'key' => 'field_page_carrieres_tab_filter',
                'label' => 'Recherche et Filtre',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Activer la recherche/filtre
            array(
                'key' => 'field_page_carrieres_emplois_enable_search',
                'label' => 'Activer la recherche et le filtre',
                'name' => 'stellenangebote_enable_search',
                'type' => 'true_false',
                'instructions' => 'Si active, le systeme de recherche et de filtre sera affiche',
                'message' => 'Afficher la recherche et le filtre',
                'default_value' => 1,
                'ui' => 1,
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Options de filtre
            array(
                'key' => 'field_page_carrieres_emplois_filter_options',
                'label' => 'Options de filtre',
                'name' => 'stellenangebote_filter_options',
                'type' => 'checkbox',
                'instructions' => 'Selectionnez les filtres a afficher',
                'required' => 0,
                'choices' => array(
                    'search' => 'Champ de recherche',
                    'category' => 'Filtre par categorie',
                    'contract' => 'Filtre par type de contrat',
                ),
                'default_value' => array(
                    'search',
                    'category',
                    'contract',
                ),
                'layout' => 'vertical',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_page_carrieres_emplois_enable_search',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Onglet: CTA Candidature spontanee
            array(
                'key' => 'field_page_carrieres_tab_recruitment',
                'label' => 'Candidature spontanee / CTA',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // CTA Recrutement
            array(
                'key' => 'field_page_carrieres_emplois_recruitment_cta',
                'label' => 'Bloc candidature spontanee',
                'name' => 'stellenangebote_recruitment_cta',
                'type' => 'wysiwyg',
                'instructions' => 'Contenu du bloc candidature spontanee a la fin des offres d\'emploi (optionnel)',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-carrieres.php',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Parametres pour la page Carrieres',
    ));
}
add_action('acf/init', 'socorif_page_carrieres_register_acf_fields');

