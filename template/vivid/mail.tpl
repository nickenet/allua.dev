<? /*

Шаблон отправки сообщения контрагенту

*/ ?>

*warning_mail*
<form action="*action*" ENCTYPE="multipart/form-data" method="post" id="mail_form">
<table cellpadding="5" cellspacing="1" border="0" width="100%">
 <tr>
  <td bgColor="*bgcolor*" align="right" width="30%">*yourmail*: <font color="red">*</font></td>
  <td bgColor="*bgcolor*" align="left" width="70%"><input type="hidden" name="hiddenbut" value="go">&nbsp;<input type="text" name="email" maxlength="50" size="50">
  </td>
 </tr>
 <tr>
  <td bgColor="*bgcolor*" align="right" width="30%">*yourmessage*: <font color="red">*</font></td>
  <td bgColor="*bgcolor*" align="left" width="70%">&nbsp;<textarea name="texty" id="texty" cols="10" rows="5" onKeyUp="textCounter('texty', 'remLen', *message_size*);" style="width:316px;"></textarea>
   <br>&nbsp;<input readonly type="text" name="remLen" id="remLen" size="3" maxlength="4" value="*message_size*"> *characters_left*
   </td>
 </tr>
 <tr>
  <td bgColor="*bgcolor*" align="right" width="30%">
   *attach* (< *max_attach* Kb): &nbsp;&nbsp;
  </td>
  <td bgColor="*bgcolor*" align="left" width="70%"><input type="hidden" name="hiddenbut" value="go">&nbsp;<input type="file" name="file" maxlength="200" size="50">
  </td>
 </tr>
 <tr>
   <td align="right" colspan=2>*captcha* <font color="red">*</font>
       *security*&nbsp;<input type="text" name="security" maxlength="100" value="" style="width:150px;">
   </td>
 </tr>
 <tr>
   <td align="right" bgColor="*bgcolor*" colspan="2">
    <input type="submit" name="inbut" value="*sendmessage_button*">
   </td>
 </tr>
</table>
</form>


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
