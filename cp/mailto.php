<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: mailto.php
-----------------------------------------------------
 Назначение: Сообщение контрагенту
=====================================================
*/

session_start();

require_once './defaults.php';

$idident=intval($_REQUEST['id']);
if (isset($_POST['idident'])) $idident=intval($_REQUEST['idident']);

$help_section = (string)$mail_help;

$title_cp = 'Сообщение контрагенту - ';
$speedbar = ' | <a href="offers.php?REQ=auth&id='.$idident.'">'.$def_admin_offers_k.' id='.$idident.'</a> | Сообщение контрагенту';

check_login_cp('1_0','mailto.php?id='.$idident);

require_once 'template/header.php';

$r=$db->query ("select selector, firmname, mail from $db_users where selector='$idident'") or die ("mySQL error!");

$f=$db->fetcharray ($r);

table_item_top ("Сообщение котрагенту",'mailto.png');

$to = $def_adminmail;
$email= safeHTML ($_POST['email']);
$subject = safeHTML ($_POST['subject']);
$message = unHTML ($_POST['message']);

if ($email!=$f['mail']) $error_mailto = "E-mail адрес не соотвествует адресу контрагенту указанному в базе данных.";

if ($subject=="") $error_mailto1 = "Вы не указали тему сообщения.";

if ($message=="") $error_mailto2 = "Вы не указали текст сообщения.";

if ((empty ($error_mailto)) and (empty ($error_mailto1)) and (empty ($error_mailto2))) {

    mail($email,$subject,stripcslashes($message),"FROM: ".$to."\r\nContent-Type: text/plain; charset=windows-1251\r\n");

    $yes_message_mailto = 'Сообщение контрагенту компании <b>'.$f['firmname'].'</b> (id='.$f['selector'].') успешно отправлено на e-mail: <u>'.$f['mail'].'</u>.';

    msg_text('80%',$def_admin_message_ok,$yes_message_mailto);

    logsto("Отправлено сообщение компании <b>$f[firmname]</b> (id=$f[selector])");
}

else

{
    $no_empty_mailto = $error_mailto.' '.$error_mailto1.' '.$error_mailto2;
    msg_text('80%',$def_admin_message_error,$no_empty_mailto);
}

require_once 'template/footer.php';

?>