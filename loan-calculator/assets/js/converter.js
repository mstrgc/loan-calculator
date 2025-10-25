(function(window, document) {
    'use strict';
    
    //add namespace
    window.number_converter = window.number_converter || {};

    number_converter.text_error = document.getElementById('error');

    number_converter.persian_numbers = function(input) {
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

    number_converter.english_numbers = function(input) {
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
} (window, document));