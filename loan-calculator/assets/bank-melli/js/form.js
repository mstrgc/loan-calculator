(function(window, document) {
    'use strict';
    
    //add namespace
    window.loan_plugin_js = window.loan_plugin_js || {};

    loan_plugin_js.text_error = document.getElementById('error');

    loan_plugin_js.label_date_time_fee = function(){
        let date_span = document.getElementsByClassName('date_span');
        let time_span = document.getElementsByClassName('time_span');
        let fee_span = document.getElementById('fee_result');

        let date_input = document.getElementById('date').value;
        let time_input = document.getElementById('time').value;
        let fee_input = document.querySelectorAll('input[name="fee"]');

        //display date and time values to selected elements
        for(let i = 0; i < date_span.length; i++){
            date_span[i].textContent = window.number_converter.persian_numbers(date_input) + ' ماه';
            time_span[i].textContent = window.number_converter.persian_numbers(time_input) + ' ماه';
        };

        //display fee value in result section
        fee_input.forEach(fee_percent => {
            if(fee_percent.checked){
                fee_span.textContent = window.number_converter.persian_numbers(fee_percent.value);
            }
        });

        return;
    }

    loan_plugin_js.display_result = function(result){
        let average_result = document.getElementById('average_result');
        let loan_result = document.getElementById('loan_result');
        let surplus_result = document.getElementById('surplus_result');

        if (result['status'] == 'success') {
            if(document.getElementById('loan').checked){
                //show calculated average if loan option is choosen
                average_result.textContent = window.number_converter.persian_numbers(result['message']);
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (window.number_converter.english_numbers(price_value.value) <= 300000000 ? price_value.value : window.number_converter.persian_numbers(300000000));
                surplus_result.textContent = (window.number_converter.english_numbers(price_value.value) < 300000000 ? '۰' : window.number_converter.persian_numbers(window.number_converter.english_numbers(price_value.value) - 300000000));
            
            } else if(document.getElementById('average').checked){
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (result['message'] <= 300000000 ? window.number_converter.persian_numbers(result['message']) : window.number_converter.persian_numbers(300000000));
                surplus_result.textContent = (result['message'] < 300000000 ? '۰' : window.number_converter.persian_numbers(result['message'] - 300000000));

                average_result.textContent = price_value.value;
            }

            this.text_error.textContent = null;

        } else {
            //display errors
            this.text_error.textContent = result['message'];
            average_result.textContent = '۰';
            loan_result.textContent = '۰';
        }
    }
} (window, document));