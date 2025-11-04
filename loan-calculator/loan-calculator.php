<?php

/**
 * Plugin Name: Loan Calculator
 * Version: 1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}

define('LC_PLUGIN_MAIN_PATH', plugin_dir_path(__FILE__ ));
define('LC_PLUGIN_MAIN_URL', plugin_dir_url(__FILE__ ));

require_once LC_PLUGIN_MAIN_PATH . 'exception/calculator-exception.php';
require_once LC_PLUGIN_MAIN_PATH . 'banks/bank-melli/calculator.php';
require_once LC_PLUGIN_MAIN_PATH . 'banks/bank-mehr/calculator.php';

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
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_essentials']);
        add_action('wp_ajax_calculator', [$this, 'ajax_handler']);
        add_action('wp_ajax_nopriv_calculator', [$this, 'ajax_handler']);
    }

    private $available_banks = ['melli', 'mehr'];

    public function render_loan_calculator($parameter){

        $parameters = shortcode_atts(
            ['bank_name' => ''],
            $parameter,
            'loan_calculator'
        );

        try{
            if(in_array($parameters['bank_name'], $this->available_banks)){
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

    public function ajax_handler() {
        $key = sanitize_text_field($_POST['key']) ?? '';

        if(!in_array($key, $this->available_banks)){
            wp_send_json_error(['message' => 'خطا در ارسال اطلاعات']);
        }

        $class = ucfirst($key) . '_loan_calculator';
        $class::get_instance()->calculator();
    }

    public function enqueue_essentials(){
        wp_enqueue_script(
            'common_js',
            LC_PLUGIN_MAIN_URL . 'common/common.js',
            ['jquery'],
            null,
            true
        );
    }
}

add_action('plugins_loaded', ['Loan_calculator', 'get_instance']);