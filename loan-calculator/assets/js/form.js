window.loan_plugin_js = window.loan_plugin_js || {};

loan_plugin_js.persian_numbers = function(numbers) {
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

    for (let i = 0; i < numbers.length; i++) {
        num = Array.from(String(numbers))[i];
        result += persian_numbers[num];
    }
    return result;
}