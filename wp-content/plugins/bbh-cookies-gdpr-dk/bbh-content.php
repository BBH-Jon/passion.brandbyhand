<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * bbh_GDPR_Content File Doc Comment
 *
 * @category bbh_GDPR_Content
 * @package   bbh-gdpr-tracking
 * @author    Gaspar Nemes
 */

/**
 * bbh_GDPR_Content Class Doc Comment
 *
 * @category Class
 * @package  bbh_Controller
 * @author   Gaspar Nemes
 */
class bbh_GDPR_Content {
	/**
	 * Construct
	 */
	function __construct() {
		$this->bbh_register_content_elements();
	}
	/**
	 * Register actions
	 *
	 * @return void
	 */
	public function bbh_register_content_elements() {

	}

	/**
	 * Privacy Overview Tab Content
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_privacy_overview_content() {
		$_content   = __("<p>This website uses cookies to ensure our users get the best experience possible. Cookie information is stored in your browser to recognise you when you return to this website and helping our team to understand which information on the website you find interesting and useful.</p><p>By navigating the tabs on the left hand side you are able to adjust your cookie settings.</p><p>Read our full privacy policy here.</p>","bbh-gdpr");
		return $_content;
	}

	/**
	 * Strict Necessary Tab Content
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_strict_necessary_content() {
		$_content   = __("<p>This should be enabled at all times so that we can save your preferences for cookie settings and provide you with the best experience.</p>","bbh-gdpr");
		return $_content;
	}

	/**
	 * Strict Necessary Warning Message
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_strict_necessary_warning() {
		$_content   = __("If you disable this cookie, we will not be able to save your preferences. Every time you visit this website you will need to enable or disable cookies again.","bbh-gdpr");
		return $_content;
	}

	/**
	 * Advanced Cookies Tab Content
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_advanced_cookies_content() {
		$_content   = __("<p><strong>Google Analytics:</strong><br />
We use Google Analytics to track traffic and events on this website. By enabling this feature, you agree that your data will be used for Google Analytics.</p>
<p><strong>Sleeknote:</strong><br />
Sleeknote is used to collect relevant data so we can contact you the way you want it. By activating this feature you agree that your data will be used in Sleeknote.</p>
<p><strong>Facebook Pixels:</strong><br />
We use Facebook Pixels to track and measure on our ads through Facebook. By activating this feature, you agree that your data will be used in Facebook Pixels.</p>
","bbh-gdpr");
		return $_content;
	}

	/**
	 * Third Party Cookies Tab Content
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_third_party_content() {
		$_content   = __("<p>This website uses Google Analytics to collect anonymous information such as the number of visitors to the site, and the most popular pages.</p><p>Keeping this cookie enabled helps us to improve our website.</p>","bbh-gdpr");
		return $_content;
	}

	/**
	 * Cookie Policy Tab Content
	 * @return string Filtered Content
	 */
	public function bbh_gdpr_get_cookie_policy_content() {
		$_content   = __("<p>More information about our <a href=''/privatlivspolitik/' target='_blank'>Cookie Policy</a></p>","bbh-gdpr");
		return $_content;
	}

	/**
	 * Get option name
	 */

	public function bbh_gdpr_get_option_name() {
		return 'bbh_gdpr_plugin_settings';
	}

	/**
	 * Get WMPL language code
	 */

	public function bbh_gdpr_get_wpml_lang() {
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		  return '_'.ICL_LANGUAGE_CODE;
		}
		return '';
	}

}
new bbh_GDPR_Content();
