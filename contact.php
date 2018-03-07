<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: contact.php
-----------------------------------------------------
 Назначение: Отправка сообщения администратору
=====================================================
*/

include( "./defaults.php" );

$incomingline = $def_contact_admin;

$help_section = $contact_help;

session_start();

	header("Cache-control: private");

	if (!isset($_SESSION['random']))
	{
		$_SESSION['random'] = mt_rand(1000000,9999999);
	}

	$rand = mt_rand(1, 999);


include ( "./template/$def_template/header.php" );

main_table_top  ($def_contact_admin);

$template_contact=set_tFile('contact.tpl');

$template = new Template;

                $template->load($template_contact);

                $template->replace("security", "<img src=\"security.php?$rand\" />");

                $template->replace("dir_to_main", $def_mainlocation);
                $template->replace("bgcolor", $def_form_back_color);
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                $template->publish();

main_table_bottom();

require 'includes/js/contact.js'; // Подключаем java

include ( "./template/$def_template/footer.php" );

?>