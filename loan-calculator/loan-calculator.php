<?php

/**
 * Plugin Name: Loan Calculator
 * Version: 1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/calculator-exception.php';
require_once plugin_dir_path(__FILE__) . 'includes/bank-melli/calculator.php';


class Loan_calculator{
    //add singleton pattern
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        new Loan_calculator_shortcode();
        add_action('send_headers', [$this, 'add_security_headers']);
    }

    public function add_security_headers() {
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
    }
}

add_action('plugins_loaded', ['Loan_calculator', 'get_instance']);