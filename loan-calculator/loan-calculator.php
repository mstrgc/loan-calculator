<?php

/**
 * Plugin Name: Loan Calculator
 * Version: 1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue.php';

class Loan_calculator{
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        new Loan_calculator_shortcode();
        new Loan_enqueue();
    }
}

add_action('plugin_loaded', ['Loan_calculator', 'get_instance']);