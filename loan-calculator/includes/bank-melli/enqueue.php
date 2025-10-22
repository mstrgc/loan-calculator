<?php

if(!defined('ABSPATH')){
    exit;
}

class Melli_script_enqueue{

    public function __construct(){
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    public function enqueue_assets(){
        wp_enqueue_style(
            'style',
            plugin_dir_url(__FILE__) . '../../assets/bank-melli/css/style.css'
        );

        wp_enqueue_script(
            'loan_form',
            plugin_dir_url(__FILE__) . '../../assets/bank-melli/js/form.js',
            [],
            null,
            true
        );

        wp_enqueue_script(
            'loan_config',
            plugin_dir_url(__FILE__) . '../../assets/bank-melli/js/config.js',
            ['loan_form', 'jquery'],
            null,
            true
        );

        wp_localize_script('loan_config', 'loan_config_variables',
            ['admin_ajax_url' => admin_url('admin-ajax.php')]
        );
    }
}