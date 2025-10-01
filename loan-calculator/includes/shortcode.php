<?php

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
        ]
    ];

    public function calculator() {
        $price = $_POST['price'];
        $date = $_POST['date'];
        $time = $_POST['time'] - 1;
        $fee = $_POST['fee'];

        $result = $this->loan_to_average_calculator($price, $date, $time, $fee);
        echo $result;
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
        ?>
            <div>
                <form id="loan_form">
                    <input type="radio" name="loan_or_average" value="average" id="average" checked>
                    <label for="average">میانگین</label>
                    <br>
                    <input type="radio" name="loan_or_average" value="loan" id="loan">
                    <label for="loan">وام</label>
                    <br>
                    <input type="text" name="price" id="average">
                    <label for="average">میانگین سرمایه</label>
                    <br>
                    <input type="number" name="date" id="date" min="6" max="60" step="6">
                    <label for="date">مدت زمان</label>
                    <br>
                    <input type="number" name="time" id="time" min="1" max="12">
                    <label for="time">مدت زمان واریز به حساب</label>
                    <br>
                    <input type="number" name="fee" id="fee" min="0" max="4" step="2">
                    <label for="fee">کارمزد</label>
                    <br>
                    <button type="button" id="loan_form_submit">محاسبه</button>
                </form>
                <p id="result"></p>
            </div>
            <script>
                const text_result = document.getElementById('result');

                function calculate() {
                    let loan_form = document.getElementById('loan_form');
                    let loan_form_data = new FormData(loan_form);

                    loan_form_data.append('action', 'calculator');

                    fetch("<?= admin_url('admin-ajax.php') ?>", {method: 'post', body: loan_form_data})
                    .then(response => response.text())
                    .then(result => {text_result.innerHTML = result;});
                }

                document.getElementById('loan_form_submit').addEventListener('click', calculate);
            </script>
        <?php
        return ob_get_clean();
    }
}