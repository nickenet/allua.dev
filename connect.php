<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: connect.php
-----------------------------------------------------
 Назначение: Соединение с базой данных
=====================================================
*/

// Укажите параметры mySQL соединения

$db_host = "localhost"; // Хост сервер базы данных (как правило не изменяется)
$db_user = "root"; // Логин для доступа к базе данных
$db_pass = ""; // Пароль к базе данных
$db_name = "allua"; // Название базы данных
$prefix_b = "pmd"; //Укажите префикс базы данных, например любые латинские буквы

// Пожалуйста, удостоверитесь, что определенный выше пользователь, имеет весь доступ к созданию таблиц в данной базе данных

$db_users = $prefix_b ."_users";
$db_offers = $prefix_b ."_offers";
$db_images = $prefix_b ."_images";
$db_exelp= $prefix_b ."_exelp";
$db_video = $prefix_b ."_video";
$db_zsearch = $prefix_b ."_zsearch";
$db_infofields = $prefix_b ."_infofields";
$db_info = $prefix_b ."_info";
$db_filial = $prefix_b ."_filial";

$db_rating = $prefix_b ."_rating";
$db_reviews = $prefix_b ."_reviews";
$db_reply = $prefix_b ."_reply";

$db_category = $prefix_b ."_category";
$db_subcategory = $prefix_b ."_subcategory";
$db_subsubcategory = $prefix_b ."_subsubcategory";

$db_location = $prefix_b ."_location";
$db_states = $prefix_b ."_states";

$db_admin = $prefix_b ."_admin";
$db_log = $prefix_b ."_log";
$db_lost = $prefix_b ."_lost";
$db_links = $prefix_b ."_links";

$db_categorynews = $prefix_b ."_categorynews";
$db_news = $prefix_b ."_news";
$db_newsrev = $prefix_b ."_newsrev";

$db_engines = $prefix_b ."_engines";
$db_stat = $prefix_b ."_stat";
$db_complaint = $prefix_b ."_complaint";

$db_case = $prefix_b ."_case";
$db_static = $prefix_b ."_static";

$db_foto = $prefix_b ."_foto";
$db_foto_meta = $prefix_b ."_foto_meta";

$db = new Dbaccess;

$db_result = $db->connect ( $db_host, $db_user, $db_pass, $db_name );
$db->query ( "set names utf8" );


if ( !$db_result )

{
	error ( "mySQL error. No connect MySql. connect.php", mysql_error() );
}

?>