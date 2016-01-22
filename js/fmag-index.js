(function($){

if($('body').hasClass('home')){


// Create a clone of the menu, right next to original.
$('.site-header').addClass('original').clone().insertAfter('#page').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    scrollIntervalID = setInterval(stickIt, 10);



    function stickIt() {

        var orgElementPos = $('.original').offset();
        //console.log(orgElementPos);
        orgElementTop = orgElementPos.top+100;

        if ($(window).scrollTop() >= (orgElementTop)) {
            // scrolled past the original position; now only show the cloned, sticky element.

            // Cloned element should always have same left position and width as original element.
            orgElement = $('.original');
            coordsOrgElement = orgElement.offset();
            //leftOrgElement = coordsOrgElement.left;
            leftOrgElement = 0;
            // widthOrgElement = orgElement.css('width');
            widthOrgElement = "100%";
            $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show().css('opacity',1);
            $('.original').css('visibility','hidden');



        } else {
            // not scrolled past the menu; only show the original menu.
            $('.cloned').hide().css('opacity',0);
            $('.original').css('visibility','visible');
        }
    }
}
})(jQuery);