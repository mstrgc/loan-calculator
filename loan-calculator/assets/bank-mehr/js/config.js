function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    let request = fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data});

    request.then(function(response){
        return response.json();
    })
    .then(response => {
        document.getElementById('result').textContent = response.data['message'];
    });
}

document.getElementById('mehr_submit_button').addEventListener('click', calculate);