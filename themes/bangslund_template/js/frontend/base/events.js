// Will run when DOM is loaded
$(document).ready(function () {

    // Add your methods here
    projectFunctions.generalFunctions.init();

    if ($('body').is(".page-template-find-sdg")) {
        projectFunctions.sdgWheelFunctions.init();
    }
    if ($('body').is(".page-template-network")) {
        projectFunctions.networkFunctions.init();
    }
    
    projectFunctions.accountCreate.init();


    $('.carousel-feature').carousel({
        ride: false,
        interval: 9000
    })


    // if ('serviceWorker' in navigator) {
    //     navigator.serviceWorker.register('sw.js').then(function(reg) {
    //         console.log('Successfully registered service worker', reg);
    //     }).catch(function(err) {
    //         console.warn('Error whilst registering service worker', err);
    //     });
    // }

    window.addEventListener('load', function () {

        $('html').on('DOMMouseScroll mousewheel', function (e) {
            if(e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0) {
                $( "header" ).addClass( "hide-nav-bar" );
            } else {
                //scroll up
                $( "header" ).removeClass( "hide-nav-bar" );
             }
        });
        
       
    }, false);


    window.addEventListener('load', function() {

        
        // fetch all the forms we want to apply custom style
        var inputs = $('.form-control');
        
        // loop over each input and watch blue event
        var validation = Array.prototype.filter.call(inputs, function(input) {
        
        $(input).on('keyup change', function () {
            // reset
            $(input).removeClass('is-invalid');
            $(input).removeClass('is-valid');
            var countryCode = $('#countries_select').find(':selected').data('code');
            $('#phonePrefix').html('+' + countryCode);
            if (input.checkValidity() === false) {
                $(input).addClass('is-invalid');
            }
            else {
                $(input).addClass('is-valid');
            }
           
        });
        $('#repeatPassword, #password').on('keyup focusout',function () {
            $('#repeatPassword').removeClass('is-invalid');
            $("#repeatPassword").removeClass('is-valid');
            var password = $('#password').val();
            var passwordRepeat = $('#repeatPassword').val();
           // alert(passwordRepeat.length);
           
            if (password !== passwordRepeat && passwordRepeat !== 0) {
                $('#repeatPassword').addClass('is-invalid');
            }else{
                $('#repeatPassword').addClass('is-valid');
            }  
           
            
            
        });
        },false);

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                $('html, body').animate({
                    scrollTop: $("form").offset().top
                }, 2000);
            }

            form.classList.add('was-validated')
            }, false)
        })

    }, false);

       

    //next line are just an example of how to use the so_ajax function with the example_method from ajax/methods folder
    //delete this as is not neccessary for your project
    // var data =  {
    //     'action' : 'example_method',
    //     'testData' :  'data'
    // };
    // do_ajax(AjaxMethodsUrl, data, function (response, data) {
    //     console.log('======== response from the ajax request to example_data method =========');
    //     console.log(response);
    // })

});

// Checks if the content has been loaded before another request is made
var isActive = 1;

// Defines how many posts to show from start.
var post_amount = 2;

// Kills the request if there is no more posts
var kill_request = 0;

function loadProjects() {
    if (kill_request == 0) { 
        var kommune_reg_sel = $('#inputMunicipality').val();
        var sdg_sel = $('#inputSdg').val();
        var com_type_sel = $('#inputCompanyType').val();
        var search_sel = $('#inputsSearch').val();

        var data = {
            'action': 'project_filtering_method',
            'sdg_category': sdg_sel,
            'kommune': kommune_reg_sel,
            'company_type': com_type_sel,
            'search': search_sel,
            'post_amount': post_amount
        };
        do_ajax(AjaxMethodsUrl, data, function (response, data) {
            console.log('======== response from the ajax request to example_data method =========');
            console.log('here goes' + response['post_items']);


            switch (response['post_items']) {
                case 'undefined':
                    $('.no_results .response-2').show();
                    kill_request = 1;
                    break;
                case false:
                    $('.no_results .response-1').show();
                    break;

                default:

                    $.each(response['post_items'], function (index, value) {
                        var categories = [];

                        $.each(value.post_category, function (index, value){
                            categories[index] = value.name;
                        });
                       console.log(categories);
                        var projet_remplate = `
                        <div class=" card-item project-item box-shadow col-md-4">
                                <a class="d-flex flex-column bg-white card-item-content" href="`+ value.post_url + `">
                                    <div class="d-flex flex-column">
                                        <i class="goal-size-1 goal-`+value.post_category_id+`"></i> 
                                        <div class="item-cover"><img  src="`+ value.post_image + `" alt="` + value.post_title + `"></div>
                                        <div class="p-4 d-flex flex-column">
                                            <div class="card-details d-flex mb-2 color-green">`+ categories.join(", ")+ `</div>
                                            <h4 class="excerpt">`+ value.post_title + `</h4>
                                            <div class="mt-3 mb-2 d-flex justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <p class="mb-0 item-company">`+value.post_company_name+`</p>
                                                </div>
                                                <i class="sdg-icon sdg-arrow"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>`;
                        $('#projects_feed').append(projet_remplate);
                    });
                    break;
            }
        });
    }
}
//<img class="item-logo mr-2" src="`+value.post_company_logo+`" alt="`+value.post_company_name+`" title="`+value.post_company_name+`">

// Infinite scroll
$('body').on('scroll', function () {
    let div = $(this).get(0);
    if (div.scrollTop + div.clientHeight >= div.scrollHeight -500) {
        post_amount = post_amount + 2;
        console.log(isActive);
        if (isActive == 1) {
            loadProjects();
        }
    }
});

// Seach reset
var ref;
var myfunc = function(){
    ref = null;
    isActive = 1;

    // Defines how many posts to show from start.
    post_amount = 2;

    // Kills the request if there is no more posts
    kill_request = 0;
    loadProjects();
};


$(window).load(function () {

    // Add your methods here
    loadProjects();

    $('#inputMunicipality, #inputCompanyType, #inputSdg').on('change keyup', function () {
        $('.card-item.project-item ').remove();
        // Checks if the content has been loaded before another request is made
        isActive = 1;

        // Defines how many posts to show from start.
        post_amount = 2;

        // Kills the request if there is no more posts
        kill_request = 0;
        loadProjects();
    });

    $('#inputsSearch').on('keyup', function () {
        $('.card-item.project-item').remove();
        // Checks if the content has been loaded before another request is made
        window.clearTimeout(ref);
        ref = window.setTimeout(myfunc, 1500);
    });
 

}).ajaxStop(function () {
    $('.content-spinner').hide();
    isActive = 1;
}).ajaxStart(function () {

    if (kill_request == 0) { 
        isActive = 0;
        $('.content-spinner').show();
        $('.no_results .response-1, .no_results .response-2').hide();
    }
});