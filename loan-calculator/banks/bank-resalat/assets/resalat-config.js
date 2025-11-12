async function calculate(){
    let loan_form = document.getElementById('resalat_form');

    let loan_form_data = new FormData(loan_form);

    loan_form_data.append('action', 'calculator');
    loan_form_data.append('key', 'resalat');

    try{
        request = await window.lc_plugin.ajax_handler(loan_config_variables.admin_ajax_url, loan_form_data);
        document.getElementById('deposit_result').textContent = request.data.to_persian();
        display_result();
    } catch(error) {
        return;
    }
};

function display_range(){
    let ranges = document.getElementById('resalat_form_inputs').querySelectorAll('input[type="range"]');
    ranges.forEach(range => {
        document.getElementById(range.name + '_index').textContent = (range.value).to_persian();
    })
}

function display_result(){
    let ranges = document.getElementById('resalat_form_inputs').querySelectorAll('input[type="range"]');
    ranges.forEach(range => {
        document.getElementById(range.name + '_result').textContent = (range.value).to_persian();
    })

    let price  = ranges[0].value;
    let payment  = ranges[2].value;
    payment_calc(price, payment);
}

function payment_calc(price, payment){
    let payment_price = document.getElementById('payment_price_result').textContent = Math.round(price / payment).to_persian();
    //round to million to avoid 0% fee conflicts
    let total = Math.round((payment_price.to_english() * payment) / 1000000) * 1000000;
    document.getElementById('payment_total_price_result').textContent = total.to_persian();
}

document.getElementById('resalat_form').addEventListener('change', calculate);
document.getElementById('resalat_form').addEventListener('input', display_range);
document.addEventListener('DOMContentLoaded', () => {
    calculate();
    display_range();
});