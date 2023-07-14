$('.see-more').click(function(){
    if($(this).text() == 'See More »') {                
        $(this).text("See Less »");
    } else {
        $(this).text("See More »");
    }
});