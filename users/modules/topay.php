<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: topay.php
-----------------------------------------------------
 Назначение: Заявка на перевод в платную группу
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}


if (isset($_POST['pay'])) {

// Проверяем на корректность

	if (
		($_POST["mail"] <> "")
		and ($_POST[name] != "")
		and ($_POST[firm] != "")
		and ($_POST[id] != "")
		and ($_POST[item_name] != "")
		and ($_POST[price] != "")
	   ) {

// Все корректно

$text = "

Здравствуйте.

Данное письмо вам отправил $_POST[name] с сайта $def_mainlocation ($def_title)

------------------------------------------------
Текст сообщения
------------------------------------------------

Заявка на перевод аккаунта в тарифный план  «$_POST[item_name]»

Имя отправителя - $_POST[name]

Телефон - $_POST[phone]

E-mail - $_POST[mail]

Название компании - $_POST[firm]

Тарифный план -  $_POST[item_name]

Стоимость нахождения в тарифном плане - $_POST[price]

";

// Оплата электронными платежами

if ($_POST['pay']=="1") {

$text .= "
------------------------------------------------

WMID - $_POST[wmid]

Кошелек WMZ - $_POST[wmz]

Кошелек WMR - $_POST[wmr]

Счет Яндекс.Деньги - $_POST[yandex] 

";

}

// Оплата банковским переводом

if ($_POST['pay']=="2") {

$text .= "
------------------------------------------------

Наименование платежа - $_POST[platezh]

Сумма платежа - $_POST[summa]

ФИО плательщика - $_POST[fio]

Адрес плательщика - $_POST[adressp]

Дата оплаты - $_POST[datep]

";

}

$text .= "
-----------------------------------------------

Сообщение:

$_POST[text]

------------------------------------------------
Помните, что администрация сайта не несет ответственности за содержание данного письма

С уважением,

Администрация $def_mainlocation";


		$to = $def_adminmail;
		$mail = $_POST[mail];

			mail($to,"Обновление тарифного плана",stripcslashes($text),"FROM: ".$mail."\r\nContent-Type: text/plain; charset=windows-1251\r\n");

// Письмо клиенту каталога

$text_klient = "

Здравствуйте.

Данное письмо отправлено с сайта $def_mainlocation ($def_title)

------------------------------------------------
Текст сообщения
------------------------------------------------

Доброе время суток.

Заявка на перевод аккаунта в тарифный план  «$_POST[item_name]» была отправлена администратору сайта.

В ближайшее время администратор рассмотрит Вашу заявку и свяжется с Вами.

------------------------------------------------

Ваши данные

Имя - $_POST[name]

Телефон - $_POST[phone]

E-mail - $_POST[mail]

Название компании - $_POST[firm]

Тарифный план -  $_POST[item_name]

Стоимость нахождения в тарифном плане - $_POST[price]

------------------------------------------------
Помните, что администрация сайта не несет ответственности за содержание данного письма

С уважением,

Администрация $def_mainlocation";

        		mail($mail,"Обновление тарифного плана",stripcslashes($text_klient),"FROM: ".$to."\r\nContent-Type: text/plain; charset=windows-1251\r\n");

echo "<center><div align=\"center\" id=\"messages\">Ваше сообщение успешно отправлено администратору каталога! <img src=\"$def_mainlocation/users/template/images/ok.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\" align=\"middle\"></div></center>";

	     } else

	     {

// Ошибка заполнения поля

echo "<center><div align=\"center\" id=\"messages\"><img src=\"$def_mainlocation/users/template/images/error.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\"><br><font color=red><b>Ошибка!</b></font><br>Заполните обязательные поля.</div></center>";


	     }	



}

else

