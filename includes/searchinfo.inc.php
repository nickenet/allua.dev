<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: searchinfo.php
-----------------------------------------------------
 Назначение: Форма поиска по публикациям
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo();

$fields_yes="false";

$res_infofields = $db->query("SELECT * FROM $db_infofields WHERE num = '$kType'");
	$b_f = $db->fetcharray($res_infofields);
	$row_name=array(1=>$b_f[f_name1], 2=>$b_f[f_name2], 3=>$b_f[f_name3], 4=>$b_f[f_name4], 5=>$b_f[f_name5], 6=>$b_f[f_name6], 7=>$b_f[f_name7], 8=>$b_f[f_name8], 9=>$b_f[f_name9], 10=>$b_f[f_name10]);
	$row_on=array(1=>$b_f[f_on1], 2=>$b_f[f_on2], 3=>$b_f[f_on3], 4=>$b_f[f_on4], 5=>$b_f[f_on5], 6=>$b_f[f_on6], 7=>$b_f[f_on7], 8=>$b_f[f_on8], 9=>$b_f[f_on9], 10=>$b_f[f_on10]);

	$data_search = array();
	
	for ($zzz = 1; $zzz < 11; $zzz++) {

		if ($row_on[$zzz]==1) {

			$data_search[$zzz] = "$row_name[$zzz]: <input type=\"text\" name=\"form_n$zzz\" value=\"\" maxlength=\"60\" class=\"form-control\"><br>";
			$fields_yes="true";
		} else $data_search[$zzz]='';

	}
     
        $template_info_find = implode ('', file('./template/' . $def_template . '/searchform_info.tpl'));
        
        if ($fields_yes!="true")  $template_info_find = preg_replace("!<rp>(.*?)</rp>!si","",$template_info_find);

	$template_info_find = str_replace ( "<rp>", "", $template_info_find );
	$template_info_find = str_replace ( "</rp>", "", $template_info_find );
        
        $template_firma = new Template;
        
        $template_firma->load($template_info_find);

        $template_firma->replace("bgcolor", $def_form_back_color_search);
        $template_firma->replace("file_find", "$def_mainlocation/search-1.php");
        $template_firma->replace("text_find", $def_find_info_txt);
        $template_firma->replace("rezult", htmlspecialchars($item_short_full,ENT_QUOTES,$def_charset));

        if ($fields_yes=="true") {
    
            $template_firma->replace("data_search1", $data_search[1]);
            $template_firma->replace("data_search2", $data_search[2]);
            $template_firma->replace("data_search3", $data_search[3]);
            $template_firma->replace("data_search4", $data_search[4]);
            $template_firma->replace("data_search5", $data_search[5]);
            $template_firma->replace("data_search6", $data_search[6]);
            $template_firma->replace("data_search7", $data_search[7]);
            $template_firma->replace("data_search8", $data_search[8]);
            $template_firma->replace("data_search9", $data_search[9]);
            $template_firma->replace("data_search10", $data_search[10]);
        }
        
        $template_firma->replace("type_find", $kType);

        $template_firma->replace("button_search", $def_search);

        $template_firma->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_firma->publish();
	
?>