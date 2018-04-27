<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TDT_Notification {

    function __construct(){

    }

    public function init() {

    }

    public function load_scripts(){
        wp_enqueue_script(
			'tdt-notification',
			TDT_NOTIFICATION_PLUGIN_DIR . 'assets/js/notification.min.js',
			'',
			null,
			false
		);
		wp_enqueue_style(
			'tdt-notification',
			TDT_NOTIFICATION_PLUGIN_DIR . 'assets/css/notification.css',
			'',
			null,
			false
		);
    }

    public function inline_scripts() {
		echo '<script>document.getElementsByTagName("body")[0].className = document.getElementsByTagName("body")[0].className.replace("no-js", "js");</script>';
	}

}

if ( get_option( 'tdt_notification_disable', false ) == false ) {
	$tdt_notification = new TDT_Notification();
	add_action( 'wp', array( $tdt_notification, 'init' ) );
}