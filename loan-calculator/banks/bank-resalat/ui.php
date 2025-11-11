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
                <p><span id="resalat_result_text"></span></p>
            </div>
        </form>
    </div>
</div>
<template id="price_form">
    <div class="text_input">
        <div class="input_label">
            <label for="deposit">مبلغ سپرده</label>
            <p class="display_range"><span id="deposit_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="deposit" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="deposit_duration">مدت زمان نگهداشت پول در حساب</label>
            <p class="display_range"><span id="deposit_duration_index">۱</span> ماه</p>
        </div>
        <input type="range" name="deposit_duration" value="1" step="1" min="1" max="12">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="payment">تعداد اقساط </label>
            <p class="display_range"><span id="payment_index">۶</span> ماه</p>
        </div>
        <input type="range" name="payment" value="6" step="6" min="6" max="60">
    </div>
</template>
<template id="deposit_form">
    <div class="text_input">
        <div class="input_label">
            <label for="price">مبلغ وام</label>
            <p class="display_range"><span id="price_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="price" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="deposit_duration">مدت زمان نگهداشت پول در حساب</label>
            <p class="display_range"><span id="deposit_duration_index">۱</span> ماه</p>
        </div>
        <input type="range" name="deposit_duration" value="1" step="1" min="1" max="12">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="payment">تعداد اقساط </label>
            <p class="display_range"><span id="payment_index">۶</span> ماه</p>
        </div>
        <input type="range" name="payment" value="6" step="6" min="6" max="60">
    </div>
</template>
<template id="deposit_duration_form">
    <div class="text_input">
        <div class="input_label">
            <label for="price">مبلغ وام</label>
            <p class="display_range"><span id="price_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="price" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="deposit">مبلغ سپرده</label>
            <p class="display_range"><span id="deposit_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="deposit" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="payment">تعداد اقساط </label>
            <p class="display_range"><span id="payment_index">۶</span> ماه</p>
        </div>
        <input type="range" name="payment" value="6" step="6" min="6" max="60">
    </div>
</template>
<template id="payment_form">
    <div class="text_input">
        <div class="input_label">
            <label for="price">مبلغ وام</label>
            <p class="display_range"><span id="price_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="price" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="deposit_duration">مدت زمان نگهداشت پول در حساب</label>
            <p class="display_range"><span id="deposit_duration_index">۱</span> ماه</p>
        </div>
        <input type="range" name="deposit_duration" value="1" step="1" min="1" max="12">
    </div>
    <div class="text_input">
        <div class="input_label">
            <label for="deposit">مبلغ سپرده</label>
            <p class="display_range"><span id="deposit_index">۱,۰۰۰,۰۰۰</span> ریال</p>
        </div>
        <input type="range" name="deposit" value="1000000" min="1000000" max="1000000000" step="1000000">
    </div>
</template>