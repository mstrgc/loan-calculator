<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
        <div class="loan_calculator_section1">
            <div class="section_select">
                <label class="section_select_option" for="loan">
                    <input class="loan_radio_input" type="radio" name="loan_or_average" value="loan" id="loan" checked>تسهیلات درخواستی
                </label>
                <label class="section_select_option" for="average">
                    میانگین حساب<input class="loan_radio_input" type="radio" name="loan_or_average" value="average" id="average">
                </label>
            </div>
            <div>
                <label for="display_price">مبلغ (تومان):</label>
                <input type="text" name="display_price" id="display_price" value="۱,۰۰۰,۰۰۰" maxlength="15">
                <p id="error"></p>
            </div>
        </div>
        <div class="loan_calculator_section2">
            <div>
                <label for="fee">کارمزد تسهیلات:</label>
                <div class="section_select">
                    <label class="section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="0" checked>۰ درصد</label>
                    <label class="section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="2">۲ درصد</label>
                    <label class="section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="4">۴ درصد</label>
                </div>
            </div>
            <div>
                <label for="date">مدت بازپرداخت: <span class="date_span">۶ ماه</span></label>
                <input type="range" class="range_input" name="date" id="date" min="6" max="60" step="6" value="6">
                <div class="loan_range_span">
                    <span>۶</span>
                    <span>۶۰</span>
                </div>
            </div>
            <div>
                <label for="time">مدت زمان واریز به حساب: <span class="time_span">۱ ماه</span></label>
                <input type="range" class="range_input" name="time" id="time" min="1" max="12" value="1">
                <div class="loan_range_span">
                    <span>۱</span>
                    <span>۱۲</span>
                </div>
            </div>
        </div>
        <div class="loan_calculator_section3">
            <div>
                <p class="loan_section3_key">میانگین حساب ~</p>
                <p class="loan_section3_value"><span id="average_result"></span> تومان</p>
            </div>
            <div>
                <p class="loan_section3_key">تسهیلات درخواستی ~</p>
                <p class="loan_section3_value"><span id="loan_result"></span> تومان</p>
            </div>
            <div>
                <p class="loan_section3_key">مبلغ مازاد تسهیلات:</p>
                <p class="loan_section3_value"><span id="surplus_result"></span> تومان</p>
            </div>
            <div>
                <p class="loan_section3_key">کارمزد تسهیلات:</p>
                <p class="loan_section3_value"><span id="fee_result"></span> درصد</p>
            </div>
            <div>
                <p class="loan_section3_key">مدت بازپرداخت :</p>
                <p class="loan_section3_value"><span class="date_span"></span></p>
            </div>
            <div>
                <p class="loan_section3_key">مدت زمان واریز به حساب:</p>
                <p class="loan_section3_value"><span class="time_span"></span></p>
            </div>
        </div>
    </form>
</div>