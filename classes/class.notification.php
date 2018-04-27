<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class TDT_Notification {

    public $notification_content;
    public $notification_contentjs;

    function __construct(){
        $this->notification_content = $this->get_notification_content();
        $this->notification_contentjs = '';
    }

    public function init() {
        if ( get_option( 'tdt_notification_disable' ) == false ) {
            add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ), 0 );
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

    public function inline_scripts() {
        if($this->notification_content != false){
            foreach($this->notification_content as $notification){
                if((list($name, $location, $timespan, $delay) = array_pad(explode('|', $notification, 4), 4, null)) == true){

                    // Remove unexpected new line cause "Invalid or unexpected token" at frontend
                    $name = str_replace(["\r", "\n"], '', $name);
                    $location = str_replace(["\r", "\n"], '', $location);
                    $timespan = str_replace(["\r", "\n"], '', $timespan);
                    $delay = str_replace(["\r", "\n"], '', $delay);
                    
                    // Pre-process
                    $name = empty($name) ? "Ẩn danh" : $name;
                    $timespan = empty($timespan) ? "Vừa mới đây" : $timespan;

                    $this->notification_contentjs .= sprintf('["%s", "%s", "%s", %d],', $name, $location, $timespan, $delay);
                }
            }
        }
        printf('<script>const tdt_notification_content = [%s];</script>', $this->notification_contentjs);
    }

}

if ( get_option( 'tdt_notification_disable', false ) == false ) {
    $tdt_notification = new TDT_Notification();
    add_action( 'wp', array( $tdt_notification, 'init' ) );
}