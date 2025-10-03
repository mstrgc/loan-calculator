function form_control() {

}

function persian_numbers(numbers) {
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
        num = Array.from(numbers)[i];
        result += persian_numbers[num];
    }

    document.getElementById('test').innerHTML = result;
}

persian_numbers('99999');