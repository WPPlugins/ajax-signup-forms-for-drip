<?php

defined('ABSPATH') or die('Jog on!');

function yk_ds_shortcode( $atts )
{
	$shortcode_args = shortcode_atts( array(
        'campaign_id' => false,
        'form_class' => '',
        'placeholder_text' => 'Enter your email address',
        'button_text' => 'Submit',
        'already_submitted_class' => 'yk-ds-hide-form',
        'hide_another_element_on_page' => '',
        'loader_colour' => '#000000'
    ), $atts );

	return yk_ds_display_signup_form($shortcode_args);

}
add_shortcode( YK_DS_SHORTCODE, 'yk_ds_shortcode' );

function yk_ds_display_signup_form($shortcode_args)
{

	$form_id = $shortcode_args['campaign_id'];

	// Attach a random string to end to ensure two Shortcodes placed with same campaign cause no issues.
	$form_id .= "-" . substr(md5(rand()), 0, 7);

	//Only render form if we have a valid signup id
	if ($form_id != false)
	{
		//Queue relevant jQuery
		wp_enqueue_script(YK_DS_SLUG . '-js-sa', plugins_url( 'yk_ds.js', __FILE__ ), array('jquery'), YK_DS_PLUGIN_VERSION);
		wp_enqueue_script(YK_DS_SLUG . '-js-loader', plugins_url( 'query.loader.js', __FILE__ ), array('jquery'), YK_DS_PLUGIN_VERSION);
		wp_enqueue_script(YK_DS_SLUG . '-js', plugins_url( 'sweetalert/sweetalert.min.js', __FILE__ ), array('jquery', YK_DS_SLUG . '-js-sa'), YK_DS_PLUGIN_VERSION);
		wp_enqueue_style( YK_DS_SLUG . '-css-sa', plugins_url( 'sweetalert/sweetalert.css', __FILE__ ), array(), YK_DS_PLUGIN_VERSION );
		wp_enqueue_style( YK_DS_SLUG . '-css', plugins_url( 'yk_ds.css', __FILE__ ), array(), YK_DS_PLUGIN_VERSION );

		if (YK_DS_JAVASCRIPT_COOKIES) {
			wp_enqueue_script(YK_DS_SLUG . '-js-cookie', plugins_url( 'jquery.cookie.js', __FILE__ ), array('jquery'), YK_DS_PLUGIN_VERSION);
		}

		$shortcode_args['form_class'] = (!empty($shortcode_args['form_class']) ? ' ' . $shortcode_args['form_class'] : '');

		$hide_class = (yk_ds_has_user_submitted_form_before()) ? ' ' . $shortcode_args['already_submitted_class'] : '';
		$hide_parent = (yk_ds_has_user_submitted_form_before()) ? 'true' : 'false';


		$html = '<form class="yk-ds-form' . $shortcode_args['form_class'] . $hide_class . '" id="yk-ds-form-' . $form_id . '" data-unique-id="' . $form_id . '" data-hide-parent="' . $hide_parent . '" data-loader-colour="' . $shortcode_args['loader_colour'] . '" data-also-hide="' . $shortcode_args['hide_another_element_on_page'] . '"  data-campaign="' . $shortcode_args['campaign_id'] . '" data-already-submitted-class="' . $shortcode_args['already_submitted_class'] . '">
					<input type="text" id="yk-ds-email-' . $form_id . '" name="yk-ds-email-' . $form_id . '" value="" placeholder="' . $shortcode_args['placeholder_text'] . '"/>
 					<button type="submit" form="yk-ds-form-' . $form_id . '" id="yk-ds-button-' . $form_id . '">' . $shortcode_args['button_text'] . '</button>
					<div id="yk-ds-loader-' . $form_id . '" class="yk-ds-hide" >&nbsp;</div>				
				</form>';

		return $html;
	}
}

