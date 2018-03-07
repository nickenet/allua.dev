<? /*

Шаблон - страница жалоб (complaint.php)

*/ ?>

<br />
<form action="complaint.php?REQ=send" method="post" id="complaint_form">
<table cellpadding="1" cellspacing="3" border="0" width="550">
 <tr>
   <td align="right" width="40%">Ваше имя:</td>
   <td align=left width=60%>&nbsp;<input type="text" name="name"  value="*rezult_name*" maxlength="50" size="35"></td>
 </tr>
 <tr>
   <td align="right" width="40%">E-mail: <font color=red>*</font></td>
   <td align=left width=60%>&nbsp;<input type="text" name="mail" maxlength="50"  value="*rezult_mail*" size="35"><br></td>
 </tr>
 <tr>
   <td align="right" width="40%">Адрес страницы:</td>
   <td align=left width=60%>&nbsp;<input type="text" name="url" maxlength="50"  value="*url*" size="35"><br></td>
 </tr>
 <tr>
   <td align="right" width="40%">Нарушение: <font color=red>*</font></td>
   <td align="left" width="60%">
<select style="width: 415px;" size="14" name="category">
<option value="Фирма не существует">Фирма не существует</option>
<option value="Контактные данные не достоверны">Контактные данные не достоверны</option>
<option value="Дублирующая страница компании">Дублирующая страница компании</option>
<option value="Информация, нарушающая авторские права">Информация, нарушающая авторские права</option>
<option value="Информация о товарах и услугах, не соответствующих законодательству">Информация о товарах и услугах, не соответствующих законодательству</option>
<option value="Незаконно полученная частная и конфиденциальная информация">Незаконно полученная частная и конфиденциальная информация</option>
<option value="Информация с множеством грамматических ошибок">Информация с множеством грамматических ошибок</option>
<option value="Информация непристойного содержания">Информация непристойного содержания</option>
<option value="Содержание, связанное с насилием">Содержание, связанное с насилием</option>
<option value="Спам, вредоносные программы и вирусы (в том числе ссылки)">Спам, вредоносные программы и вирусы (в том числе ссылки)</option>
<option value="Информация о заработке в интернете">Информация о заработке в интернете</option>
<option value="Информация не носящая деловой характер">Информация не носящая деловой характер</option>
<option value="Информация оскорбляющая честь и достоинство третьих лиц">Информация оскорбляющая честь и достоинство третьих лиц</option>
<option value="Другие нарушения правил размещения информации">Другие нарушения правил размещения информации</option>
</select>
   </td>
 </tr>
 <tr>
   <td align="middle" width="100%" colspan="2"><br>Текст комментария:</td>
 </tr>
 <tr>
   <td align="middle" width="100%" colspan="2"><textarea name="text" cols="60" rows="10">*rezult_text*</textarea><br></td>
 </tr>
  <tr>
   <td align="right" colspan="2">Код безопасности: <font color="red">*</font>
   *security*&nbsp;<input type="text" name="security" maxlength="15">
   </td>
  </tr>
  <tr>
   <td align="right" colspan="2"><input type="submit" name="inbut" value="Отправить" border="0"><input type="hidden" name="firma_id" value="*id_firma*"></td>
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
$(function() {
	
	$('#complaint_form').validate({
		rules: { 
				mail: 'required email',
				category: 'required',
				security: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			form.submit();
		}
	});		
});
</script>