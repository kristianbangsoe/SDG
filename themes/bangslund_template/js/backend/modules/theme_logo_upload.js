/**
 * Will initialize the theme logo upload functionality
 */
function init_theme_logo_upload() {

    var upload_logo_button = $('.upload_logo_button');

    if(upload_logo_button.length > 0){

        var clicked_button_input_data = '';

        upload_logo_button.on('click', function() {

            clicked_button_input_data = $(this).attr('data-text-input');

            tb_show('', 'media-upload.php?type=image&TB_iframe=true');

            return false;

        });

        window.send_to_editor = function(html) {

            var imgurl = $(html).attr('src');

            $('#'+clicked_button_input_data).val(imgurl);

            var logo_wrapper = $('#'+clicked_button_input_data+"_wrapper");

            logo_wrapper.html("<img src='"+ imgurl +"' height='100' />");

            tb_remove();

            clicked_button_input_data = '';

        };

        $('.remove_logo').click(function(){

            var image_type = $(this).attr('data-logo-type');

            $('#'+image_type+"_wrapper").find('img').remove();

            $('#'+image_type).val('');

        });

    }
}