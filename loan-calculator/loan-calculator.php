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
        new Loan_enqueue();
        add_action('send_headers', [$this, 'add_security_headers']);
        add_action('init', [$this, 'setup_rate_limit']);
    }

    public function add_security_headers() {
        header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");
        header("X-Content-Type-Options: nosniff");
        header("X-Frame-Options: SAMEORIGIN");
        header("X-XSS-Protection: 1; mode=block");
    }

    public function setup_rate_limit() {
        if(!session_id()) {
            session_start();
        }

        $current_time = time();
        $rate_limit_window = 60;
        $max_requests = 30;

        if(!isset($_SESSION['loan_calculator_plugin_requests'])) {
            $_SESSION['loan_calculator_plugin_requests'] = [];
        }

        $_SESSION['loan_calculator_plugin_requests'] = array_filter(
            $_SESSION['loan_calculator_plugin_requests'],
            function($timestamp) use ($current_time, $rate_limit_window) {
                return ($current_time - $timestamp) < $rate_limit_window; 
            }
        );

        if(count($_SESSION['loan_calculator_plugin_requests']) >= $max_requests) {
            wp_send_json_error('تعداد درخواست بیش از حد محاز است, دوباره امتحان کنید');
        }

        $_SESSION['loan_calculator_plugin_requests'][] = $current_time;
    }
}

add_action('plugin_loaded', ['Loan_calculator', 'get_instance']);