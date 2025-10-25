function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

    request.then(function(response){
        return response.json();
    })
    .then(response => {
        document.getElementById('result').textContent = display_result(response.data);
    });
}

function display_result(input) {
    tags = '';

    tbody = document.getElementById('mehr_result_tbody');

    payment_value = document.getElementById('mehr_payment').value;
    price_value = document.getElementById('mehr_price').value;

    payment_description = 'تسهيلات به مبلغ ' + window.number_converter.persian_numbers(price_value) + ' با بازپرداخت ' + window.number_converter.persian_numbers(payment_value) + ' قسط ۱ ماهه با مبلغ تقريبي ' + window.number_converter.persian_numbers(input['payment']) + ' ريال';

    for(let i = 0; i < input['deposit'].length; i++) {
        tags += (
            '<tr><td>' + window.number_converter.persian_numbers(i + 1) + '</td><td>' + window.number_converter.persian_numbers(input['deposit'][i]) + '</td><td>' + payment_description + '</td></tr>'
        );
    }
    document.getElementById('mehr_placeholder').style = 'display: none;';
    tbody.innerHTML = tags;
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);