<?php
/**
 * WordPress Configuration for Production (lamine.masingatech.com)
 *
 * INSTRUCTIONS:
 * 1. Create database in Hostinger hPanel > Databases > MySQL
 * 2. Fill in DB_NAME, DB_USER, DB_PASSWORD below
 * 3. Upload this file to server and rename to wp-config.php
 */

// ** Database settings ** //
define( 'DB_NAME', 'u167262118_socorif' );    // TODO: Replace with actual database name
define( 'DB_USER', 'u167262118_socorif' );    // TODO: Replace with actual database user
define( 'DB_PASSWORD', 'YOUR_DB_PASSWORD' );   // TODO: Replace with actual password
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

// ** Security Keys ** //
define('AUTH_KEY',         ')ys#|ub<N/|Vp{ycp ,ctKl;/muFGnME0/|G/ay,|WvD4Msxy-LfF_Wgq_sV[o&+');
define('SECURE_AUTH_KEY',  'GNQ#~SQ`rjahwln#,Al!rFPh`8H|lJA+Wssjb/GTOnmXy2DV+uaa^]Lat+RG!&3c');
define('LOGGED_IN_KEY',    'MBo<P+qM,ui.7v0NK@|Zq/pm#8ij$-+M.9v9frx7fkt5]iJv[G9p^&ps!nmgOk?:');
define('NONCE_KEY',        ' +{.|&e9.*pGEU)0(+v}wEasQTVkMw{t-r=J_%d>fW+vsh2NTsoh|]5S7$%<}BHX');
define('AUTH_SALT',        '=wm54+=`(36B2uXYAm`2l,CE2=OHg|OV1n()@yX/k+@a4|vw1n[HpVJR9]`d~3rl');
define('SECURE_AUTH_SALT', 'A@3^Lk;y#cwC>iDo(F35R,y8!3H(X=K-J19N@+[JMwxb#!6bT<=sg#(U&5+VN7>h');
define('LOGGED_IN_SALT',   'DA(8L(C[O Ds2-SX C5B8)^4ahw+Nsfqe=#N;*#5fItH?TcK{m|w|iH%alBf8uc+');
define('NONCE_SALT',       'CW`3g,{-]!!Nu.sg<dQB:JH*DIB&k-K:UFJ^ W.Ue5a~%%7~&>7!&7S+~92&D[.I');

// ** Table prefix ** //
$table_prefix = 'scrf_';

// ** Production settings ** //
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'DISALLOW_FILE_EDIT', true );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );

// ** Site URLs (uncomment after first install) ** //
// define( 'WP_HOME', 'https://lamine.masingatech.com' );
// define( 'WP_SITEURL', 'https://lamine.masingatech.com' );

// ** Memory limits ** //
define( 'WP_MEMORY_LIMIT', '256M' );
define( 'WP_MAX_MEMORY_LIMIT', '512M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
