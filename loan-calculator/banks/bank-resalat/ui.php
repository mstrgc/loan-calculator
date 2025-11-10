<div id="resalat_container_wrapper">
    <div id="resalat_container">
        <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
        <div id="resalat_calc_type">
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
        <form id="resalat_form">
            <div id="resalat_form_inputs"></div>
            <div class="resalat_results">
                <p id="resalat_result_desc"></p>
                <p id="resalat_result_text"></p>
            </div>
        </form>
    </div>
</div>
<template id="price_form">
    <label for=""><input type="text">مبلغ سپرده</label>
    <label for=""><input type="text">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text">تعداد اقساط </label>
</template>
<template id="deposit_form">
    <label for=""><input type="text">مبلغ وام</label>
    <label for=""><input type="text">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text">تعداد اقساط </label>
</template>
<template id="deposit_duration_form">
    <label for=""><input type="text">مبلغ وام</label>
    <label for=""><input type="text">مبلغ سپرده</label>
    <label for=""><input type="text">تعداد اقساط </label>
</template>
<template id="payment_form">
    <label for=""><input type="text">مبلغ وام</label>
    <label for=""><input type="text">مدت زمان نگهداشت پول در حساب</label>
    <label for=""><input type="text">مبلغ سپرده</label>
</template>