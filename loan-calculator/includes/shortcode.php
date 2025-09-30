<?php

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
    }

    public static $zero_fee = [
        '6' => 22,
        '12' => 12.5,
        '18' => 8.5,
        '24' => 6.5,
        '30' => 5,
        '36' => 4,
        '42' => 3.5,
        '48' => 3,
        '54' => 2.5,
        '60' => 2,
    ];

    public function render_loan_calculator(){
        ob_start();
        ?>
            <form action="">
                <input type="text" id="average">
                <label for="average">میانگین سرمایه</label>
                <br>
                <input type="number" id="date" min="6" max="60" step="6">
                <label for="date">مدت زمان</label>
                <br>
                <input type="number" id="time" min="1" max="12">
                <label for="time">مدت زمان واریز به حساب</label>
            </form>
            <button onclick="calculate()">محاسبه</button>
            <p id="result"></p>
            <script>
                const result = document.getElementById('result');

                function calculate() {
                    const average = document.getElementById('average').value;
                    const date = document.getElementById('date').value;
                    const time = document.getElementById('time').value;
                    const fee_list = <?= json_encode(self::$zero_fee) ?>;
                    let date1 = fee_list[date];

                    result.innerHTML = (average * (date1 * time)) / 100;
                }
            </script>
        <?php
        return ob_get_clean();
    }
}