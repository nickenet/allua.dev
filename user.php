<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: user.php
-----------------------------------------------------
 Назначение: Авторизация в личном кабинете клиента
=====================================================
*/

include ( "./defaults.php" );

session_start();

if (!isset($_SESSION['random'])) $_SESSION['random'] = mt_rand(1000000,9999999);

$rand = mt_rand(1, 999);

$incomingline = $def_user;

$help_section = $user_help_3;

include ( "./template/$def_template/header.php" );

main_table_top ($def_user); // Вверх заголовка

$template = new Template;

$template->set_file('user.tpl');

$template->replace("bgcolor", $def_form_back_color);

$template->replace("user", $def_user_login);
$template->replace("password", $def_pass);
$template->replace("security", "<img src=\"security.php?$rand\" />");
$template->replace("enter", $def_enter);
$template->replace("reminder", $def_reminder);

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->publish();

main_table_bottom(); // Низ заголовка

include("./template/$def_template/footer.php");

?>