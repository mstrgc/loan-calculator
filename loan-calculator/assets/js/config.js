const text_result = document.getElementById('result');
let price_value = document.getElementById('display_price');

price_value.addEventListener('input', function () {
    const cursorPos = this.selectionStart;
    this.value = loan_plugin_js.persian_numbers(this.value);
    this.setSelectionRange(cursorPos, cursorPos);
});
/*
function calculate() {
    let loan_form = document.getElementById('loan_form');
    //document.getElementById('price').value = price_value;


    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');

    fetch(loan_config_variables.admin_ajax_url, { method: 'post', body: loan_form_data })
    .then(response => response.json())
    .then(result => {
        if (result['status'] == 'success') {
            text_result.innerHTML = loan_plugin_js.persian_numbers(result['message']);
        } else {
            text_result.innerHTML = result['message'];
        }
    });
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('loan_form').addEventListener('input', calculate);*/