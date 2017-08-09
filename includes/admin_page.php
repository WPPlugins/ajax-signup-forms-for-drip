<?php

defined('ABSPATH') or die('Jog on!');

function yk_ds_admin_menu() {
	add_options_page( YK_DS_PLUGIN_NAME . ' Options', YK_DS_PLUGIN_NAME, 'manage_options', 'yk-ds-admin-page', 'yk_ds_admin_page' );
}
function yk_ds_admin_page() {
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}

		?>
		<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">


			<ul>
				<li><a href="#settings">Drip Settings</a>
				<li><a href="#instructions">Shortcode Instructions</a>
				
			</ul>

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<a name="settings" />
					<div class="postbox">

					
						<h3 class="hndle"><span><?php _e( YK_DS_PLUGIN_NAME . ' Settings'); ?></span></h3>

						<div class="inside">
						
							<form method="post" action="options.php"> 
								<?php

									settings_fields( 'yk-ds-options-group' );
									do_settings_sections( 'yk-ds-options-group' ); 

								?>
							
									<table class="form-table">
										<tr>
											<th scope="row"><?php _e( 'API Key' ); ?></th>
											<td>
												<input type="text" class="large-text" value="<?php echo YK_DS_API_KEY; ?>" id="yk-ds-app-id" name="yk-ds-app-id" />
												<p><?php _e('Drip API Key. To get this, goto <a href="https://www.getdrip.com/user/edit" target="_blank">www.getdrip.com/user/edit</a> and copy API token.');?></p>
											</td>
										</tr>
										<tr>
											<th scope="row"><?php _e( 'Account ID' ); ?></th>
											<td>
												<input type="text" class="large-text" value="<?php echo YK_DS_ACCOUNT_ID; ?>" id="yk-ds-account-id" name="yk-ds-account-id" />
												<p><?php _e('Drip Account ID. To get this, goto <a href="https://www.getdrip.com/" target="_blank">https://www.getdrip.com</a> and login. Goto Settings > Site Setup and copy Account ID under third party integrations');?></p>
											</td>
										</tr>
										<tr>
											<th scope="row"><?php _e( 'Enable Double Opt-in?' ); ?></th>
											<td>
												<select id="yk-ds-double-opt-in" name="yk-ds-double-opt-in">
													<option value="yes" <?php selected( get_option('yk-ds-double-opt-in'), 'yes' ); ?>><?php _e('Yes')?></option>
													<option value="no" <?php selected( get_option('yk-ds-double-opt-in'), 'no' ); ?>><?php _e('No')?></option>
												</select>
												<p><?php _e('If enabled, a confirmation email will be sent to the subscriber before they are added to your campaign.')?></p>
											</td>
										</tr>
										<tr>
										<th scope="row"><?php _e( 'Use JavaScript to set Cookies?' ); ?></th>
											<td>
												<select id="yk-ds-use-javascript-cookies" name="yk-ds-use-javascript-cookies">
													<option value="no" <?php selected( get_option('yk-ds-use-javascript-cookies'), 'no' ); ?>><?php _e('No')?></option>
													<option value="yes" <?php selected( get_option('yk-ds-use-javascript-cookies'), 'yes' ); ?>><?php _e('Yes')?></option>					
												</select>
												<p><?php _e('By default PHP is used to set cookies when a sign up form has been completed. However some setups (caching for example) may intefere with this. If this is the case, try using JavaScript to set the cookies instead.')?></p>
											</td>
										</tr>
										<tr>
											<th scope="row"><?php _e( 'Cooikie Key' ); ?></th>
											<td>
												<input type="text" class="large-text" value="<?php echo YK_DS_COOKIE_NAME; ?>" id="yk-ds-cookie-key" name="yk-ds-cookie-key" />
												<p><?php _e('When a signup form is successfully completed a cookie is dumped. This specifies the name of the cookie key. If this cookie is found, then the forms aren\'t shown. You can change this key name to force forms to be shown again');?></p>
											</td>
										</tr>
										
									</table>
									
								
								<?php submit_button(); ?>



							</form>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

			
					<a name="instructions" />
					<div class="postbox">
						<h3 class="hndle"><span><?php _e( YK_DS_PLUGIN_NAME . ' Instructions'); ?> </span></h3>
						<div style="padding: 0px 15px 0px 15px">
					
							<h2>Placing a shortcode</h2>
							<p>On the page you require a Drip signup form, simply place the following shortcode:</p>

							<p><strong>[drip-signup campaign_id="12345678"]</strong></p>

							<p>The shortcode supports the following attributes:</p>
							<ul style="margin-left:20px">
							<li><strong>campaign_id</strong> - mandatory. This is the Drip Campaign that the visitor should be subscribed to. Read the FAQ section to get more information on getting a campaign ID.</li>
							<li><strong>form_class</strong> - optional. The CSS class that should be applied to the form; this allows you to style the form as you wish via style sheets. Default: ''.</li>
							<li><strong>placeholder_text</strong> - optional. The default placeholder text that appears in the email address text box. Default: 'Enter your email address'</li>
							<li><strong>button_text</strong> - optional. Specifies the text on the submit button. Default: 'Submit'.</li>
							<li><strong>already_submitted_class</strong> - optional. Specifies the class that should be applied to the form if the user has already subscribed. Default 'yk-ds-hide-form'.</li>
							<li><strong>loader_colour</strong> - optional. Specifies the colour of the animated "loading" graphic. This allows you to contrast it against backgrounds. Default: '#000000'</li>
							<li><strong>hide_another_element_on_page</strong> This attribute allows you to specify the ID of another HTML element on the page. When a form is submitted or a cookie has been detected, the css class specified by argument "already_submitted_class" will also be applied to given HTML element. For example this allows you to hide a div containging the form and other text. Default: none.</li>
							</ul>
							<p>Here is a full example:</p>
							<p><strong>[drip-signup campaign_id="12345678" form_class="my-css-form-class" placeholder_text="Enter your email address" button_text="Subscribe" already_submitted_class="my-css-form-submitted" hide_another_element_on_page="id-of-another-html-element" loader_colour="#FFFFFF"]</strong></p>

							<h2>Placing via PHP / Templates</h2>

							<p>If you wish to render a form via PHP, use the following sytnax:</p>
							
							<p style="margin-left:20px">

							if (function_exists('yk_ds_shortcode'))<br />
							{<br />
								$shortcode_args = 
								array(
							        'campaign_id' => 12345678,<br />
							        'form_class' => 'my-css-form-class',<br />
							        'placeholder_text' => 'Enter your email address',<br />
							        'button_text' => 'Subscribe',<br />
							        'already_submitted_class' => 'my-css-form-submitted',<br />
							        loader_colour => '#FFFFFF',<br />
							        'hide_another_element_on_page' => 'id-of-another-html-element'<br />
							    	);<br/><br />

								echo yk_ds_shortcode($shortcode_args);<br />
							}
							</p>
						</div>
					</div>
				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->		

	<?php


}

function yk_ds_register_settings()
{
	register_setting( 'yk-ds-options-group', 'yk-ds-account-id' );
	register_setting( 'yk-ds-options-group', 'yk-ds-app-id' );
	register_setting( 'yk-ds-options-group', 'yk-ds-double-opt-in' );
	register_setting( 'yk-ds-options-group', 'yk-ds-use-javascript-cookies' );
	register_setting( 'yk-ds-options-group', 'yk-ds-cookie-key' );
}

if ( is_admin() )
{
	add_action( 'admin_menu', 'yk_ds_admin_menu' );
	add_action( 'admin_init', 'yk_ds_register_settings' );
}


