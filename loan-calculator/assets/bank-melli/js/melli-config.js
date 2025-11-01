let price_value = document.getElementById('display_price');

//display price input in persian
price_value.addEventListener('input', function () {
    this.value = this.value.to_persian();
    //calculate by any input in price input
    calculate();
});

function ajax_handler(url, body){
    let ajax_request = {
        method: 'POST',
        body: body,
        credentials: 'same-origin',
        cache: 'no-cache'
    }

    let response = fetch(url, ajax_request);

    let result = null;

    response.then(function(resp) {
        if(!resp.ok){
            throw new Error('ارتباط با سرور برقرار نشد');
        }
        return result = resp.json();
    })
    return result;
}

function calculate() {
    //create formdata from html form
    let loan_form = document.getElementById('melli_loan_form');
    let loan_form_data = new FormData(loan_form);

    //add php calculator function to formdata
    loan_form_data.append('action', 'melli_calculator');
    
    //convert price value to english
    loan_form_data.append('price', price_value.value.to_english());
    loan_form_data.delete('display_price');

    try{
        request = ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data);

        console.log(ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data));

        if(!request){
            throw new Error('خطا در ارسال درخواست');
        } else{
            window.loan_plugin_js.display_result(request);
        }

    } catch(error) {
        return document.getElementById('error_text').textContent = error.message;
    }
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('melli_loan_form').addEventListener('change', calculate);