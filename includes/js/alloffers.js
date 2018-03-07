<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/messages_ru.js"></script>

<script type="text/javascript">
    $(function() {

	$('#send_req').validate({
		rules: {
				name: 'required',
				tel: 'required',
				security: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			$(form).ajaxSubmit();
		}
	});
       
    $('#send_form').click(function() {
        var name = $("#name").val();
        var tel = $("#tel").val();
        var mail = $("#mail").val();
	var message = $("#message").val();
        var security = $("#security").val();
        var firm = $("#firm").val();
		
        if($('#send_req').valid()) { 
        $.ajax({
            type: "POST",
            url: 'includes/ajax/send_request.php',
			dataType: "script",
            data: { id: <? echo $f['selector']; ?>, name: name, id_num: <? echo $full_offers; ?>, mail: mail, tel: tel, message: message, security: security, firm: firm  },
            cache: false,
            beforeSend: function() { $('#send_req_img').css("display","block"); },
            success: function(html) { eval(html);  $('#send_req_img').css("display","none");}
        });
        }
		return false;
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
</script>