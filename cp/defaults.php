<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: defaults.php
-----------------------------------------------------
 Назначение: Файл подключений
=====================================================
*/

define ( 'ISB', true );

ini_set ('error_reporting', E_ALL & ~E_NOTICE);
srand ((double) microtime() * 10000000);

// Подключаем файл конфигурации
include (".././conf/config.php");

// Подключаем файл тарифных планов
include (".././conf/memberships.php");

// Подключаем файл функций
include (".././includes/functions.php");

// Подключаем файл функций cp
include ("./inc/functions.php");

// Подключаем класс управления базой данных
include (".././includes/$def_dbtype.php");

// Подключаем файл соединения с базой данных
include (".././connect.php");

// Подключаем файл SQL функций
include (".././includes/sqlfunctions.php");

// Подключаем файл таблиц
include ("./template/table.php");

// Подключаем языковой файл
include ("./lang/adm.$def_admin_language.php");

// Подключаем файл помощи
include ("./help/help.$def_admin_language.php");

$lang = $def_admin_language;

?>