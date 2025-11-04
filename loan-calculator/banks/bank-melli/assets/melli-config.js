let price_value = document.getElementById('display_price');
let text_error = document.getElementById('error_text');

//display price input in persian
price_value.addEventListener('input', function(){
    this.value = window.lc_plugin.check_input(this.value);
    this.value = this.value.to_persian();
    //calculate by any input in price input
    calculate();
});

async function calculate() {
    //create formdata from html form
    let loan_form = document.getElementById('melli_loan_form');
    let loan_form_data = new FormData(loan_form);

    //add php calculator function to formdata
    loan_form_data.append('action', 'calculator');
    loan_form_data.append('key', 'melli');
    
    //convert price value to english and remove
    loan_form_data.append('price', price_value.value.to_english());
    loan_form_data.delete('display_price');

    try{
        request = await window.lc_plugin.ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data);

        if(!request){
            throw new Error('خطا در ارسال درخواست');
        }

        display_result(request);

    } catch(error) {
        return error_text.textContent = error.message;
    }
}

function sync_labels(){
    let date_span = document.getElementsByClassName('date_span');
    let time_span = document.getElementsByClassName('time_span');
    let fee_span = document.getElementById('fee_result');

    let date_input = document.getElementById('date').value;
    let time_input = document.getElementById('time').value;
    let fee_input = document.querySelectorAll('input[name="fee"]');

    //display date and time values to selected elements
    for(let i = 0; i < date_span.length; i++){
        date_span[i].textContent = date_input.to_persian() + ' ماه';
        time_span[i].textContent = time_input.to_persian() + ' ماه';
    };

    //display fee value in result section
    fee_input.forEach(fee_percent => {
        if(fee_percent.checked){
            fee_span.textContent = fee_percent.value.to_persian();
        }
    });

    return;
}

function display_result(result){
    let average_result = document.getElementById('average_result');
    let loan_result = document.getElementById('loan_result');
    let surplus_result = document.getElementById('surplus_result');

    if(result.success){
        if(document.getElementById('loan').checked){
            //show calculated average if loan option is choosen
            average_result.textContent = result.data.message.to_persian();
            //calculate and separate loan and surplus loan value
            loan_result.textContent = (price_value.value.to_english() <= 300000000 ? price_value.value : (300000000).to_persian());
            surplus_result.textContent = (price_value.value.to_english() < 300000000 ? '۰' : (price_value.value.to_english() - 300000000).to_persian());
        
        } else if(document.getElementById('average').checked){
            //calculate and separate loan and surplus loan value
            loan_result.textContent = (result.data.message <= 300000000 ? result.data.message.to_persian() : (300000000).to_persian());
            surplus_result.textContent = (result.data.message < 300000000 ? '۰' : (result.data.message - 300000000).to_persian());

            average_result.textContent = price_value.value;
        }

        //display date, time, fee values in result section
        sync_labels();

        text_error.textContent = null;

    } else {
        //display errors
        text_error.textContent = result.data.message;
        average_result.textContent = '۰';
        loan_result.textContent = '۰';
    }
}

document.addEventListener('DOMContentLoaded', calculate);
document.getElementById('melli_loan_form').addEventListener('change', calculate);