let error_text = document.getElementById('mehr_placeholder');

function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    try{
        let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

        request.then(function(response){
            if(!resp.ok){
                throw new Error('ارتباط با سرور برقرار نشد');
            }
            return response.json();
        })
        .then(response => {
            display_result(response);
        });

    } catch(error){
        error_text.textContent = error.message;
    }
}

function display_result(input) {
    let tbody = document.getElementById('mehr_result_tbody');

    if(input.success == false){
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

function sync_label(input){
    input_value = document.getElementById(input).value;
    document.getElementById(input + '_indicator').textContent = window.number_converter.persian_numbers(input_value);
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);