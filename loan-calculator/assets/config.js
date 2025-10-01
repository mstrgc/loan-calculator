const text_result = document.getElementById('result');

console.log('hhhh');

function calculate() {
    console.log('hhhh');

    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');

    fetch("", { method: 'post', body: loan_form_data })
        .then(response => response.text())
        .then(result => { text_result.innerHTML = result; });
}

document.getElementById('loan_form_submit').addEventListener('click', calculate);