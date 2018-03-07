<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: support.php
-----------------------------------------------------
 Назначение: Отправка сообщения администратору
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$tosupport=$_POST[tosupport];

if ($tosupport=="") $error1="Вы пытаетесь отправить пустое сообщение!";
if ($f[mail]=="") $error2="У Вас не указан контактный e-mail!";


if ( (!isset($error1)) and (!isset($error2)) ) 

{

$text = "

Здравствуйте.

Данное письмо в службу поддержки клиентов Вам отправил клиент каталога ID=$f[selector] с сайта $def_mainlocation ($def_title)

------------------------------------------------
Текст сообщения
------------------------------------------------

Сообщение - $tosupport

------------------------------------------------
Помните, что администрация сайта не несет ответственности за содержание данного письма

С уважением,

Администрация $def_mainlocation";

$to = $def_adminmail;
$mail = $f[mail];

if ($_POST[support_type]=="uslugi") $mail_s="Заказ дополнительных услуг"; else $mail_s="В службу поддержки";

mail($to,$mail_s,stripcslashes($text),"From: $mail\r\nContent-Type: text/html; charset=windows-1251\r\n"."Reply-To: $mail\r\n"."MIME-Version: 1.0\n"."X-Sender: $mail\n"."X-Mailer: I-Soft Bizness\n"."X-Priority: 3 (Normal)\n");

echo "<center><div align=\"center\" id=\"messages\">Ваше сообщение успешно отправлено администратору каталога! <img src=\"$def_mainlocation/users/template/images/ok.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\" align=\"middle\"></div></center>";

}

else

{

echo "<center><div align=\"center\" id=\"messages\"><img src=\"$def_mainlocation/users/template/images/error.gif\" width=\"64\" height=\"64\" hspace=\"2\" vspace=\"2\"><br><font color=red><b>Ошибка!</b></font><br>$error1 $error2</div></center>";

}

?>