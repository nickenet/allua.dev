<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: viborka.php
-----------------------------------------------------
 Назначение: Выборка фирм для облака тегов
=====================================================
*/

include ("./defaults.php");

$file = 'system/tags.dat';
	
if ( !isset($_GET['tag']) )
{

include ( "./template/$def_template/header.php" );

	echo 'Не задан параметр тега!';

include ( "./template/$def_template/footer.php" );
	
	return;	
}

if ( !file_exists($file) )
{
	echo 'No file';
	
	return;
}

$list = '';
$data = file_get_contents($file);
$data = unserialize($data);
while (!$list && list($k, $row) = each($data) )
{
	if ($row->state == 'on' && $row->field == $_GET['tag'])
	{
		$list = $row->value;
		$title_tags = $row->name;
	}
}

if ($list === '')
{
include ( "./template/$def_template/header.php" );

	echo 'Параметр тега не корректен! Либо не верно сформирован список!';

include ( "./template/$def_template/footer.php" );
	
	return;	
}


$r = $db->query ( " SELECT * FROM $db_users WHERE selector IN ($list)");
@$results_amount = mysql_num_rows ( $r );

$help_section = "$tags_help";
$incomingline_firm = $title_tags;
$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_tags</font>";

include ( "./template/$def_template/header.php" );

if ($results_amount==0) echo 'Не верно сформирован список для тега!';

else

{
	$fetchcounter=$results_amount;
	include ("./includes/sub.php");	
}

include ( "./template/$def_template/footer.php" );

?>