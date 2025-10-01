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
                    <input type="text" name="average" id="average">
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
                    <button type="button" id="loan_form_submit">محاسبه</button>
                </form>
                <p id="result"></p>
            </div>
            <script>
                const presult = document.getElementById('result');

                function calculate() {
                    let loan_form = document.getElementById('loan_form');
                    let loan_form_data = new FormData(loan_form);

                    fetch("", {method: 'post', body: loan_form_data})

                    .then(response => response.text())
                    .then(result => {console.log(result);
                    });
                }

                document.getElementById('loan_form_submit').addEventListener('click', calculate);
            </script>
        <?php
        return ob_get_clean();
    }
}