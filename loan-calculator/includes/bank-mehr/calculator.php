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

    public function mehr_calculator() {
        try{
            //validate nonce
            if(!isset($_POST['loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['loan_calculator_nonce_field'], 'loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                //get form values
                $inputs = [
                    'price' => filter_input(INPUT_POST, 'mehr_price', FILTER_VALIDATE_INT),
                    'payment' => filter_input(INPUT_POST, 'mehr_payment', FILTER_VALIDATE_INT),
                    'debt_price' => filter_input(INPUT_POST, 'mehr_debt_price', FILTER_VALIDATE_INT),
                    'mehr_fee' => filter_input(INPUT_POST, 'mehr_fee', FILTER_VALIDATE_INT)
                ];

            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
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