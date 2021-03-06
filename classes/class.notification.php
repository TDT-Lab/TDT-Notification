<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TDT_Notification {

    public $notification_content;

    function __construct(){
        $this->notification_content = $this->get_notification_content();
    }

    public function init() {
        if ( get_option( 'tdt_notification_disable' ) == false ) {
            add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 0 );
            add_action( 'wp_head', array( $this, 'inline_styles' ), 99 );
            add_action( 'wp_footer', array( $this, 'inline_scripts' ), 1 );
        }
    }

    public function load_scripts(){
        wp_enqueue_script(
            'tdt-notification',
            TDT_NOTIFICATION_PLUGIN_DIR . 'assets/js/notification.js',
            '',
            null,
            true
        );
        wp_enqueue_style(
            'tdt-notification',
            TDT_NOTIFICATION_PLUGIN_DIR . 'assets/css/notification.css',
            '',
            null,
            false
        );
    }
    
    public function get_notification_content(){
        if(($temp = get_option('tdt_notification_content', false)) === false || empty($temp)){
            return false; // Not exists
        }
        return explode("\n", $temp);
    }

    public function inline_styles(){
        $background_color = get_option('tdt_notification_background_color');
        $text_color = get_option('tdt_notification_text_color');
        $image = get_option('tdt_notification_image');

        printf('<style>.tdt-notification { background-color: %s; color: %s; }
                        .tdt-notification-image { background-image: url("%s") }</style>', $background_color, $text_color, $image);
    }

    public function inline_scripts(){
        $contentJS = '';
        if($this->notification_content != false){
            foreach($this->notification_content as $notification){
                if((list($name, $location, $timespan, $delay) = array_pad(explode('|', $notification, 4), 4, null)) == true){

                    $name = esc_html($name);
                    $location = esc_html($location);
                    $timespan = esc_html($timespan);

                    // Remove unexpected new line cause "Invalid or unexpected token" at frontend
                    $name = str_replace(["\r", "\n"], '', $name);
                    $location = str_replace(["\r", "\n"], '', $location);
                    $timespan = str_replace(["\r", "\n"], '', $timespan);
                    $delay = str_replace(["\r", "\n"], '', $delay);
                    
                    // Pre-process
                    $name = empty($name) ? "Ẩn danh" : $name;
                    $timespan = empty($timespan) ? "Vừa mới đây" : $timespan;

                    $contentJS .= sprintf('["%s", "%s", "%s", %d],', $name, $location, $timespan, $delay);
                }
            }
        }
        printf('<script>const tdt_notification_content = [%s];</script>', $contentJS);
    }

}

if ( get_option( 'tdt_notification_disable', false ) == false ) {
    $tdt_notification = new TDT_Notification();
    add_action( 'wp', array( $tdt_notification, 'init' ) );
}