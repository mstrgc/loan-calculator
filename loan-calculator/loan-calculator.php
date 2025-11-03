<?php

/**
 * Plugin Name: Loan Calculator
 * Version: 1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}

require_once plugin_dir_path(__FILE__) . 'includes/calculator-exception.php';
require_once plugin_dir_path(__FILE__) . 'includes/bank-melli/calculator.php';
require_once plugin_dir_path(__FILE__) . 'includes/bank-mehr/calculator.php';

class Loan_calculator{
    //add singleton pattern
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private $class;

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_essentials']);
    }

    public function render_loan_calculator($parameter){

        $parameters = shortcode_atts(
            ['bank_name' => ''],
            $parameter,
            'loan_calculator'
        );

        $available_banks = ['melli', 'mehr'];

        try{
            if(in_array($parameters['bank_name'], $available_banks)){
                require_once plugin_dir_path(__FILE__) . 'includes/bank-' . $parameters['bank_name'] . '/calculator.php';
                $class_name = ucfirst($parameters['bank_name']) . '_loan_calculator';
                return $class_name::get_instance()->render();
            } else{
                throw new Calculator_exception('محاسبه گر وامی با این نام وجود ندارد', 'could not find a calculator with the given parameter.');
            }
        } catch(Calculator_exception $error){
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            ob_start();
            echo '<p>' . $error->get_error() . '</p>';
            return ob_get_clean();
        }
    }

    public function enqueue_essentials(){
        wp_enqueue_script(
            'number_converter',
            plugin_dir_url(__FILE__) . 'assets/js/converter.js',
            [],
            null,
            true
        );

        wp_enqueue_script(
            'ajax_handler',
            plugin_dir_url(__FILE__) . 'assets/js/ajax-handler.js',
            [],
            null,
            true
        );
    }
}

add_action('plugins_loaded', ['Loan_calculator', 'get_instance']);