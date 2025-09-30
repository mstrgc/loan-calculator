<?php

/**
 * Plugin Name: Loan Calculator
 * Version: 1.0.0
 */

if(!defined('ABSPATH')){
    exit;
}
class Loan_calculator{
    private static $instance = null;

    public static function get_instance() {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }
}