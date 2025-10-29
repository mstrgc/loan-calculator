let error_text = document.getElementById('error_text');

function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    try{
        let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

        request.then(function(response){
            if(!response.ok){
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

        if(input.data == null){
            error_text.textContent = 'خطا در دریافت اطلاعات';
        } else{
            tags = '';

            payment_value = document.getElementById('mehr_payment').value;
            price_value = document.getElementById('mehr_price').value;

            payment_description = 'تسهيلات به مبلغ ' + price_value.to_persian() + ' با بازپرداخت ' + payment_value.to_persian() + ' قسط ۱ ماهه با مبلغ تقريبي ' + (input.data['payment']).to_persian() + ' ريال';

            for(let i = 0; i < input.data['deposit'].length; i++) {
                tags += (
                    '<tr><td>' + (i + 1).to_persian() + '</td><td>' + (input.data['deposit'][i]).to_persian() + '</td><td>' + payment_description + '</td></tr>'
                );
            }

            document.getElementById('mehr_placeholder').style = 'display: none;';
            tbody.innerHTML = tags;
        }
    }
}

function sync_label(input){
    input_value = document.getElementById(input).value;
    document.getElementById(input + '_indicator').textContent = input_value.to_persian();
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);