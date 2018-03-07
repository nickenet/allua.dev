<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: mail.php
-----------------------------------------------------
 Назначение: Отправка сообщения компании
=====================================================
*/

include ( "./defaults.php" );

    $r = $db->query  ( "SELECT mail, firmname, selector FROM $db_users WHERE selector = '$id'" );

if ( $db->numrows($r) == 1 ) {

            $f = $db->fetcharray ( $r );

session_start();

	header("Cache-control: private");

	if (!isset($_SESSION['random']))
	{
		$_SESSION['random'] = mt_rand(1000000,9999999);
	}

	$rand = mt_rand(1, 999);

    $incomingline_firm = "$def_sendmessage &raquo; $fa[firmname]";

    include ("./template/$def_template/header.php");

       $template_sub = implode ('', file('./template/' . $def_template . '/mail.tpl'));

       $template = new Template;

       $template->load($template_sub);

       $template->replace("company", $f['firmname']);
       $template->replace("id", $f['selector']);
       $template->replace("security_img", "<img src=\"../security.php?$rand\" />");

       $template->publish();

       

    include ( "./template/$def_template/footer.php" );

}

?>