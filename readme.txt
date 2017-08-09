=== AJAX Signup forms for Drip ===
Contributors: aliakro
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=J3C968CUGDV6U
Tags: drip, mail, subscribe, ajax, sweetalert, subscribe, list
Requires at least: 4.2.0
Tested up to: 4.2.2
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

"AJAX Signup forms for Drip" is a plugin that allows you to place one or more subscribe forms for Drip (www.getdrip.com) on your site. Using Shortcodes (or direct PHP calls) a form that captures an email address can be placed. Using AJAX, the email is submitted to Drip (www.getdrip.com) without refreshing the page. All dialog boxes are presented using Sweet Alert (http://t4t5.github.io/sweetalert/).

You can drop as many shortcodes as you wish and a new subscribe form is dropped. You can associate each form with a Drip Campaign by specifying the ID (shortcode attribute "campaign_id").

Once a form has been completed successfully, a CSS class (defined by shortcode attribute "already_submitted_class") is added to all Drip AJAX Signup forms and a cookie is set. This allows you to hide them if you wish.

Please read the FAQ on how to place the shortcode / PHP call.
 
== Installation ==

1. Login into Wordpress Admin Panel
2. Goto Plugins > Add New
3. Search for "Drip AJAX Signup"
4. Install
5. Goto Tools > Drip AJAX Signup and complete the relevant fields

Read the guide on Tools > Drip AJAX Signup on how to place a Subscribe form.

== Frequently Asked Questions ==

= To get an API key follow these steps: = 

1. Goto https://www.getdrip.com/user/edit
2. Copy API Token. Paste these into the settings page fpr Drip Signup

= To get a campaign ID: = 

1. Goto your campaigns page (e.g. https://www.getdrip.com/1111111/campaigns)
2. Click on the desired campaign
3. You should see a link like https://www.getdrip.com/1111111/campaigns/5151381 Copy the number at the end of the URL. In this case 5151381 - this is your campaign ID.

= To get your account ID: =

1. Goto Settings page: https://www.getdrip.com/
2. Goto Settings > Site Setup
3. Copy Account ID under third party integrations

= How do I add a Drip Ajax Signup form to a page / post? =

On the page you require a Drip signup form, simply place the following shortcode:

[drip-signup campaign_id="12345678"]

The shortcode supports the following attributes:

campaign_id - mandatory. This is the Drip Campaign that the visitor should be subscribed to. Read the FAQ section to get more information on getting a campaign ID.

form_class - optional. The CSS class that should be applied to the form; this allows you to style the form as you wish via style sheets. Default: ''.

placeholder_text - optional. The default placeholder text that appears in the email address text box. Default: 'Enter your email address'.

button_text - optional. Specifies the text on the submit button. Default: 'Submit'.

already_submitted_class - optional. Specifies the class that should be applied to the form if the user has already subscribed. Default 'yk-ds-hide-form'

loader_colour - optional. Specifies the colour of the animated "loading" graphic. This allows you to contrast it against backgrounds. Default: '#000000'

hide_another_element_on_page - optional. This attribute allows you to specify the ID of another HTML element on the page. When a form is submitted or a cookie has been detected, the css class specified by argument "already_submitted_class" will also be applied to given HTML element. For example this allows you to hide a div containging the form and other text. Default: none.

Here is a full example:

[drip-signup campaign_id="12345678" form_class="my-css-form-class" placeholder_text="Enter your email address" button_text="Subscribe" already_submitted_class="my-css-form-submitted" hide_another_element_on_page="id-of-another-html-element"]

= How do I use the shortcode via template / PHP calls? =

If you wish to render a form via PHP, use the following sytnax:

if (function_exists('yk_ds_shortcode'))
{

	$shortcode_args = 
		array(
	        'campaign_id' => 12345678,
	        'form_class' => 'my-css-form-class',
	        'placeholder_text' => 'Enter your email address',
	        'button_text' => 'Subscribe',
	        'already_submitted_class' => 'my-css-form-submitted',
	        'loader_colour' => '#000000',
	        'hide_another_element_on_page' => 'id-of-another-html-element'
	    	);

	echo yk_ds_shortcode($shortcode_args);
}

= Forms no longer appear? =

Once a user has subscribed to a form, a generic cookie is dumped. If detected, the class specified by already_submitted_class parameter is applied to the form. This means your form maybe getting hidden as the user has already subscribed. You can test this by ensuring your CSS doesn't cause elements with that class to be hidden.

= Cookies aren't being set? =

By default cookies are set using PHP. This however may not work on some setups (for example due to caching). Therefore, you can specify that cookies are set via JavaScript. To do this, go to the admin page. Settings > Drip Ajax Signup. Ensure "Use JavaScript to set Cookies?" is set to "Yes".

== Screenshots ==

1. Default unstyled Signup form
2. Form in progress of being submitted (throbber displayed)
3. Form succesfully submitted
4. Display error from Drip
5. Screenshot of Admin page

== Changelog ==

= 1.1 =
* Added another argument to the shortcode "hide_another_element_on_page". This attribute allows you to specify the ID of another HTML element on the page. When a form is submitted or a cookie has been detected, the css class specified by argument "already_submitted_class" will also be applied to given HTML element. For example this allows you to hide a div containging the form and other text.
* Set JS cookie path to "/" so avaliable across the site (not just a page!)

= 1.0 =
* Initial Release
