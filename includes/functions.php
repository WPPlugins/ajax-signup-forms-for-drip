<?php

defined('ABSPATH') or die('Jog on!');

// ------------------------------------------------------
// Send email address to Drip
// ------------------------------------------------------
function yk_ds_send_email_to_drip($campaign_id, $email)
{
	try {

		$drip_api = new Drip_Api(YK_DS_API_KEY);

		$api_params = array(

						'account_id' => YK_DS_ACCOUNT_ID,
						'campaign_id' => $campaign_id,
						'double_optin' => YK_DS_DOUBLE_OPT_IN,
						'email' => $email 

					);

		$api_result = $drip_api->subscribe_subscriber($api_params);

		// If no array returned, can assume an error
		if (empty($api_result))	{

			$error_text = $drip_api->get_error_code();

			if (!empty($error_text)) {
				$return_text = __('An error occurred trying to save your email address. Please try again.');
				return $return_text;
			}
			else
			 	return $drip_api->get_error_message();
		}
		
	} catch (Exception $e) {
		return $e->getMessage();
	}

	return true;
}

// ------------------------------------------------------
// AJAX Handler
// ------------------------------------------------------
function yk_ds_add_drip_user_callback()
{
	check_ajax_referer( 'yk_ds_add_drip_user', 'security' );

 	$user_data = yk_ds_ajax_post_value('user-data', false);

 	$outcome = yk_ds_send_email_to_drip($user_data['campaign'], $user_data['email']);

	$response['success'] = false;
	$response['error'] = '';
	$response['campaign'] = $user_data['campaign'];
	$response['unique-id'] = $user_data['unique-id'];

	if (is_bool($outcome) && $outcome) {
		$response['success'] = true;
		if (!YK_DS_JAVASCRIPT_COOKIES) {
			yk_ds_setcookie();
		}
	}
	else {
		$response['error'] = $outcome;	
	}

	echo json_encode($response);

	wp_die();
}
add_action( 'wp_ajax_nopriv_yk_ds_add_drip_user', 'yk_ds_add_drip_user_callback' );
add_action( 'wp_ajax_yk_ds_add_drip_user', 'yk_ds_add_drip_user_callback' );


function yk_ds_ajax_post_value($key, $json_decode = false)
{ 
    if(isset($_POST[$key]) && $json_decode) {
        return json_decode($_POST[$key]);
    }
    elseif(isset($_POST[$key])) {
    	return $_POST[$key];
    }

    return false;
}


// ------------------------------------------------------
// Set / Read Cookies
// ------------------------------------------------------
function yk_ds_setcookie() {
   setcookie( YK_DS_COOKIE_NAME, '1', time() + 36000000, COOKIEPATH, COOKIE_DOMAIN );
}
function yk_ds_has_user_submitted_form_before() {
	return isset( $_COOKIE[YK_DS_COOKIE_NAME] ) && '1' ===  $_COOKIE[YK_DS_COOKIE_NAME] && YK_DS_JAVASCRIPT_COOKIES == false ? true : false;
}
function yk_ds_resetcookie() {
   setcookie( YK_DS_COOKIE_NAME, false, time() + 36000000, COOKIEPATH, COOKIE_DOMAIN );
}