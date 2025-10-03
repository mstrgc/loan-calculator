<?php

if(!defined('ABSPATH')){
    exit;
}
class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
        add_action('wp_ajax_nopriv_calculator', [$this, 'calculator']);
        add_action('wp_ajax_calculator', [$this, 'calculator']);
    }

    public static $factor = [
        '0' => [
            '6' => [22, 44, 66.5, 88.5, 110.5, 132.5, 154.5, 176.5, 198, 220, 242, 264],
            '12' => [12.5, 25, 37.5, 50, 62, 74.5, 87, 99.5, 112, 124, 136.5, 149],
            '18' => [8.5, 17.5, 26, 35, 44, 52.5, 61.5, 70, 79, 88, 96, 105],
            '24' => [6.5, 13, 19.5, 26, 32.5, 39, 45.5, 52, 58.5, 65, 71.5, 78],
            '30' => [5, 10.5, 16, 21, 26.5, 32, 37, 42.5, 48, 53, 58.5, 63.5],
            '36' => [4, 8.5, 13, 17.5, 21.5, 26, 30.5, 35, 39, 43.5, 48, 52],
            '42' => [3.5, 7.5, 11, 15, 18, 22.5, 26, 30, 33.5, 37.5, 41, 45],
            '48' => [3, 6.5, 9.5, 13, 16, 19.5, 22.5, 26, 29, 32, 35.5, 38.5],
            '54' => [2.5, 5.5, 8.5, 11.5, 14.5, 17, 20, 23, 25.5, 28.5, 31.5, 34.5],
            '60' => [2, 5, 7.5, 10, 12.5, 15, 17.5, 20, 22.5, 25.5, 28, 30.5]
        ],
        '2' => [
            '6' => [26, 52, 78, 104, 130, 156, 182, 208, 234, 260, 286, 312],
            '12' => [17.5, 34.5, 52, 69.5, 86.5, 104, 121.5, 138.5, 156, 173.5, 190.5, 208],
            '18' => [11.5, 23, 34.5, 46, 58, 69.5, 81, 92.5, 104, 115.5, 127, 138.5],
            '24' => [8.5, 17.5, 26, 34.5, 43.5, 52, 60.5, 69.5, 78, 86.5, 95.5, 104],
            '30' => [7, 14, 21, 27.5, 34.5, 41.5, 48.5, 55.5, 62.5, 69.5, 76.5, 83],
            '36' => [6, 11.5, 17.5, 23, 29, 34.5, 40.5, 46, 52, 58, 63.5, 69.5],
            '42' => [5, 10, 15, 20, 25, 29.5, 34.5, 39.5, 44.5, 49.5, 54.5, 59.5],
            '48' => [4.5, 8.5, 13, 17.5, 21.5, 26, 30.5, 34.5, 39, 43.5, 47.5, 52],
            '54' => [4, 7.5, 11.5, 15.5, 19.5, 23, 27, 31, 34.5, 38.5, 42.5, 46],
            '60' => [3.5, 7, 10.5, 14, 17.5, 21, 24.5, 27.5, 31, 34.5, 38, 41.5]
        ],
        '4' => [
            '6' => [40, 70, 100, 130, 160, 190, 220, 250, 280, 310, 340, 370],
            '12' => [26, 52, 78, 104, 130, 156, 182, 208, 234, 260, 286, 312],
            '18' => [18, 35, 52, 70, 87, 104, 122, 139, 156, 174, 191, 208],
            '24' => [13, 26, 39, 52, 65, 78, 91, 104, 117, 130, 143, 156],
            '30' => [11, 21, 32, 42, 52, 63, 73, 84, 94, 104, 115, 125],
            '36' => [9, 18, 26, 35, 44, 52, 61, 70, 78, 87, 96, 104],
            '42' => [8, 15, 23, 30, 38, 45, 52, 60, 67, 75, 82, 90],
            '48' => [7, 13, 20, 26, 33, 39, 46, 52, 59, 65, 72, 78],
            '54' => [6, 12, 18, 24, 29, 35, 41, 47, 52, 58, 64, 70],
            '60' => [5, 10, 16, 21, 26, 32, 37, 42, 47, 52, 58, 63]
        ],
    ];

    public function calculator() {
        if(isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'])){
            $loan_or_average = sanitize_text_field($_POST['loan_or_average']);
            $price = sanitize_text_field($_POST['price']);
            $date = sanitize_text_field($_POST['date']);
            $time = sanitize_text_field($_POST['time']) - 1;
            $fee = sanitize_text_field($_POST['fee']);

            if($price < 1000000){
                echo json_encode($result = ['message' =>'مبلغ نمی تواند از 1 میلیون تومان کمتر باشد', 'status' => 'error']);
                wp_die();
            }

            if($loan_or_average == 'average'){
                $result = $this->average_to_loan_calculator($price, $date, $time, $fee);
            } elseif($loan_or_average == 'loan'){
                $result = $this->loan_to_average_calculator($price, $date, $time, $fee);
            }

            echo json_encode($result = ['message' => $result, 'status' => 'success']);
        }
        wp_die();
    }

    public function average_to_loan_calculator($price, $date, $time, $fee): int{
        $factor = self::$factor[$fee][$date][$time];
        $loan = ($price * $factor) / 100;

        return $loan;
    }

    public function loan_to_average_calculator($price, $date, $time, $fee): int{
        $factor = self::$factor[$fee][$date][$time];
        $average = ($price / $factor) * 100;

        return $average;
    }

    public function render_loan_calculator(){
        ob_start();
        include plugin_dir_path(__FILE__) . '../templates/render-shortcode.php';
        return ob_get_clean();
    }
}