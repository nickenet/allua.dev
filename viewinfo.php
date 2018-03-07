<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: viewinfo.php
-----------------------------------------------------
 Назначение: Публикация
=====================================================
*/

include ( "./defaults.php" );

$vi = intval ($_GET['vi']);
$kPage=0;

$type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

$r = $db->query  ( "SELECT * FROM $db_info WHERE num='$vi'" );
$f_p = $db->fetcharray  ( $r );
@$results_amount_all_info = mysql_num_rows ( $r );

if ($results_amount_all_info>0) {

$kType=$f_p['type'];

if ($kType==1) { $name_type="news"; }
if ($kType==2) { $name_type="tender"; }
if ($kType==3) { $name_type="board"; }
if ($kType==4) { $name_type="job"; }
if ($kType==5) { $name_type="pressrel"; }

	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

	$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

	if ($cat != 0)

	{
		$res = $db->query  ( "SELECT selector, category FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe['category'];
		$category = $fe['selector'];

		if ($def_rewrite == "YES")
		$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= "<a href=\"index.php?category=$cat\">";
	
		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}

	if ($subcat != 0)

	{
		$res = $db->query  ( "SELECT catsubsel, subcategory FROM $db_subcategory WHERE catsubsel = '$subcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showcategory = $fe['subcategory'];
		$subcategory = $fe['catsubsel'];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

	if ($subsubcat != 0)

	{
		$res = $db->query  ( "SELECT catsubsubsel, subsubcategory FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showsubcategory = $fe['subsubcategory'];
		$subsubcategory = $fe['catsubsubsel'];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$kPage\">";

		$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

// Формируем ЧПУ для компании

if (($category == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$f_p[firmselector]-$kPage-0.html";
if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$category-0-0-$f_p[firmselector]-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$category-$subcategory-0-$f_p[firmselector]-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$category-$subcategory-$subsubcategory-$f_p[firmselector]-$kPage-0.html";

if ($def_rewrite == "YES")

{

$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> |";
$incomingline.= " <a href=\"$def_mainlocation/$name_type-$f_p[firmselector]-0-$cat-$subcat-$subsubcat.html\"><font color=\"$def_status_font_color\"><u>$type_on[$kType]</u></font></a> | $f_p[item]";

}

else

{

$incomingline.= " | <a href=\"$def_mainlocation/view.php?id=$f_p[firmselector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> |";
$incomingline.= " <a href=\"$def_mainlocation/publication.php?id=$f_p[firmselector]&amp;type=$f_p[type]&amp;page=0&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat \" ><font color=\"$def_status_font_color\"><u>$type_on[$kType]</u></font></a> | $f_p[item]";

}

if (!isset($cat)) $incomingline=$f_p['item'];

$incomingline_firm=$f_p['item'];

            $descriptions_meta = chek_meta($f_p['shortstory']);
            $descriptions_meta = substr($descriptions_meta, 0, 200);
            $descriptions_meta = substr($descriptions_meta, 0, strrpos($descriptions_meta, ' '));
            $descriptions_meta = trim($descriptions_meta);
            $keywords_meta=check_keywords($f_p['shortstory']);

$help_section = $viewinfo_help;

include ( "./template/$def_template/header.php" );

        main_table_top($f_p['item']);

            $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$f_p[firmselector]'" );

            include ("./includes/sub.php");

            $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
            require 'includes/components/stat.php'; // Подключаем файл статистики

            $re = $db->query  ( "SELECT * FROM $db_info WHERE num='$vi' LIMIT 1" );

            $res_infofields = $db->query("SELECT * FROM $db_infofields WHERE num = '$kType'");
            $b_f = $db->fetcharray($res_infofields);

            $row_name=array(1=>$b_f[f_name1], 2=>$b_f[f_name2], 3=>$b_f[f_name3], 4=>$b_f[f_name4], 5=>$b_f[f_name5], 6=>$b_f[f_name6], 7=>$b_f[f_name7], 8=>$b_f[f_name8], 9=>$b_f[f_name9], 10=>$b_f[f_name10]);
            $row_type=array(1=>$b_f[f_type1], 2=>$b_f[f_type2], 3=>$b_f[f_type3], 4=>$b_f[f_type4], 5=>$b_f[f_type5], 6=>$b_f[f_type6], 7=>$b_f[f_type7], 8=>$b_f[f_type8], 9=>$b_f[f_type9], 10=>$b_f[f_type10]);
            $row_on=array(1=>$b_f[f_on1], 2=>$b_f[f_on2], 3=>$b_f[f_on3], 4=>$b_f[f_on4], 5=>$b_f[f_on5], 6=>$b_f[f_on6], 7=>$b_f[f_on7], 8=>$b_f[f_on8], 9=>$b_f[f_on9], 10=>$b_f[f_on10]);

            $view_template = "YES";

            include ("./includes/sub_component/pubsub.php");
        
        main_table_bottom();
 	
 }

 else

 {

        $incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';
        $incomingline_firm = $def_title_error;
	@header( "HTTP/1.0 404 Not Found" );    
    
        include ( "./template/$def_template/header.php" );
 	$def_message_error = $def_nopublic;
        include ( "./includes/error_page.php" );
 }

include ( "./template/$def_template/footer.php" );

?>