// This closure function makes the $-sign an alias for jQuery (noConflict)
(function($) {

// Defining a global object for the javascript functions
// By defining all our functions to this global object, we can access all functions in any function or file.
    window.projectFunctions = window.projectFunctions || {};

'use strict';

/**
 * Function which should help doing AJAX calls
 * @param url
 * @param data
 * @param callback
 * @param method
 */
function do_ajax(url, data, callback, method) {

    var ajax_method = 'post';

    if (typeof method != 'undefined') {
        ajax_method = method;
    }

    window.doingAjax = true;

    //add this only if you need it
    // $('body').addClass('loading');

    $.ajax({
        url: url,
        type: ajax_method,
        dataType: 'json',
        timeout: 240000,
        data: data,

        success: function success(response_data) {

            console.log(['Ajax Success:', response_data]);
            $('body').removeClass('loading');
            window.doingAjax = false;
            callback(response_data, data);
        },

        error: function error(response_data, status, _error) {
            console.error(['Ajax Error:', response_data, status, _error]);
            $('body').removeClass('loading');
            window.doingAjax = false;

            if (status == "timeout") {
                alert("Error: Your request could not be completed because it timed out. Try again later");
                document.location.href = "/";
            } else {
                callback(response_data, data);
            }
        }

    });
}
'use strict';

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
    });

    // if ('serviceWorker' in navigator) {
    //     navigator.serviceWorker.register('sw.js').then(function(reg) {
    //         console.log('Successfully registered service worker', reg);
    //     }).catch(function(err) {
    //         console.warn('Error whilst registering service worker', err);
    //     });
    // }

    window.addEventListener('load', function () {

        $('html').on('DOMMouseScroll mousewheel', function (e) {
            if (e.originalEvent.detail > 0 || e.originalEvent.wheelDelta < 0) {
                $("header").addClass("hide-nav-bar");
            } else {
                //scroll up
                $("header").removeClass("hide-nav-bar");
            }
        });
    }, false);

    window.addEventListener('load', function () {

        // fetch all the forms we want to apply custom style
        var inputs = $('.form-control');

        // loop over each input and watch blue event
        var validation = Array.prototype.filter.call(inputs, function (input) {

            $(input).on('keyup change', function () {
                // reset
                $(input).removeClass('is-invalid');
                $(input).removeClass('is-valid');
                var countryCode = $('#countries_select').find(':selected').data('code');
                $('#phonePrefix').html('+' + countryCode);
                if (input.checkValidity() === false) {
                    $(input).addClass('is-invalid');
                } else {
                    $(input).addClass('is-valid');
                }
            });
            $('#repeatPassword, #password').on('keyup focusout', function () {
                $('#repeatPassword').removeClass('is-invalid');
                $("#repeatPassword").removeClass('is-valid');
                var password = $('#password').val();
                var passwordRepeat = $('#repeatPassword').val();
                // alert(passwordRepeat.length);

                if (password !== passwordRepeat && passwordRepeat !== 0) {
                    $('#repeatPassword').addClass('is-invalid');
                } else {
                    $('#repeatPassword').addClass('is-valid');
                }
            });
        }, false);

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    $('html, body').animate({
                        scrollTop: $("form").offset().top
                    }, 2000);
                }

                form.classList.add('was-validated');
            }, false);
        });
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

                        $.each(value.post_category, function (index, value) {
                            categories[index] = value.name;
                        });
                        console.log(categories);
                        var projet_remplate = '\n                        <div class=" card-item project-item box-shadow col-md-4">\n                                <a class="d-flex flex-column bg-white card-item-content" href="' + value.post_url + '">\n                                    <div class="d-flex flex-column">\n                                        <i class="goal-size-1 goal-' + value.post_category_id + '"></i> \n                                        <div class="item-cover"><img  src="' + value.post_image + '" alt="' + value.post_title + '"></div>\n                                        <div class="p-4 d-flex flex-column">\n                                            <div class="card-details d-flex mb-2 color-green">' + categories.join(", ") + '</div>\n                                            <h4 class="excerpt">' + value.post_title + '</h4>\n                                            <div class="mt-3 mb-2 d-flex justify-content-between">\n                                                <div class="d-flex align-items-center">\n                                                    <p class="mb-0 item-company">' + value.post_company_name + '</p>\n                                                </div>\n                                                <i class="sdg-icon sdg-arrow"></i>\n                                            </div>\n                                        </div>\n                                    </div>\n                                </a>\n                            </div>\n                        </div>';
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
    var div = $(this).get(0);
    if (div.scrollTop + div.clientHeight >= div.scrollHeight - 500) {
        post_amount = post_amount + 2;
        console.log(isActive);
        if (isActive == 1) {
            loadProjects();
        }
    }
});

