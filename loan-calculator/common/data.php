<?php

if(!defined('ABSPATH')){
    exit;
}

class Data_handler{
    public function __construct($list){
        $this->allowed_input = $list['allowed_input'];
        $this->factors = $list['factors'];
    }

    public function get_allowed_input(){
        return $this->allowed_input;
    }

    public function get_factor(){
        return $this->factors;
    }
}