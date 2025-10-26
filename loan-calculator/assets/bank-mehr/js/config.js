function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

    request.then(function(response){
        return response.json();
    })
    .then(response => {
        display_result(response);
    });
}

function display_result(input) {
    let tbody = document.getElementById('mehr_result_tbody');

    if(input.success == false){
        let error_text = document.getElementById('mehr_placeholder');
        tbody.innerHTML = '';
        error_text.style = 'display: block';
        error_text.textContent = input.data['message'];
    } else{
        tags = '';

        payment_value = document.getElementById('mehr_payment').value;
        price_value = document.getElementById('mehr_price').value;

        payment_description = 'تسهيلات به مبلغ ' + window.number_converter.persian_numbers(price_value) + ' با بازپرداخت ' + window.number_converter.persian_numbers(payment_value) + ' قسط ۱ ماهه با مبلغ تقريبي ' + window.number_converter.persian_numbers(input.data['payment']) + ' ريال';

        for(let i = 0; i < input.data['deposit'].length; i++) {
            tags += (
                '<tr><td>' + window.number_converter.persian_numbers(i + 1) + '</td><td>' + window.number_converter.persian_numbers(input.data['deposit'][i]) + '</td><td>' + payment_description + '</td></tr>'
            );
        }

        document.getElementById('mehr_placeholder').style = 'display: none;';
        tbody.innerHTML = tags;
    }
}

function sync_input_label() {
    price_value = document.getElementById('mehr_price').value;
    document.getElementById('price_input_indicator').textContent = window.number_converter.persian_numbers(price_value);

    payment_value = document.getElementById('mehr_payment').value;
    document.getElementById('payment_input_indicator').textContent = window.number_converter.persian_numbers(payment_value);

    debt_price_value = document.getElementById('mehr_debt_price').value;
    document.getElementById('debt_price_input_indicator').textContent = window.number_converter.persian_numbers(debt_price_value);
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);
document.getElementById('loan_form').addEventListener('input', sync_input_label);