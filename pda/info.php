<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: info.php
-----------------------------------------------------
 Назначение: Вывод полной версии публикации
=====================================================
*/

include ("./defaults.php");


$vi = intval ($_GET['vi']);
$type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

	$re = $db->query  ( "SELECT * FROM $db_info WHERE num='$vi'" );
	@$results_amount = mysql_num_rows ( $re );

if ($results_amount>0) {

	$res_infofields = $db->query("SELECT * FROM $db_infofields WHERE num = '$kType'");
	$b_f = $db->fetcharray($res_infofields);

	$row_name=array(1=>$b_f[f_name1], 2=>$b_f[f_name2], 3=>$b_f[f_name3], 4=>$b_f[f_name4], 5=>$b_f[f_name5], 6=>$b_f[f_name6], 7=>$b_f[f_name7], 8=>$b_f[f_name8], 9=>$b_f[f_name9], 10=>$b_f[f_name10]);
	$row_type=array(1=>$b_f[f_type1], 2=>$b_f[f_type2], 3=>$b_f[f_type3], 4=>$b_f[f_type4], 5=>$b_f[f_type5], 6=>$b_f[f_type6], 7=>$b_f[f_type7], 8=>$b_f[f_type8], 9=>$b_f[f_type9], 10=>$b_f[f_type10]);
	$row_on=array(1=>$b_f[f_on1], 2=>$b_f[f_on2], 3=>$b_f[f_on3], 4=>$b_f[f_on4], 5=>$b_f[f_on5], 6=>$b_f[f_on6], 7=>$b_f[f_on7], 8=>$b_f[f_on8], 9=>$b_f[f_on9], 10=>$b_f[f_on10]);

        $f = $db->fetcharray   ( $re );

        $incomingline_firm = $f['item'];

include ("./template/$def_template/header.php");

$template_sub_pub = implode ('', file('./template/' . $def_template . '/viewinfo.tpl'));

	$template = new Template;

	$template->load($template_sub_pub);

        $template->replace("date", undate($f[date], "DD.MM.YYYY"));
	$date_time=substr($f['datetime'],0,5);
	$template->replace("datetime", $date_time);
	$template->replace("company", $f['firmname']);
	$template->replace("title", $f['item']);

        $fullstory=stripslashes($f['fullstory']);
        $shortstory=stripslashes($f['shortstory']);

	$show_info = $f["show_info"];
	$show_info++;

	$db->query  ( "UPDATE $db_info SET show_info = '$show_info' WHERE num = '$f[num]'" );

        $template->replace("hits", $show_info);

        if (strlen($fullstory)>strlen($shortstory)) $template->replace("fullstory", $fullstory); else $template->replace("fullstory", $shortstory);

        $view_img='';

	if ($f[img_on]==1) {

            $img_files = array();
            $img_files_small = glob('../info/'.$vi.'-small.*');
            $img_files_full = glob('../info/'.$vi.'.*');

	}

	if (($f[img_on]==1) and ($img_files_small[0]!='')) { $img_small="<img src=\"$def_mainlocation/info/".basename($img_files_small[0])."\" alt=\"$f[item]\" style=\"padding: 3px;\" align=\"left\" border=\"0\">"; $img="<img src=\"$def_mainlocation/info/".basename($img_files_full[0])."\" style=\"padding: 3px;\" alt=\"$f[item]\" align=\"left\" border=\"0\">"; } else { $img_small=""; $img=""; }
	if (($f[img_on]==1) and ($img_files_small[0]!='')) $img_link="$def_mainlocation/info/".basename($img_files_full[0]); else $img_link="";

        $template->replace("img_small", "$img_small");
	$template->replace("img", "$img");
	$template->replace("img_link", "$img_link");

	if ( ($row_on[1]==1) and ($f[f_name1]!="") ) $f_name1="$row_name[1]: $f[f_name1]<br>"; else $f_name1="";
	if ( ($row_on[2]==1) and ($f[f_name2]!="") ) $f_name2="$row_name[2]: $f[f_name2]<br>"; else $f_name2="";
	if ( ($row_on[3]==1) and ($f[f_name3]!="") ) $f_name3="$row_name[3]: $f[f_name3]<br>"; else $f_name3="";
	if ( ($row_on[4]==1) and ($f[f_name4]!="") ) $f_name4="$row_name[4]: $f[f_name4]<br>"; else $f_name4="";
	if ( ($row_on[5]==1) and ($f[f_name5]!="") ) $f_name5="$row_name[5]: $f[f_name5]<br>"; else $f_name5="";
	if ( ($row_on[6]==1) and ($f[f_name6]!="") ) $f_name6="$row_name[6]: $f[f_name6]<br>"; else $f_name6="";
	if ( ($row_on[7]==1) and ($f[f_name7]!="") ) $f_name7="$row_name[7]: $f[f_name7]<br>"; else $f_name7="";
	if ( ($row_on[8]==1) and ($f[f_name8]!="") ) $f_name8="$row_name[8]: $f[f_name8]<br>"; else $f_name8="";
	if ( ($row_on[9]==1) and ($f[f_name9]!="") ) $f_name9="$row_name[9]: $f[f_name9]<br>"; else $f_name9="";
	if ( ($row_on[10]==1) and ($f[f_name10]!="") ) $f_name10="$row_name[10]: $f[f_name10]<br>"; else $f_name10="";

	$template->replace("f_name1", "$f_name1");
	$template->replace("f_name2", "$f_name2");
	$template->replace("f_name3", "$f_name3");
	$template->replace("f_name4", "$f_name4");
	$template->replace("f_name5", "$f_name5");
	$template->replace("f_name6", "$f_name6");
	$template->replace("f_name7", "$f_name7");
	$template->replace("f_name8", "$f_name8");
	$template->replace("f_name9", "$f_name9");
	$template->replace("f_name10", "$f_name10");

		$date_day = date ( "d" );
 		$date_month = date ( "m" );
	 	$date_year = date ( "Y" );

 		list ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $f["date"] );

		$first_date = mktime ( 0,0,0,$on_month,$on_day,$on_year );
		$second_date = mktime ( 0,0,0,$date_month,$date_day,$date_year );

 		if ( $second_date > $first_date )

 		{
 			$days = $second_date-$first_date;
 		}

 		else

 		{
 			$days = $first_date-$second_date;
 		}

		$days_result = round( $f[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );


	$template->replace("resilt", "$days_result");

	$template->replace("link_to_company", $def_mainlocation_pda.'/view.php?id='.$f['firmselector']);

        $template->replace("path_to_images", $def_mainlocation_pda . "/template/" . $def_template . "/images");

	$template->publish();

        $url_full_version = 'viewinfo.php?vi='.$vi.'&mobile=no';

include ( "./template/$def_template/footer.php" );

}

?>