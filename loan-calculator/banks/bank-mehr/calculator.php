<?php

if(!defined('ABSPATH')){
    exit;
}

require_once LC_PLUGIN_MAIN_PATH . 'banks/bank-mehr/data.php';
class Mehr_loan_calculator{
    private static $instance = null;
    private static $is_enqueued = false;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        $this->data = new Mehr_data();
    }

    public function calculator() {
        try{
            if(!isset($_POST['mehr_loan_calculator_nonce_field']) || !wp_verify_nonce($_POST['mehr_loan_calculator_nonce_field'], 'mehr_loan_calculator_nonce')){
                throw new Calculator_exception('خطا در تایید فرم', 'nonce validation failed');
            } else {
                $inputs = [
                    'price' => filter_input(INPUT_POST, 'mehr_price', FILTER_VALIDATE_INT),
                    'payment' => filter_input(INPUT_POST, 'mehr_payment', FILTER_VALIDATE_INT),
                    'debt_price' => filter_input(INPUT_POST, 'mehr_debt_price', FILTER_VALIDATE_INT),
                    'fee' => filter_input(INPUT_POST, 'mehr_fee', FILTER_VALIDATE_INT)
                ];

                $allowed_inputs = $this->data->get_allowed_inputs();
                    
                foreach($inputs as $name => $value) {
                    if($name == 'price' || 'debt_price'){
                        if(!is_int($value)){
                            wp_send_json_error(['message' => 'مبلغ باید شامل اعداد باشد']);
                        }
                    } else {
                        if(!in_array($value, $allowed_inputs[$name])){
                            wp_send_json_error(['message' => 'ورودی نامعتبر']);
                        };
                    }
                };

                //notice: 0, 1 and 2, 3 fee factors are equal
                $inputs['fee'] = $inputs['fee'] % 2 != 0 ? $inputs['fee'] -= 1 : $inputs['fee'];

                $deposit = $this->average_deposit($inputs);
                $payment = $this->payment_calculator($inputs);

                if(!$payment){
                    wp_send_json_error(['message' => 'وامی با این شرایط موجود نیست']);
                } elseif(!$deposit){
                    throw new Calculator_exception('خطا در دریافت اطلاعات', 'could not reterive mehr bank factor data');
                }
                
                wp_send_json_success(['deposit' => $deposit, 'payment' => $payment]);
            }
        } catch (Calculator_exception $error) {
            error_log('Loan calculator plugin error: ' . $error->getMessage());
            wp_send_json_error(['message' => $error->get_error()]);
        };
        wp_die();
    }

    public function average_deposit($input){
        $data = $this->data->get_factors();
        $result = [];

        if($data[$input['fee']][$input['payment']]){
            $factors = $data[$input['fee']][$input['payment']];

            foreach($factors as $factor){
                $deposit = ($input['price'] / $factor) * 100;
                $result[] = intval($deposit / 1000000) * 1000000;
            }
        } else{
            return false;
        }

        return $result;
    }

    public function payment_calculator($input){
        $price = $input['price'];
        $debt_price = $input['debt_price'];
        $payment = $input['payment'];

        //get maximum payment price
        $result = (ceil((($price / $payment)) / 100000)) * 100000;

        if($result > $debt_price){
            return false;
        }
        
        return $result;
    }

    public function render(){   
        $this->enqueue_assets();     
        ob_start();
        include_once LC_PLUGIN_MAIN_PATH . 'banks/bank-mehr/ui.php';
        return ob_get_clean();
    }

    public function enqueue_assets(){
        if(self::$is_enqueued) return;
        wp_enqueue_style(
            'mehr_style',
            LC_PLUGIN_MAIN_URL . 'banks/bank-mehr/assets/mehr-style.css'
        );

        wp_enqueue_script(
            'mehr_config',
            LC_PLUGIN_MAIN_URL . 'banks/bank-mehr/assets/mehr-config.js',
            [],
            null,
            true
        );

        wp_localize_script(
            'mehr_config',
            'loan_config_variables',
            ['admin_ajax_url' => admin_url('admin-ajax.php')]
        );
        self::$is_enqueued = true;
    }
}