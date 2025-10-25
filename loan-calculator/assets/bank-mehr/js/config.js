function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

    request.then(function(response){
        return response.json();
    })
    .then(response => {
        document.getElementById('result').textContent = display_result(response.data['message']);
    });
}

function display_result(input) {
    /*deposit_result_row = document.querySelectorAll('td.mehr_deposit_result');

    for(let i = 0; i < input.length; i++) {
        deposit_result_row[i].textContent = input[i];
    }

    document.getElementById('mehr_placeholder').remove();
    return;*/

    tags = '';

    tbody = document.getElementById('mehr_result_tbody');

    for(let i = 0; i < input.length; i++) {
        tags += (
            '<tr><td>' + (i + 1) + '</td><td>' + input[i] + '</td><td></td></tr>'
        );
    }
    tbody.innerHTML = tags;
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);