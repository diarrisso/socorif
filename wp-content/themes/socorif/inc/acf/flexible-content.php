<?php
/**
 * ACF Flexible Content Field Group
 */

if (!defined('ABSPATH')) exit;

add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) return;

    $layouts = [
        // Hero
        [
            'key' => 'layout_hero',
            'name' => 'hero',
            'label' => 'Hero',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_hero_bg', 'label' => 'Image de fond', 'name' => 'background_image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_hero_overlay', 'label' => 'Opacite overlay', 'name' => 'overlay_opacity', 'type' => 'range', 'default_value' => 50, 'min' => 0, 'max' => 100],
                ['key' => 'field_fc_hero_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Bienvenue chez Socorif'],
                ['key' => 'field_fc_hero_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'required' => 0, 'default_value' => 'Votre partenaire immobilier de confiance'],
                ['key' => 'field_fc_hero_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Qualite, fiabilite et experience - ce sont les valeurs qui nous distinguent depuis plus de 25 ans. Faites confiance a notre expertise pour votre projet immobilier.'],
                ['key' => 'field_fc_hero_height', 'label' => 'Hauteur', 'name' => 'height', 'type' => 'select', 'choices' => ['auto' => 'Automatique', 'screen' => 'Plein ecran', 'large' => 'Grand', 'medium' => 'Moyen'], 'default_value' => 'large'],
            ],
        ],
        // Hero Split
        [
            'key' => 'layout_hero_split',
            'name' => 'hero-divise',
            'label' => 'Hero divise',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_hs_badge_text', 'label' => 'Texte du badge', 'name' => 'badge_text', 'type' => 'text', 'instructions' => 'Texte optionnel du badge au-dessus du titre'],
                ['key' => 'field_fc_hs_badge_link', 'label' => 'Lien du badge', 'name' => 'badge_link', 'type' => 'url', 'instructions' => 'Lien optionnel pour le badge'],
                ['key' => 'field_fc_hs_heading', 'label' => 'Titre', 'name' => 'heading', 'type' => 'text', 'required' => 1, 'default_value' => 'Votre entreprise en vedette', 'instructions' => 'Titre principal'],
                ['key' => 'field_fc_hs_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'instructions' => 'Texte de description sous le titre'],
                ['key' => 'field_fc_hs_primary_button_text', 'label' => 'Texte bouton principal', 'name' => 'primary_button_text', 'type' => 'text', 'instructions' => 'Texte pour le bouton principal'],
                ['key' => 'field_fc_hs_primary_button_link', 'label' => 'Lien bouton principal', 'name' => 'primary_button_link', 'type' => 'url', 'instructions' => 'Lien pour le bouton principal'],
                ['key' => 'field_fc_hs_secondary_button_text', 'label' => 'Texte bouton secondaire', 'name' => 'secondary_button_text', 'type' => 'text', 'instructions' => 'Texte pour le bouton secondaire (lien texte)'],
                ['key' => 'field_fc_hs_secondary_button_link', 'label' => 'Lien bouton secondaire', 'name' => 'secondary_button_link', 'type' => 'url', 'instructions' => 'Lien pour le bouton secondaire'],
                ['key' => 'field_fc_hs_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'required' => 1, 'return_format' => 'array', 'instructions' => 'Grande image hero (minimum 1200px de largeur recommande)'],
            ],
        ],
        // Services Cards
        [
            'key' => 'layout_services_cards',
            'name' => 'cartes-services',
            'label' => 'Cartes de services',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_sc_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Nos services'],
                ['key' => 'field_fc_sc_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Ce que nous faisons pour vous'],
                ['key' => 'field_fc_sc_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'De la conception a la realisation - nous vous offrons des services complets pour votre projet immobilier.'],
                ['key' => 'field_fc_sc_cards', 'label' => 'Cartes', 'name' => 'cards', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un service', 'sub_fields' => [
                    ['key' => 'field_fc_sc_c_service', 'label' => 'Selectionner un service', 'name' => 'service', 'type' => 'post_object', 'post_type' => ['leistungen'], 'return_format' => 'id', 'ui' => 1, 'required' => 1, 'instructions' => 'Choisissez un service dans la liste'],
                    ['key' => 'field_fc_sc_c_image', 'label' => 'Image personnalisee (optionnel)', 'name' => 'custom_image', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Laisser vide pour utiliser l\'image du service'],
                    ['key' => 'field_fc_sc_c_desc', 'label' => 'Description personnalisee (optionnel)', 'name' => 'custom_description', 'type' => 'textarea', 'rows' => 2, 'instructions' => 'Laisser vide pour utiliser la description du service'],
                ]],
                ['key' => 'field_fc_sc_columns', 'label' => 'Colonnes', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '3'],
                ['key' => 'field_fc_sc_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Section CTA
        [
            'key' => 'layout_section_cta',
            'name' => 'section-cta',
            'label' => 'Section CTA',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_cta_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_cta_position', 'label' => 'Position de l\'image', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Gauche', 'right' => 'Droite'], 'default_value' => 'left'],
                ['key' => 'field_fc_cta_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Commencer maintenant'],
                ['key' => 'field_fc_cta_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'required' => 1, 'default_value' => 'Pret pour votre prochain projet ?'],
                ['key' => 'field_fc_cta_content', 'label' => 'Contenu', 'name' => 'content', 'type' => 'wysiwyg', 'tabs' => 'all', 'toolbar' => 'basic', 'default_value' => '<p>Contactez-nous des aujourd\'hui pour une consultation gratuite. Ensemble, nous trouverons la meilleure solution pour votre projet immobilier.</p>'],
                ['key' => 'field_fc_cta_button', 'label' => 'Bouton', 'name' => 'button', 'type' => 'link', 'return_format' => 'array'],
            ],
        ],
        // About
        [
            'key' => 'layout_about',
            'name' => 'a-propos',
            'label' => 'A propos',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_about_intro_label', 'label' => 'Label d\'intro', 'name' => 'intro_label', 'type' => 'text', 'default_value' => 'A propos'],
                ['key' => 'field_fc_about_title', 'label' => 'Titre principal', 'name' => 'title', 'type' => 'text', 'required' => 1, 'default_value' => 'Notre mission est de realiser des projets immobiliers de qualite'],
                ['key' => 'field_fc_about_intro_text', 'label' => 'Texte d\'introduction', 'name' => 'intro_text', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Depuis des annees, Socorif represente l\'excellence en immobilier et des partenariats fiables. Notre equipe experimentee realise vos projets avec la plus grande precision et qualite.'],
                ['key' => 'field_fc_about_mission_title', 'label' => 'Titre mission', 'name' => 'mission_title', 'type' => 'text', 'default_value' => 'Notre mission'],
                ['key' => 'field_fc_about_mission_text_1', 'label' => 'Texte mission 1', 'name' => 'mission_text_1', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'Nous nous efforcons de depasser les attentes de nos clients grace a des solutions innovantes et un savoir-faire de premier ordre. Avec une technologie de pointe et une equipe engagee, nous fixons de nouveaux standards dans l\'immobilier.'],
                ['key' => 'field_fc_about_mission_text_2', 'label' => 'Texte mission 2', 'name' => 'mission_text_2', 'type' => 'textarea', 'rows' => 4, 'default_value' => 'La durabilite et la qualite sont les piliers de notre travail. Chaque projet est traite avec le meme soin et le meme professionnalisme, quelle que soit sa taille.'],
                ['key' => 'field_fc_about_image_1', 'label' => 'Image 1 (haut gauche)', 'name' => 'image_1', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_about_image_2', 'label' => 'Image 2 (haut droite)', 'name' => 'image_2', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_about_image_3', 'label' => 'Image 3 (bas gauche)', 'name' => 'image_3', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_about_image_4', 'label' => 'Image 4 (bas droite)', 'name' => 'image_4', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_about_stats_title', 'label' => 'Titre statistiques', 'name' => 'stats_title', 'type' => 'text', 'default_value' => 'Nos chiffres'],
                ['key' => 'field_fc_about_stats', 'label' => 'Statistiques', 'name' => 'statistiques', 'type' => 'repeater', 'min' => 3, 'max' => 4, 'layout' => 'table', 'button_label' => 'Ajouter une statistique', 'instructions' => 'Ajoutez 3-4 statistiques: nombre de projets, nombre de clients, nombre d\'employes, etc.', 'sub_fields' => [
                    ['key' => 'field_fc_about_stat_label', 'label' => 'Libelle', 'name' => 'label', 'type' => 'text', 'placeholder' => 'Projets realises / Clients satisfaits / Employes'],
                    ['key' => 'field_fc_about_stat_value', 'label' => 'Valeur', 'name' => 'value', 'type' => 'text', 'placeholder' => '250+ / 150+ / 50+'],
                ]],
            ],
        ],
        // Services Icons
        [
            'key' => 'layout_services_icons',
            'name' => 'icones-services',
            'label' => 'Services avec icones',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_si_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos services'],
                ['key' => 'field_fc_si_services', 'label' => 'Services', 'name' => 'services', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un service', 'sub_fields' => [
                    ['key' => 'field_fc_si_s_icon', 'label' => 'Icone', 'name' => 'icon', 'type' => 'text', 'instructions' => 'Classe d\'icone (ex: fa-home)', 'default_value' => 'fa-home'],
                    ['key' => 'field_fc_si_s_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Service'],
                    ['key' => 'field_fc_si_s_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Execution professionnelle avec une technologie de pointe et des specialistes qualifies.'],
                ]],
            ],
        ],
        // Team
        [
            'key' => 'layout_team',
            'name' => 'equipe',
            'label' => 'Equipe',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_team_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Notre equipe'],
                ['key' => 'field_fc_team_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Nous sommes un groupe dynamique de personnes passionnees par leur travail et dediees a offrir le meilleur a nos clients.'],
                ['key' => 'field_fc_team_members', 'label' => 'Membres de l\'equipe', 'name' => 'members', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un membre', 'sub_fields' => [
                    ['key' => 'field_fc_team_m_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array'],
                    ['key' => 'field_fc_team_m_name', 'label' => 'Nom', 'name' => 'name', 'type' => 'text', 'default_value' => 'Jean Dupont'],
                    ['key' => 'field_fc_team_m_department', 'label' => 'Departement', 'name' => 'department', 'type' => 'select', 'required' => 1, 'choices' => ['management' => 'Direction', 'administration' => 'Administration / Secretariat', 'training' => 'Formation', 'finance' => 'Finance', 'operations' => 'Operations', 'sales' => 'Commercial', 'technical' => 'Technique'], 'default_value' => 'management'],
                    ['key' => 'field_fc_team_m_role', 'label' => 'Poste', 'name' => 'role', 'type' => 'text', 'default_value' => 'Directeur General'],
                    ['key' => 'field_fc_team_m_location', 'label' => 'Localisation', 'name' => 'localisation', 'type' => 'text', 'default_value' => 'Paris, France'],
                    ['key' => 'field_fc_team_m_email', 'label' => 'E-mail (optionnel)', 'name' => 'email', 'type' => 'email', 'required' => 0],
                ]],
                ['key' => 'field_fc_team_columns', 'label' => 'Colonnes (Desktop)', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '4'],
            ],
        ],
        // Clients
        [
            'key' => 'layout_clients',
            'name' => 'clients',
            'label' => 'Clients',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_clients_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos clients'],
                ['key' => 'field_fc_clients_logos', 'label' => 'Logos', 'name' => 'logos', 'type' => 'gallery', 'return_format' => 'array'],
            ],
        ],
        // Testimonials
        [
            'key' => 'layout_testimonials',
            'name' => 'temoignages',
            'label' => 'Temoignages',
            'display' => 'block',
            'sub_fields' => [
                // Section Title
                ['key' => 'field_fc_testi_section_title', 'label' => 'Titre de la section', 'name' => 'section_title', 'type' => 'text', 'required' => 0, 'default_value' => 'TEMOIGNAGES', 'instructions' => 'Titre principal pour la section temoignages (optionnel)'],

                // Testimonials Repeater
                ['key' => 'field_fc_testi_repeater', 'label' => 'Temoignages', 'name' => 'temoignages', 'type' => 'repeater', 'min' => 1, 'layout' => 'block', 'button_label' => 'Ajouter un temoignage', 'instructions' => 'Ajoutez plusieurs temoignages clients. Ils seront affiches dans un slider.', 'sub_fields' => [
                    ['key' => 'field_fc_testi_sub_quote', 'label' => 'Citation', 'name' => 'quote', 'type' => 'textarea', 'rows' => 5, 'required' => 1, 'default_value' => 'Socorif a realise notre projet de maniere professionnelle et dans les delais. La qualite du travail et le service etaient excellents. Nous recommandons vivement leur equipe.'],
                    ['key' => 'field_fc_testi_sub_person_image', 'label' => 'Photo de la personne', 'name' => 'person_image', 'type' => 'image', 'return_format' => 'array', 'required' => 0],
                    ['key' => 'field_fc_testi_sub_person_name', 'label' => 'Nom', 'name' => 'person_name', 'type' => 'text', 'required' => 0, 'default_value' => 'Marie Dupont'],
                    ['key' => 'field_fc_testi_sub_person_title', 'label' => 'Poste/Titre', 'name' => 'person_title', 'type' => 'text', 'required' => 0, 'default_value' => 'Directrice, Entreprise Dupont'],
                ]],

                // Slider Settings Tab
                ['key' => 'field_fc_testi_tab_slider', 'label' => 'Parametres du slider', 'name' => 'slider_settings', 'type' => 'tab', 'placement' => 'top'],
                ['key' => 'field_fc_testi_autoplay', 'label' => 'Lecture automatique', 'name' => 'enable_autoplay', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Activer pour faire defiler le slider automatiquement'],
                ['key' => 'field_fc_testi_autoplay_delay', 'label' => 'Delai autoplay (ms)', 'name' => 'autoplay_delay', 'type' => 'number', 'default_value' => 6000, 'min' => 2000, 'max' => 15000, 'step' => 1000, 'instructions' => 'Temps entre les slides en millisecondes', 'conditional_logic' => [
                    [['field' => 'field_fc_testi_autoplay', 'operator' => '==', 'value' => '1']]
                ]],
                ['key' => 'field_fc_testi_loop', 'label' => 'Boucle infinie', 'name' => 'enable_loop', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Revenir au premier slide apres le dernier'],
                ['key' => 'field_fc_testi_pagination', 'label' => 'Afficher la pagination', 'name' => 'show_pagination', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Afficher les points de navigation entre les slides'],
                ['key' => 'field_fc_testi_navigation', 'label' => 'Afficher les fleches de navigation', 'name' => 'show_navigation', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Afficher les fleches precedent/suivant'],
            ],
        ],
        // Testimonials Grid (Client Testimonials)
        [
            'key' => 'layout_testimonials_grid',
            'name' => 'temoignages-clients-grille',
            'label' => 'Temoignages clients (Grille)',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_tcg_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Mes clients temoignent'],
                ['key' => 'field_fc_tcg_initial_count', 'label' => 'Nombre initial affiche', 'name' => 'initial_count', 'type' => 'number', 'default_value' => 4, 'min' => 2, 'max' => 12, 'instructions' => 'Nombre de temoignages affiches au chargement'],
                ['key' => 'field_fc_tcg_load_more_count', 'label' => 'Nombre a charger', 'name' => 'load_more_count', 'type' => 'number', 'default_value' => 2, 'min' => 1, 'max' => 6, 'instructions' => 'Nombre de temoignages a charger au clic'],
                ['key' => 'field_fc_tcg_button_text', 'label' => 'Texte du bouton', 'name' => 'button_text', 'type' => 'text', 'default_value' => 'Voir les Temoignages'],
                ['key' => 'field_fc_tcg_testimonials', 'label' => 'Temoignages', 'name' => 'testimonials', 'type' => 'repeater', 'min' => 1, 'layout' => 'block', 'button_label' => 'Ajouter un temoignage', 'sub_fields' => [
                    ['key' => 'field_fc_tcg_t_quote', 'label' => 'Citation', 'name' => 'quote', 'type' => 'textarea', 'rows' => 4, 'required' => 1],
                    ['key' => 'field_fc_tcg_t_photo', 'label' => 'Photo', 'name' => 'photo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail'],
                    ['key' => 'field_fc_tcg_t_name', 'label' => 'Nom', 'name' => 'name', 'type' => 'text', 'required' => 1],
                    ['key' => 'field_fc_tcg_t_position', 'label' => 'Poste', 'name' => 'position', 'type' => 'text'],
                    ['key' => 'field_fc_tcg_t_company', 'label' => 'Entreprise', 'name' => 'company', 'type' => 'text'],
                    ['key' => 'field_fc_tcg_t_logo', 'label' => 'Logo entreprise', 'name' => 'company_logo', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'instructions' => 'Logo optionnel de l\'entreprise'],
                ]],
                ['key' => 'field_fc_tcg_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair'], 'default_value' => 'white'],
            ],
        ],
        // Gallery
        [
            'key' => 'layout_gallery',
            'name' => 'galerie',
            'label' => 'Galerie',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_gallery_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos projets'],
                ['key' => 'field_fc_gallery_columns', 'label' => 'Colonnes', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '2'],
                ['key' => 'field_fc_gallery_images', 'label' => 'Images', 'name' => 'images', 'type' => 'gallery', 'return_format' => 'array'],
            ],
        ],
        // Accordion
        [
            'key' => 'layout_accordion',
            'name' => 'accordeon',
            'label' => 'Accordeon',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_acc_title', 'label' => 'Titre', 'name' => 'accordion_title', 'type' => 'text', 'default_value' => 'Questions frequentes'],
                ['key' => 'field_fc_acc_items', 'label' => 'Elements', 'name' => 'accordion_items', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un element', 'sub_fields' => [
                    ['key' => 'field_fc_acc_i_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Question ou sujet'],
                    ['key' => 'field_fc_acc_i_content', 'label' => 'Contenu', 'name' => 'content', 'type' => 'wysiwyg', 'toolbar' => 'basic', 'default_value' => '<p>Voici la reponse detaillee ou la description de ce sujet.</p>'],
                ]],
            ],
        ],
        // YouTube Video
        [
            'key' => 'layout_youtube_video',
            'name' => 'video-youtube',
            'label' => 'Video YouTube',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_yt_video_id', 'label' => 'ID video YouTube', 'name' => 'video_id', 'type' => 'text', 'required' => 0, 'instructions' => 'Entrez l\'ID de la video (ex: "dQw4w9WgXcQ") - OU utilisez le champ URL', 'placeholder' => 'dQw4w9WgXcQ', 'default_value' => ''],
                ['key' => 'field_fc_yt_url', 'label' => 'URL YouTube (Alternative)', 'name' => 'youtube_url', 'type' => 'url', 'required' => 0, 'instructions' => 'OU: Collez l\'URL complete', 'placeholder' => 'https://www.youtube.com/watch?v=', 'default_value' => ''],
                ['key' => 'field_fc_yt_title', 'label' => 'Titre', 'name' => 'video_title', 'type' => 'text', 'default_value' => 'Titre de la video'],
                ['key' => 'field_fc_yt_desc', 'label' => 'Description', 'name' => 'video_description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Decouvrez notre travail et nos projets dans cette video.'],
                ['key' => 'field_fc_yt_thumbnail', 'label' => 'Miniature personnalisee', 'name' => 'custom_thumbnail', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => 'Optionnel - sinon la miniature YouTube sera utilisee'],
                ['key' => 'field_fc_yt_aspect_ratio', 'label' => 'Format', 'name' => 'aspect_ratio', 'type' => 'select', 'choices' => ['16/9' => '16:9 (Standard)', '4/3' => '4:3', '1/1' => '1:1 (Carre)'], 'default_value' => '16/9'],
                ['key' => 'field_fc_yt_use_bg', 'label' => 'Utiliser miniature comme fond', 'name' => 'use_thumbnail_background', 'type' => 'true_false', 'ui' => 1, 'default_value' => 0, 'instructions' => 'Utiliser la miniature comme image de fond de toute la section'],
                ['key' => 'field_fc_yt_overlay_opacity', 'label' => 'Opacite overlay fond', 'name' => 'overlay_opacity', 'type' => 'range', 'min' => 0, 'max' => 100, 'step' => 5, 'default_value' => 50, 'append' => '%', 'conditional_logic' => [[['field' => 'field_fc_yt_use_bg', 'operator' => '==', 'value' => '1']]]],
            ],
        ],
        // News
        [
            'key' => 'layout_news',
            'name' => 'actualites',
            'label' => 'Actualites',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_news_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Actualites'],
                ['key' => 'field_fc_news_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Actualites et projets'],
                ['key' => 'field_fc_news_display_mode', 'label' => 'Mode d\'affichage', 'name' => 'display_mode', 'type' => 'select', 'choices' => ['grid' => 'Grille', 'slider' => 'Slider (3 par slide)'], 'default_value' => 'grid', 'wrapper' => ['width' => '50']],
                ['key' => 'field_fc_news_bg_color', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray' => 'Gris clair', 'dark' => 'Sombre'], 'default_value' => 'white', 'wrapper' => ['width' => '50']],
                ['key' => 'field_fc_news_articles', 'label' => 'Articles', 'name' => 'articles', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un article', 'sub_fields' => [
                    ['key' => 'field_fc_news_a_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                    ['key' => 'field_fc_news_a_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Titre de l\'article'],
                    ['key' => 'field_fc_news_a_category', 'label' => 'Categorie', 'name' => 'category', 'type' => 'text', 'default_value' => 'Actualites'],
                    ['key' => 'field_fc_news_a_excerpt', 'label' => 'Extrait', 'name' => 'excerpt', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Bref resume de l\'article ou de l\'actualite.'],
                    ['key' => 'field_fc_news_a_link', 'label' => 'Lien', 'name' => 'link', 'type' => 'link', 'return_format' => 'array'],
                ]],
            ],
        ],
        // Projects Grid
        [
            'key' => 'layout_projects_grid',
            'name' => 'grille-projets',
            'label' => 'Grille de projets',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_pg_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Projets'],
                ['key' => 'field_fc_pg_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos projets de reference'],
                ['key' => 'field_fc_pg_mode', 'label' => 'Mode d\'affichage', 'name' => 'projects_mode', 'type' => 'select', 'choices' => ['auto' => 'Automatique (derniers projets)', 'selection' => 'Selection manuelle'], 'default_value' => 'selection', 'instructions' => 'Automatique: affiche les derniers projets. Selection: choisissez les projets a afficher.'],
                // Auto mode fields
                ['key' => 'field_fc_pg_count', 'label' => 'Nombre de projets', 'name' => 'projects_count', 'type' => 'number', 'default_value' => 6, 'min' => 1, 'max' => 24, 'conditional_logic' => [[['field' => 'field_fc_pg_mode', 'operator' => '==', 'value' => 'auto']]]],
                // Selection mode fields
                ['key' => 'field_fc_pg_projects', 'label' => 'Projets a afficher', 'name' => 'projects', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un projet', 'conditional_logic' => [[['field' => 'field_fc_pg_mode', 'operator' => '==', 'value' => 'selection']]], 'sub_fields' => [
                    ['key' => 'field_fc_pg_p_project', 'label' => 'Selectionner un projet', 'name' => 'project', 'type' => 'post_object', 'post_type' => ['projekte'], 'return_format' => 'id', 'ui' => 1, 'required' => 1, 'instructions' => 'Choisissez un projet dans la liste'],
                    ['key' => 'field_fc_pg_p_image', 'label' => 'Image personnalisee (optionnel)', 'name' => 'custom_image', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Laisser vide pour utiliser l\'image du projet'],
                ]],
                ['key' => 'field_fc_pg_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Background Image Section
        [
            'key' => 'layout_background_image_section',
            'name' => 'section-image-fond',
            'label' => 'Section image de fond',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_bgimg_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'required' => 1, 'return_format' => 'array', 'instructions' => 'Selectionnez une grande image (minimum 2000px de largeur recommande)'],
                ['key' => 'field_fc_bgimg_alt', 'label' => 'Texte alternatif', 'name' => 'alt_text', 'type' => 'text', 'instructions' => 'Texte alternatif pour l\'accessibilite'],
                ['key' => 'field_fc_bgimg_rounded', 'label' => 'Coins arrondis', 'name' => 'rounded', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Affiche des coins arrondis sur desktop'],
                ['key' => 'field_fc_bgimg_aspect', 'label' => 'Ratio d\'aspect', 'name' => 'aspect_ratio', 'type' => 'select', 'choices' => ['aspect-video' => '16:9 (Video)', 'aspect-[5/2]' => '5:2 (Large)', 'aspect-[21/9]' => '21:9 (Ultra-large)', 'aspect-[3/1]' => '3:1 (Banniere)', 'aspect-square' => '1:1 (Carre)'], 'default_value' => 'aspect-[5/2]'],
                ['key' => 'field_fc_bgimg_spacing', 'label' => 'Espacement haut', 'name' => 'spacing_top', 'type' => 'select', 'choices' => ['mt-16 sm:mt-20' => 'Normal', 'mt-24 sm:mt-32' => 'Grand', 'mt-32 sm:mt-40' => 'Tres grand', 'mt-0' => 'Pas d\'espacement'], 'default_value' => 'mt-32 sm:mt-40'],
            ],
        ],
        // Before After
        [
            'key' => 'layout_before_after',
            'name' => 'avant-apres',
            'label' => 'Avant/Apres',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_ba_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Avant/Apres'],
                ['key' => 'field_fc_ba_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Decouvrez la transformation'],
                ['key' => 'field_fc_ba_before', 'label' => 'Image avant', 'name' => 'before_image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_ba_after', 'label' => 'Image apres', 'name' => 'after_image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_ba_before_label', 'label' => 'Label avant', 'name' => 'before_label', 'type' => 'text', 'default_value' => 'Avant'],
                ['key' => 'field_fc_ba_after_label', 'label' => 'Label apres', 'name' => 'after_label', 'type' => 'text', 'default_value' => 'Apres'],
                ['key' => 'field_fc_ba_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Decouvrez la difference impressionnante entre l\'etat initial et le projet termine.'],
            ],
        ],
        // Slider
        [
            'key' => 'layout_slider',
            'name' => 'slider',
            'label' => 'Slider/Carrousel',
            'display' => 'block',
            'sub_fields' => [
                // Header
                ['key' => 'field_fc_slider_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Galerie'],
                ['key' => 'field_fc_slider_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Decouvrez nos realisations'],

                // Slides
                ['key' => 'field_fc_slider_slides', 'label' => 'Slides', 'name' => 'slides', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un slide', 'sub_fields' => [
                    ['key' => 'field_fc_slider_s_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                    ['key' => 'field_fc_slider_s_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Titre du slide'],
                    ['key' => 'field_fc_slider_s_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Description du projet ou du service.'],
                    ['key' => 'field_fc_slider_s_link', 'label' => 'Lien', 'name' => 'link', 'type' => 'link', 'return_format' => 'array'],
                ]],

                // Display Settings
                ['key' => 'field_fc_slider_tab_display', 'label' => 'Parametres d\'affichage', 'name' => 'display_settings', 'type' => 'tab', 'placement' => 'top'],
                ['key' => 'field_fc_slider_slides_mobile', 'label' => 'Slides visibles (Mobile < 640px)', 'name' => 'slides_per_view_mobile', 'type' => 'number', 'default_value' => 1, 'min' => 1, 'max' => 2],
                ['key' => 'field_fc_slider_slides_tablet', 'label' => 'Slides visibles (Tablette 640px+)', 'name' => 'slides_per_view_tablet', 'type' => 'number', 'default_value' => 2, 'min' => 1, 'max' => 4],
                ['key' => 'field_fc_slider_slides_desktop', 'label' => 'Slides visibles (Desktop 1024px+)', 'name' => 'slides_per_view_desktop', 'type' => 'number', 'default_value' => 3, 'min' => 1, 'max' => 6],
                ['key' => 'field_fc_slider_space', 'label' => 'Espacement entre slides (px)', 'name' => 'space_between', 'type' => 'number', 'default_value' => 30, 'min' => 0, 'max' => 100],

                // Behavior Settings
                ['key' => 'field_fc_slider_tab_behavior', 'label' => 'Comportement', 'name' => 'behavior_settings', 'type' => 'tab', 'placement' => 'top'],
                ['key' => 'field_fc_slider_loop', 'label' => 'Boucle infinie', 'name' => 'enable_loop', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_slider_autoplay', 'label' => 'Lecture automatique', 'name' => 'enable_autoplay', 'type' => 'true_false', 'default_value' => 0, 'ui' => 1],
                ['key' => 'field_fc_slider_autoplay_delay', 'label' => 'Delai autoplay (ms)', 'name' => 'autoplay_delay', 'type' => 'number', 'default_value' => 5000, 'min' => 1000, 'max' => 10000, 'conditional_logic' => [
                    [['field' => 'field_fc_slider_autoplay', 'operator' => '==', 'value' => '1']]
                ]],
                ['key' => 'field_fc_slider_speed', 'label' => 'Vitesse d\'animation (ms)', 'name' => 'animation_speed', 'type' => 'number', 'default_value' => 600, 'min' => 200, 'max' => 2000],
                ['key' => 'field_fc_slider_effect', 'label' => 'Effet de transition', 'name' => 'transition_effect', 'type' => 'select', 'choices' => ['slide' => 'Glissement', 'fade' => 'Fondu', 'cube' => 'Cube', 'coverflow' => 'Coverflow'], 'default_value' => 'slide'],

                // Navigation Settings
                ['key' => 'field_fc_slider_tab_nav', 'label' => 'Navigation', 'name' => 'navigation_settings', 'type' => 'tab', 'placement' => 'top'],
                ['key' => 'field_fc_slider_show_nav', 'label' => 'Afficher les fleches', 'name' => 'show_navigation', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_slider_show_pagination', 'label' => 'Afficher la pagination (points)', 'name' => 'show_pagination', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],

                // Style Settings
                ['key' => 'field_fc_slider_tab_style', 'label' => 'Style', 'name' => 'style_settings', 'type' => 'tab', 'placement' => 'top'],
                ['key' => 'field_fc_slider_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Contact Form
        [
            'key' => 'layout_contact_form',
            'name' => 'formulaire-contact',
            'label' => 'Formulaire de contact',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_cf_heading', 'label' => 'Titre', 'name' => 'heading', 'type' => 'text', 'default_value' => 'Contactez-nous'],
                ['key' => 'field_fc_cf_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Nous sommes a votre ecoute et vous repondrons dans les plus brefs delais.'],
                ['key' => 'field_fc_cf_address', 'label' => 'Adresse', 'name' => 'address', 'type' => 'textarea', 'rows' => 2, 'default_value' => "123 Rue Exemple\n75000 Paris"],
                ['key' => 'field_fc_cf_phone', 'label' => 'Telephone', 'name' => 'phone', 'type' => 'text', 'default_value' => '+33 (0) 1 23 45 67 89'],
                ['key' => 'field_fc_cf_email', 'label' => 'Adresse e-mail', 'name' => 'email', 'type' => 'email', 'default_value' => 'contact@socorif.fr'],
                ['key' => 'field_fc_cf_button_text', 'label' => 'Texte du bouton', 'name' => 'button_text', 'type' => 'text', 'default_value' => 'Envoyer le message'],
                ['key' => 'field_fc_cf_action', 'label' => 'URL d\'action du formulaire', 'name' => 'form_action', 'type' => 'url', 'instructions' => 'URL pour le traitement du formulaire (laisser vide par defaut)'],
                ['key' => 'field_fc_cf_show_bg', 'label' => 'Afficher fond decoratif', 'name' => 'show_decorative_bg', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_cf_show_gradient', 'label' => 'Afficher effet degrade', 'name' => 'show_gradient', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
            ],
        ],
        // Stats/Numbers
        [
            'key' => 'layout_stats',
            'name' => 'statistiques',
            'label' => 'Chiffres cles',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_stats_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'En chiffres'],
                ['key' => 'field_fc_stats_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos resultats parlent d\'eux-memes'],
                ['key' => 'field_fc_stats_items', 'label' => 'Chiffres cles', 'name' => 'statistiques', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un chiffre', 'sub_fields' => [
                    ['key' => 'field_fc_stats_i_number', 'label' => 'Nombre', 'name' => 'number', 'type' => 'number', 'default_value' => 100],
                    ['key' => 'field_fc_stats_i_suffix', 'label' => 'Suffixe', 'name' => 'suffix', 'type' => 'text', 'instructions' => 'ex: +, %, ans', 'default_value' => '+'],
                    ['key' => 'field_fc_stats_i_label', 'label' => 'Libelle', 'name' => 'label', 'type' => 'text', 'default_value' => 'Projets'],
                    ['key' => 'field_fc_stats_i_icon', 'label' => 'Icone', 'name' => 'icon', 'type' => 'text', 'instructions' => 'Classe d\'icone (ex: fa-check)', 'default_value' => 'fa-check'],
                ]],
                ['key' => 'field_fc_stats_columns', 'label' => 'Colonnes', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '4'],
                ['key' => 'field_fc_stats_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'gray-50'],
            ],
        ],
        // Map/Location - Affiche uniquement la carte Google Maps
        [
            'key' => 'layout_location',
            'name' => 'localisation',
            'label' => 'Localisation',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_loc_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Notre emplacement'],
                ['key' => 'field_fc_loc_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => ''],
                ['key' => 'field_fc_loc_map', 'label' => 'Integration carte Google Maps', 'name' => 'map_embed', 'type' => 'textarea', 'rows' => 4, 'instructions' => 'Allez sur Google Maps, recherchez votre adresse, cliquez sur Partager > Integrer une carte, puis collez le code iframe ici.', 'default_value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63132.35768072938!2d-13.712024!3d9.6412431!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xf1cd6c6e2bccc15%3A0x73e2f9a0b4cc810d!2sConakry%2C%20Guinea!5e0!3m2!1sen!2sfr!4v1704067200000!5m2!1sen!2sfr" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>'],
                ['key' => 'field_fc_loc_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Timeline/Process
        [
            'key' => 'layout_timeline',
            'name' => 'chronologie',
            'label' => 'Processus',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_tl_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Notre processus'],
                ['key' => 'field_fc_tl_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Comment se deroule votre projet'],
                ['key' => 'field_fc_tl_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'De la premiere idee a la remise des cles, nous vous accompagnons a chaque etape.'],
                ['key' => 'field_fc_tl_steps', 'label' => 'Etapes', 'name' => 'steps', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter une etape', 'sub_fields' => [
                    ['key' => 'field_fc_tl_s_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Consultation'],
                    ['key' => 'field_fc_tl_s_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Nous discutons de vos souhaits et elaborons un concept personnalise.'],
                ]],
                ['key' => 'field_fc_tl_layout', 'label' => 'Mise en page', 'name' => 'layout', 'type' => 'select', 'choices' => ['grid' => 'Grille', 'vertical' => 'Vertical', 'horizontal' => 'Horizontal'], 'default_value' => 'grid'],
                ['key' => 'field_fc_tl_columns', 'label' => 'Colonnes (Grille)', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '4', 'conditional_logic' => [['field' => 'field_fc_tl_layout', 'operator' => '==', 'value' => 'grid']]],
                ['key' => 'field_fc_tl_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Text + Image
        [
            'key' => 'layout_text_image',
            'name' => 'texte-image',
            'label' => 'Texte avec image',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_ti_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array'],
                ['key' => 'field_fc_ti_position', 'label' => 'Position de l\'image', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Gauche', 'right' => 'Droite'], 'default_value' => 'left'],
                ['key' => 'field_fc_ti_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Qualite et experience reunies'],
                ['key' => 'field_fc_ti_content', 'label' => 'Contenu', 'name' => 'content', 'type' => 'wysiwyg', 'tabs' => 'all', 'toolbar' => 'basic', 'default_value' => '<p>Avec plus de 25 ans d\'experience dans l\'immobilier, nous sommes votre partenaire de confiance pour tous vos projets.</p>'],
                ['key' => 'field_fc_ti_features', 'label' => 'Caracteristiques', 'name' => 'features', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Ajouter une caracteristique', 'sub_fields' => [
                    ['key' => 'field_fc_ti_f_text', 'label' => 'Texte', 'name' => 'text', 'type' => 'text', 'default_value' => 'Conseil professionnel'],
                    ['key' => 'field_fc_ti_f_icon', 'label' => 'Icone', 'name' => 'icon', 'type' => 'text', 'instructions' => 'Classe d\'icone (ex: fa-check)', 'default_value' => 'fa-check'],
                ]],
                ['key' => 'field_fc_ti_button', 'label' => 'Bouton', 'name' => 'button', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_ti_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Certifications/Awards
        [
            'key' => 'layout_certifications',
            'name' => 'certifications',
            'label' => 'Certifications',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_cert_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Qualite & Securite'],
                ['key' => 'field_fc_cert_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nos certifications'],
                ['key' => 'field_fc_cert_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Nous respectons les plus hauts standards de qualite et de securite.'],
                ['key' => 'field_fc_cert_items', 'label' => 'Certifications', 'name' => 'certifications', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter une certification', 'sub_fields' => [
                    ['key' => 'field_fc_cert_i_logo', 'label' => 'Logo', 'name' => 'logo', 'type' => 'image', 'return_format' => 'array', 'required' => 1],
                    ['key' => 'field_fc_cert_i_title', 'label' => 'Nom (pour accessibilite)', 'name' => 'title', 'type' => 'text', 'placeholder' => 'ex: ISO 9001', 'instructions' => 'Utilise comme texte alternatif pour le logo'],
                ]],
                ['key' => 'field_fc_cert_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Partners
        [
            'key' => 'layout_partners',
            'name' => 'partenaires',
            'label' => 'Logos partenaires',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_partners_logos', 'label' => 'Logos partenaires', 'name' => 'partenaires', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter un partenaire', 'sub_fields' => [
                    ['key' => 'field_fc_partner_logo_light', 'label' => 'Logo (Clair)', 'name' => 'logo_light', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Logo pour mode clair (sera inverse automatiquement en mode sombre si pas de logo sombre)'],
                    ['key' => 'field_fc_partner_logo_dark', 'label' => 'Logo (Sombre)', 'name' => 'logo_dark', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Optionnel - Logo pour mode sombre'],
                    ['key' => 'field_fc_partner_alt', 'label' => 'Texte alternatif', 'name' => 'alt_text', 'type' => 'text', 'default_value' => 'Logo partenaire'],
                ]],
                ['key' => 'field_fc_partners_badge_text', 'label' => 'Texte du badge', 'name' => 'badge_text', 'type' => 'text', 'default_value' => 'Plus de 2500 entreprises font confiance a nos services.'],
                ['key' => 'field_fc_partners_badge_link_text', 'label' => 'Texte du lien', 'name' => 'badge_link_text', 'type' => 'text', 'default_value' => 'Lire les temoignages'],
                ['key' => 'field_fc_partners_badge_link', 'label' => 'Lien', 'name' => 'badge_link', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_partners_show_badge', 'label' => 'Afficher le badge', 'name' => 'show_badge', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
            ],
        ],
        // Details Page
        [
            'key' => 'layout_details_page',
            'name' => 'page-details',
            'label' => 'Page details (Plein ecran)',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_dp_badge_text', 'label' => 'Texte du badge', 'name' => 'badge_text', 'type' => 'text', 'default_value' => ''],
                ['key' => 'field_fc_dp_badge_link', 'label' => 'Lien du badge', 'name' => 'badge_link', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_dp_heading', 'label' => 'Titre', 'name' => 'heading', 'type' => 'text', 'required' => 1, 'default_value' => 'Des donnees pour enrichir votre entreprise'],
                ['key' => 'field_fc_dp_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 4, 'default_value' => ''],
                ['key' => 'field_fc_dp_primary_button', 'label' => 'Bouton principal', 'name' => 'primary_button', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_dp_secondary_button', 'label' => 'Bouton secondaire', 'name' => 'secondary_button', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_dp_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'required' => 1, 'return_format' => 'array', 'preview_size' => 'large'],
                ['key' => 'field_fc_dp_show_svg', 'label' => 'Afficher SVG decoratif', 'name' => 'show_decorative_svg', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
            ],
        ],
        // Blog Grid
        [
            'key' => 'layout_blog_grid',
            'name' => 'grille-blog',
            'label' => 'Grille blog',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_blog_section_title', 'label' => 'Titre de la section', 'name' => 'section_title', 'type' => 'text', 'default_value' => 'Du blog'],
                ['key' => 'field_fc_blog_section_desc', 'label' => 'Description', 'name' => 'section_description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Decouvrez comment developper votre entreprise grace a nos conseils d\'experts.'],
                ['key' => 'field_fc_blog_posts_per_page', 'label' => 'Nombre d\'articles', 'name' => 'posts_per_page', 'type' => 'number', 'default_value' => 6, 'min' => 1, 'max' => 24],
                ['key' => 'field_fc_blog_columns', 'label' => 'Colonnes', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '3'],
                ['key' => 'field_fc_blog_show_filters', 'label' => 'Afficher filtre categories', 'name' => 'show_filters', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_blog_show_search', 'label' => 'Afficher champ recherche', 'name' => 'show_search', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_blog_pagination_type', 'label' => 'Type de pagination', 'name' => 'pagination_type', 'type' => 'select', 'choices' => ['pagination' => 'Pagination classique', 'load_more' => 'Bouton charger plus', 'infinite' => 'Scroll infini', 'none' => 'Aucune'], 'default_value' => 'pagination'],
            ],
        ],
        // CTA Split
        [
            'key' => 'layout_cta_split',
            'name' => 'cta-divise',
            'label' => 'CTA divise',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_cta_split_layout', 'label' => 'Type de mise en page', 'name' => 'layout_type', 'type' => 'select', 'choices' => ['split' => 'Divise (Image + Texte)', 'centered' => 'Centre (texte seul)', 'background' => 'Fond (image en arriere-plan)'], 'default_value' => 'split', 'ui' => 1],
                ['key' => 'field_fc_cta_split_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Requis pour les layouts Divise et Fond'],
                ['key' => 'field_fc_cta_split_image_pos', 'label' => 'Position de l\'image', 'name' => 'image_position', 'type' => 'select', 'choices' => ['left' => 'Gauche', 'right' => 'Droite'], 'default_value' => 'right', 'conditional_logic' => [[['field' => 'field_fc_cta_split_layout', 'operator' => '==', 'value' => 'split']]]],
                ['key' => 'field_fc_cta_split_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Support exceptionnel'],
                ['key' => 'field_fc_cta_split_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Nous sommes la pour vous'],
                ['key' => 'field_fc_cta_split_desc', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 3, 'default_value' => 'Notre equipe est a votre disposition a tout moment. Contactez-nous pour un conseil professionnel et un service de premiere qualite.'],
                ['key' => 'field_fc_cta_split_button', 'label' => 'Bouton principal', 'name' => 'button', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_cta_split_button_sec', 'label' => 'Bouton secondaire', 'name' => 'button_secondary', 'type' => 'link', 'return_format' => 'array'],
            ],
        ],
        // Banniere Publicitaire
        [
            'key' => 'layout_banniere_pub',
            'name' => 'banniere-pub',
            'label' => 'Banniere publicitaire',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_bp_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Expert en gestion de patrimoine internationale'],
                ['key' => 'field_fc_bp_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'textarea', 'rows' => 3, 'required' => 1, 'default_value' => 'VOUS AVEZ UN PROJET IMMOBILIER A L\'ETRANGER ?'],
                ['key' => 'field_fc_bp_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Image de promotion (villa, projet, etc.)'],
                ['key' => 'field_fc_bp_button', 'label' => 'Bouton', 'name' => 'button', 'type' => 'link', 'return_format' => 'array'],
                ['key' => 'field_fc_bp_layout', 'label' => 'Mise en page', 'name' => 'layout', 'type' => 'select', 'choices' => ['vertical' => 'Vertical (comme maquette)', 'horizontal' => 'Horizontal (grand ecran)'], 'default_value' => 'vertical'],
                ['key' => 'field_fc_bp_bg_color', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['primary' => 'Orange (primaire)', 'secondary' => 'Bleu (secondaire)', 'dark' => 'Sombre'], 'default_value' => 'secondary'],
            ],
        ],
        // Grille Proprietes - Marche guineen
        [
            'key' => 'layout_grille_proprietes',
            'name' => 'grille-proprietes',
            'label' => 'Grille de proprietes',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_gp_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Nos biens'],
                ['key' => 'field_fc_gp_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Proprietes disponibles a Conakry'],
                ['key' => 'field_fc_gp_mode', 'label' => 'Mode d\'affichage', 'name' => 'display_mode', 'type' => 'select', 'choices' => ['auto' => 'Automatique (avec filtres)', 'selection' => 'Selection manuelle'], 'default_value' => 'auto', 'instructions' => 'Automatique: affiche les proprietes avec filtres. Selection: choisissez les proprietes a afficher.'],
                // Auto mode fields
                ['key' => 'field_fc_gp_posts_per_page', 'label' => 'Nombre de biens', 'name' => 'posts_per_page', 'type' => 'number', 'default_value' => 6, 'min' => 3, 'max' => 24, 'conditional_logic' => [[['field' => 'field_fc_gp_mode', 'operator' => '==', 'value' => 'auto']]]],
                ['key' => 'field_fc_gp_show_filters', 'label' => 'Afficher les filtres', 'name' => 'show_filters', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Filtres par type, commune, prix', 'conditional_logic' => [[['field' => 'field_fc_gp_mode', 'operator' => '==', 'value' => 'auto']]]],
                // Selection mode fields
                ['key' => 'field_fc_gp_properties', 'label' => 'Proprietes a afficher', 'name' => 'properties', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter une propriete', 'conditional_logic' => [[['field' => 'field_fc_gp_mode', 'operator' => '==', 'value' => 'selection']]], 'sub_fields' => [
                    ['key' => 'field_fc_gp_p_property', 'label' => 'Selectionner une propriete', 'name' => 'property', 'type' => 'post_object', 'post_type' => ['property'], 'return_format' => 'id', 'ui' => 1, 'required' => 1, 'instructions' => 'Choisissez une propriete dans la liste'],
                ]],
                ['key' => 'field_fc_gp_columns', 'label' => 'Colonnes', 'name' => 'columns', 'type' => 'select', 'choices' => ['2' => '2 colonnes', '3' => '3 colonnes', '4' => '4 colonnes'], 'default_value' => '3'],
                ['key' => 'field_fc_gp_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'white'],
            ],
        ],
        // Propriete en Vedette
        [
            'key' => 'layout_propriete_vedette',
            'name' => 'propriete-vedette',
            'label' => 'Propriete en vedette',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_pv_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'A la une'],
                ['key' => 'field_fc_pv_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Propriete en vedette'],
                ['key' => 'field_fc_pv_property', 'label' => 'Propriete', 'name' => 'property', 'type' => 'post_object', 'post_type' => ['property'], 'return_format' => 'object', 'required' => 1, 'instructions' => 'Selectionnez le bien a mettre en avant'],
                ['key' => 'field_fc_pv_show_features', 'label' => 'Afficher les caracteristiques', 'name' => 'show_features', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_pv_show_gallery', 'label' => 'Afficher la galerie', 'name' => 'show_gallery', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1],
                ['key' => 'field_fc_pv_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair', 'secondary-dark' => 'Sombre'], 'default_value' => 'gray-50'],
            ],
        ],
        // Recherche Proprietes
        [
            'key' => 'layout_recherche_proprietes',
            'name' => 'recherche-proprietes',
            'label' => 'Recherche de proprietes',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_rp_subtitle', 'label' => 'Sous-titre', 'name' => 'subtitle', 'type' => 'text', 'default_value' => 'Recherche avancee'],
                ['key' => 'field_fc_rp_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'default_value' => 'Trouvez votre bien ideal a Conakry'],
                ['key' => 'field_fc_rp_description', 'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'default_value' => 'Utilisez nos filtres pour trouver le bien qui correspond parfaitement a vos criteres dans les 5 communes de Conakry.'],
                ['key' => 'field_fc_rp_bg_image', 'label' => 'Image de fond', 'name' => 'background_image', 'type' => 'image', 'return_format' => 'array', 'instructions' => 'Image d\'arriere-plan pour le layout Hero'],
                ['key' => 'field_fc_rp_overlay', 'label' => 'Opacite overlay', 'name' => 'overlay_opacity', 'type' => 'range', 'default_value' => 60, 'min' => 0, 'max' => 100],
                ['key' => 'field_fc_rp_layout', 'label' => 'Style d\'affichage', 'name' => 'layout', 'type' => 'select', 'choices' => ['hero' => 'Hero (plein ecran)', 'compact' => 'Compact (barre simple)'], 'default_value' => 'hero'],
                ['key' => 'field_fc_rp_show_advanced', 'label' => 'Filtres avances', 'name' => 'show_advanced_filters', 'type' => 'true_false', 'default_value' => 1, 'ui' => 1, 'instructions' => 'Surface, chambres, quartier, reference'],
            ],
        ],
        // Galerie avec Unites (Projet/Immeuble)
        [
            'key' => 'layout_galerie_unites',
            'name' => 'galerie-unites',
            'label' => 'Galerie avec unites',
            'display' => 'block',
            'sub_fields' => [
                ['key' => 'field_fc_gu_title', 'label' => 'Titre', 'name' => 'title', 'type' => 'text', 'required' => 1, 'default_value' => 'Notre residence'],
                ['key' => 'field_fc_gu_gallery', 'label' => 'Galerie photos', 'name' => 'gallery', 'type' => 'gallery', 'return_format' => 'id', 'preview_size' => 'medium', 'instructions' => 'Photos du projet/immeuble'],
                ['key' => 'field_fc_gu_units', 'label' => 'Unites / Lots', 'name' => 'units', 'type' => 'repeater', 'layout' => 'block', 'button_label' => 'Ajouter une unite', 'sub_fields' => [
                    ['key' => 'field_fc_gu_u_name', 'label' => 'Nom de l\'unite', 'name' => 'unit_name', 'type' => 'text', 'required' => 1, 'default_value' => 'Unite 1', 'wrapper' => ['width' => '40']],
                    ['key' => 'field_fc_gu_u_status', 'label' => 'Statut', 'name' => 'unit_status', 'type' => 'select', 'choices' => ['disponible' => 'Disponible', 'reserve' => 'Reserve', 'vendu' => 'Vendu', 'loue' => 'Loue'], 'default_value' => 'disponible', 'wrapper' => ['width' => '20']],
                    ['key' => 'field_fc_gu_u_price', 'label' => 'Prix', 'name' => 'unit_price', 'type' => 'number', 'append' => 'GNF', 'wrapper' => ['width' => '20']],
                    ['key' => 'field_fc_gu_u_surface', 'label' => 'Surface', 'name' => 'unit_surface', 'type' => 'number', 'append' => 'm²', 'wrapper' => ['width' => '20']],
                    ['key' => 'field_fc_gu_u_bedrooms', 'label' => 'Chambres', 'name' => 'unit_bedrooms', 'type' => 'number', 'wrapper' => ['width' => '50']],
                    ['key' => 'field_fc_gu_u_bathrooms', 'label' => 'Salles de bain', 'name' => 'unit_bathrooms', 'type' => 'number', 'wrapper' => ['width' => '50']],
                    ['key' => 'field_fc_gu_u_features', 'label' => 'Caracteristiques', 'name' => 'unit_features', 'type' => 'repeater', 'layout' => 'table', 'button_label' => 'Ajouter', 'sub_fields' => [
                        ['key' => 'field_fc_gu_uf_icon', 'label' => 'Icone', 'name' => 'icon', 'type' => 'select', 'choices' => ['check' => 'Check', 'bed' => 'Chambre', 'bath' => 'Salle de bain', 'kitchen' => 'Cuisine', 'living' => 'Salon', 'balcony' => 'Balcon', 'parking' => 'Parking', 'garden' => 'Jardin'], 'default_value' => 'check', 'wrapper' => ['width' => '30']],
                        ['key' => 'field_fc_gu_uf_text', 'label' => 'Description', 'name' => 'text', 'type' => 'text', 'wrapper' => ['width' => '70']],
                    ]],
                ]],
                ['key' => 'field_fc_gu_bg', 'label' => 'Couleur de fond', 'name' => 'bg_color', 'type' => 'select', 'choices' => ['white' => 'Blanc', 'gray-50' => 'Gris clair'], 'default_value' => 'white'],
            ],
        ],
    ];

    acf_add_local_field_group([
        'key' => 'group_flexible_content',
        'title' => 'Contenu de la page',
        'fields' => [
            // Tab Contenu
            [
                'key' => 'field_fc_tab_content',
                'label' => 'Contenu',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ],
            [
                'key' => 'field_flexible_content',
                'label' => 'Blocs de contenu',
                'name' => 'flexible_content',
                'type' => 'flexible_content',
                'layouts' => $layouts,
                'button_label' => 'Ajouter un bloc',
                'instructions' => 'Ajoutez et organisez les blocs pour construire votre page.',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'projekte',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'leistungen',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'property',
                ],
            ],
            [
                [
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'emplois',
                ],
            ],
        ],
        'style' => 'seamless',
    ]);
});
