window.loan_plugin_js = window.loan_plugin_js || {};

loan_plugin_js.persian_numbers = function(input) {
    persian_numbers = {
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
        if(persian_numbers[num]){
            result += persian_numbers[num];
        } else {
            result += num;
        }
    }
    return result;
}