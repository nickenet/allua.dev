<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: publication.php
-----------------------------------------------------
 Назначение: Публикация информационного блока
=====================================================
*/

include ( "./defaults.php" );

$kPage = intval($_GET['page']);
$kType = intval ($_GET['type']);

$type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

$r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
$f_p = $db->fetcharray  ( $r );

if ($kType==1) { if ($f_p[news] > 0) $ok_info="ok"; $results_amount = $f_p['news']; $name_type="news"; }
if ($kType==2) { if ($f_p[tender] > 0) $ok_info="ok"; $results_amount = $f_p['tender']; $name_type="tender"; }
if ($kType==3) { if ($f_p[board] > 0) $ok_info="ok"; $results_amount = $f_p['board']; $name_type="board"; }
if ($kType==4) { if ($f_p[job] > 0) $ok_info="ok"; $results_amount = $f_p['job']; $name_type="job"; }
if ($kType==5) { if ($f_p[pressrel] > 0) $ok_info="ok"; $results_amount = $f_p['pressrel']; $name_type="pressrel"; }

if ( ($results_amount > 0) and (isset ($ok_info)) )

{
	$cat_firm = 0;
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
		$cat_firm = $fe['selector'];

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

if (($cat_firm == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
if (($cat_firm != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$cat_firm-0-0-$id-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$cat_firm-$subcategory-0-$id-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$cat_firm-$subcategory-$subsubcategory-$id-$kPage-0.html";

if ($def_rewrite == "YES")
$incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> | $type_on[$kType]";
else
$incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$f_p[firmname]</u></font></a> | $type_on[$kType]";

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

$help_section = $publication_help;

$incomingline_firm="$type_on[$kType] - $f_p[firmname]";

include ( "./template/$def_template/header.php" );

main_table_top($type_on[$kType]);

        $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id'" );

	include ("./includes/sub.php");

        $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
        require 'includes/components/stat.php'; // Подключаем файл статистики

	$re = $db->query  ( "SELECT * FROM $db_info WHERE firmselector = '$id' and type='$kType' ORDER BY date DESC, datetime DESC LIMIT $page1, $def_info_page" );
	@$results_amount_2 = mysql_num_rows ( $re );

	$res_infofields = $db->query("SELECT * FROM $db_infofields WHERE num = '$kType'");
	$b_f = $db->fetcharray($res_infofields);

	$row_name=array(1=>$b_f[f_name1], 2=>$b_f[f_name2], 3=>$b_f[f_name3], 4=>$b_f[f_name4], 5=>$b_f[f_name5], 6=>$b_f[f_name6], 7=>$b_f[f_name7], 8=>$b_f[f_name8], 9=>$b_f[f_name9], 10=>$b_f[f_name10]);
	$row_type=array(1=>$b_f[f_type1], 2=>$b_f[f_type2], 3=>$b_f[f_type3], 4=>$b_f[f_type4], 5=>$b_f[f_type5], 6=>$b_f[f_type6], 7=>$b_f[f_type7], 8=>$b_f[f_type8], 9=>$b_f[f_type9], 10=>$b_f[f_type10]);
	$row_on=array(1=>$b_f[f_on1], 2=>$b_f[f_on2], 3=>$b_f[f_on3], 4=>$b_f[f_on4], 5=>$b_f[f_on5], 6=>$b_f[f_on6], 7=>$b_f[f_on7], 8=>$b_f[f_on8], 9=>$b_f[f_on9], 10=>$b_f[f_on10]);

        echo '<div style="padding:10px;" align="right"><a href="'.$def_mainlocation.'/rss.php?id='.$f_p[selector].'&type=3&ktype='.$kType.'">Rss</a> <img src="'.$def_mainlocation.'/images/rss.gif" border="0" align="absmiddle"></div>';

	include ("./includes/sub_component/pubsub.php");

	// Страницы

	if ( $results_amount > $def_info_page )

	{
            $prev_page=''; $page_news=''; $next_page='';
            
		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount;

		@    $z=$first/$def_info_page;

		if ($kPage > 0) {                    
                    
                    $z_prev=$kPage-1;
                    
                    if ($z_prev==0) {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$name_type.'-'.$f_p['selector'].'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/publication.php?id='.$f_p['selector'].'&type='.$kType.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';                        
                    } else {
			if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/'.$name_type.'-'.$f_p['selector'].'-'.($kPage-1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/publication.php?id='.$f_p['selector'].'&type='.$kType.'&page='.($kPage-1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';  
                    }
		}
                
		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{

			if ( $z == $kPage )

			{
				$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
				$z++;
			}

			else

			{
                            if ($z==0) {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$name_type.'-'.$f_p['selector'].'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.( $z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/publication.php?id='.$f_p['selector'].'&type='.$kType.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;'; 
                            } else {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/'.$name_type.'-'.$f_p['selector'].'-'.$z.'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.( $z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/publication.php?id='.$f_p['selector'].'&type='.$kType.'&page='.$z.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';                              
                            }                            
				$z++;
			}
		}
                
                if ($kPage - (($results_amount / $def_info_page) - 1) < 0)

                {
                        if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/'.$name_type.'-'.$f_p['selector'].'-'.($kPage+1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_next.'</b></a>&nbsp;';
			else $next_page = '<a href="'.$def_mainlocation.'/publication.php?id='.$f_p['selector'].'&type='.$kType.'&page='.($kPage+1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_next.'</b></a>&nbsp;';  
        	}
                
        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();
        
	}
        
        main_table_bottom();
	
 }

 else

 {
        $meta_index='<meta name="robots" content="noindex,nofollow" />'."\n";    
    
        include ( "./template/$def_template/header.php" );

 	$def_message_error = $def_nopublic;
        include ( "./includes/error_page.php" );
 }

include ( "./template/$def_template/footer.php" );

?>