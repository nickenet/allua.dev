<? /*

Шаблон отправки сообщения контрагенту

*/ ?>

*warning_mail*

<div class="form-horizontal" role="form">
    <form action="*action*" ENCTYPE="multipart/form-data" method="post" id="mail_form">
        <div class="form-group has-warning">
            *yourmail*:
            <input type="hidden" name="hiddenbut" value="go">&nbsp;<input type="text" name="email" maxlength="50" size="50" class="form-control">
        </div>
        <div class="form-group has-warning">
            *yourmessage*:
            <textarea name="texty" id="texty" cols="10" rows="5" onKeyUp="textCounter('texty', 'remLen', *message_size*);" class="form-control"></textarea>
            <input readonly type="text" name="remLen" id="remLen" size="3" maxlength="4" value="*message_size*" style="width:216px;" class="form-control"> *characters_left*
        </div>
        <div class="form-group has-warning">
            *attach* (< *max_attach* Kb): &nbsp;&nbsp;
            <input type="hidden" name="hiddenbut" value="go">&nbsp;<input type="file" name="file" maxlength="200" size="50" class="form-control">
        </div>
        <div class="form-group has-warning">
            *captcha* *security*:
            <input type="text" name="security" maxlength="100" value="" class="form-control">
        </div>
        <div class="form-group has-default">
            <input type="submit" name="inbut" value="*sendmessage_button*" class="btn btn-primary">
        </div>
    </form>
</div>


<style type="text/css">
label.error {
	display: block;
	color: red;
}
</style>


<script type="text/javascript">
function textCounter (field, countField, maxLimit)
{
	maxLimit = parseInt(maxLimit);
	field = $('#' + field);
	countField = $('#' + countField);
	if (!field.length || !countField.length)
	{
		return;
	} 

	var text = field.val(); 
	
	if (text.length > maxLimit)
	{
		field.val(text.substr(0, maxLimit));
	}
	
	countField.val(maxLimit - text.length);
}


$(function() {
	
	$('#mail_form').validate({
		rules: { 
				email: 'required email',
				texty: 'required',
				security: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			form.submit();
		}
	});		
	
	$('#texty').keyup();
});
</script>  
