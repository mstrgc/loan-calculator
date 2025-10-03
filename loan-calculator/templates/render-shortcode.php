<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field() ?>
        <input type="radio" name="loan_or_average" value="average" id="average" checked>
        <label for="average">میانگین</label>
        <br>
        <input type="radio" name="loan_or_average" value="loan" id="loan">
        <label for="loan">وام</label>
        <br>
        <input type="text" name="price" id="price" value="1000000">
        <label for="price">مبلغ</label>
        <br>
        <input type="range" name="date" id="date" min="6" max="60" step="6" value="6">
        <label for="date">مدت زمان</label>
        <br>
        <input type="range" name="time" id="time" min="1" max="12" value="1">
        <label for="time">مدت زمان واریز به حساب</label>
        <br>
        <label><input type="radio" name="fee" value="0" checked>0%</label>
        <label><input type="radio" name="fee" value="2">2%</label>
        <label><input type="radio" name="fee" value="4">4%</label>
        <label for="fee">کارمزد</label>
    </form>
    <p id="result"></p>
</div>