<?php

if(!defined('ABSPATH')){
    exit;
}

class Resalat_loan_calculator{
    private static $instance = null;
    private static $is_enqueued = false;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function calculator(){
        try{
            if(!isset($_POST['loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['loan_calculator_nonce_field'], 'loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
                $deposit_duration = filter_input(INPUT_POST, 'deposit_duration', FILTER_VALIDATE_INT);
                $payment = filter_input(INPUT_POST, 'payment', FILTER_VALIDATE_INT);
                $result = ($price * $payment) / ($deposit_duration * 2);
                return wp_send_json_success(intval($result));
            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function render(){
        $this->enqueue_assets();
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-resalat/ui.php';
        return ob_get_clean();
    }

    public function enqueue_assets(){
        if(self::$is_enqueued) return;
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
        self::$is_enqueued = true;
    }
}