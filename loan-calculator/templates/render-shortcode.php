<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field() ?>
        <div class="loan_calculator_section1">
            <div class="section1_select">
                <div class="section1_select_option">
                    <label class="loan_radio_label" for="average">میانگین حساب</label>
                    <input class="loan_radio_input" type="radio" name="loan_or_average" value="average" id="average" checked>
                </div>
                <div class="section1_select_option">
                    <label class="loan_radio_label" for="loan">تسهیلات درخواستی</label>
                    <input class="loan_radio_input" type="radio" name="loan_or_average" value="loan" id="loan">
                </div>
            </div>
            <label for="price">مبلغ (تومان):</label>
            <input type="text" name="display_price" id="display_price" value="۱,۰۰۰,۰۰۰">
        </div>
        <div class="loan_calculator_section2">
            <label for="fee">کارمزد</label>
            <br>
            <label class="loan_radio_label"><input class="loan_radio_input" type="radio" name="fee" value="0" checked>۰%</label>
            <label class="loan_radio_label"><input class="loan_radio_input" type="radio" name="fee" value="2">۲%</label>
            <label class="loan_radio_label"><input class="loan_radio_input" type="radio" name="fee" value="4">۴%</label>
            <br>
            <label for="date">مدت زمان</label>
            <input type="range" name="date" id="date" min="6" max="60" step="6" value="6">
            <br>
            <label for="time">مدت زمان واریز به حساب</label>
            <input type="range" name="time" id="time" min="1" max="12" value="1">
        </div>
        <div class="loan_calculator_section3">
            <p id="result"></p>
        </div>
    </form>
</div>