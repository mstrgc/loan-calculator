function display_form(){
    let options = document.querySelectorAll('input[name="calc_type"]');

    options.forEach((option) => {
        if(option.checked){
            let template = document.getElementById(option.value + '_form');
            let clone = template.content.cloneNode(true);
            document.getElementById('resalat_form_inputs').replaceChildren();
            document.getElementById('resalat_form_inputs').appendChild(clone);
        }
    });
    return;
}

async function calculate(){
    let loan_form = document.getElementById('resalat_form');
    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');
    loan_form_data.append('key', 'resalat');

    try{
        request = await window.lc_plugin.ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data);
    } catch(error) {
        return;
    }
};


document.getElementById('resalat_form').addEventListener('input', calculate);
document.addEventListener('DOMContentLoaded', display_form);
document.getElementById('resalat_calc_type').addEventListener('input', display_form);