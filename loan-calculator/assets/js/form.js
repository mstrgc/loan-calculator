window.loan_plugin_js = window.loan_plugin_js || {};

loan_plugin_js.persian_numbers = function(input) {
    persian_number = {
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
    input = String(input);

    for (let i = 0; i < input.length; i++) {
        num = Array.from(input)[i];
        if(persian_number.hasOwnProperty(num)){
            result += persian_number[num];
        } else if(Object.values(persian_number).includes(num)) {
            result += num;
        }
    }

    let reversed_result = result.split('').reverse().join('').replaceAll(',', '');
    result = reversed_result.match(/.{1,3}/g);
    return result.join(',').split('').reverse().join('');
};

loan_plugin_js.english_numbers = function(input) {
    english_number = {
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

    for (let i = 0; i < input.length; i++) {
        num = Array.from(input)[i];
        if(english_number.hasOwnProperty(num)){
            result += english_number[num];
        } else if(Number(num)) {
            result += num;
        }
    }
    return Number(result);
};

loan_plugin_js.label_date_time = function(){
    let date_span = document.getElementById('date_span');
    let time_span = document.getElementById('time_span');

    let date_input = document.getElementById('date').value;
    let time_input = document.getElementById('time').value;

    date_span.innerHTML = loan_plugin_js.persian_numbers(date_input) + ' ماه';
    time_span.innerHTML = loan_plugin_js.persian_numbers(time_input) + ' ماه';
    return;
}

loan_plugin_js.display_result = function(result){
    let average_result = document.getElementById('average_result');
    let loan_result = document.getElementById('loan_result');
    let surplus_result = document.getElementById('surplus_result');

    let text_error = document.getElementById('error');

    if (result['status'] == 'success') {
        if(document.getElementById('loan').checked){
            average_result.innerHTML = this.persian_numbers(result['message']);
            loan_result.innerHTML = (this.english_numbers(price_value.value) <= 300000000 ? price_value.value : this.persian_numbers(300000000));
            surplus_result.innerHTML = (this.english_numbers(price_value.value) < 300000000 ? '۰' : this.persian_numbers(this.english_numbers(price_value.value) - 300000000));
        
        } else if(document.getElementById('average').checked){
            loan_result.innerHTML = (result['message'] <= 300000000 ? this.persian_numbers(result['message']) : this.persian_numbers(300000000));
            average_result.innerHTML = price_value.value;
            surplus_result.innerHTML = (result['message'] < 300000000 ? '۰' : this.persian_numbers(result['message'] - 300000000));
        }

        text_error.innerHTML = null;

        document.querySelectorAll('.loan_input').forEach((input, index) => {
            let result = document.getElementById('loan_result' + (index + 1));
            result.innerHTML = input.value;
        });



    } else {
        text_error.innerHTML = result['message'];
        average_result.innerHTML = '۰';
        loan_result.innerHTML = '۰';
    }
}