<?php
/*****************************************************************************
	SUPERCHARGED WP-CONFIG.PHP

	@Description:
		All useful wordpress globals in a wp-config.php, ready for a new project.


	@Usage:
		Adapt the settings to your need: there is a switch allowing you to use different configurations (e.g: "local", "staging", "production"). Set your variables and just remove what you don't need.

	@Learn:
		Basic: 		http://codex.wordpress.org/Editing_wp-config.php
		Advanced:	http://premium.wpmudev.org/blog/wordpress-wp-config-file-guide/

	@Discuss: 	https://github.com/pixeline/wp-config-supercharged/issues

	@Authors:
		Alexandre Plennevaux _ alexandre@pixeline.be _ https://pixeline.be
		Julien Bosuma _ contact@lianzadesign.com _ http://www.lianzadesign.com
			(Adding custom wp-content (app/) folder location)

*****************************************************************************/

/*  ------------------------ GLOBAL SWITCH & CONDITIONAL FLAGS --------------------- */

// The Main Switch: 'local' or 'live'
define('CURRENT_SERVER','local');

// Debian/Raspbian Dev Server Switch:
define('LINUX_DEV_SERVER', false);

// WP Siteurl and Home Url Overrides Switch:
	/**
	 * About WP_SITEURL and WP_HOME
	 *
	 * @see   https://codex.wordpress.org/Editing_wp-config.php#WP_SITEURL
	 * @see   https://codex.wordpress.org/Changing_The_Site_URL#Relocate_method
	 *
	 * Adding this in can reduce the number of database calls when loading your site.
	 * NOTE: I This will 'not' change the database stored value. The url will revert to the old database value if
	 * this line is ever removed from wp-config. You can use use the RELOCATE constant to change the siteurl value
	 * in the database.
	 */
define('HARDCODE_SITEURL', false);


/*  ------------------------ SERVER CONFIGURATIONS --------------------- */

