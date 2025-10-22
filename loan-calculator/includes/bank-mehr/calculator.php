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

    public function render(){
        ob_start();
        echo '<p>test</p>';
        return ob_get_clean();
    }
}

add_action('plugins_loaded', ['Mehr_loan_calculator', 'get_instance']);