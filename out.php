<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: out.php
-----------------------------------------------------
 Назначение: Редирект на сайты компании
=====================================================
*/

if ((empty($_GET['fil'])) and (empty($_GET['ID']))) die("Hacking attempt!");

include ( "./defaults.php" );

if (isset($_GET['fil'])) {

$id_fil=intval ($_GET['fil']);

$r=$db->query ("SELECT www FROM $db_filial WHERE num='$id_fil'") or die (mysql_error());

$f=$db->fetcharray($r);

$output=punicode_url($f['www']);

echo '<div align="center"><img src="'.$def_mainlocation.'/images/go.gif"><br>'.$def_message_out.' <a href="'.$output.'">'.$f['www'].'</a></div>' ;

echo <<<HTML
<script language='Javascript'><!--
function reload() {location = "$output"}; setTimeout('reload()', 100);
//--></script>
HTML;

} else 

{

$id_www = intval ($_GET['ID']);

$r=$db->query ("SELECT www, webcounter, banner_click FROM $db_users WHERE selector='$id_www'") or die (mysql_error());

$f=$db->fetcharray($r);

$f['webcounter']++;

if (isset($_GET['banner'])) $f['banner_click']++;

$db->query ("UPDATE $db_users SET webcounter=$f[webcounter], banner_click=$f[banner_click]  WHERE selector='$id_www'") or die (mysql_error());

$output=punicode_url($f['www']);

echo '<div align="center"><img src="'.$def_mainlocation.'/images/go.gif"><br>'.$def_message_out.' <a href="'.$output.'">'.$f['www'].'</a></div>' ;

echo <<<HTML
<script language='Javascript'><!--
function reload() {location = "$output"}; setTimeout('reload()', 100);
//--></script>
HTML;

}

$db->close();

exit;

?>