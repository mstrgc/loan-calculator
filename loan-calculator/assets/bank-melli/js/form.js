(function(global) {
    loan_plugin_js.text_error = document.getElementById('error_text');

    function label_date_time_fee(){
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


        if (result['status'] == 'success') {
            if(document.getElementById('loan').checked){
                //show calculated average if loan option is choosen
                average_result.textContent = result['message'].to_persian();
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (price_value.value.to_english() <= 300000000 ? price_value.value : (300000000).to_persian());
                surplus_result.textContent = (price_value.value.to_english() < 300000000 ? '۰' : (price_value.value.to_english() - 300000000).to_persian());
            
            } else if(document.getElementById('average').checked){
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (result['message'] <= 300000000 ? result['message'].to_persian() : (300000000).to_persian());
                surplus_result.textContent = (result['message'] < 300000000 ? '۰' : (result['message'] - 300000000).to_persian());

                average_result.textContent = price_value.value;
            }

            //display date, time, fee values in result section
            this.label_date_time_fee();

            this.text_error.textContent = null;

        } else {
            //display errors
            this.text_error.textContent = result['message'];
            average_result.textContent = '۰';
            loan_result.textContent = '۰';
        }
    }

    global.loan_plugin_js = global.loan_plugin_js || {};
    global.loan_plugin_js.label_date_time_fee = label_date_time_fee;
    global.loan_plugin_js.display_result = display_result;

})(window);