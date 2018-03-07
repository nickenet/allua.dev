<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: main.php
-----------------------------------------------------
 Назначение: Рабочий стол
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$main_help;

$title_cp = "Рабочий стол - ";

check_login_cp('0_1','main.php');

require_once 'template/header.php';

$top_wt='main';

require_once 'template/top_wt.php';

require_once 'template/part.php';

require_once 'template/footer.php';
		
?>
