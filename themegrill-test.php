<?php
/**
 * Plugin Name: Themegrill Test
 * Description: Enables the WordPress classic editor and the old-style Edit Post screen with TinyMCE, Meta Boxes, etc. Supports the older plugins that extend this screen.
 * Version:     1.0
 * Author:      Sabin Nepal
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: themegrill-test
 * Requires PHP: 7.0
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

define( 'TGT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'TGT_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// The code that runs during plugin activation.
function tst_activate() {
	flush_rewrite_rules();
}

// The code that runs during plugin deactivation.
function tst_deactivate() {
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'tst_activate' );
register_activation_hook( __FILE__, 'tst_deactivate' );

require plugin_dir_path( __FILE__ ) . 'includes/class-themegrilltest.php';

new ThemeGrillTest();
