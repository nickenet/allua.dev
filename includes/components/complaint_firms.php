<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: complaint_firms.php
-----------------------------------------------------
 Назначение: Формирование ссылки на страницу с жалобой
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$link_to_complaint=$def_mainlocation.'/complaint.php?firma_id='.$id;

$template->replace("link_to_complaint", $link_to_complaint);
$template->replace("text_to_complaint", $def_complaint);

?>