switch(CURRENT_SERVER){

case 'local':

	/***************************************
	DEVELOPMENT SERVER. OPTIMIZED FOR DEBUGGING
	****************************************/

	define('WP_CACHE', false);
	define('WP_DEBUG', true);
	define('SAVEQUERIES', false);
	define('WP_DEBUG_LOG', false);
	define('WP_DEBUG_DISPLAY', true);
	/*
		The SAVEQUERIES definition saves the database queries to an array to help analyze those queries.
		See http://codex.wordpress.org/Editing_wp-config.php on how to use it.
	*/
	define( 'SCRIPT_DEBUG', true );
	define( 'CONCATENATE_SCRIPTS', false );

	// DATABASE
	define('DB_NAME', 'database_name_here');
	define('DB_USER', 'username_here');
	define('DB_PASSWORD', 'password_here');
	define('DB_HOST', 'localhost');

	// Development Server Document Root's Subfolder:
	// The subfolder under '/Applications/MAMP/htdocs/' (OSX) or under '/var/www/html/' (Raspbian).
	define('DEV_SERVER_SUBFOLDER', '/subfolder_name_here'); // Use empty string if no subfolder is used.

	// DOMAIN & URL
	define('PROTOCOL', 'http://');
	define('DOMAIN_NAME', $_SERVER['HTTP_HOST']);
	define('PATH_TO_WP', '/wp'); // if WordPress Core is in a subdirectory.

	if (LINUX_DEV_SERVER || HARDCODE_SITEURL) {
		define('WP_SITEURL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . PATH_TO_WP); 	// path to WP Core files folder
		define('WP_HOME', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER); 					// root of your WordPress site
	}

	break;

case 'live':
default:
	/***************************************
	PRODUCTION SERVER. OPTIMIZED FOR SPEED.
	****************************************/
	define('WP_CACHE', true);
	define('WP_DEBUG', false);
	define('SAVEQUERIES', false);
	define( 'SCRIPT_DEBUG', false);
	define( 'CONCATENATE_SCRIPTS', true );
	// log errors in a file (wp-content/debug.log), don't show them to end-users.
	define('WP_DEBUG_LOG', true);
	define('WP_DEBUG_DISPLAY', false);
	define('ENFORCE_GZIP', true);
	// DATABASE
	define('DB_NAME', 'database_name_here');
	define('DB_USER', 'username_here');
	define('DB_PASSWORD', 'password_here');
	define('DB_HOST', 'localhost');

	// Development Server Document Root's Subfolder:
	define('DEV_SERVER_SUBFOLDER', '');		// Usually empty on a production site, unless its root is in a subdirectory.

	// DOMAIN & URL
	define('PROTOCOL', 'http://');
	define('DOMAIN_NAME', $_SERVER['HTTP_HOST']);
	define('PATH_TO_WP', '/wp'); // If WordPress Core is in a subdirectory. Empty string otherwise.

	if ( HARDCODE_SITEURL ) {
		define('WP_SITEURL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . PATH_TO_WP); 	// path to WP Core files folder
		define('WP_HOME', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER); 					// root of your whole WordPress site
	}

	// Using subdomains to serve static content (CDN) ?
	// To prevent WordPress cookies from being sent with each request to static content on your subdomain, set the cookie domain to your non-static domain only.
	// define('COOKIE_DOMAIN', DOMAIN_NAME);

	// FTP: On some webhosting configurations, Wordpress automatic updates fail. Try the FTP method. If still a no-go, see: http://codex.wordpress.org/Editing_wp-config.php#Override_of_default_file_permissions for alternative methods. */
	/*
	define('FS_METHOD', 'ftpext');
	define('FTP_USER', 'YOUR FTP LOGIN');
	define('FTP_PASS', 'YOUR FTP PASSWORD');
	define('FTP_HOST', 'YOUR FTP HOST (without http:// or ftp://)');
	define('FTP_SSL', false);
*/
	break;
}


/*  ------------------------ SETTINGS COMMON TO ALL SERVERS  --------------------- */

define('TABLE_PREFIX','cstmr_');  // Something else than the default wp_. Only numbers, letters, and underscores.
define('WP_POST_REVISIONS', 10 ); // How many revisions to keep at max.
define('AUTOSAVE_INTERVAL', 60); // in seconds
define('EMPTY_TRASH_DAYS', 30); // in days (use 0 to disable trash)

// WORDPRESS' LANGUAGE _ Default is 'en_EN' // NOTE: Now obsolete and handled through the admin UI (under Settings > General)
define('WPLANG', 'fr_FR');

// DB INTERNALS
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// define('WP_ALLOW_REPAIR', false); // Set to true to have WP repairs its database tables, refresh page, set back to false.

// DIRECTORY CUSTOMIZATION
// make it less obvious that your site is using wordpress.

// rename 'wp-content' folder to 'app' AND change its location.
define( 'WP_CONTENT_DIR', dirname(__FILE__) . '/app' );
define( 'WP_CONTENT_URL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . '/app');

// rename uploads folder
// define( 'UPLOADS', '/app/uploads' );

// rename plugins folder
// define( 'WP_PLUGIN_DIR', dirname(__FILE__)  . '/app/plugins' );
// define( 'WP_PLUGIN_URL', PROTOCOL . DOMAIN_NAME . DEV_SERVER_SUBFOLDER . '/app/plugins');

// You cannot move the Themes folder, but your can register an additional theme directory
// register_theme_directory( dirname( __FILE__ ) . '/themes-dev' );

// Prevent users from editing themes and plugins via the UI
define( 'DISALLOW_FILE_MODS', false ); // Warning: this hides access to "add new plugins" functionality
define( 'DISALLOW_FILE_EDIT', true );

// Cron system
//define( 'DISABLE_WP_CRON', true ); // If you can, disable wp_cron: use a real cronjob to trigger /wp-cron.php

// SSL
if (PROTOCOL === 'https://'){
	define( 'FORCE_SSL_LOGIN', true );
	define( 'FORCE_SSL_ADMIN', true );
}

// If you don't plan to post via email, decrease this
define('WP_MAIL_INTERVAL', 86400); // 1 day (instead of 5 minutes)


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'put something here');
define('SECURE_AUTH_KEY',  'put something here');
define('LOGGED_IN_KEY',    'put something here');
define('NONCE_KEY',        'put something here');
define('AUTH_SALT',        'put something here');
define('SECURE_AUTH_SALT', 'put something here');
define('LOGGED_IN_SALT',   'put something here');
define('NONCE_SALT',       'put something here');


/*  ------------------------  MULTISITE MODE  --------------------- */

/*
define( 'WP_ALLOW_MULTISITE', true ); // Enable multisite mode.
define('SUBDOMAIN_INSTALL', false); //  Leave false to use subdirectories
define('DOMAIN_CURRENT_SITE', DOMAIN_NAME);
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

// Must-use Plugins. These plugins are loaded by default before any other plugins.
// define( 'WPMU_PLUGIN_DIR', dirname(__FILE__) . '/extensions/builtin' );
// define( 'WPMU_PLUGIN_URL', 'http://mywebsite.com/extensions/builtin' );

// Where to redirect users stumbling on a 404 website
define( 'NOBLOGREDIRECT', 'http://mainwebsite.com' );


*/


/*  ------------------------ OTHER CONSTANTS YOU COULD NEED  --------------------- */

/*

// MEMORY ALLOCATION
define('WP_MEMORY_LIMIT', '32M');
define('WP_MAX_MEMORY_LIMIT', '32M');  // Admin area specifically
define('WP_DEFAULT_THEME', 'twentyeleven'); // Custom Default Theme

// Custom Database Table for Users
define( 'CUSTOM_USER_TABLE', $table_prefix.'peeps' );
define( 'CUSTOM_USER_META_TABLE', $table_prefix.'peepmeta' );

// More Cron
define( 'WP_CRON_LOCK_TIMEOUT', 120 ); // cron repeat interval
define( 'ALTERNATE_WP_CRON', true ); // Issues with cron? Try this setting as a last resort.

// Auto-updates
define( 'AUTOMATIC_UPDATER_DISABLED', true );  // Disable all automatic updates
define( 'WP_AUTO_UPDATE_CORE', false ); // Disable all core updates
define( 'WP_AUTO_UPDATE_CORE', true ); // Enable all core updates, including minor and major
define( 'WP_AUTO_UPDATE_CORE', 'minor' ); // Enable core updates for minor releases (default)
define( 'DO_NOT_UPGRADE_GLOBAL_TABLES', true ); // Disable DB Tables auto-update

*/

/*  -------------------------- STOP EDITING PAST THIS POINT  --------------------- */
$table_prefix = TABLE_PREFIX;

// Adapt your servers to the chosen locale.
setlocale(LC_ALL, WPLANG);

// For compatibility with old plugins
if (isset(WP_PLUGIN_DIR)) define( 'PLUGINDIR',  WP_PLUGIN_DIR );

/** Absolute path to WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . PATH_TO_WP);
require_once(ABSPATH . 'wp-settings.php');
