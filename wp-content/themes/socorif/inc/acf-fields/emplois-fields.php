<?php
/**
 * Champs ACF pour le Custom Post Type Offres d'emploi
 *
 * Definit tous les champs personnalises pour les offres d'emploi
 *
 * @package Socorif
 * @since 1.0.0
 */

// Empecher l'acces direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Enregistrer les champs ACF pour les offres d'emploi
 */
function socorif_emplois_register_acf_fields(): void
{
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_emplois_details',
        'title' => 'Details de l\'offre d\'emploi',
        'fields' => array(

            // Message d'information sur les blocs par defaut
            array(
                'key' => 'field_emplois_info_blocks',
                'label' => '',
                'name' => '',
                'type' => 'message',
                'message' => '<div style="background: linear-gradient(135deg, #7c3aed 0%, #5b21b6 100%); color: white; padding: 16px 20px; border-radius: 12px; margin-bottom: 20px;">
                    <strong style="font-size: 14px; display: block; margin-bottom: 8px;">Blocs flexibles par defaut pour cette offre :</strong>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px; font-size: 13px;">
                        <span>1. Accordeon (FAQ)</span>
                        <span>2. CTA divise</span>
                    </div>
                    <p style="margin-top: 10px; font-size: 12px; opacity: 0.9;">Ces blocs apparaissent automatiquement dans "Contenu de la page" pour les nouvelles offres.</p>
                </div>',
                'new_lines' => '',
                'esc_html' => 0,
            ),

            // Date de debut
            array(
                'key' => 'field_emplois_cpt_start_date',
                'label' => 'Date de debut',
                'name' => 'start_date',
                'type' => 'text',
                'instructions' => 'Date d\'entree souhaitee (ex: "A partir du 14 decembre 2025" ou "Des que possible")',
                'required' => 0,
                'default_value' => 'Des que possible',
                'placeholder' => 'Ex: A partir du 14 decembre 2025',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Onglet: Contenu de formation (pour Stage/Alternance)
            array(
                'key' => 'field_emplois_cpt_tab_ausbildung',
                'label' => 'Contenu de formation',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Titre du contenu de formation
            array(
                'key' => 'field_emplois_cpt_ausbildung_title',
                'label' => 'Contenu de formation - Titre',
                'name' => 'ausbildung_title',
                'type' => 'text',
                'default_value' => 'Contenu de la formation :',
                'required' => 0,
                'instructions' => 'Titre pour le contenu de formation/stage',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Contenu de formation (WYSIWYG)
            array(
                'key' => 'field_emplois_cpt_ausbildung_content',
                'label' => 'Contenu de formation - Description',
                'name' => 'ausbildung_content',
                'type' => 'wysiwyg',
                'instructions' => 'Description du contenu de formation, deroulement, duree, etc. Formatage flexible possible.',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
            ),

            // Onglet: Missions
            array(
                'key' => 'field_emplois_cpt_tab_tasks',
                'label' => 'Missions',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Titre des missions
            array(
                'key' => 'field_emplois_cpt_tasks_title',
                'label' => 'Missions - Titre',
                'name' => 'tasks_title',
                'type' => 'text',
                'default_value' => 'Vos missions :',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Liste des missions
            array(
                'key' => 'field_emplois_cpt_tasks',
                'label' => 'Missions (points)',
                'name' => 'tasks',
                'type' => 'repeater',
                'instructions' => 'Ajoutez les missions du poste',
                'layout' => 'table',
                'button_label' => 'Ajouter une mission',
                'min' => 0,
                'max' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_emplois_cpt_task_item',
                        'label' => 'Mission',
                        'name' => 'item',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                ),
            ),

            // Onglet: Profil
            array(
                'key' => 'field_emplois_cpt_tab_profile',
                'label' => 'Profil recherche',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Titre du profil
            array(
                'key' => 'field_emplois_cpt_profile_title',
                'label' => 'Profil - Titre',
                'name' => 'profile_title',
                'type' => 'text',
                'default_value' => 'Votre profil :',
                'required' => 0,
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Liste du profil
            array(
                'key' => 'field_emplois_cpt_profile',
                'label' => 'Profil (points)',
                'name' => 'profile',
                'type' => 'repeater',
                'instructions' => 'Ajoutez les criteres du profil recherche',
                'layout' => 'table',
                'button_label' => 'Ajouter un critere',
                'min' => 0,
                'max' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_emplois_cpt_profile_item',
                        'label' => 'Critere',
                        'name' => 'item',
                        'type' => 'text',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                ),
            ),

            // Onglet: Ce que nous offrons
            array(
                'key' => 'field_emplois_cpt_tab_perspectives',
                'label' => 'Ce que nous offrons',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Titre des avantages
            array(
                'key' => 'field_emplois_cpt_perspectives_title',
                'label' => 'Avantages - Titre',
                'name' => 'perspectives_title',
                'type' => 'text',
                'default_value' => 'Ce que nous offrons :',
                'required' => 0,
                'instructions' => 'Titre de la section avantages (ex: "Ce que nous offrons :", "Nos avantages :", etc.)',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Contenu des avantages (WYSIWYG)
            array(
                'key' => 'field_emplois_cpt_perspectives_content',
                'label' => 'Avantages - Contenu',
                'name' => 'perspectives_content',
                'type' => 'wysiwyg',
                'instructions' => 'Contenu libre pour les avantages et perspectives. Vous pouvez utiliser des listes, du texte, de la mise en forme, etc.',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 0,
                'delay' => 0,
                'wrapper' => array(
                    'width' => '100',
                ),
            ),

            // Onglet: Sections supplementaires (Optionnel & Repetable)
            array(
                'key' => 'field_emplois_cpt_tab_additional',
                'label' => 'Sections supplementaires (optionnel)',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Repeteur de sections supplementaires
            array(
                'key' => 'field_emplois_cpt_additional_sections',
                'label' => 'Sections supplementaires',
                'name' => 'additional_sections',
                'type' => 'repeater',
                'instructions' => 'Ajoutez autant de sections supplementaires que necessaire (ex: "Ce que nous attendons de vous :", "Vos competences :", etc.)',
                'required' => 0,
                'layout' => 'block',
                'button_label' => 'Ajouter une section',
                'collapsed' => 'field_emplois_cpt_additional_section_title',
                'min' => 0,
                'max' => 0,
                'sub_fields' => array(
                    array(
                        'key' => 'field_emplois_cpt_additional_section_title',
                        'label' => 'Titre',
                        'name' => 'section_title',
                        'type' => 'text',
                        'instructions' => 'Titre de cette section (ex: "Ce que nous attendons de vous :")',
                        'required' => 1,
                        'placeholder' => 'Ex: Ce que nous attendons de vous :',
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                    array(
                        'key' => 'field_emplois_cpt_additional_section_content',
                        'label' => 'Contenu',
                        'name' => 'section_content',
                        'type' => 'wysiwyg',
                        'instructions' => 'Contenu de cette section. Formatage flexible possible.',
                        'required' => 1,
                        'tabs' => 'all',
                        'toolbar' => 'full',
                        'media_upload' => 0,
                        'delay' => 0,
                        'wrapper' => array(
                            'width' => '100',
                        ),
                    ),
                ),
            ),

            // Onglet: Candidature
            array(
                'key' => 'field_emplois_cpt_tab_application',
                'label' => 'Candidature',
                'type' => 'tab',
                'placement' => 'top',
            ),

            // Titre de la candidature
            array(
                'key' => 'field_emplois_cpt_application_postal_title',
                'label' => 'Candidature - Titre',
                'name' => 'application_postal_title',
                'type' => 'text',
                'default_value' => 'Postulez a cette adresse :',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Adresse postale
            array(
                'key' => 'field_emplois_cpt_application_postal',
                'label' => 'Adresse postale',
                'name' => 'application_postal',
                'type' => 'textarea',
                'rows' => 4,
                'instructions' => 'Ex: "SOCORIF SARL, Service RH, Rue Example, Dakar, Senegal"',
                'wrapper' => array(
                    'width' => '50',
                ),
            ),

            // Choix de la methode de candidature
            array(
                'key' => 'field_emplois_cpt_application_is_email',
                'label' => 'Candidature par email',
                'name' => 'application_is_email',
                'type' => 'true_false',
                'instructions' => 'Si active, une adresse email (mailto) sera utilisee. Sinon, un lien vers la page de candidature.',
                'message' => 'Utiliser l\'email (mailto:)',
                'default_value' => 0,
                'ui' => 1,
                'wrapper' => array(
                    'width' => '25',
                ),
            ),

            // Adresse email (conditionnel)
            array(
                'key' => 'field_emplois_cpt_application_email',
                'label' => 'Adresse email',
                'name' => 'application_email',
                'type' => 'email',
                'instructions' => 'Adresse email pour les candidatures',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_emplois_cpt_application_is_email',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '37.5',
                ),
            ),

            // Objet de l'email (conditionnel)
            array(
                'key' => 'field_emplois_cpt_application_email_subject',
                'label' => 'Objet de l\'email (optionnel)',
                'name' => 'application_email_subject',
                'type' => 'text',
                'instructions' => 'Objet optionnel, sera ajoute au mailto',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_emplois_cpt_application_is_email',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '37.5',
                ),
            ),

            // Lien de candidature (conditionnel)
            array(
                'key' => 'field_emplois_cpt_application_link',
                'label' => 'Lien de candidature',
                'name' => 'application_link',
                'type' => 'link',
                'instructions' => 'Lien vers la page de candidature. Ignore si "Candidature par email" est active.',
                'required' => 0,
                'return_format' => 'array',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_emplois_cpt_application_is_email',
                            'operator' => '!=',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '100',
                ),
            ),

            // Onglet: Banniere Pub
            array(
                'key' => 'field_emplois_tab_banniere',
                'label' => 'Banniere Pub',
                'type' => 'tab',
                'placement' => 'top',
            ),
            array(
                'key' => 'field_emplois_banniere_activer',
                'label' => 'Activer la banniere publicitaire',
                'name' => 'banniere_activer',
                'type' => 'true_false',
                'default_value' => 0,
                'ui' => 1,
            ),
            array(
                'key' => 'field_emplois_banniere_subtitle',
                'label' => 'Sous-titre',
                'name' => 'banniere_subtitle',
                'type' => 'text',
                'default_value' => 'Expert en gestion de patrimoine internationale',
                'conditional_logic' => array(array(array('field' => 'field_emplois_banniere_activer', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key' => 'field_emplois_banniere_title',
                'label' => 'Titre',
                'name' => 'banniere_title',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'VOUS AVEZ UN PROJET IMMOBILIER A L\'ETRANGER ?',
                'conditional_logic' => array(array(array('field' => 'field_emplois_banniere_activer', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key' => 'field_emplois_banniere_image',
                'label' => 'Image',
                'name' => 'banniere_image',
                'type' => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'conditional_logic' => array(array(array('field' => 'field_emplois_banniere_activer', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key' => 'field_emplois_banniere_button',
                'label' => 'Bouton',
                'name' => 'banniere_button',
                'type' => 'link',
                'return_format' => 'array',
                'conditional_logic' => array(array(array('field' => 'field_emplois_banniere_activer', 'operator' => '==', 'value' => '1'))),
            ),
            array(
                'key' => 'field_emplois_banniere_bg_color',
                'label' => 'Couleur de fond',
                'name' => 'banniere_bg_color',
                'type' => 'select',
                'choices' => array('primary' => 'Orange', 'secondary' => 'Bleu', 'dark' => 'Sombre'),
                'default_value' => 'secondary',
                'conditional_logic' => array(array(array('field' => 'field_emplois_banniere_activer', 'operator' => '==', 'value' => '1'))),
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'emplois',
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
        'description' => 'Details des offres d\'emploi',
    ));
}
add_action('acf/init', 'socorif_emplois_register_acf_fields');
