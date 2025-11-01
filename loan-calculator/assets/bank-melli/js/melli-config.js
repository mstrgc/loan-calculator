let price_value = document.getElementById('display_price');

//display price input in persian
price_value.addEventListener('input', function () {
    this.value = this.value.to_persian();
    //calculate by any input in price input
    calculate();
});

async function calculate() {
    //create formdata from html form
    let loan_form = document.getElementById('melli_loan_form');
    let loan_form_data = new FormData(loan_form);

    //add php calculator function to formdata
    loan_form_data.append('action', 'melli_calculator');
    
    //convert price value to english and remove 
    loan_form_data.append('price', price_value.value.to_english());
    loan_form_data.delete('display_price');

    try{
        request = await window.loan_plugin_js.ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data);

        if(!request){
            throw new Error('خطا در ارسال درخواست');
        }

        window.loan_plugin_js.display_result(request.data);

    } catch(error) {
        return document.getElementById('error_text').textContent = error.message;
    }
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('melli_loan_form').addEventListener('change', calculate);