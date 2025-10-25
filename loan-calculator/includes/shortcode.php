<?php

if(!defined('ABSPATH')){
    exit;
}

require_once plugin_dir_path(__FILE__) . 'bank-melli/calculator.php';
require_once plugin_dir_path(__FILE__) . 'bank-mehr/calculator.php';

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
    }

    public function render_loan_calculator($parameter){

        $parameters = shortcode_atts(
            ['bank_name' => ''],
            $parameter,
            'loan_calculator'
        );

        add_action('wp_enqueue_scripts', [$this, 'enqueue_essentials']);

        if($parameters['bank_name'] == 'melli'){
            return Melli_loan_calculator::get_instance()->render();
        } elseif($parameters['bank_name'] == 'mehr'){
            return Mehr_loan_calculator::get_instance()->render();
        }
    }

    public function enqueue_essentials(){
        wp_enqueue_script(
            'number_converter',
            plugin_dir_url(__FILE__) . '../assets/js/converter.js',
            [],
            null,
            true
        );
    }
}