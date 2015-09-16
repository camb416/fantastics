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

    // scroll to top
    /*
    function scrollTop(){
            $("html, body").animate({
                scrollTop: 0
            }, 600);
    }
    */

    function nextSpread(){
        setSpread(curSpread+1);
    }
    function prevSpread(){
        setSpread(curSpread-1);
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
            //scrollTop();
        });
        $('.bigspreads li img').click(function(e){
            var whichClicked_int = $(this).prevAll().length;
            if(whichClicked_int === 0){
                prevSpread();
            } else {
                nextSpread();
            }
        })

    });




})(jQuery);
