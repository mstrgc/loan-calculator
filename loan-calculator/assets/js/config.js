let text_result = document.getElementById('result');
let text_error = document.getElementById('error');
let price_value = document.getElementById('display_price');

price_value.addEventListener('input', function () {
    this.value = loan_plugin_js.persian_numbers(this.value);

});

function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');
    loan_form_data.append('price', loan_plugin_js.english_numbers(price_value.value));

    fetch(loan_config_variables.admin_ajax_url, { method: 'post', body: loan_form_data })
    .then(response => response.json())
    .then(result => {
        if (result['status'] == 'success') {
            text_result.innerHTML = loan_plugin_js.persian_numbers(result['message']);
            text_error.innerHTML = null;
        } else {
            text_error.innerHTML = result['message'];
            text_result.innerHTML = '۰';
        }
    });
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('loan_form').addEventListener('input', calculate);
document.addEventListener('input', loan_plugin_js.label_date_time);