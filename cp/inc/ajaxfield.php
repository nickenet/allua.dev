<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: ajaxfiled.php
-----------------------------------------------------
 Назначение: Подключение дополнительных полей
=====================================================
*/

header("Content-type: text/plain; charset=windows-1251");

// Including configuration file
include ( "../../conf/config.php" );

// Including mysql class
include ( "../../includes/$def_dbtype.php" );

// Connecting to the database
include ( "../../connect.php" );

// Including functions
include ( "../../includes/sqlfunctions.php" );

if ( !empty($_REQUEST['ajax']) )
{
	$param = (int)$_REQUEST['param'];

	if (!is_numeric ($param)) die( "Hacking attempt!" );
	
	$res_infofields = $db->query("SELECT * FROM $db_infofields WHERE num = '$param'");
	$b_f = $db->fetcharray($res_infofields);

	$row_name=array(1=>$b_f['f_name1'], 2=>$b_f['f_name2'], 3=>$b_f['f_name3'], 4=>$b_f['f_name4'], 5=>$b_f['f_name5'], 6=>$b_f['f_name6'], 7=>$b_f['f_name7'], 8=>$b_f['f_name8'], 9=>$b_f['f_name9'], 10=>$b_f['f_name10']);
	$row_type=array(1=>$b_f['f_type1'], 2=>$b_f['f_type2'], 3=>$b_f['f_type3'], 4=>$b_f['f_type4'], 5=>$b_f['f_type5'], 6=>$b_f['f_type6'], 7=>$b_f['f_type7'], 8=>$b_f['f_type8'], 9=>$b_f['f_type9'], 10=>$b_f['f_type10']);
	$row_on=array(1=>$b_f['f_on1'], 2=>$b_f['f_on2'], 3=>$b_f['f_on3'], 4=>$b_f['f_on4'], 5=>$b_f['f_on5'], 6=>$b_f['f_on6'], 7=>$b_f['f_on7'], 8=>$b_f['f_on8'], 9=>$b_f['f_on9'], 10=>$b_f['f_on10']);

	$data_fields = "";
	
	for ($zzz = 1; $zzz < 11; $zzz++) {

		if ($row_on[$zzz]==1) {

			if ($row_type[$zzz]==1) echo "$row_name[$zzz]: <input type=\"text\" name=\"form_n$zzz\" value=\"\" size=\"45\" maxlength=\"100\"><br>";
			else echo "$row_name[$zzz]:<br><textarea name=\"form_n$zzz\" cols=\"45\" rows=\"5\" style=\"width:400px; height:100px;\"></textarea><br>";

		}

	}	

	echo " ";
	exit;
}

?>