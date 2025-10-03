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

    for (let i = Array(numbers); i <= numbers.length; i++) {
        numbers = numbers.replace(i, persian_numbers[i]);
    }

    document.getElementById('test').innerHTML = numbers;
}

persian_numbers(99999);