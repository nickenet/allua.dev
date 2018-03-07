$(document).ready(function(){

	$("ul.subnav").parent().append("<span></span>"); 
	
	$("ul.topnav li span").click(function() { 
				
		$(this).parent().find("ul.subnav").slideDown('fast').show();

		$(this).parent().hover(function() {
		}, function(){	
			$(this).parent().find("ul.subnav").slideUp('slow');
		});

		}).hover(function() { 
			$(this).addClass("subhover");
		}, function(){	//On Hover Out
			$(this).removeClass("subhover");
	});

	$('#help_close').click(function(){
		$('#help_content').slideUp();
	});
	$('#help_link').click(function(){
		$('#help_content').css('paddingBottom', '10px');
		$('#help_content').slideDown(700);
		$('#help_content').animate({paddingBottom:'0'}, 300);
	});

});