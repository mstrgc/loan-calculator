<div id="resalat_container_wrapper">
    <div id="resalat_container">
        <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
        <div class="resalat_calc_type">
            <label for="calc_type">
                <input name="calc_type" type="radio" value="price" checked>مبلغ وام
            </label>
            <label for="calc_type">
                <input name="calc_type" type="radio" value="deposit">مبلغ سپرده
            </label>
            <label for="calc_type">
                <input name="calc_type" type="radio" value="deposit_duration">زمان نگهداشت سپرده
            </label>
            <label for="calc_type">
                <input name="calc_type" type="radio" value="payment">تعداد اقساط
            </label>
        </div>
        <div>
            <template>
                <input type="text">
                <input type="text">
                <input type="text">
            </template>
        </div>
    </div>
</div>