{

?>

<script type="text/javascript" language="JavaScript">

function showBut(el){

if(el.checked)
document.regform.regbut.disabled=false;
else 
document.regform.regbut.disabled=true;
}

function showBut1(el){

if(el.checked)
document.regform1.regbut1.disabled=false;
else 
document.regform1.regbut1.disabled=true;
}

</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Электронные платежи</li>
            <li class="TabbedPanelsTab" tabindex="0">Оплата банковским переводом</li>
            <li class="TabbedPanelsTab" tabindex="0">Оплата наличными</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">Заявка на оплату для перевода Вашего аккаунта на тарифный план: <b><? echo "$_POST[item_names]"; ?></b>&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/topay1.gif" alt="Электронные платежи" width="193" height="125"></td>
    <td align="center"><br>
      <b>Поля помеченные: <font color=red>*</font> обязательны к заполнению!</b><br><br>
Проверьте правильность контактных данных.<br> Укажите наиболее удобный для Вас кошелек в системе WebMoney или Яндекс.Деньги, на который будет выставлен счет на оплату.<br>
    </td>
  </tr>
</table>
<div align="center">
<table cellpadding=1 cellspacing=0 border=0 width=450>
<form action="?REQ=authorize&mod=topay" name='regform' ENCTYPE="multipart/form-data" method=post>
<tr><td align=right colspan=2><br></td></tr>
<tr><td align=right width=40%>Ваше имя: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=name  value="<? echo "$_POST[name]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%><b>Ваш ID в системе:</b> <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=id  value="<? echo "$_POST[ids]"; ?>" maxlength=30 size=5 style="background-color : #F3F3F3;" ></td></tr>
<tr><td align=right width=40%>Название компании: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=firm  value="<? echo "$_POST[firms]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%>Телефон: &nbsp;&nbsp;</td><td align=left width=60%></font>&nbsp;<input type=text name=phone  value="<? echo "$_POST[phones]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%>E-mail: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=mail maxlength=50  value="<? echo "$_POST[mails]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Тарифный план: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=item_name maxlength=50  value="<? echo "$_POST[item_names]"; ?>" size=35 style="background-color : #F3F3F3;" ><br></td></tr>
<tr><td align=right width=40%>Стоимость нахождения в тарифном плане: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=price maxlength=40  value="<? echo "$_POST[prices]"; ?>" size=15 style="background-color : #F3F3F3;" > за <? echo "$_POST[prices_day]"; ?> дней<br></td></tr>
<tr><td align=right width=40%>Ваш WMID: </td><td align=left width=60%></font>&nbsp;<input type=text name=wmid maxlength=50  value="<? echo "$_POST[wmid]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Ваш WMZ кошелек: </td><td align=left width=60%></font>&nbsp;<input type=text name=wmz maxlength=50  value="<? echo "$_POST[wmz]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Ваш WMR кошелек: </td><td align=left width=60%></font>&nbsp;<input type=text name=wmr maxlength=50  value="<? echo "$_POST[wmr]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Ваш счет Яндекс.Деньги: </td><td align=left width=60%></font>&nbsp;<input type=text name=yandex maxlength=50  value="<? echo "$_POST[yandex]"; ?>" size=35><br></td></tr>
<tr><td align=middle width=100% colspan=2><br>Сообщение: <br><br></td></tr>
<tr><td align=middle width=100% colspan=2><textarea name=text cols=60 rows=10><? echo "$_POST[text]"; ?></textarea><br></td></tr>
<tr><td align=right colspan=2>
<INPUT TYPE="checkbox" name="pravila" value="on" onclick="showBut(this)"> С тарифным планом ознакомлены, с условиями оплаты согласны&nbsp;<br>
<input type=submit name="regbut" disabled="true" value="Отправить" border=0><input type="hidden" name="pay" value="1"></td></tr>
</form></table>
</center>
<br>
		  </td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
              </div>
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE">Заявка на оплату для перевода Вашего аккаунта на тарифный план: <b><? echo "$_POST[item_names]"; ?></b>&nbsp;</td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="200" align="center"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/topay2.jpg" alt="Оплата банковским переводом" width="193" height="125"></td>
    <td align="center"><br>
      <b>Поля помеченные: <font color=red>*</font> обязательны к заполнению!</b><br><br>
Проверьте правильность контактных данных.<br>
    </td>
  </tr>
</table>
<div align="center">
<? require ('doc/rekviziti.php'); ?>
<table cellpadding=1 cellspacing=0 border=0 width=450>
<form action="?REQ=authorize&mod=topay" name='regform1' ENCTYPE="multipart/form-data" method=post>
<tr><td align=right colspan=2><br></td></tr>
<tr><td align=right width=40%>Ваше имя: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=name  value="<? echo "$_POST[name]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%><b>Ваш ID в системе:</b> <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=id  value="<? echo "$_POST[ids]"; ?>" maxlength=30 size=5 style="background-color : #F3F3F3;" ></td></tr>
<tr><td align=right width=40%>Название компании: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=firm  value="<? echo "$_POST[firms]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%>Телефон: &nbsp;&nbsp;</td><td align=left width=60%></font>&nbsp;<input type=text name=phone  value="<? echo "$_POST[phones]"; ?>" maxlength=50 size=35></td></tr>
<tr><td align=right width=40%>E-mail: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=mail maxlength=50  value="<? echo "$_POST[mails]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Тарифный план: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=item_name maxlength=50  value="<? echo "$_POST[item_names]"; ?>" size=35 style="background-color : #F3F3F3;" ><br></td></tr>
<tr><td align=right width=40%>Стоимость нахождения в тарифном плане: <font color=red>*</font></td><td align=left width=60%></font>&nbsp;<input type=text name=price maxlength=40  value="<? echo "$_POST[prices]"; ?>" size=15 style="background-color : #F3F3F3;" > за <? echo "$_POST[prices_day]"; ?> дней<br></td></tr>
<tr><td align=right width=40%>Наименование платежа: </td><td align=left width=60%></font>&nbsp;<input type=text name=platezh maxlength=50  value="<? echo "$_POST[platezh]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Сумма платежа: </td><td align=left width=60%></font>&nbsp;<input type=text name=summa maxlength=50  value="<? echo "$_POST[summa]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>ФИО плательщика: </td><td align=left width=60%></font>&nbsp;<input type=text name=fio maxlength=50  value="<? echo "$_POST[fio]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Адрес плательщика: </td><td align=left width=60%></font>&nbsp;<input type=text name=adressp maxlength=50  value="<? echo "$_POST[adressp]"; ?>" size=35><br></td></tr>
<tr><td align=right width=40%>Дата оплаты: </td><td align=left width=60%></font>&nbsp;<input type=text name=datep maxlength=50  value="<? echo "$_POST[datep]"; ?>" size=35><br></td></tr>
<tr><td align=middle width=100% colspan=2><br>Сообщение: <br><br></td></tr>
<tr><td align=middle width=100% colspan=2><textarea name=text cols=60 rows=10><? echo "$_POST[text]"; ?></textarea><br></td></tr>
<tr><td align=right colspan=2>
<INPUT TYPE="checkbox" name="pravila" value="on" onclick="showBut1(this)"> С тарифным планом ознакомлены, с условиями оплаты согласны&nbsp;<br>
<input type=submit name="regbut1" disabled="true" value="Отправить" border=0><input type="hidden" name="pay" value="2"></td></tr>
</form></table>
</center>
		  </td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
            </div>
            <div class="TabbedPanelsContent">
              <p><? require ('doc/contact_pay.php'); ?></p>
              </div>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
		<? echo "$help_topay"; ?>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>

<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
</script>

<?php
}
?>