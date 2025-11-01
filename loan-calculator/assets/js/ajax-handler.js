(function(global){
    async function ajax_handler(url, body){
        let ajax_request = {
            method: 'POST',
            body: body,
            credentials: 'same-origin',
            cache: 'no-cache'
        }

        //validate body
        if(!(body instanceof FormData)){
            throw new Error('خطا در ارسال اطلاعات');
        }

        let response = await fetch(url, ajax_request);

        if(!response){
            throw new Error('ارتباط با سرور برقرار نشد');
        }

        let result = await response.json();

        //validate and send result data
        if(result.data){
            return result.data;
        } else{
            throw new Error('خطا در دریافت اطلاعات');
        }
    }

    global.loan_plugin_js = global.loan_plugin_js || {};
    global.loan_plugin_js.ajax_handler = ajax_handler;

})(window);