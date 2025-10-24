<?php

if(!defined('ABSPATH')){
    exit;
}
class Mehr_loan_calculator{
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        add_action('wp_ajax_nopriv_mehr_calculator', [$this, 'mehr_calculator']);
        add_action('wp_ajax_mehr_calculator', [$this, 'mehr_calculator']);
    }

    public function mehr_calculator(){
        wp_send_json_success(['message' => 'recieved!'], '200');
        wp_die();
    }

    public function enqueue(){
        require_once plugin_dir_path(__FILE__) . 'enqueue.php';
        $styles =  new Mehr_script_enqueue();
        return $styles->enqueue_assets();
    }

    public function render(){
        $this->enqueue();
        
        ob_start();
        include_once plugin_dir_path(__FILE__) . '../../templates/bank-mehr-ui.php';
        return ob_get_clean();
    }
}

add_action('plugins_loaded', ['Mehr_loan_calculator', 'get_instance']);