-- SQL pour créer les pages de formulaires de devis
-- À exécuter dans phpMyAdmin ou via WP-CLI

-- Note: Ajustez le post_author (ID de l'utilisateur admin) si nécessaire
-- Par défaut utilisé: 1

-- ========================================
-- PAGE 1: Balkonsanierung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Balkonsanierung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'balkonsanierung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @balkonsanierung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@balkonsanierung_id, '_wp_page_template', 'page-angebot-balkonsanierung.php'),
(@balkonsanierung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 2: Bauwerksabdichtung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Bauwerksabdichtung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'bauwerksabdichtung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @bauwerksabdichtung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@bauwerksabdichtung_id, '_wp_page_template', 'page-angebot-bauwerksabdichtung.php'),
(@bauwerksabdichtung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 3: Beschichtung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Beschichtung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'beschichtung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @beschichtung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@beschichtung_id, '_wp_page_template', 'page-angebot-beschichtung.php'),
(@beschichtung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 4: Betonsanierung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Betonsanierung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'betonsanierung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @betonsanierung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@betonsanierung_id, '_wp_page_template', 'page-angebot-betonsanierung.php'),
(@betonsanierung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 5: Sachverständigung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Sachverständigung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'sachverstaendigung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @sachverstaendigung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@sachverstaendigung_id, '_wp_page_template', 'page-angebot-sachverstaendigung.php'),
(@sachverstaendigung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 6: Schimmelpilzsanierung
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Schimmelpilzsanierung Angebot',
    '',
    'publish',
    'closed',
    'closed',
    'schimmelpilzsanierung-angebot',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @schimmelpilzsanierung_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@schimmelpilzsanierung_id, '_wp_page_template', 'page-angebot-schimmelpilzsanierung.php'),
(@schimmelpilzsanierung_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- PAGE 7: Danke (Page de remerciement)
-- ========================================
INSERT INTO wp_posts (
    post_author,
    post_date,
    post_date_gmt,
    post_content,
    post_title,
    post_excerpt,
    post_status,
    comment_status,
    ping_status,
    post_name,
    post_modified,
    post_modified_gmt,
    post_type
) VALUES (
    1,
    NOW(),
    UTC_TIMESTAMP(),
    '',
    'Vielen Dank',
    '',
    'publish',
    'closed',
    'closed',
    'danke',
    NOW(),
    UTC_TIMESTAMP(),
    'page'
);

SET @danke_id = LAST_INSERT_ID();

INSERT INTO wp_postmeta (post_id, meta_key, meta_value) VALUES
(@danke_id, '_wp_page_template', 'page-danke.php'),
(@danke_id, '_edit_lock', CONCAT(UNIX_TIMESTAMP(), ':1'));

-- ========================================
-- Afficher les résultats
-- ========================================
SELECT 'Pages créées avec succès!' as message;
SELECT
    post_id,
    post_title,
    post_name as slug,
    CONCAT('/', post_name, '/') as url
FROM wp_posts
WHERE post_id IN (
    @balkonsanierung_id,
    @bauwerksabdichtung_id,
    @beschichtung_id,
    @betonsanierung_id,
    @sachverstaendigung_id,
    @schimmelpilzsanierung_id,
    @danke_id
)
ORDER BY post_id;
