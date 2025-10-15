<?php

if(!defined('ABSPATH')){
    exit;
}

class Calculator_exception extends Exception{
    protected $user_error = '';

    public function __construct(string $user_error, string $logMessage = '', int $code = 0, Throwable $previous = null) {
        parent::__construct($logMessage ?: '', $code, $previous);
        $this->user_error = $user_error;
    }

    public function get_error(){
        return $this->user_error;
    }
}