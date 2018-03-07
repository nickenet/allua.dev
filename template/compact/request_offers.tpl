<? /*

Форма отправки заявки компании

*/ ?>

<div align="right"><br><br><b>Перейти в раздел компании &raquo;</b> Продукция и услуги <a href="*link_type*" title="*company*">[*type*]</a> <a href="*link_type_all*" title="*company*">[Показать все]</a></div>

<div align="left" style="padding: 5px;"><b><a id="help_link" href="javascript:;">Оформить заявку <img src="images/market.gif" border="0" alt="Заявка" align="absmiddle" /></a></b></div>

<div id="help_content" class="hh" style="padding:10px; text-align:left;">
<a id="help_close" href="javascript:;" style="float: right" class="closed">Закрыть заявку [X]</a>
<img style="display:none;" src="images/go.gif" id="send_req_img"> 
<div id="send_req_info"></div>
<form action="alloffers.php?REQ=send&full=*id_firm*&idfull=*full_offers*&catfirm=*cat_firm*" method="post" id="send_req">
    
<div style="text-align:left; padding: 3px;">Заявка на продукцию или услугу - <b>"*title*"</b><br><br>
Проверте правильность контактных данных.<br> Поля помеченные: <font color="red">*</font> обязательны к заполнению!</div>
    
<table cellpadding="1" cellspacing="0" border="0" width="450">
<tr><td align="right" colspan="2"><br></td></tr>
<tr><td align="right" width="40%">Ваше имя: <font color=red>*</font></td><td align="left" width="60%">&nbsp;<input type="text" name="name"  value="*rezult_name*" id="name" maxlength="50" size="35" required></td></tr>
<tr><td align="right" width="40%">Название компании: &nbsp;&nbsp;</td><td align="left" width="60%">&nbsp;<input type="text" name="firm"  value="*rezult_firm*" id="firm" maxlength="50" size="35"></td></tr>
<tr><td align="right" width="40%">Телефон: <font color=red>*</font></td><td align="left" width="60%">&nbsp;<input type="text" name="tel"  value="*rezult_phone*" id="tel" maxlength="50" size="35" required></td></tr>
<tr><td align="right" width="40%">E-mail: &nbsp;&nbsp;</td><td align="left" width="60%">&nbsp;<input type="text" name="mail" maxlength=50  value="*rezult_mail*" id="mail" size=35><br></td></tr>
<tr><td align="middle" width=100% colspan="2"><br>Сообщение: <br><br></td></tr>
<tr><td align="middle" width="100%" colspan="2"><textarea name="text" cols="60" rows="10" id="message">*rezult_text*</textarea><br></td></tr>
  <tr>
   <td align="right" colspan=2>Код безопасности: <font color="red">*</font>
       *security*&nbsp;<input type="text" name="security" maxlength="100" value="" style="width:150px;" id="security">
   </td>
  </tr>
<tr><td align="right" colspan="2"><input type="submit" id="send_form" name="inbut" value="Отправить заявку"></td></tr>
</table>
</form>
</div>
<div id="ok_send"></div>

<style type="text/css">
.hh {
    display: none;
}

label.error {
	display: block;
	color: red;
}
</style>



