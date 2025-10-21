<?php

use BcMath\Number;

if(!defined('ABSPATH')){
    exit;
}

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
    }

    public function render_loan_calculator($parameter){

        $parameters = shortcode_atts(
            ['bank_name' => ''],
            $parameter,
            'Loan_calculator'
        );

        if($parameters['bank_name']="melli"){
            require_once plugin_dir_path(__FILE__) . 'bank-melli/calculator.php';
            new Melli_loan_calculator();
        }
    }
}