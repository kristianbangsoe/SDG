/**
 * General functions.
 */
projectFunctions.sdgWheelFunctions = projectFunctions.sdgWheelFunctions || {};

/**
 * Init: Will be triggered on document ready.
 */
projectFunctions.sdgWheelFunctions.init = function() {
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
        var step = 360/counter;
        
        // set starting angle
        var angle = -90-(360/counter);
        
        // convert to radian
        var rad = angle * (Math.PI / 360);
        
        var x = 0;
        var y = 0;
        
        // loop in links 
        $.each(links, function(){
            angle += step;
            rad = angle * (Math.PI / 180);
            x = Math.round(r * Math.cos(rad)) + 125;
            y = Math.round(r * Math.sin(rad));
            //$(this).css({ left: x + 'px', 'margin-top': -1*y + 'px' });
            $(this).animate({ left: x + 'px', 'margin-top': +1*y + 'px' });
            $(this).attr('data-left', x + 'px').attr('margin-top', +1*y + 'px');
           
        });
        var old_Link = $('.categories a').attr('href');
        
      
        $('html, body').animate({scrollTop: '+=190px'});
      
           
        
        links.on('click',function(e){
            
            $('.categories a').attr('href','');
            e.preventDefault();
            $('.categories .sdg-img').css( 'opacity','0').delay(500);
            var name = $(this).data('name');
            var color = $(this).data('color');
            var description = $(this).data('description');
            var sgdId = $(this).data('id');
            links.removeClass('active');
            $(this).addClass('active');
            console.log(name);
            var link = $(this).data('href');
            $('#find-sdg .half-circle-menu').css('background-color', color);
            $('#find-sdg').css('background-color', color+ 'c7');
            $('#content').css('background-color','black');


            $('.sdg-description').css('color','white');
            $('.categories .sdg-title').hide();
            //$('.categories .sdg-title').text(sgdId + '. ' +name);
        
            $('.categories .sdg-description').text(description);
            $('.categories a').fadeIn();
            
            $('.categories .sdg-img').animate({ opacity:'1'});
            $('.categories .sdg-img').attr('src', 'https://raw.githubusercontent.com/UNStats/FIS4SDGs/master/globalResources/sdgIcons1000x1000/TGG_Icon_Color_'+sgdId+'.png');
           
            $('.categories a').attr('href',old_Link +link);
        });
    }
    
    $(document).ready(function(){
        setPosition();
    });

};





