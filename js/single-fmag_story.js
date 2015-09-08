(function($){

    var curSpread;
    var numSpreads;



    function setSpread(newSpread){
        if(newSpread>=0 && newSpread<numSpreads){
            reset();
            curSpread = newSpread;
            update();
            return 0;
        } else {
            return -1;
        }
    }

    function scrollTop(){
            $("html, body").animate({
                scrollTop: 0
            }, 600);
    }

    function reset(){
        $('.bigspreads li').eq(curSpread).addClass('hidden');
        $('.tinyspreads li').eq(curSpread).removeClass('active');
    }
    function update(){
        $('.bigspreads li').eq(curSpread).removeClass('hidden');
        $('.tinyspreads li').eq(curSpread).addClass('active');
    }

    $(document).ready(function(e){

        curSpread = 0;

        numSpreads = $('.tinyspreads li').length;
        console.log("numspreads: "+numSpreads)

        $('.tinyspreads li').click(function(e){
            var whichClicked_int = $(this).prevAll().length;
            setSpread(whichClicked_int);
            scrollTop();
        });

    });




})(jQuery);
