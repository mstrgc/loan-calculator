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

document.addEventListener('DOMContentLoaded', display_form);
document.getElementById('resalat_calc_type').addEventListener('input', display_form);