<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: gl.php
-----------------------------------------------------
 Назначение: Редирект ссылок
=====================================================
*/

if (empty($_GET['id']) && empty($_GET['name'])) die("Hacking attempt!");

include './defaults.php';

$link = array();
if (isset($_GET['id']))
{
	$id = (int)$_GET['id'];

	$r = $db->query("SELECT * FROM $db_links WHERE selector='$id'") or die(mysql_error());
	$link = $db->fetcharray($r);
}
elseif (isset($_GET['name']))
{
	$r = $db->query('SELECT * FROM ' . $db_links . ' WHERE name LIKE "' . mysql_real_escape_string($_GET['name']) . '"')
			or die(mysql_error());
	$link = $db->fetcharray($r);

	$id = $link['selector'];
}

if (empty($link))
{
	echo 'Ссылка отсутствует!';
	exit;
}

$db->query("UPDATE $db_links SET hit=hit+1 WHERE selector='$id'") or die(mysql_error());

$substr_count = substr_count( $link['url'],"рф");

if ($substr_count>0) 

	echo '<div align="center" style="padding-top:30px;">Внимание! Данный домен не поддерживает автоматического перенаправления, для перехода на сайт нажмите на ссылку - <a href='. $link['url'].'>'. $link['url'].'</a></div>'; 

else {

header('Location: ' . $link['url']);

echo '<div align="center" style="padding-top:30px;">
	Внимание! Если браузер не поддерживает автоматического перенаправления,
	для перехода на сайт нажмите на ссылку - <a href="' . $link['url'] . '">' . $link['url'] . '</a></div>';
}

exit;
?>