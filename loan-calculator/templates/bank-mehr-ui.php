<div id="loan_calculator_container">
    <div class="loan_form_container">
        <form id="loan_form">
            <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
            <div class="input_container">
                <div class="input_title">
                    <label for="mehr_price">مبلغ تسهیلات</label>
                    <p>20,000,000 ریال</p>
                </div>
                <input type="range" name="mehr_price" id="mehr_price" min="20000000" max="4000000000" step="5000000" value="20000000">
                <div class="input_span">
                    <span>20,000,000</span>
                    <span>4,000,000,000</span>
                </div>
            </div>
            <div class="input_container">
                <div class="input_title">
                    <label for="mehr_payment">تعداد اقساط</label>
                    <p>24 عدد</p>
                </div>
                <input type="range" name="mehr_payment" id="mehr_payment" min="24" max="60" step="6" value="24">
                <div class="input_span">
                    <span>24</span>
                    <span>60</span>
                </div>
            </div>
            <div class="input_container">
                <div class="input_title">
                    <label for="mehr_debt_price">حداکثر توانایی باز پرداخت</label>
                    <p>1,000,000 ریال</p>
                </div>
                <input type="range" name="mehr_debt_price" id="mehr_debt_price" min="1000000" max="500000000" step="5000000" value="1000000">
                <div class="input_span">
                    <span>1,000,000</span>
                    <span>500,000,000</span>
                </div>
            </div>
            <label for="fee">انتخاب كارمزد</label>
            <div class="fee_radio_input">
                <label for="mehr_fee"><input type="radio" name="mehr_fee" value="0" checked>۰ درصد</label>
                <label for="mehr_fee"><input type="radio" name="mehr_fee" value="1">1 درصد</label>
                <label for="mehr_fee"><input type="radio" name="mehr_fee" value="2">۲ درصد</label>
                <label for="mehr_fee"><input type="radio" name="mehr_fee" value="3">3 درصد</label>
                <label for="mehr_fee"><input type="radio" name="mehr_fee" value="4">۴ درصد</label>
            </div>
            <button id="mehr_submit_button" type="button">محاسبه</button>
        </form>
    </div>
    <div class="loan_result_container">
        <table id="loan_result_table">
            <thead>
                <th>مدت ماه انتظار</th>
                <th>معدل حساب</th>
                <th>شرح تسهیلات</th>
            </thead>
            <tbody id="mehr_result_tbody">
                <span id="mehr_placeholder">موردی وارد نشده است</span>
            </tbody>
        </table>
    </div>
</div>