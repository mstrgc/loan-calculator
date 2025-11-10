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

    public function calculator(){
        try{
            if(!isset($_POST['loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['loan_calculator_nonce_field'], 'loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                $inputs = [
                    'input1' => filter_input(INPUT_POST, 'input1', FILTER_VALIDATE_INT),
                    'input2' => filter_input(INPUT_POST, 'input2', FILTER_VALIDATE_INT),
                    'input3' => filter_input(INPUT_POST, 'input3', FILTER_VALIDATE_INT),
                ];

                $calc_type = sanitize_text_field($_POST['calc_type']);
                $result = $this->$calc_type($inputs);
                return wp_send_json_success($result);
            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function price(array $inputs){
        return ($inputs['input1'] * $inputs['input2'] * 2) / $inputs['input3'];
    }

    public function deposit(array $inputs){
        return ($inputs['input1'] * $inputs['input3']) / ($inputs['input2'] * 2);
    }

    public function deposit_duration(array $inputs){
        return ($inputs['input1'] * $inputs['input3']) / ($inputs['input2'] * 2);
    }

    public function payment(array $inputs){
        return $inputs['input3'] * ($inputs['input2'] * 2) / $inputs['input1'];
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

        wp_localize_script(
            'melli_config',
            'loan_config_variables',
            ['admin_ajax_url' => admin_url('admin-ajax.php')]
        );
    }
}