function yk_ns_footer_js()
{
	$success_message = __('Your email has been successfully subscribed!');

	if(YK_DS_DOUBLE_OPT_IN) {
		$success_message .= '<br /><br />' . __('To complete your signup, a confirmation email has been sent to the given email address');
	}

	echo '
	<script>
		jQuery(document).ready(function( $ ) {
			
			jQuery(".yk-ds-form").each(function () {
				$campaign = $(this).data("unique-id");
				$colour = $(this).data("loader-colour");
				var cl = new CanvasLoader("yk-ds-loader-" + $campaign);
				cl.setColor($colour); 
				cl.setDiameter(26);
				cl.setSpeed(1); 
				cl.show();


				';
				if (!YK_DS_JAVASCRIPT_COOKIES)
				{
					echo '

					$hide_parent = $(this).data("hide-parent");

					if(true == $hide_parent)
					{
						yk_ds_hide_parent(jQuery(this).attr("id"));
					}';
				}
				echo '
		   	});';

			if (YK_DS_JAVASCRIPT_COOKIES)
				{
					echo '
						// Hide forms if already submitted
						yk_ds_already_submitted_form();
					';
				}
			echo '
			$( ".yk-ds-form" ).submit(function( event ) {

				event.preventDefault();
			 
				var user_data = {};

				$form_id = $(this).data("unique-id");

				user_data["campaign"] = $(this).data("campaign"); 
				user_data["email"] =  $("#yk-ds-email-" + $form_id).val();
				user_data["unique-id"] =  $form_id;

				if (yk_ds_is_email(user_data["email"]))	{
			
					yk_ds_hide_button($form_id);

					yk_ds_add_user(user_data,
							yk_ds_handle_response_from_drip
						);

				}
				else {
					yk_ds_display_error("' . __('You must enter an email address!') . '");
				}
			});		
		});
		
		function yk_ds_hide_button($campaign)
		{
			jQuery("#yk-ds-loader-" + $campaign).removeClass("yk-ds-hide");
			jQuery("#yk-ds-button-" + $campaign).addClass("yk-ds-hide");
 		
		}

		function yk_ds_show_button($campaign)
		{
			jQuery("#yk-ds-loader-" + $campaign).addClass("yk-ds-hide");
			jQuery("#yk-ds-button-" + $campaign).removeClass("yk-ds-hide");
		}

		function yk_ds_hide_form($campaign)
		{
			jQuery("#yk-ds-button-" + $campaign).removeClass("yk-ds-hide");
			jQuery("#yk-ds-form-" + $campaign).addClass("yk-ds-hide");
		}

		function yk_ds_hide_parent($campaign)
		{
			$parent = jQuery("#" + $campaign).data("also-hide");

			if($parent)
			{
				$class_to_apply = jQuery("#" + $campaign).data("already-submitted-class");

				if($class_to_apply)
				{
					jQuery("#" + $parent).addClass($class_to_apply);
				}
			}
		}

		function yk_ds_set_cookie()
		{
			jQuery(document).ready(function ($) {
					$.cookie("' . YK_DS_COOKIE_NAME .  '", "1", { expires: 9999, path: "/" });
				});
		}

		function yk_ds_already_submitted_form()
		{
			
			$value = jQuery.cookie("' . YK_DS_COOKIE_NAME .  '");

			if ("1" == $value) {
				
				jQuery(".yk-ds-form").each(function () {

						$class_to_apply = jQuery(this).data("already-submitted-class");

						jQuery(this).addClass($class_to_apply);

						yk_ds_hide_parent(jQuery(this).attr("id"));
						
				   	});
			}

			
		}

		function yk_ds_add_user(userdata, callback)
		{ 
			var data = {
				"action": "yk_ds_add_drip_user",
				"security": "' . wp_create_nonce( 'yk_ds_add_drip_user' ) . '",
				"user-data": userdata   
			};
			
			jQuery.post("' . admin_url('admin-ajax.php') . '", data, function(response) {
				
				var response = JSON.parse(response);
				callback(response);

			});

		}

		function yk_ds_handle_response_from_drip(response)
		{
			  if (true == response["success"]) {
			  	yk_ds_hide_form(response["unique-id"]);
				yk_ds_hide_parent("yk-ds-form-" + response["unique-id"]);
			  	';
			
				if (YK_DS_JAVASCRIPT_COOKIES)
				{
					echo '
						yk_ds_set_cookie();
						';
				}
				echo '
			  	yk_ds_display_success();
			  }
			  else {
			  	yk_ds_show_button(response["unique-id"]);
			  	yk_ds_display_error(response["error"]);
			  }
		}

		function yk_ds_display_success() {
			
			swal({
					title: "' . __('Success!') . '",
					text: "' . $success_message . '",
					type: "success",
					html: true

				 	});
		}

		function yk_ds_display_error($text)	{
			sweetAlert("' . __('Oops') . '...", $text, "error");
		}

		function yk_ds_is_email(email) {
		  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		  return regex.test(email);
		}

	</script>
		';
}
add_action( 'wp_footer', 'yk_ns_footer_js' );