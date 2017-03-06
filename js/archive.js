(function($){
$(document).ready(function(e){

    // this matches the heights of the grid of stories...
    // TODO: make sure this is actually doing something considering the default set at 360 in _archive.scss line 87

    var stories = $('.fmag_story');
    var tallest = 0;
    for(var i=0;i<stories.length;i++){
        if($(stories[i]).height() > tallest) tallest = $(stories[i]).height();
    }
    $('.fmag_story').height(tallest);




});
})(jQuery);