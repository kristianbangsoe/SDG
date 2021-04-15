/**
 * General functions.
 */
projectFunctions.networkFunctions = projectFunctions.networkFunctions || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.networkFunctions.init = function() {
    
    if ($('body').hasClass('page-template-network')) {
        this.networkModal();
    } 
};



/**
 * SDG Finder
 */
projectFunctions.networkFunctions.networkModal = function () {

    $('.network-item .network-name a').on('click', function(){
        $(this).parent().parent('.network-item').toggleClass('active');
        $('.overlay').fadeIn();
    });
    $('.overlay, .network-item .close-network').on('click', function(){
        $('.network-item').removeClass('active');
        $('.overlay').fadeOut();
    });
    
        var categoriesArr = [];
        
        $.when(
            $.getJSON('/wp-json/wp/v2/categories?per_page=20', function (data) {

                $.each(data, function (key, value) {
                    var id = value['id'];
                    var name = value['name'];
                    var acfId = value['acf']['sdg_id'];
                    var parent = value['parent'];
                    console.log(value);
                    if(acfId != 0 && parent == 1 || acfId != 0 && parent == 27){
                        categoriesArr.push('<option value="'+id+'">'+name+'</option>');
                    }
                    
                })
                
            })
        ).done(function () {
            
            
            $('.select-input').append(categoriesArr.join(""));
            
            
            $('.select-input, .type-input').on('change', function(){
                var selVal = $('.select-input').val();
                var selVal2 = $('.type-input').val();

                $('.network-item').each(function () {
                    var isType, isPart = true;
                    var categoriesArr = $(this).data('category-ids');
                    var arr1 = JSON.parse("[" + categoriesArr + "]");
                    var arr2 = JSON.parse("[" + selVal + "]");
                    isPart = compareArrays(arr2, arr1) || selVal == 0 ? true : false;

                    var typeId = $(this).data('type');
                    
                    isType = selVal2 == typeId || selVal2 == 0 ? true : false;

                    if (isType == true && isPart == true) {
                        $(this).show();
                    }else{
                        $(this).hide();
                    }
                    
                });
            });

            

        });

        function compareArrays(arr1, arr2) {
            return $(arr1).not(arr2).length == 0;
        };
      

  

};





