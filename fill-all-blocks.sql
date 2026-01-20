-- Script SQL pour remplir tous les blocks ACF sur la page d'accueil (ID: 2)
-- Ce script ajoute tous les blocks disponibles avec des donnees de test

-- Nettoyer les anciennes donnees flexible_content
DELETE FROM wp_postmeta WHERE post_id = 2 AND meta_key LIKE 'flexible_content%';

-- Definir le nombre de blocks
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '13');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 0: Hero
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_background_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_background_image', 'field_fc_hero_bg');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_overlay_opacity', '50');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_overlay_opacity', 'field_fc_hero_overlay');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_subtitle', 'Willkommen bei BEKA');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_subtitle', 'field_fc_hero_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_title', 'Professionelle Losungen fur Ihr Zuhause');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_title', 'field_fc_hero_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_description', 'Wir bieten erstklassige Dienstleistungen in den Bereichen Renovierung, Modernisierung und Instandhaltung. Ihr Projekt ist bei uns in besten Handen.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_description', 'field_fc_hero_desc');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_cta_button', 'a:3:{s:5:"title";s:17:"Jetzt anfragen";s:3:"url";s:9:"#contact";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_cta_button', 'field_fc_hero_cta');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_height', 'large');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_0_height', 'field_fc_hero_height');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_0_text_align', 'center');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '0');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 1: About
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_image', 'field_fc_about_image');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_experience_number', '25');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_experience_number', 'field_fc_about_exp_number');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_experience_label', 'Jahre Erfahrung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_experience_label', 'field_fc_about_exp_text');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_since_text', 'Seit 1998');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_since_text', 'field_fc_about_exp_text');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_title', 'Uber BEKA - Ihr zuverlassiger Partner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_title', 'field_fc_about_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_description', 'Seit uber 25 Jahren sind wir Ihr kompetenter Partner fur alle Bereiche rund um Renovierung und Modernisierung. Unser erfahrenes Team steht fur Qualitat und Zuverlassigkeit.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_description', 'field_fc_about_content');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_1_features', 'field_fc_about_features');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_0_text', 'Hochqualifizierte Fachkrafte');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_1_text', 'Termingerechte Ausfuhrung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_1_features_2_text', 'Faire Preise und Transparenz');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 2: Services Cards
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_subtitle', 'Unsere Leistungen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_subtitle', 'field_fc_sc_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_title', 'Was wir fur Sie tun konnen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_title', 'field_fc_sc_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_description', 'Entdecken Sie unser umfangreiches Leistungsspektrum - von der Planung bis zur Umsetzung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_description', 'field_fc_sc_desc');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_cards', 'field_fc_sc_services');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_title', 'Renovierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_description', 'Professionelle Renovierungsarbeiten fur Wohn- und Geschaftsraume');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_0_link', 'a:3:{s:5:"title";s:13:"Mehr erfahren";s:3:"url";s:10:"#services";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_title', 'Modernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_description', 'Modernisierung von Bad, Kuche und allen Wohnbereichen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_1_link', 'a:3:{s:5:"title";s:13:"Mehr erfahren";s:3:"url";s:10:"#services";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_title', 'Instandhaltung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_description', 'Regelmaßige Wartung und Instandhaltung Ihrer Immobilie');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_cards_2_link', 'a:3:{s:5:"title";s:13:"Mehr erfahren";s:3:"url";s:10:"#services";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_columns', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_columns', 'field_fc_sc_columns');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_2_bg_color', 'white');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_2_bg_color', 'field_fc_sc_bg');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '2');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 3: Services Icons
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_title', 'Warum BEKA wahlen?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_3_title', 'field_fc_si_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_3_services', 'field_fc_si_services');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_icon', 'shield-check');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_title', 'Qualitatsgarantie');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_0_description', 'Hochste Qualitatsstandards bei allen Arbeiten');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_icon', 'clock');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_title', 'Punktlichkeit');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_1_description', 'Termingerechte Projektabwicklung garantiert');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_icon', 'users');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_title', 'Erfahrenes Team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_2_description', 'Uber 25 Jahre Erfahrung im Handwerk');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_icon', 'euro');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_title', 'Faire Preise');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_3_services_3_description', 'Transparente Kalkulation ohne versteckte Kosten');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 4: Projects Grid
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_subtitle', 'Unsere Projekte');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_4_subtitle', 'field_fc_pg_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_title', 'Referenzen die uberzeugen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_4_title', 'field_fc_pg_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects', '6');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_4_projects', 'field_fc_pg_projects');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_title', 'Badsanierung Familie Muller');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_category', 'Badezimmer');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_0_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_title', 'Kuchenmodernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_category', 'Kuche');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_1_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_title', 'Wohnzimmer Renovierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_category', 'Wohnbereich');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_2_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_title', 'Fassadensanierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_category', 'Außenbereich');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_3_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_4_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_4_title', 'Dachgeschoss Ausbau');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_4_category', 'Ausbau');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_4_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_5_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_5_title', 'Terrassen Gestaltung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_5_category', 'Außenbereich');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_projects_5_link', 'a:3:{s:5:"title";s:17:"Projekt ansehen";s:3:"url";s:10:"#projects";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_4_bg_color', 'gray-50');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_4_bg_color', 'field_fc_pg_bg');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 5: Before/After
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_subtitle', 'Vorher/Nachher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_subtitle', 'field_fc_ba_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_title', 'Sehen Sie den Unterschied');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_title', 'field_fc_ba_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_before_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_before_image', 'field_fc_ba_before');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_after_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_after_image', 'field_fc_ba_after');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_before_label', 'Vorher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_before_label', 'field_fc_ba_before_label');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_after_label', 'Nachher');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_after_label', 'field_fc_ba_after_label');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_5_description', 'Eine komplette Transformation - von alt zu modern in nur 4 Wochen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_5_description', 'field_fc_ba_desc');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '5');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 6: Team
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_title', 'Unser Team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_6_title', 'field_fc_team_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_6_members', 'field_fc_team_members');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_name', 'Thomas Schmidt');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_0_role', 'Geschaftsfuhrer');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_name', 'Michael Weber');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_1_role', 'Projektleiter');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_name', 'Stefan Becker');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_2_role', 'Meister');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_3_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_3_name', 'Andreas Hoffman');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_6_members_3_role', 'Fachkraft');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '6');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 7: Testimonials
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_title', 'Was unsere Kunden sagen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_7_title', 'field_fc_testi_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_7_testimonials', 'field_fc_testi_items');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_content', 'Hervorragende Arbeit! Das Team war punktlich, professionell und hat unsere Erwartungen ubertroffen. Wir sind sehr zufrieden mit dem Ergebnis.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_author', 'Familie Muller');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_role', 'Bauherr');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_0_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_content', 'Die Badsanierung wurde termingerecht und im Budget abgeschlossen. Absolut empfehlenswert!');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_author', 'Anna Schmidt');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_role', 'Hausbesitzerin');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_1_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_content', 'Kompetente Beratung und saubere Ausfuhrung. Wir wurden jederzeit wieder mit BEKA zusammenarbeiten.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_author', 'Peter Wagner');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_role', 'Geschaftskunde');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_7_testimonials_2_photo', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '7');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 8: Clients
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_8_title', 'Unsere Partner und Kunden');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_8_title', 'field_fc_clients_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_8_logos', 'a:6:{i:0;s:1:"1";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_8_logos', 'field_fc_clients_logos');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '8');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 9: Gallery
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_9_title', 'Unsere Arbeiten im Bild');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_9_title', 'field_fc_gallery_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_9_images', 'a:8:{i:0;s:1:"1";i:1;s:1:"1";i:2;s:1:"1";i:3;s:1:"1";i:4;s:1:"1";i:5;s:1:"1";i:6;s:1:"1";i:7;s:1:"1";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_9_images', 'field_fc_gallery_images');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '9');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 10: Accordion
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_title', 'Haufig gestellte Fragen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_10_accordion_title', 'field_fc_acc_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items', '4');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_10_accordion_items', 'field_fc_acc_items');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_0_title', 'Wie lange dauert eine typische Renovierung?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_0_content', 'Die Dauer hangt vom Umfang des Projekts ab. Eine Badsanierung dauert etwa 2-3 Wochen, eine Kuchenrenovierung 3-4 Wochen.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_1_title', 'Erstellen Sie kostenlose Kostenvoranschlage?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_1_content', 'Ja, wir erstellen kostenlose und unverbindliche Kostenvoranschlage fur alle Projekte.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_2_title', 'Bieten Sie eine Garantie auf Ihre Arbeiten?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_2_content', 'Selbstverstandlich! Wir bieten eine 5-jahrige Garantie auf alle unsere Arbeiten.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_3_title', 'Arbeiten Sie auch am Wochenende?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_10_accordion_items_3_content', 'Nach Absprache konnen wir auch Wochenendarbeiten durchfuhren, um Ihre Bedurfnisse optimal zu erfullen.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '10');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 11: News
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_subtitle', 'Aktuelles');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_11_subtitle', 'field_fc_news_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_title', 'Neuigkeiten von BEKA');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_11_title', 'field_fc_news_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles', '3');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_11_articles', 'field_fc_news_articles');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_title', 'Neue Technologien in der Badsanierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_category', 'Innovation');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_excerpt', 'Entdecken Sie die neuesten Trends und Technologien fur moderne Badezimmer.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_0_link', 'a:3:{s:5:"title";s:14:"Weiterlesen";s:3:"url";s:6:"#news";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_title', 'Energieeffiziente Modernisierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_category', 'Nachhaltigkeit');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_excerpt', 'So sparen Sie Energie und Kosten durch intelligente Modernisierung.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_1_link', 'a:3:{s:5:"title";s:14:"Weiterlesen";s:3:"url";s:6:"#news";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_title', 'BEKA erweitert sein Team');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_category', 'Unternehmen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_excerpt', 'Wir freuen uns uber neue Kollegen in unserem wachsenden Team.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_11_articles_2_link', 'a:3:{s:5:"title";s:14:"Weiterlesen";s:3:"url";s:6:"#news";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '11');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 12: Section CTA
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_image', '1');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_image', 'field_fc_cta_image');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_image_position', 'left');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_image_position', 'field_fc_cta_position');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_subtitle', 'Bereit zu starten?');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_subtitle', 'field_fc_cta_subtitle');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_title', 'Lassen Sie uns Ihr Projekt besprechen');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_title', 'field_fc_cta_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_content', '<p>Kontaktieren Sie uns noch heute fur ein unverbindliches Beratungsgesprach. Wir freuen uns darauf, Ihre Vorstellungen in die Realitat umzusetzen.</p>');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_content', 'field_fc_cta_content');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_12_button', 'a:3:{s:5:"title";s:17:"Kontakt aufnehmen";s:3:"url";s:8:"#contact";s:6:"target";s:0:"";}');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_12_button', 'field_fc_cta_button');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '12');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- ===========================
-- BLOCK 13: YouTube Video
-- ===========================
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_youtube_url', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_13_youtube_url', 'field_fc_yt_url');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_video_title', 'BEKA - Ihr Partner fur Renovierung');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_13_video_title', 'field_fc_yt_title');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content_13_video_description', 'Erfahren Sie mehr uber unsere Arbeitsweise und sehen Sie unsere Projekte im Video.');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content_13_video_description', 'field_fc_yt_desc');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, 'flexible_content', '13');
INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES (2, '_flexible_content', 'field_flexible_content');

-- Mettre a jour le compteur total de blocks
UPDATE wp_postmeta SET meta_value = '14' WHERE post_id = 2 AND meta_key = 'flexible_content';
