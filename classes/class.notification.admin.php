<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class TDT_Notification_Admin {

    function __construct(){
        add_action(
			'admin_menu',
			array( $this, 'admin_menu' )
		);
    }

    public function setting_fields(){
        add_settings_section(
			'tdt-notification-general-section',
			'General Settings',
			null,
			'tdt-notification'
		);
		add_settings_field(
			'tdt_notification_disable',
			'Disable plugin?',
			array( $this, 'render_tdt_notification_disable' ),
			'tdt-notification',
			'tdt-notification-general-section'
		);
		register_setting(
			'tdt-notification-settings',
			'tdt_notification_disable'
        );
        add_settings_field(
			'tdt_notification_content',
			'Notification content:',
			array( $this, 'render_tdt_notification_content' ),
			'tdt-notification',
			'tdt-notification-general-section'
		);
		register_setting(
			'tdt-notification-settings',
			'tdt_notification_content'
		);
    }

    public function render_tdt_notification_disable() {
        echo '<input type="checkbox" name="tdt_notification_disable" value="1" ' . checked( 1, get_option( 'tdt_notification_disable' ), false ) . ' />';
    }
    
    public function render_tdt_notification_enable_for_advanced(){
        echo '<textarea style="width: 100%" name="tdt_notification_content" value="' . get_option( 'tdt_notification_content' ) . '" />';
    }

    public function get_notification_content(){
        // $raw = get_option( 'tdt_notification_content' );
        
    }

    public function admin_menu() {
		add_submenu_page(
			'options-general.php',
			'TDT Notification Settings Page',
			'TDT Notification',
			'manage_options',
			'tdt-notification',
			array( $this, 'show_options' )
		);
	}

}

if ( is_admin() ) {
	$notification_admin = new TDT_Notification_Admin();
	register_activation_hook( __FILE__, array( $notification_admin, 'install' ) );
}
