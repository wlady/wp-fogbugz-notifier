<?php
/**
 * FogBugzNotifierAdmin class for admin actions
 *
 * This class contains all functions and actions required for NaishProducts to work in the admin of WordPress
 *
 */

class FogBugzNotifierAdmin extends FogBugzNotifier {

	/**
	 * Full file system path to the main plugin file
	 *
	 * @since 3.0.0.0
	 * @var string
	 */
	var $plugin_file;

	/**
	 * Path to the main plugin file relative to WP_CONTENT_DIR/plugins
	 *
	 * @since 3.0.0.0
	 * @var string
	 */
	var $plugin_basename;

	/**
	 * Name of options page hook
	 *
	 * @since 3.0.0.1
	 * @var string
	 */
	var $options_page_hookname;

	/**
	 * Plugin slug to detect available updates
	 * @var string
	 */
	var $plugin_slug;
	
	/**
	 * Setup backend functionality in WordPress
	 *
	 * @return none
	 * @since 3.0.0.0
	 */
	public function __construct () {
		parent::__construct();
		$this->plugin_file = dirname (__FILE__) . '/wp-fogbugz-notifier.php';
		$this->plugin_basename = plugin_basename ( $this->plugin_file );
		$this->plugin_slug = basename(dirname(__FILE__));
		// Activation hook
		register_activation_hook ( $this->plugin_file , array ( &$this , 'init' ) );
		// Whitelist options
		add_action ( 'admin_init' , array ( &$this , 'register_settings' ) );
		// Activate the options page
		add_action ( 'admin_menu' , array ( &$this , 'add_page' ) ) ;
	}

	/**
	 * Whitelist the fogbugz-notifier options
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function register_settings () {
		register_setting ( 'fogbugz-notifier' , 'fogbugz-notifier' , array ( &$this , 'update' ) );
	}

	/**
	 * Update/validate the options in the options table from the POST
	 *
	 * @since 3.0.0.1
	 * @return none
	 */
	function update ( $options ) {
		// Make sure there are no empty values, seems users like to clear out options before saving
		foreach ( $this->defaults () as $key => $value ) {
			if ( ( ! isset ( $options[$key] ) || empty ( $options[$key] ) ) && $key != 'delete' && $key != 'default' )
				$options[$key] = $value;
		}
		if ( isset ( $options['delete'] ) && $options['delete'] == 'true' ) { // Check if we are supposed to remove options
			delete_option ( 'fogbugz-notifier' );
		} else if ( isset ( $options['default'] ) && $options['default'] == 'true' ) { // Check if we are supposed to reset to defaults
			$this->options = $this->defaults ();
			return $this->options;
		} else {
			unset ( $options['delete'] , $options['default'] );
			$this->options = $options;
			return $this->options;
		}
	}

	/**
	 * Add the options page
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function add_page () {
		if ( current_user_can ( 'manage_options' ) ) {
			$this->options_page_hookname = add_options_page ( __( 'FogBugz Notifier' , 'fogbugz-notifier' ) , __( 'FogBugz Notifier' , 'fogbugz-notifier' ) , 'manage_options' , 'fogbugz-notifier' , array ( &$this , 'admin_page' ) );
		}
	}

	/**
	 * Output the options page
	 *
	 * @return none
	 * @since 2.0.3
	 */
	function admin_page () {
		if ( ! @include ( dirname(__FILE__).'/fogbugz-notifier-options-page.php' ) ) {
			_e ( sprintf ( '<div id="message" class="updated fade"><p>The options page for the <strong>FogBugz Notifier</strong> cannot be displayed.  The file <strong>%s</strong> is missing.  Please reinstall the plugin.</p></div>' , dirname ( __FILE__ ) . '/fogbugz-notifier-options-page.php' ) );
		}
	}

	function sanitize ( $string , $type = 'text' ) {
		return self::getTypedVar($string , $type);
	}
}
