(function($){
$(document).ready(function(e){
    var a = $('a.frontlink').width();
    var b = $('main').width();
    var c = b-a-40;
    $('body.archive header.page-header, body.search header.page-header h1').width(c);
    $('body.archive header.page-header, body.search header.page-header').width(c);
});
})(jQuery);