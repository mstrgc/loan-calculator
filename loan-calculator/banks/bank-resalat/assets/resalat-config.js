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
        document.getElementById('deposit_result').textContent = request.data.to_persian();

    } catch(error) {
        return;
    }
};

function form_submit(){
    /*let label = document.getElementById('resalat_form_inputs').querySelectorAll('span[class="error_span"]');

    if(label.length > 0) return () => {label.forEach(span => {
        span.parentNode.removeChild(span);
    })};

    let loan_form = document.getElementById('resalat_form');
    let inputs = Array.from(loan_form.querySelectorAll('input[type="text"]'));


    let errors = [];

    inputs.some(input => {
        let number = Number(input.value);
        if(input.name == 'price' || input.name == 'deposit'){
            if(number < 1000000){
                errors.push(input.name);
            }
        } else if(number < 1 || number > 99){
            errors.push(input.name);
        }
    });

    if(errors.length > 0){
        errors.forEach(error => {
            let label = document.getElementById('resalat_form_inputs');
            let elem = label.querySelector('label[for="' + error + '"]');
            let err = document.createElement('span');
            err.className = 'error_span';
            err.textContent = 'error';
            elem.appendChild(err);
        });
        return;
    }*/
    return calculate();
}

function display_range(){
    let ranges = document.getElementById('resalat_form_inputs').querySelectorAll('input[type="range"]');
    ranges.forEach(range => {
        document.getElementById(range.name + '_index').textContent = (range.value).to_persian();
        document.getElementById(range.name + '_result').textContent = (range.value).to_persian();
    })

    let price  = ranges[0].value;
    let payment  = ranges[2].value;
    payment_calc(price, payment);
}

function payment_calc(price, payment){
    document.getElementById('payment_price_result').textContent = Math.round(price / payment).to_persian();
}

document.getElementById('resalat_form').addEventListener('change', calculate);
document.addEventListener('DOMContentLoaded', () => {
    calculate();
    display_range();
});
//document.getElementById('resalat_calc_type').addEventListener('input', display_form);
document.getElementById('resalat_form_inputs').addEventListener('input', display_range);