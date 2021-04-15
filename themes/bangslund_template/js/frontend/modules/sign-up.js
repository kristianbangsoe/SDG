/**
 * General functions.
 */
projectFunctions.accountCreate = projectFunctions.accountCreate || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.accountCreate.init = function() {
    //this.radioTrigger();
    this.signup();
    this.countries();
};


/**
 * Append countries to select
 */

projectFunctions.accountCreate.countries = function () {

    // Global Variables
    const countriesList = document.getElementById("countries_select");
    let countries; // will contain "fetched" data
    
    fetch("https://restcountries.eu/rest/v2/all?fields=name;callingCodes")
    .then(res => res.json())
    .then(data => initialize(data))
    .catch(err => console.log("Error:", err));
    
    function initialize(countriesData) {
      countries = countriesData;
      let options = "";
        var count = 0;
      
      countries.forEach(country => {
        options+=`<option data-code="${country.callingCodes[0]}" value="${count}">${country.name}</option>`;
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
    
    const queryString = window.location.search;
    console.log(queryString);
    // ?product=shirt&color=blue&newuser&size=m
    const urlParams = new URLSearchParams(queryString);
    const membership = urlParams.get('membership');
    
    var membershipSelection = $('form #membership');
    membershipSelection.val(membership);
    localStorage.setItem('membership', membership);
    
    function shouldSee(parma) {
        if ($(parma).val() == "1" || $(parma).val() == "2") {
            $('.company').fadeOut();
            $('.company input, .company select, .company textarea, .company range').prop('required', false)
        }else{
            $('.company').fadeIn();
            $('.company input, .company select, .company textarea, .company range').prop('required', true)
        }  
    }
    shouldSee(membershipSelection);
    membershipSelection.on('change load', function () {
        shouldSee(membershipSelection);
    });
};

    const watch = $( "input['text'], select, textarea, range" );
    watch.each(function( index ) {
        var itemid= $(this).attr('id');
        var itemVal = localStorage.getItem(itemid);
        $('#'+itemid).val(itemVal);
    });


    watch.on('keyup, change', function () {
        var itemid= $(this).attr('id');
        var itemVal = $(this).val();
        localStorage.setItem(itemid, itemVal);
    });

/**
 * SDG Finder
 */
projectFunctions.accountCreate.radioTrigger = function () {

    $("#sign-up").submit(function(e) {
        e.preventDefault();
    });

    $('#company-type-selector button').on('click', function () {
        $('#company-type-selector button').removeClass('active');
        var id = $(this).data('company-type-id');
        $('#company-type-selector input[value='+id+']').prop("checked", true);
        $('#company-type-selector button[data-company-type-id='+id+']').addClass('active');
        var selectedText = $(this).html();
        $('#pre-sel').html(selectedText);
    })

    $('#sdg-selection img').on('click', function () {
        $('#sdg-selection img').removeClass('active');
        var id = $(this).data('company-sdg-id');
        $('#sdg-selection input[value='+id+']').prop("checked", true);
        $('#sdg-selection img[data-company-sdg-id='+id+']').addClass('active');
    })

    // Steps 
    $('.company-type').on('click', function (e) {
        e.preventDefault();
    });
    
};





