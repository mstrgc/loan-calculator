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
            if(!isset($_POST['loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['loan_calculator_nonce_field'], 'loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                $inputs = [
                    'price' => filter_input(INPUT_POST, 'mehr_price', FILTER_VALIDATE_INT),
                    'payment' => filter_input(INPUT_POST, 'mehr_payment', FILTER_VALIDATE_INT),
                    'debt_price' => filter_input(INPUT_POST, 'mehr_debt_price', FILTER_VALIDATE_INT),
                    'fee' => filter_input(INPUT_POST, 'mehr_fee', FILTER_VALIDATE_INT)
                ];

                $this->include_data();

                $data = $this->bank_data;

                foreach($inputs as $name => $value) {
                    if($name == 'price' || 'debt_price'){
                        if(!is_int($value)){
                            wp_send_json_error(['message' => 'مبلغ باید شامل اعداد باشد']);
                        }
                    } else {
                        if(!in_array($value, $data['allowed_inputs'][$name])){
                            wp_send_json_error(['message' => 'ورودی نامعتبر']);
                        };
                    }
                };

                $deposit = $this->average_deposit($inputs);
                $payment = $this->payment_calculator($inputs);
                wp_send_json_success(['deposit' => $deposit, 'payment' => $payment]);

            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function average_deposit($input){
        $this->include_data();
        $data = $this->bank_data;

        $result = [];

        $factors = $data['factors'][$input['fee']][$input['payment']];

        foreach($factors as $factor){
            $deposit = ($input['price'] / $factor) * 100;
            $result[] = intval($deposit / 1000000) * 1000000;
        }

        return $result;
    }

    public function payment_calculator($input){
        $price = $input['price'];
        $debt_price = $input['debt_price'];
        $payment = $input['payment'];

        $result = (round(((($price / $payment) * 109.1) / 100) / 100000)) * 100000;
        return $result;
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

    public function include_data(){
        //add factor data
        $data_file = plugin_dir_path(__FILE__) . 'data.php';
        try{
            if(!file_exists($data_file)){
                throw new Exception('factor data is not found');
            }

            $data = include_once $data_file;

            if(!is_array($data)){
                throw new Exception('factor data has invalid data type');
            }
            
            $this->bank_data = $data;

        } catch(Exception $error){
            error_log($error->getMessage());
        }
    }
}

add_action('plugins_loaded', ['Mehr_loan_calculator', 'get_instance']);