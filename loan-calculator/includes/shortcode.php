<?php

class Loan_calculator_shortcode{

    public function __construct(){
        add_shortcode('loan_calculator', [$this, 'render_loan_calculator']);
    }

    public static $fee = [
        '0' => [
            '6' => 22,
            '12' => 12.5,
            '18' => 8.5,
            '24' => 6.5,
            '30' => 5,
            '36' => 4,
            '42' => 3.5,
            '48' => 3,
            '54' => 2.5,
            '60' => 2
        ],
        '2' => [
            '6' => 22,
            '12' => 12.5,
            '18' => 8.5,
            '24' => 6.5,
            '30' => 5,
            '36' => 4,
            '42' => 3.5,
            '48' => 3,
            '54' => 2.5,
            '60' => 2
        ]
    ];

    public function calculator() {
        return '"hello"';
    }

    public function render_loan_calculator(){
        ob_start();
        ?>
            <div>
                <form id="loan_form">
                    <input type="text" id="average">
                    <label for="average">میانگین سرمایه</label>
                    <br>
                    <input type="number" id="date" min="6" max="60" step="6">
                    <label for="date">مدت زمان</label>
                    <br>
                    <input type="number" id="time" min="1" max="12">
                    <label for="time">مدت زمان واریز به حساب</label>
                    <br>
                    <input type="number" id="fee" min="0" max="4" step="2">
                    <label for="fee">کارمزد</label>
                    <button type="submit" onclick="calculate()">محاسبه</button>
                </form>
                <p id="result"></p>
            </div>
            <script>
                const result = document.getElementById('result');

                function calculate() {
                    let loan_form = document.getElementById('loan_form');
                    let loan_form_data = new loan_form_data(loan_form);

                    result.innerHTML = loan_form_data;
                }
            </script>
        <?php
        return ob_get_clean();
    }
}