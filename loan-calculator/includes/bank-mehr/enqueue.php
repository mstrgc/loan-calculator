<?php

if(!defined('ABSPATH')){
    exit;
}

class Mehr_script_enqueue{

    public function __construct(){
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    
    public function enqueue_assets(){
        wp_enqueue_style(
            'style',
            plugin_dir_url(__FILE__) . '../../assets/bank-mehr/css/style.css'
        );

        wp_enqueue_script(
            'loan_config',
            plugin_dir_url(__FILE__) . '../../assets/bank-mehr/js/config.js',
            ['loan_form', 'jquery'],
            null,
            true
        );
    }
}