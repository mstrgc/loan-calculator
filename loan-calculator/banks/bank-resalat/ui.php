<div id="resalat_container_wrapper">
    <div id="resalat_container">
        <form id="resalat_form">
            <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
            <div id="resalat_calc_type">
                <label for="price">
                    <input name="calc_type" type="radio" value="price" id="price" checked>مبلغ وام
                </label>
                <label for="deposit">
                    <input name="calc_type" type="radio" value="deposit" id="deposit">مبلغ سپرده
                </label>
                <label for="deposit_duration">
                    <input name="calc_type" type="radio" value="deposit_duration" id="deposit_duration">زمان نگهداشت سپرده
                </label>
                <label for="payment">
                    <input name="calc_type" type="radio" value="payment" id="payment">تعداد اقساط
                </label>
            </div>
            <div id="resalat_form_inputs"></div>
            <div class="resalat_results">
                <p id="resalat_result_desc"></p>
                <p id="resalat_result_text"></p>
            </div>
        </form>
    </div>
</div>
<template id="price_form">
    <label for=""><input type="text" name="input1" value="1000000">مبلغ سپرده</label>
    <label for=""><input type="text" name="input2" value="6">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text" name="input3" value="12">تعداد اقساط </label>
</template>
<template id="deposit_form">
    <label for=""><input type="text" name="input1" value="1000000">مبلغ وام</label>
    <label for=""><input type="text" name="input2" value="6">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text" name="input3" value="12">تعداد اقساط </label>
</template>
<template id="deposit_duration_form">
    <label for=""><input type="text" name="input1" value="1000000">مبلغ وام</label>
    <label for=""><input type="text" name="input2" value="1000000">مبلغ سپرده</label>
    <label for=""><input type="text" name="input3" value="12">تعداد اقساط </label>
</template>
<template id="payment_form">
    <label for=""><input type="text" name="input1" value="1000000">مبلغ وام</label>
    <label for=""><input type="text" name="input2" value="6">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text" name="input3" value="1000000">مبلغ سپرده</label>
</template>