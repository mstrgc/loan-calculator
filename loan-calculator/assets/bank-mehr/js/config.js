function calculate() {
    let loan_form = document.getElementById('loan_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'mehr_calculator');

    fetch(loan_config_variables.admin_ajax_url, {method: 'POST', body: loan_form_data})

    .then();
}

document.getElementById('submit_fom').addEventListener('click', calculate);