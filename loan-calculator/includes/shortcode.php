<?php

if(!defined('ABSPATH')){
    exit;
}

require_once plugin_dir_path(__FILE__) . 'bank-melli/calculator.php';
require_once plugin_dir_path(__FILE__) . 'bank-mehr/calculator.php';

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_essentials']);
    }

    
}