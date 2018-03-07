<? /*

Форма отправки заявки компании

*/ ?>

<div class="panel panel-default">
  <div class="panel-body">
    <div align="right"><b>Перейти в раздел компании &raquo;</b> Продукция и услуги <a href="*link_type*" title="*company*">[*type*]</a> <a href="*link_type_all*" title="*company*">[Показать все]</a></div>
  </div>
</div>

<div align="left" style="padding: 5px;"><a class="btn btn-warning" id="help_link" href="javascript:;">Оформить заявку <span class="glyphicon glyphicon-shopping-cart"></span></a></div>

<div id="help_content" class="hh" style="padding:25px; text-align:left;">
<a id="help_close" href="javascript:;" style="float: right" class="closed">Закрыть заявку [X]</a>
<img style="display:none;" src="images/go.gif" id="send_req_img"> 
<div id="send_req_info"></div>
<form action="alloffers.php?REQ=send&full=*id_firm*&idfull=*full_offers*&catfirm=*cat_firm*" method="post" id="send_req" class="form-horizontal" role="form">
    
<div class="form-group block_vote">Заявка на продукцию или услугу - <b>"*title*"</b><br>
Проверте правильность контактных данных.<br> Поля помеченные: <font color="red">*</font> обязательны к заполнению!</div>

<div class="form-group has-warning">
    Ваше имя: <font color="red">*</font>
    <input type="text" name="name"  value="*rezult_name*" id="name" maxlength="50" size="35" class="form-control" required>
</div>
<div class="form-group has-default">
    Название компании:
    <input type="text" name="firm"  value="*rezult_firm*" id="firm" maxlength="50" size="35" class="form-control">
</div>
<div class="form-group has-warning">
    Телефон: <font color="red">*</font>
    <input type="text" name="tel"  value="*rezult_phone*" id="tel" maxlength="50" size="35" class="form-control" required>
</div>
<div class="form-group has-default">
    E-mail:
    <input type="text" name="mail" maxlength=50  value="*rezult_mail*" id="mail" size="35" class="form-control">
</div>
<div>Сообщение:</div>
<div class="form-group has-default">
    <textarea name="text" cols="60" rows="10" id="message">*rezult_text*</textarea>
</div>
<div class="form-group has-warning">
    Код безопасности: <font color="red">*</font> *security*
    <input type="text" name="security" maxlength="100" value="" style="width:150px;" id="security" class="form-control">
</div>
<div class="form-group has-default">
    <input type="submit" id="send_form" name="inbut" value="Отправить заявку" class="btn btn-primary">
</div>

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



