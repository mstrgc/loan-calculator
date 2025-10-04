<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field() ?>
        <div class="loan_calculator_section1">
            <div class="section_select">
                    <label class="loan_radio_label section_select_option" for="average">
                        میانگین حساب<input class="loan_radio_input" type="radio" name="loan_or_average" value="average" id="average" checked>
                    </label>
                    <label class="loan_radio_label section_select_option" for="loan">
                        <input class="loan_radio_input" type="radio" name="loan_or_average" value="loan" id="loan">تسهیلات درخواستی
                    </label>
            </div>
            <div>
                <label for="price">مبلغ (تومان):</label>
                <input type="text" name="display_price" id="display_price" value="۱,۰۰۰,۰۰۰">
                <p id="error"></p>
            </div>
        </div>
        <div class="loan_calculator_section2">
            <label for="fee">کارمزد تسهیلات:</label>
            <div class="section_select">
                <label class="loan_radio_label section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="0" checked>۰%</label>
                <label class="loan_radio_label section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="2">۲%</label>
                <label class="loan_radio_label section_select_option"><input class="loan_radio_input" type="radio" name="fee" value="4">۴%</label>
            </div>
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