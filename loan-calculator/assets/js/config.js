const text_result = document.getElementById('result');

function calculate() {
    let loan_form = document.getElementById('loan_form');
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
document.getElementById('loan_form').addEventListener('input', calculate);