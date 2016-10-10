<?php
/**
 * Plugin Name: FogBugz Updates Notifier
 * Plugin URI: http://www.bumpnetworks.com
 * Description: Add FogBugz case number to email subject sent by WP Updates Notifier plugin.
 * Version: 1.1.2
 * Author: Vladimir Zabara
 */

include ('fogbugz_notifier.class.php');
if ( is_admin () ) {
	include ('fogbugz_notifier_admin.class.php');
    $plugin = new FogBugzNotifierAdmin;

    if ($domain = $plugin->get_option('fogbugz-notifier-repository')) {
        require 'plugin-update-checker/plugin-update-checker.php';
        $myUpdateChecker = PucFactory::buildUpdateChecker(
            rtrim($domain) . '/index.php?action=get_metadata&slug=' . pathinfo(__FILE__, PATHINFO_FILENAME),
            __FILE__
        );
    }
} else {
	new FogBugzNotifier;
}
