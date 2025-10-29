<div id="mehr_loan_container_wrapper">
    <div id="mehr_loan_calculator_container">
        <div class="mehr_loan_form_container">
            <form id="mehr_loan_form">
                <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
                <div class="input_container">
                    <div class="input_title">
                        <label for="mehr_price">مبلغ تسهیلات</label>
                        <p><span id="mehr_price_indicator">۲۰,۰۰۰,۰۰۰</span> ریال</p>
                    </div>
                    <input type="range" name="mehr_price" id="mehr_price" min="20000000" max="4000000000" step="5000000" value="20000000" oninput="sync_label('mehr_price')">
                    <div class="input_span">
                        <span>۲۰,۰۰۰,۰۰۰</span>
                        <span>۴,۰۰۰,۰۰۰,۰۰۰</span>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_title">
                        <label for="mehr_payment">تعداد اقساط</label>
                        <p><span id="mehr_payment_indicator">۲۴</span> عدد</p>
                    </div>
                    <input type="range" name="mehr_payment" id="mehr_payment" min="24" max="60" step="2" value="24" oninput="sync_label('mehr_payment')">
                    <div class="input_span">
                        <span>۲۴</span>
                        <span>۶۰</span>
                    </div>
                </div>
                <div class="input_container">
                    <div class="input_title">
                        <label for="mehr_debt_price">حداکثر توانایی باز پرداخت</label>
                        <p><span id="mehr_debt_price_indicator">۱,۰۰۰,۰۰۰</span> ریال</p>
                    </div>
                    <input type="range" name="mehr_debt_price" id="mehr_debt_price" min="1000000" max="500000000" step="500000" value="1000000" oninput="sync_label('mehr_debt_price')">
                    <div class="input_span">
                        <span>۱,۰۰۰,۰۰۰</span>
                        <span>۵۰۰,۰۰۰,۰۰۰</span>
                    </div>
                </div>
                <div class="input_container">
                    <label for="fee">انتخاب كارمزد</label>
                    <div class="fee_radio_input">
                        <label for="mehr_fee"><input type="radio" name="mehr_fee" value="0" checked>۰ درصد</label>
                        <label for="mehr_fee"><input type="radio" name="mehr_fee" value="1">۱ درصد</label>
                        <label for="mehr_fee"><input type="radio" name="mehr_fee" value="2">۲ درصد</label>
                        <label for="mehr_fee"><input type="radio" name="mehr_fee" value="3">۳ درصد</label>
                        <label for="mehr_fee"><input type="radio" name="mehr_fee" value="4">۴ درصد</label>
                    </div>
                </div>
                <button id="mehr_submit_button" type="button">محاسبه</button>
            </form>
        </div>
        <div class="mehr_loan_result_container">
            <table id="loan_result_table">
                <thead>
                    <tr>
                        <th>مدت ماه انتظار</th>
                        <th>معدل حساب</th>
                        <th>شرح تسهیلات</th>
                    </tr>
                </thead>
                <tbody id="mehr_result_tbody">
                </tbody>
            </table>
            <p id="error_text">موردی وارد نشده است</p>
        </div>
    </div>
</div>