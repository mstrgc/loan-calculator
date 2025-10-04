<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field() ?>
        <div class="loan-calculator-section1">
            <label for="average">میانگین</label>
            <input type="radio" name="loan_or_average" value="average" id="average" checked>
            <br>
            <label for="loan">وام</label>
            <input type="radio" name="loan_or_average" value="loan" id="loan">
            <br>
            <label for="price">مبلغ</label>
            <input type="text" name="display_price" id="display_price" value="۱,۰۰۰,۰۰۰">
        </div>
        <div class="loan_calculator_section2">
            <label for="date">مدت زمان</label>
            <input type="range" name="date" id="date" min="6" max="60" step="6" value="6">
            <br>
            <label for="time">مدت زمان واریز به حساب</label>
            <input type="range" name="time" id="time" min="1" max="12" value="1">
            <br>
            <label for="fee">کارمزد</label>
            <label><input type="radio" name="fee" value="0" checked>۰%</label>
            <label><input type="radio" name="fee" value="2">۲%</label>
            <label><input type="radio" name="fee" value="4">۴%</label>
        </div>
    </form>
    <div class="loan_calculator_section3">
    <p id="result"></p>
    </div>
</div>