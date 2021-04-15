/**
 * Function which should help doing AJAX calls
 * @param url
 * @param data
 * @param callback
 * @param method
 */
function do_ajax(url, data, callback, method) {

    var ajax_method = 'post';

    if(typeof method != 'undefined') {
        ajax_method = method;
    }

    window.doingAjax   = true;
    
    //add this only if you need it
    // $('body').addClass('loading');

    $.ajax({
        url: url,
        type: ajax_method,
        dataType: 'json',
        timeout: 240000,
        data: data,

        success: function(response_data) {

            console.log(['Ajax Success:',response_data]);
            $('body').removeClass('loading');
            window.doingAjax = false;
            callback(response_data, data);

        },

        error: function(response_data, status, error) {
            console.error(['Ajax Error:', response_data, status, error]);
            $('body').removeClass('loading');
            window.doingAjax = false;

            if(status == "timeout") {
                alert("Error: Your request could not be completed because it timed out. Try again later");
                document.location.href="/";
            } else {
                callback(response_data, data);
            }

        }

    });
}