// Seach reset
var ref;
var myfunc = function myfunc() {
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
'use strict';

/**
 * General functions.
 */
projectFunctions.sdgWheelFunctions = projectFunctions.sdgWheelFunctions || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.sdgWheelFunctions.init = function () {
    this.wheel();
};

/**
 * SDG Finder
 */
projectFunctions.sdgWheelFunctions.wheel = function () {

    function setPosition() {
        // set radius
        var r = 320;

        // set anchor elements
        var links = $('.center-circle').find('.little-circle');

        // count anchor elements
        var counter = links.length;

        // set angle steps
        var step = 360 / counter;

        // set starting angle
        var angle = -90 - 360 / counter;

        // convert to radian
        var rad = angle * (Math.PI / 360);

        var x = 0;
        var y = 0;

        // loop in links 
        $.each(links, function () {
            angle += step;
            rad = angle * (Math.PI / 180);
            x = Math.round(r * Math.cos(rad)) + 125;
            y = Math.round(r * Math.sin(rad));
            //$(this).css({ left: x + 'px', 'margin-top': -1*y + 'px' });
            $(this).animate({ left: x + 'px', 'margin-top': +1 * y + 'px' });
            $(this).attr('data-left', x + 'px').attr('margin-top', +1 * y + 'px');
        });
        var old_Link = $('.categories a').attr('href');

        $('html, body').animate({ scrollTop: '+=190px' });

        links.on('click', function (e) {

            $('.categories a').attr('href', '');
            e.preventDefault();
            $('.categories .sdg-img').css('opacity', '0').delay(500);
            var name = $(this).data('name');
            var color = $(this).data('color');
            var description = $(this).data('description');
            var sgdId = $(this).data('id');
            links.removeClass('active');
            $(this).addClass('active');
            console.log(name);
            var link = $(this).data('href');
            $('#find-sdg .half-circle-menu').css('background-color', color);
            $('#find-sdg').css('background-color', color + 'c7');
            $('#content').css('background-color', 'black');

            $('.sdg-description').css('color', 'white');
            $('.categories .sdg-title').hide();
            //$('.categories .sdg-title').text(sgdId + '. ' +name);

            $('.categories .sdg-description').text(description);
            $('.categories a').fadeIn();

            $('.categories .sdg-img').animate({ opacity: '1' });
            $('.categories .sdg-img').attr('src', 'https://raw.githubusercontent.com/UNStats/FIS4SDGs/master/globalResources/sdgIcons1000x1000/TGG_Icon_Color_' + sgdId + '.png');

            $('.categories a').attr('href', old_Link + link);
        });
    }

    $(document).ready(function () {
        setPosition();
    });
};
'use strict';

/**
 * General functions.
 */
projectFunctions.generalFunctions = projectFunctions.generalFunctions || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.generalFunctions.init = function () {
    this.checkDevice();
    this.navigation();
};

/**
 * Check if it is a device
 */
projectFunctions.generalFunctions.checkDevice = function () {

    var isMobile = false; //initiate as false
    // Device detection
    if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0, 4))) {
        isMobile = true;
    }
    return isMobile;
};

/**
 * Navigation
 */
projectFunctions.generalFunctions.navigation = function () {

    $(window).on('load, resize', function () {});

    $(document).on({

        ajaxStop: function ajaxStop() {
            $('#loading-screen').fadeOut();
        }
    });

    $('.hamburger').on('click', function () {
        $(this).toggleClass('is-active');
        $('html').toggleClass('nav-active');
    });

    // $('body').on('scroll', function(){
    //     var scrollPos = $(this).scrollTop();

    //     if(scrollPos < 250){
    //         $('#top-nav').css('margin-top', '0');
    //     }else{
    //         $('#top-nav').css('margin-top', '-40px');
    //     }
    // });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
};
'use strict';

/**
 * General functions.
 */
projectFunctions.networkFunctions = projectFunctions.networkFunctions || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.networkFunctions.init = function () {

    if ($('body').hasClass('page-template-network')) {
        this.networkModal();
    }
};

/**
 * SDG Finder
 */
