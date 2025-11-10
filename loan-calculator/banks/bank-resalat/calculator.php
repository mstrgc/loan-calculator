<?php

if(!defined('ABSPATH')){
    exit;
}

class Resalat_loan_calculator{
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function render(){
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-resalat/ui.php';
        return ob_get_clean();
    }
}