<?php

if(!defined('ABSPATH')){
    exit;
}

require_once LC_PLUGIN_MAIN_PATH . 'banks/bank-melli/data.php';

class Melli_loan_calculator{

    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        $this->data = new Melli_data();
    }

    public function calculator() {
        try{
            //validate nonce
            if(!isset($_POST['loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['loan_calculator_nonce_field'], 'loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                //get form values
                $loan_or_average = sanitize_text_field($_POST['loan_or_average']);
                $int_inputs = [
                    'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT),
                    'date' => filter_input(INPUT_POST, 'date', FILTER_VALIDATE_INT),
                    'time' => filter_input(INPUT_POST, 'time', FILTER_VALIDATE_INT),
                    'fee' => filter_input(INPUT_POST, 'fee', FILTER_VALIDATE_INT)
                ];

                $allowed_inputs = $this->data->get_allowed_inputs();

                foreach($int_inputs as $name => $value) {
                    if($name == 'price'){
                        if(!is_int($value)){
                            throw new Calculator_exception('مبلغ باید شامل اعداد باشد', '$price type validation failed');
                        } elseif($int_inputs['price'] < 1000000) {
                            wp_send_json_error(['message' => 'مبلغ نمی تواند از ۱ میلیون تومان کمتر باشد']);
                        }
                    } else {
                        if(!in_array($value, $allowed_inputs[$name])){
                            throw new Calculator_exception('ورودی نامعتبر', 'input validation failed. input: ' . $name);
                        };
                    }
                };

                $int_inputs['time'] -= 1;

                //check which value to calculate
                if($loan_or_average == 'average'){
                    $calculated_result = $this->average_to_loan_calculator($int_inputs);
                } elseif($loan_or_average == 'loan'){
                    $calculated_result = $this->loan_to_average_calculator($int_inputs);
                } else {
                    throw new Calculator_exception('تسهیلات درخواستی یا میانگین حساب را انتخاب کنید', 'invalid loan_average input: ' . $loan_or_average);
                }

                if(!filter_var($calculated_result, FILTER_VALIDATE_INT)){
                    wp_send_json_error(['message' => 'نتیجه نامعتبر']); 
                }

                wp_send_json_success(['message' => $calculated_result]);
            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function average_to_loan_calculator($inputs){
        $data = $this->data->get_factors();
        //get factor percent and calculate loan
        if($data[$inputs['fee']][$inputs['date']][$inputs['time']]){
            $factor = $data[$inputs['fee']][$inputs['date']][$inputs['time']];
            error_log($factor);
            $loan = ($inputs['price'] * $factor) / 100;
        } else {
            wp_send_json_error(['message' => 'خطا در مقدار ورودی', 'status' => 'error']);
        }

        return intval($loan);
    }

    public function loan_to_average_calculator($inputs){
        $data = $this->data->get_factors();
        //get factor percent and calculate average
        if($data[$inputs['fee']][$inputs['date']][$inputs['time']]){
            $factor = $data[$inputs['fee']][$inputs['date']][$inputs['time']];
            error_log($factor);
            $average = ($inputs['price'] / $factor) * 100;
        } else {
            wp_send_json_error(['message' => 'خطا در مقدار ورودی', 'status' => 'error']);
        }

        return intval($average);
    }

    public function render(){
        //render page
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-melli/ui.php';
        return ob_get_clean();
    }

    public function enqueue_assets(){
        wp_enqueue_style(
            'melli_style',
            LC_PLUGIN_MAIN_URL . 'banks/bank-melli/assets/melli-style.css'
        );

        wp_enqueue_script(
            'melli_config',
            LC_PLUGIN_MAIN_URL . 'banks/bank-melli/assets/melli-config.js',
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