projectFunctions.networkFunctions.networkModal = function () {

    $('.network-item .network-name a').on('click', function () {
        $(this).parent().parent('.network-item').toggleClass('active');
        $('.overlay').fadeIn();
    });
    $('.overlay, .network-item .close-network').on('click', function () {
        $('.network-item').removeClass('active');
        $('.overlay').fadeOut();
    });

    var categoriesArr = [];

    $.when($.getJSON('/wp-json/wp/v2/categories?per_page=20', function (data) {

        $.each(data, function (key, value) {
            var id = value['id'];
            var name = value['name'];
            var acfId = value['acf']['sdg_id'];
            var parent = value['parent'];
            console.log(value);
            if (acfId != 0 && parent == 1 || acfId != 0 && parent == 27) {
                categoriesArr.push('<option value="' + id + '">' + name + '</option>');
            }
        });
    })).done(function () {

        $('.select-input').append(categoriesArr.join(""));

        $('.select-input, .type-input').on('change', function () {
            var selVal = $('.select-input').val();
            var selVal2 = $('.type-input').val();

            $('.network-item').each(function () {
                var isType,
                    isPart = true;
                var categoriesArr = $(this).data('category-ids');
                var arr1 = JSON.parse("[" + categoriesArr + "]");
                var arr2 = JSON.parse("[" + selVal + "]");
                isPart = compareArrays(arr2, arr1) || selVal == 0 ? true : false;

                var typeId = $(this).data('type');

                isType = selVal2 == typeId || selVal2 == 0 ? true : false;

                if (isType == true && isPart == true) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    function compareArrays(arr1, arr2) {
        return $(arr1).not(arr2).length == 0;
    };
};
"use strict";

/**
 * General functions.
 */
projectFunctions.accountCreate = projectFunctions.accountCreate || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.accountCreate.init = function () {
    //this.radioTrigger();
    this.signup();
    this.countries();
};

/**
 * Append countries to select
 */

projectFunctions.accountCreate.countries = function () {

    // Global Variables
    var countriesList = document.getElementById("countries_select");
    var countries = void 0; // will contain "fetched" data

    fetch("https://restcountries.eu/rest/v2/all?fields=name;callingCodes").then(function (res) {
        return res.json();
    }).then(function (data) {
        return initialize(data);
    }).catch(function (err) {
        return console.log("Error:", err);
    });

    function initialize(countriesData) {
        countries = countriesData;
        var options = "";
        var count = 0;

        countries.forEach(function (country) {
            options += "<option data-code=\"" + country.callingCodes[0] + "\" value=\"" + count + "\">" + country.name + "</option>";
            count++;
        });

        countriesList.innerHTML = options;

        // Select DNK (Denmark) as default
        countriesList.selectedIndex = 62;
    }
};

/**
 * Signup
 */
projectFunctions.accountCreate.signup = function () {

    var queryString = window.location.search;
    console.log(queryString);
    // ?product=shirt&color=blue&newuser&size=m
    var urlParams = new URLSearchParams(queryString);
    var membership = urlParams.get('membership');

    var membershipSelection = $('form #membership');
    membershipSelection.val(membership);
    localStorage.setItem('membership', membership);

    function shouldSee(parma) {
        if ($(parma).val() == "1" || $(parma).val() == "2") {
            $('.company').fadeOut();
            $('.company input, .company select, .company textarea, .company range').prop('required', false);
        } else {
            $('.company').fadeIn();
            $('.company input, .company select, .company textarea, .company range').prop('required', true);
        }
    }
    shouldSee(membershipSelection);
    membershipSelection.on('change load', function () {
        shouldSee(membershipSelection);
    });
};

var watch = $("input['text'], select, textarea, range");
watch.each(function (index) {
    var itemid = $(this).attr('id');
    var itemVal = localStorage.getItem(itemid);
    $('#' + itemid).val(itemVal);
});

watch.on('keyup, change', function () {
    var itemid = $(this).attr('id');
    var itemVal = $(this).val();
    localStorage.setItem(itemid, itemVal);
});

/**
 * SDG Finder
 */
projectFunctions.accountCreate.radioTrigger = function () {

    $("#sign-up").submit(function (e) {
        e.preventDefault();
    });

    $('#company-type-selector button').on('click', function () {
        $('#company-type-selector button').removeClass('active');
        var id = $(this).data('company-type-id');
        $('#company-type-selector input[value=' + id + ']').prop("checked", true);
        $('#company-type-selector button[data-company-type-id=' + id + ']').addClass('active');
        var selectedText = $(this).html();
        $('#pre-sel').html(selectedText);
    });

    $('#sdg-selection img').on('click', function () {
        $('#sdg-selection img').removeClass('active');
        var id = $(this).data('company-sdg-id');
        $('#sdg-selection input[value=' + id + ']').prop("checked", true);
        $('#sdg-selection img[data-company-sdg-id=' + id + ']').addClass('active');
    });

    // Steps 
    $('.company-type').on('click', function (e) {
        e.preventDefault();
    });
};

})(jQuery);