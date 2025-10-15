(function(window, document) {
    'use strict';
    
    //add namespace
    window.loan_plugin_js = window.loan_plugin_js || {};

    loan_plugin_js.text_error = document.getElementById('error');

    loan_plugin_js.persian_numbers = function(input) {
        let persian_number = {
            0: '۰',
            1: '۱',
            2: '۲',
            3: '۳',
            4: '۴',
            5: '۵',
            6: '۶',
            7: '۷',
            8: '۸',
            9: '۹'
        };

        let result = '';

        //convert numbers to persian numbers
        let converter = function(valid_input) {
            for (let i = 0; i < valid_input.length; i++) {
                let num = Array.from(valid_input)[i];
                //ignore unmatched characters and remove them
                if(persian_number.hasOwnProperty(num)){
                    result += persian_number[num];
                } else if(Object.values(persian_number).includes(num)) {
                    //pass numbers if already persian
                    result += num;
                }
            }
        };

        //add thousand separator to numbers
        let comma_separated_result = function(valid_input) {
            let reversed_result = valid_input.split('').reverse().join('').replaceAll(',', '');
            let separated_result = reversed_result.match(/.{1,3}/g);
            return separated_result.join(',').split('').reverse().join('');
        };

        if(typeof input === 'string'){
            converter(input);
        } else if(typeof input === 'number'){
            converter(String(input));
        } else {
            return this.text_error.textContent = 'ورودی مبلغ باید فقط شامل اعداد باشد';
        }

        return comma_separated_result(result);
    };

    loan_plugin_js.english_numbers = function(input) {
        let english_number = {
            '۰': 0,
            '۱': 1,
            '۲': 2,
            '۳': 3,
            '۴': 4,
            '۵': 5,
            '۶': 6,
            '۷': 7,
            '۸': 8,
            '۹': 9
        };

        let result = '';

        if(typeof input === 'string'){
            //convert persian numbers to english numbers
            for(let i = 0; i < input.length; i++){
                let num = Array.from(input)[i];
                //ignore unmatched characters and remove them
                if(english_number.hasOwnProperty(num)){
                    result += english_number[num];
                } else if(Number(num)) {
                    //pass numbers if already english
                    result += num;
                }
            }
        } else {
            this.text_error.textContent = 'ورودی مبلغ باید فقط شامل اعداد باشد';
        }

        return Number(result);
    };

    loan_plugin_js.label_date_time_fee = function(){
        let date_span = document.getElementsByClassName('date_span');
        let time_span = document.getElementsByClassName('time_span');
        let fee_span = document.getElementById('fee_result');

        let date_input = document.getElementById('date').value;
        let time_input = document.getElementById('time').value;
        let fee_input = document.querySelectorAll('input[name="fee"]');

        //display date and time values to selected elements
        for(let i = 0; i < date_span.length; i++){
            date_span[i].textContent = loan_plugin_js.persian_numbers(date_input) + ' ماه';
            time_span[i].textContent = loan_plugin_js.persian_numbers(time_input) + ' ماه';
        };

        //display fee value in result section
        fee_input.forEach(fee_percent => {
            if(fee_percent.checked){
                fee_span.textContent = this.persian_numbers(fee_percent.value);
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
                average_result.textContent = this.persian_numbers(result['message']);
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (this.english_numbers(price_value.value) <= 300000000 ? price_value.value : this.persian_numbers(300000000));
                surplus_result.textContent = (this.english_numbers(price_value.value) < 300000000 ? '۰' : this.persian_numbers(this.english_numbers(price_value.value) - 300000000));
            
            } else if(document.getElementById('average').checked){
                //calculate and separate loan and surplus loan value
                loan_result.textContent = (result['message'] <= 300000000 ? this.persian_numbers(result['message']) : this.persian_numbers(300000000));
                surplus_result.textContent = (result['message'] < 300000000 ? '۰' : this.persian_numbers(result['message'] - 300000000));

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