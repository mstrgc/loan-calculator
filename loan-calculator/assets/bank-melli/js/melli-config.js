let price_value = document.getElementById('display_price');

//display price input in persian
price_value.addEventListener('input', function () {
    this.value = this.value.to_persian();
    //calculate by any input in price input
    calculate();
});

function calculate() {
    //create formdata from html form
    let loan_form = document.getElementById('melli_loan_form');
    let loan_form_data = new FormData(loan_form);

    //add php calculator function to formdata
    loan_form_data.append('action', 'melli_calculator');
    
    //convert price value to english
    loan_form_data.append('price', price_value.value.to_english());

    //display date, time, fee values in result section
    window.loan_plugin_js.label_date_time_fee();

    try{
        let response = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data, credentials: 'same-origin', cache: 'no-cache'});

        response.then(function(resp) {
            if(!resp.ok){
                throw new Error('ارتباط با سرور برقرار نشد');
            }
            return resp.json();
        })

        .then(result => {
            window.loan_plugin_js.display_result(result.data);
        })

        .catch((error) => {
            document.getElementById('error_text').textContent = error.message;
        });

    } catch(error) {
        return document.getElementById('error_text').textContent = 'خطا در نمایش نتایج';
    }
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('melli_loan_form').addEventListener('change', calculate);