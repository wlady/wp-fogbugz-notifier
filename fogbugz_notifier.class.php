<?php

class FogBugzNotifier {

	protected $options = null;

	public function __construct() {
		$this->init();
	}

	/**
	 * Initialize the default options during plugin activation
	 *
	 * @return none
	 * @since 2.0.3
	 */
	protected function init () {
		if ( !($this->options = get_option ( 'fogbugz-notifier' )) ) {
			$this->options = $this->defaults();
			add_option ( 'fogbugz-notifier' , $this->options );
		}
		add_filter( 'wp_mail', array( $this, 'fogbugz_notyfier'));
	}

	/**
	 * Return the default options
	 *
	 * @return array
	 * @since 2.0.3
	 */
	protected function defaults () {
		return array (
			'fogbugz-notifier-case' => '',
			'fogbugz-notifier-repository' => '',
		);
	}

	/**
	 * Get specific option from the options table
	 *
	 * @param string $option Name of option to be used as array key for retrieving the specific value
	 * @return mixed
	 * @since 2.0.3
	 */
	public function get_option ( $option , $options = null ) {
		if ( is_null ( $options ) ) {
			$options = &$this->options;
		}
		if ( isset ( $options[$option] ) ) {
			return $options[$option];
		} else {
			return false;
		}
	}

	function fogbugz_notyfier($args) {
		$caseNumber = $this->options['fogbugz-notifier-case'];
		if (!$caseNumber) {
			return $args;
		}
		// Listen only this type of messages
		$subjMask = '~^WP Updates Notifier:~';
		if (!preg_match($subjMask, $args[ 'subject' ])) {
			return $args;
		}
		$args[ 'subject' ] .= ' (case '.$caseNumber.')';
		if (!$args[ 'headers' ]) {
			$args[ 'headers' ] = array();
		} else if (!is_array($args[ 'headers' ])) {

			$args[ 'headers' ] = explode( "\n", str_replace( "\r\n", "\n", $args[ 'headers' ] ) );
		}
		array_push($args[ 'headers' ], 'X-FogBugz-Case: '.$caseNumber);
		$new_wp_mail = array(
			'to'          => $args[ 'to' ],
			'subject'     => $args[ 'subject' ],
			'message'     => $args[ 'message' ],
			'headers'     => $args[ 'headers' ],
			'attachments' => $args[ 'attachments' ]
		);
		return $new_wp_mail;
	}

}
