<?php

if(!defined('ABSPATH')){
    exit;
}

class Resalat_loan_calculator{
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
            self::$instance->enqueue_assets();
        }
        return self::$instance;
    }

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }

    public function render(){
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-resalat/ui.php';
        return ob_get_clean();
    }

    public function enqueue_assets(){
        wp_enqueue_script(
            'resalat_config',
            LC_PLUGIN_MAIN_URL . 'banks/bank-resalat/assets/resalat-config.js',
            [],
            null,
            true
        );
    }
}