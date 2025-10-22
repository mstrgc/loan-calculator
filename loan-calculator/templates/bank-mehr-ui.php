<div id="loan_calculator_container">
    <form id="loan_form">
        <?php wp_nonce_field('loan_calculator_nonce', 'loan_calculator_nonce_field') ?>
        <label for="mehr_price">مبلغ تسهیلات</label>
        <input type="range" name="mehr_price" id="mehr_price" min="20000000" max="4000000000" step="5000000" value="20000000">
        <label for="mehr_payment">تعداد اقساط</label>
        <input type="range" name="mehr_payment" id="mehr_payment" min="24" max="60" step="6" value="24">
        <label for="mehr_debt_price">حداکثر توانایی باز پرداخت</label>
        <input type="range" name="mehr_debt_price" id="mehr_debt_price" min="1000000" max="500000000" step="5000000" value="1000000">
        <label for="fee">انتخاب كارمزد</label>
        <div>
            <label for="mehr_fee"><input type="radio" name="mehr_fee" value="0" checked>۰ درصد</label>
            <label for="mehr_fee"><input type="radio" name="mehr_fee" value="1">1 درصد</label>
            <label for="mehr_fee"><input type="radio" name="mehr_fee" value="2">۲ درصد</label>
            <label for="mehr_fee"><input type="radio" name="mehr_fee" value="3">3 درصد</label>
            <label for="mehr_fee"><input type="radio" name="mehr_fee" value="4">۴ درصد</label>
        </div>
        <button>محاسبه</button>
    </form>
</div>