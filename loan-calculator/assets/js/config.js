let price_value = document.getElementById('display_price');

//display price input in persian
price_value.addEventListener('input', function () {
    this.value = window.loan_plugin_js.persian_numbers(this.value);
});

function calculate() {
    //create formdata from html form
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    //add php calculator function to formdata
    loan_form_data.append('action', 'calculator');
    //convert price value to english
    loan_form_data.append('price', window.loan_plugin_js.english_numbers(price_value.value));

    //display date, time, fee values in result section
    window.loan_plugin_js.label_date_time_fee();

    fetch(loan_config_variables.admin_ajax_url, { method: 'post', body: loan_form_data })
    .then(response => response.json())
    .then(result => {window.loan_plugin_js.display_result(result.data)});
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('loan_form').addEventListener('input', calculate);