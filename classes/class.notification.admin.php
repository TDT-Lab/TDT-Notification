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

        add_action(
            'admin_init',
            array( $this, 'init' )
        );
    }

    public function init(){
        $this->setting_fields();
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
    
    public function render_tdt_notification_content(){
        echo sprintf('<textarea cols="70" rows="10" name="tdt_notification_content">%s</textarea>', get_option( 'tdt_notification_content' ));
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
    
    public function disabled_notice() {
        if ( get_option( 'tdt_notification_disable' ) ) {
            echo '<div class="error"><p>TDT Notification <strong>currently disabled</strong> so all your changes might not affected.</p></div>';
        }
    }
    
    public function show_options() {
        ?>
        <div class="wrap">
            <h1>TDT Notification Settings</h1>
            <?php $this->disabled_notice(); ?>
            <form method="POST" action="options.php">
                <?php
                do_settings_sections( 'tdt-notification' );
                settings_fields( 'tdt-notification-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

}

if ( is_admin() ) {
    $notification_admin = new TDT_Notification_Admin();
}
