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

        add_action(
            'admin_enqueue_scripts',
            array( $this, 'load_scripts' )
        );
    }
    
    public function load_scripts(){
        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker');
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

        add_settings_field(
            'tdt_notification_image',
            'Image:',
            array( $this, 'render_tdt_notification_image' ),
            'tdt-notification',
            'tdt-notification-general-section'
        );
        register_setting(
            'tdt-notification-settings',
            'tdt_notification_image'
        );

        add_settings_field(
            'tdt_notification_background_color',
            'Background color:',
            array( $this, 'render_tdt_notification_background_color' ),
            'tdt-notification',
            'tdt-notification-general-section'
        );
        register_setting(
            'tdt-notification-settings',
            'tdt_notification_background_color'
        );

        add_settings_field(
            'tdt_notification_text_color',
            'Text color:',
            array( $this, 'render_tdt_notification_text_color' ),
            'tdt-notification',
            'tdt-notification-general-section'
        );
        register_setting(
            'tdt-notification-settings',
            'tdt_notification_text_color'
        );
    }

    public function render_tdt_notification_disable() {
        echo '<input type="checkbox" name="tdt_notification_disable" value="1" ' . checked( 1, get_option( 'tdt_notification_disable' ), false ) . ' />';
    }
    
    public function render_tdt_notification_content(){
        echo sprintf('<textarea cols="70" rows="10" name="tdt_notification_content">%s</textarea>
                      <p>Format: Customer name | Location | Timespan | Delay</p>', get_option( 'tdt_notification_content' ));
    }

    public function render_tdt_notification_image(){
        if( ($image_url = get_option( 'tdt_notification_image', '')) != ''){
            printf('<img src="%s" style="width: 64px; height: 64px; float: left; margin-right: 15px;">', $image_url);
        }
        echo sprintf('<input type="text" name="tdt_notification_image" id="tdt_notification_image" value="%s" style="width: 445px; margin-bottom: 8px"><input type="button" name="upload-btn" id="upload-btn" class="button-secondary" style="display: block" value="Upload Image">', $image_url);
    }

    public function render_tdt_notification_background_color(){
        echo sprintf('<input type="text" name="tdt_notification_background_color" id="tdt_notification_background_color" value="%s">', get_option( 'tdt_notification_background_color', ''));
    }

    public function render_tdt_notification_text_color(){
        echo sprintf('<input type="text" name="tdt_notification_text_color" id="tdt_notification_text_color" value="%s">', get_option( 'tdt_notification_text_color', ''));
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
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('#tdt_notification_background_color').wpColorPicker();
                $('#tdt_notification_text_color').wpColorPicker();

                $('#upload-btn').click(function(e) {
                    e.preventDefault();
                    var image = wp.media({ 
                        title: 'Upload Image',
                        // mutiple: true if you want to upload multiple files at once
                        multiple: false
                    }).open()
                    .on('select', function(e){
                        // This will return the selected image from the Media Uploader, the result is an object
                        var uploaded_image = image.state().get('selection').first();
                        // We convert uploaded_image to a JSON object to make accessing it easier
                        // Output to the console uploaded_image
                        console.log(uploaded_image);
                        var image_url = uploaded_image.toJSON().url;
                        // Let's assign the url value to the input field
                        $('#tdt_notification_image').val(image_url);
                    });
                });
            });
        </script>
        <?php
    }

}

if ( is_admin() ) {
    $notification_admin = new TDT_Notification_Admin();
}
