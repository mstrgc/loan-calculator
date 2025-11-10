function display_form(){
    let options = document.querySelectorAll('input[name="calc_type"]');

    options.forEach((option) => {
        if(option.checked){
            let template = document.getElementById(option.value + '_form');
            let clone = template.content.cloneNode(true);
            document.getElementById('resalat_form_inputs').replaceChildren();
            document.getElementById('resalat_form_inputs').appendChild(clone);
            document.getElementById('resalat_result_desc').textContent = document.querySelector('label[for="' + option.value + '"]').textContent;
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
        document.getElementById('resalat_result_text').textContent = request.data;

    } catch(error) {
        return;
    }
};

function form_submit(){
    let loan_form = document.getElementById('resalat_form');
    let inputs = loan_form.querySelectorAll('input[type="text"]');

    for(let input of inputs){
        let number = Number(input.value);
        if(input.name == 'price' || input.name == 'deposit'){
            if(number < 1000000){
                return false;
            }
        } else{
            if(number < 0 || number > 99){
                return false;
            }
        }
    };

    console.log('ok');
}

document.getElementById('resalat_form').addEventListener('input', form_submit);
document.addEventListener('DOMContentLoaded', () => {
    display_form();
    form_submit();
});
document.getElementById('resalat_calc_type').addEventListener('input', display_form);