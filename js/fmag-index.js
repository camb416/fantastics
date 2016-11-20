(function($){


    /* Every time the window is scrolled ... */
    $(window).scroll( function(){

        /* Check the location of each desired element */
        $('.index-side .widget').each( function(i){

            var middle_of_object = $(this).offset().top + $(this).outerHeight()/2;
            var bottom_of_window = $(window).scrollTop() + $(window).height();

            /* If the object is completely visible in the window, fade it it */
            if( bottom_of_window > middle_of_object ){
console.log($(this));
                $(this).animate({'opacity':'1'},500);

            }

        });

    });


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


if($('body').hasClass('home')){


// Create a clone of the menu, right next to original.
$('.site-header').addClass('original').clone().insertAfter('#page').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();

    // scrollIntervalID = setInterval(stickIt, 10);





    $('document').ready(function(){
        console.log('document ready');
        sidebarStretch();

        tumblrStretch();

    });

function tumblrStretch(){

    var coverHeight = 862;

    $('.Tumblr ul').css('height', $('.storyroll').eq(0).height()+coverHeight);

}


    // lets automatically make the sidebar thingies snap to the height of two stories
    function sidebarStretch(){
        console.log('sidebar stretching');


        var sideArray = $('.index-side');

        for(var i = 0; i <= sideArray.length; i++){

            var articleArray = sideArray.eq(i).closest('.twocol').find('article');

            var firstHeight = articleArray.eq(0).height();
            var secondHeight = articleArray.eq(1).height();

           // $('.index-side').eq(i).css('height',firstHeight + secondHeight + 35);

            // for testing
            // console.log("first: " + firstHeight);
            // console.log("second: " + secondHeight);

            // articleArray.eq(0).css('background','#f00');
            // articleArray.eq(1).css('background','#f00');

        }

    }

    // parrallax scroll the sidebars
    function kenBurnsBaby(){
        //console.log( $('.index-side').scrollTop());

        var orgElementPos = $('.index-side').eq(0).offset();
        //console.log(orgElementPos);
        orgElementTop = orgElementPos.top;
        orgElementHeight = $('.index-side').eq(0).height();
        //console.log(orgElementHeight);
        //console.log("org:" + orgElementTop);
        //console.log("window: "+ ($(window).scrollTop()));
       // if ($(window).scrollTop() >= (orgElementTop)) {

        // start the scroll when
        // orgElementTop == $(window).scrollTop() + $(window).height();

        // finish the scroll when
        // orgElementTop == $(window).scrollTop();

        //console.log("first condition: " + orgElementTop + " < " + ($(window).scrollTop()+$(window).height()) );
        //console.log("second: "+ (orgElementTop+orgElementHeight) +" > "+ $(window).scrollTop());

    if(orgElementTop<($(window).scrollTop()+$(window).height()) && ((orgElementTop+orgElementHeight) > $(window).scrollTop())){

        var pct = (-50 - ((orgElementTop - $(window).scrollTop())/$(window).height() * 30)) + "%";

        // as a percentage
        //console.log("pct: " + pct);

        $('.index-side').eq(0).find('img').eq(0).css('left',pct);

    }

    }


    /*
    Ken Burns effect on sidebar
     */
    $(window).scroll(function(){
       // kenBurnsBaby();
    });


}
})(jQuery);