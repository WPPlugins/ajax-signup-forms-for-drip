<?php

defined('ABSPATH') or die("Jog on!");

/**
 * Plugin Name: AJAX Signup forms for Drip
 * Description: Place email subsribe forms across your site for Drip campaigns. Using AJAX there is no page reloading and confirmations are using Sweet Alert.
 * Version: 1.1
 * Author: YeKen
 * Author URI: http://www.YeKen.uk
 * License: GPL2
 * Text Domain: shortcode-variables
 */
/*  Copyright 2014 YeKen.uk

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define('YK_DS_ABSPATH', plugin_dir_path( __FILE__ ));

define('YK_DS_PLUGIN_VERSION', '1.1');

// -----------------------------------------------------------------------------------------
// AC: Include all relevant PHP files
// -----------------------------------------------------------------------------------------

include YK_DS_ABSPATH . 'includes/globals.php';
include YK_DS_ABSPATH . 'includes/hooks.php';
include YK_DS_ABSPATH . 'includes/pages.php';
include YK_DS_ABSPATH . 'includes/functions.php';
include YK_DS_ABSPATH . 'includes/shortcode.php';
include YK_DS_ABSPATH . 'includes/drip-api.php';
include YK_DS_ABSPATH . 'includes/admin_page.php';
// -----------------------------------------------------------------------------------------
// AC: Load relevant language files
// -----------------------------------------------------------------------------------------

load_plugin_textdomain( YK_DS_SLUG, false, dirname( plugin_basename( __FILE__ )  ) . '/languages/' );
 
// -----------------------------------------------------------------------------------------
// AC: DEV Stuff here (!!!! REMOVE !!!!)
// -----------------------------------------------------------------------------------------
