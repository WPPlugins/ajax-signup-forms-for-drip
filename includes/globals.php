<?php

defined('ABSPATH') or die('Jog on!');

define('YK_DS_API_KEY', get_option('yk-ds-app-id'));
define('YK_DS_ACCOUNT_ID', get_option('yk-ds-account-id'));

$selected_option = ((get_option('yk-ds-double-opt-in') == false || get_option('yk-ds-double-opt-in') == 'no') ? false : true);
define('YK_DS_DOUBLE_OPT_IN', $selected_option);

$selected_option = ((get_option('yk-ds-use-javascript-cookies') == false || get_option('yk-ds-use-javascript-cookies') == 'no') ? false : true);
define('YK_DS_JAVASCRIPT_COOKIES', $selected_option);

$selected_option = ((get_option('yk-ds-cookie-key') == false) ? 'yk-ds-cookie-signup' : get_option('yk-ds-cookie-key'));
define('YK_DS_COOKIE_NAME', $selected_option );

// Do not change these
define('YK_DS_PLUGIN_NAME', 'AJAX Signup forms for Drip');
define('YK_DS_SLUG', 'yk-ds-drip-signup');
define('YK_DS_SHORTCODE', 'drip-signup');
define('YK_DS_AJAX_NONCE', 'yk-ds-security-nonce');


