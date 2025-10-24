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
            ['jquery'],
            null,
            true
        );

        wp_localize_script(
            'loan_config',
            'loan_config_variables',
            ['admin_ajax_url' => admin_url('admin-ajax.php')]
        );
    }
}