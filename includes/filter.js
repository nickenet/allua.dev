(function($){
$.fn.shuffle = function() {
        var allElems = this.get(),
            shuffled = $.map(allElems, function(){
                var random = getRandom(allElems.length),
                    randEl = $(allElems[random]).clone(true)[0];
                allElems.splice(random, 1);
                return randEl;
            });
        
        this.each(function(i){
            $(this).replaceWith($(shuffled[i]));
        });
        
        return $(shuffled);
    };
})(jQuery);
   
$(function(){
	   
	$("#allcat").click(function(){
		$(".discounted-item").slideDown();
		$("#catpicker a").removeClass("current");
		$(this).addClass("current");
		return false;
	});

	$(".filter").click(function(){
		var thisFilter = $(this).attr("id");
		$(".discounted-item").slideUp();
		$("."+ thisFilter).slideDown();
		$("#catpicker a").removeClass("current");
		$(this).addClass("current");
		return false;
	});

	$('#newimg').click();	
});


function getRandom(max) 
{
    return parseInt( Math.random() * max );
}