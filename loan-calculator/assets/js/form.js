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

    result = '';

    for (let i = 0; i < input.length; i++) {
        num = Array.from(String(input))[i];
        if(persian_number.hasOwnProperty(num)){
            result += persian_number[num];
        } else {
            result += num;
        }
    }
    return result;
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

    result = '';

    for (let i = 0; i < input.length; i++) {
        num = Array.from(String(input))[i];
        if(english_number.hasOwnProperty(num)){
            result += english_number[num];
        } else {
            result += num;
        }
    }
    return result;
};