(function(global){
    'use strict';

    function check_input(input){
        let result = '';
        let allowed_inputs = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        let array_input = Array.from(String(input));
        
        array_input.forEach(word => {
            if(allowed_inputs.includes(word)){
                result += word;
            }
        });
        
        return result;
    }

    function comma_separate(input) {
        let reversed_result = input.split('').reverse().join('').replaceAll(',', '');
        let separated_result = reversed_result.match(/.{1,3}/g);
        return separated_result.join(',').split('').reverse().join('');
    };

    //convert numbers to persian numbers
    function to_persian(input){
        let result = '';

        //convert numbers to persian numbers
        for (let i = 0; i < input.length; i++) {
            let num = input[i];
            //ignore unmatched characters and remove them
            if(num.match(/[0-9]/g)){
                result += num.match(/[۰-۹]/g);
            } else if(num.match(/[۰-۹]/g)) {
                //pass numbers if already persian
                result += num;
            }
        }

        return comma_separate(result);
    };

    if(!String.prototype.to_persian){
        Object.defineProperty(String.prototype, 'to_persian', {'value': function(){return to_persian(this);}});
    }

    if(!Number.prototype.to_persian){
        Object.defineProperty(Number.prototype, 'to_persian', {'value': function(){return to_persian(this);}});
    }

    //convert numbers to english numbers
    function to_english(input){
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
        }

        return Number(result);
    };

    if(!String.prototype.to_english){
        Object.defineProperty(String.prototype, 'to_english', {'value': function(){return to_english(this);}});
    }

    if(!Number.prototype.to_english){
        Object.defineProperty(Number.prototype, 'to_english', {'value': function(){return to_english(this);}});
    }

    //ajax request handler
    async function ajax_handler(url, body){
        let ajax_request = {
            method: 'POST',
            body: body,
            credentials: 'same-origin',
            cache: 'no-cache'
        }

        //validate body
        if(!(body instanceof FormData)){
            throw new Error('خطا در ارسال اطلاعات');
        }

        let response = await fetch(url, ajax_request);

        if(!response){
            throw new Error('ارتباط با سرور برقرار نشد');
        }

        let result = await response.json();

        //validate and send result data
        if(result && result.data){
            return result;
        } else{
            throw new Error('خطا در دریافت اطلاعات');
        }
    }

    //register namespace
    global.lc_plugin = global.lc_plugin || {};
    global.lc_plugin.ajax_handler = ajax_handler;
    global.lc_plugin.check_input = check_input;
})(window);