<?php

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator'])
    }
    public function render_loan_calculator(){
        return;
    }
}