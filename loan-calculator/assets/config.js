const text_result = document.getElementById('result');

function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');

    fetch("<?= admin_url('admin-ajax.php') ?>", { method: 'post', body: loan_form_data })
        .then(response => response.text())
        .then(result => { text_result.innerHTML = result; });
}

document.getElementById('loan_form_submit').addEventListener('click', calculate);