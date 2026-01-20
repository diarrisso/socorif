-- Script SQL FINAL pour remplir tous les blocks ACF
-- Chaque block doit avoir: flexible_content_X_acf_fc_layout

DELETE FROM wp_postmeta WHERE post_id = 2 AND meta_key LIKE 'flexible_content%';

-- Total de 14 blocks (indices 0 a 13)
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '14');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- Block 0: Hero
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_acf_fc_layout', 'hero');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_background_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_overlay_opacity', '50');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_subtitle', 'Willkommen bei BEKA');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_title', 'Professionelle Losungen fur Ihr Zuhause');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_description', 'Wir bieten erstklassige Dienstleistungen in den Bereichen Renovierung, Modernisierung und Instandhaltung.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_cta_button', 'a:3:{s:5:"title";s:14:"Jetzt anfragen";s:3:"url";s:9:"#contact";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_height', 'large');

-- Block 1: About
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_acf_fc_layout', 'about');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_title', 'Uber BEKA - Ihr zuverlassiger Partner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_description', 'Seit uber 25 Jahren sind wir Ihr kompetenter Partner fur alle Bereiche rund um Renovierung und Modernisierung.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_0_text', 'Hochqualifizierte Fachkrafte');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_1_text', 'Termingerechte Ausfuhrung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_2_text', 'Faire Preise und Transparenz');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_since_text', 'Seit 1998');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_experience_number', '25');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_experience_label', 'Jahre Erfahrung');

-- Block 2: Services Cards
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_acf_fc_layout', 'services-cards');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_subtitle', 'Unsere Leistungen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_title', 'Was wir fur Sie tun konnen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_description', 'Entdecken Sie unser umfangreiches Leistungsspektrum');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_title', 'Renovierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_description', 'Professionelle Renovierungsarbeiten fur Wohn- und Geschaftsraume');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_title', 'Modernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_description', 'Modernisierung von Bad, Kuche und allen Wohnbereichen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_title', 'Instandhaltung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_description', 'Regelmaßige Wartung und Instandhaltung Ihrer Immobilie');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_columns', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_bg_color', 'white');

-- Block 3: Services Icons
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_acf_fc_layout', 'services-icons');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_title', 'Warum BEKA wahlen?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_icon', 'shield-check');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_title', 'Qualitatsgarantie');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_description', 'Hochste Qualitatsstandards');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_icon', 'clock');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_title', 'Punktlichkeit');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_description', 'Termingerechte Projektabwicklung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_icon', 'users');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_title', 'Erfahrenes Team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_description', 'Uber 25 Jahre Erfahrung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_icon', 'euro');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_title', 'Faire Preise');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_description', 'Transparente Kalkulation');

-- Block 4: Projects Grid
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_acf_fc_layout', 'projects-grid');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_subtitle', 'Unsere Projekte');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_title', 'Referenzen die uberzeugen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_title', 'Badsanierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_category', 'Badezimmer');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_title', 'Kuchenmodernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_category', 'Kuche');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_title', 'Wohnzimmer Renovierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_category', 'Wohnbereich');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_title', 'Fassadensanierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_category', 'Außenbereich');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_bg_color', 'gray-50');

-- Block 5: Before/After
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_acf_fc_layout', 'before-after');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_subtitle', 'Vorher/Nachher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_title', 'Sehen Sie den Unterschied');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_before_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_after_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_before_label', 'Vorher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_after_label', 'Nachher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_description', 'Eine komplette Transformation in nur 4 Wochen');

-- Block 6: Team
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_acf_fc_layout', 'team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_title', 'Unser Team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_name', 'Thomas Schmidt');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_role', 'Geschaftsfuhrer');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_name', 'Michael Weber');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_role', 'Projektleiter');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_name', 'Stefan Becker');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_role', 'Meister');

-- Block 7: Testimonials
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_acf_fc_layout', 'testimonials');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_title', 'Was unsere Kunden sagen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_content', 'Hervorragende Arbeit! Wir sind sehr zufrieden.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_author', 'Familie Muller');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_role', 'Bauherr');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_content', 'Termingerecht und im Budget. Absolut empfehlenswert!');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_author', 'Anna Schmidt');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_role', 'Hausbesitzerin');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_content', 'Kompetente Beratung und saubere Ausfuhrung.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_author', 'Peter Wagner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_role', 'Geschaftskunde');

-- Block 8: Clients
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_8_acf_fc_layout', 'clients');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_8_title', 'Unsere Partner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_8_logos', 'a:6:{i:0;s:1:"1";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";}');

-- Block 9: Gallery
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_9_acf_fc_layout', 'gallery');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_9_title', 'Unsere Arbeiten im Bild');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_9_images', 'a:6:{i:0;s:1:"1";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";}');

-- Block 10: Accordion
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_acf_fc_layout', 'accordion');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_title', 'Haufig gestellte Fragen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_0_title', 'Wie lange dauert eine Renovierung?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_0_content', 'Eine Badsanierung dauert etwa 2-3 Wochen.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_1_title', 'Erstellen Sie kostenlose Kostenvoranschlage?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_1_content', 'Ja, wir erstellen kostenlose Kostenvoranschlage.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_2_title', 'Garantie auf Arbeiten?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_2_content', 'Wir bieten 5-jahrige Garantie.');

-- Block 11: News
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_acf_fc_layout', 'news');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_subtitle', 'Aktuelles');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_title', 'Neuigkeiten von BEKA');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_title', 'Neue Technologien');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_category', 'Innovation');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_excerpt', 'Neueste Trends und Technologien');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_title', 'Energieeffizient');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_category', 'Nachhaltigkeit');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_excerpt', 'Energie sparen durch Modernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_title', 'Team erweitert');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_category', 'Unternehmen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_excerpt', 'Neue Kollegen in unserem Team');

-- Block 12: Section CTA
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_acf_fc_layout', 'section-cta');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_image_position', 'left');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_subtitle', 'Bereit zu starten?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_title', 'Lassen Sie uns Ihr Projekt besprechen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_content', '<p>Kontaktieren Sie uns fur ein unverbindliches Beratungsgesprach.</p>');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_button', 'a:3:{s:5:"title";s:17:"Kontakt aufnehmen";s:3:"url";s:8:"#contact";s:6:"target";s:0:"";}');

-- Block 13: YouTube Video
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_acf_fc_layout', 'youtube-video');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_youtube_url', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_video_title', 'BEKA - Ihr Partner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_video_description', 'Erfahren Sie mehr uber unsere Arbeitsweise');
