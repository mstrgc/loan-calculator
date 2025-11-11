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
                $calc_type = sanitize_text_field($_POST['calc_type']);
                $result = $this->$calc_type();
                return wp_send_json_success($result);
            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function price(){
        $deposit = filter_input(INPUT_POST, 'deposit', FILTER_VALIDATE_INT);
        $deposit_duration = filter_input(INPUT_POST, 'deposit_duration', FILTER_VALIDATE_INT);
        $payment = filter_input(INPUT_POST, 'payment', FILTER_VALIDATE_INT);
        return ($deposit * $deposit_duration * 2) / $payment;
    }

    public function deposit(){
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
        $deposit_duration = filter_input(INPUT_POST, 'deposit_duration', FILTER_VALIDATE_INT);
        $payment = filter_input(INPUT_POST, 'payment', FILTER_VALIDATE_INT);
        return ($price * $payment) / ($deposit_duration * 2);
    }

    public function deposit_duration(){
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
        $deposit = filter_input(INPUT_POST, 'deposit', FILTER_VALIDATE_INT);
        $payment = filter_input(INPUT_POST, 'payment', FILTER_VALIDATE_INT);
        return ($price * $payment) / ($deposit * 2);
    }

    public function payment(){
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
        $deposit_duration = filter_input(INPUT_POST, 'deposit_duration', FILTER_VALIDATE_INT);
        $deposit = filter_input(INPUT_POST, 'deposit', FILTER_VALIDATE_INT);
        return $deposit * ($deposit_duration * 2) / $price;
    }

    public function render(){
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-resalat/ui.php';
        return ob_get_clean();
    }

    public function enqueue_assets(){
        wp_enqueue_style(
            'resalat_style',
            LC_PLUGIN_MAIN_URL . 'banks/bank-resalat/assets/resalat-style.css'
        );

        wp_enqueue_script(
            'resalat_config',
            LC_PLUGIN_MAIN_URL . 'banks/bank-resalat/assets/resalat-config.js',
            [],
            null,
            true
        );

        wp_localize_script(
            'resalat_config',
            'loan_config_variables',
            ['admin_ajax_url' => admin_url('admin-ajax.php')]
        );
    }
}