<?php

if(!defined('ABSPATH')){
    exit;
}

class Melli_loan_calculator{

    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        add_action('wp_ajax_nopriv_melli_calculator', [$this, 'melli_calculator']);
        add_action('wp_ajax_melli_calculator', [$this, 'melli_calculator']);
    }

    public function enqueue(){
        require_once plugin_dir_path(__FILE__) . 'enqueue.php';
        $styles =  new Melli_script_enqueue();
        return $styles->enqueue_assets();
    }

    public function melli_calculator() {
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

                $allowed_inputs = [
                    'date' => [6, 12, 18, 24, 30, 36, 42, 48, 54, 60],
                    'time' => range(1, 12),
                    'fee' => [0, 2, 4]
                ];

                foreach($int_inputs as $name => $value) {
                    if($name == 'price'){
                        if(!is_int($value)){
                            throw new Calculator_exception('مبلغ باید شامل اعداد باشد', '$price type validation failed');
                        } elseif($int_inputs['price'] < 1000000) {
                            wp_send_json_error(['message' => 'مبلغ نمی تواند از ۱ میلیون تومان کمتر باشد', 'status' => 'error']);
                        }
                    } else {
                        if(!in_array($value, $allowed_inputs[$name])){
                            throw new Calculator_exception('ورودی نامعتبر', 'input validation failed. input: ' . $name);
                        };
                    }
                };

                $int_inputs['time'] -= 1;
                $this->include_factor();

                if(!isset($this->factor) || !is_array($this->factor)){
                    throw new Calculator_exception('خطا در محاسبه تسهیلات', 'factor is not available');
                }

                //check which value to calculate
                if($loan_or_average == 'average'){
                    $calculated_result = $this->average_to_loan_calculator($int_inputs);
                } elseif($loan_or_average == 'loan'){
                    $calculated_result = $this->loan_to_average_calculator($int_inputs);
                } else {
                    throw new Calculator_exception('تسهیلات درخواستی یا میانگین حساب را انتخاب کنید', 'invalid loan_average input: ' . $loan_or_average);
                }

                if(filter_var($calculated_result, FILTER_VALIDATE_INT)){
                    wp_send_json_success(['message' => $calculated_result, 'status' => 'success']);
                } else {
                    wp_send_json_error(['message' => 'نتیجه نامعتبر', 'status' => 'error']);
                }

            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function average_to_loan_calculator($inputs){
        //get factor percent and calculate loan
        if($this->factor[$inputs['fee']][$inputs['date']][$inputs['time']]){
            $factor = $this->factor[$inputs['fee']][$inputs['date']][$inputs['time']];
            $loan = ($inputs['price'] * $factor) / 100;
        } else {
            wp_send_json_error(['message' => 'خطا در مقدار ورودی', 'status' => 'error']);
        }

        return intval($loan);
    }

    public function loan_to_average_calculator($inputs){
        //get factor percent and calculate average
        if($this->factor[$inputs['fee']][$inputs['date']][$inputs['time']]){
            $factor = $this->factor[$inputs['fee']][$inputs['date']][$inputs['time']];
            $average = ($inputs['price'] / $factor) * 100;
        } else {
            wp_send_json_error(['message' => 'خطا در مقدار ورودی', 'status' => 'error']);
        }

        return intval($average);
    }

    public function render(){
        $this->enqueue();

        //render page
        ob_start();
        include_once plugin_dir_path(__FILE__) . '../../templates/bank-melli-ui.php';
        return ob_get_clean();
    }

    public function include_factor(){
        //add factor data
        $factor_file = plugin_dir_path(__FILE__) . 'mellibank-factor-data.php';
        try{
            if(!file_exists($factor_file)){
                throw new Exception('factor data is not found');
            }

            $data = include_once $factor_file;
            
            if(!is_array($data)){
                throw new Exception('factor data has invalid data type');
            }

            $this->factor = $data;

        } catch(Exception $error){
            error_log($error->getMessage());
        }
    }
}

add_action('plugins_loaded', ['Melli_loan_calculator', 'get_instance']);