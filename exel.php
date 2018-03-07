<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: exel.php
-----------------------------------------------------
 Назначение: Показ Excel прайсов для компании
=====================================================
*/

include ( "./defaults.php" );

$rz = $db->query  ( "SELECT * FROM $db_exelp WHERE firmselector = '$id' ORDER BY num" );
@$results_amount = mysql_num_rows ( $rz );

	$cat_firm = 0; $maincategory = "";
	$subcategory = 0; $mainsubcategory = "";
	$subsubcategory = 0; $mainsubsubcategory = "";

$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

if ($cat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe["category"];
		$cat_firm = $fe[selector];

		if ($def_rewrite == "YES")
		$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= "<a href=\"index.php?category=$cat\">";

		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}

if ($subcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showcategory = $fe["subcategory"];
		$subcategory = $fe[catsubsel];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$kPage\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

if ($subsubcat != 0)

	{
		$res = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showsubcategory = $fe["subsubcategory"];
		$subsubcategory = $fe[catsubsubsel];

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

if ( $results_amount > 0 ) {
    $rx = $db->query  ( "SELECT firmname,category FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
    $fx = $db->fetcharray  ( $rx );
}

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

// Контроль правильности адреса
correct_url($fx['category'],'exel',$id);
$to_canonical=to_canonical($fx['category'],$cat,$subcat,$subsubcat);
if ($to_canonical!=0) {
    if ($def_rewrite == "YES") $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/excel-'.$id.'-0-'.$to_canonical[0].'-'.$to_canonical[1].'-'.$to_canonical[2].'.html" />'."\n";
    else $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/exel.php?id='.$id.'&cat='.$to_canonical[0].'&subcat='.$to_canonical[1].'&subsubcat='.$to_canonical[2].'" />'."\n";
}

if ($def_rewrite == "YES")
    $incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_exelp";
else
    $incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_exelp";

$help_section = $exel_help_1;
$incomingline_firm = $fx['firmname'].' ('.$def_exelp.')';

if (!isset($fx['firmname'])) { $incomingline_firm=$def_title_error; $incomingline=$def_title_error; }

include ( "./template/$def_template/header.php" );

main_table_top($def_exelp);

if ( $results_amount > 0 )

{
        $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );

	include ("./includes/sub.php");

        $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
        require 'includes/components/stat.php'; // Подключаем файл статистики

        require 'includes/sub_component/price_view.php';

                // Страницы

        echo '<br><br>';

	if ( $results_amount_all > $def_info_page )

	{
                $prev_page=''; $page_news=''; $next_page='';

		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount_all) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount_all;

		@$z=$first/$def_info_page;

		if ($kPage > 0) {

                    $z_prev=$kPage-1;

                     if ($z_prev==0) {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/excel-'.$id.'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/exel.php?id='.$id.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     } else {
			if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/excel-'.$id.'-'.($kPage-1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/exel.php?id='.$id.'&page='.($kPage-1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     }
		}

                $page_news = '';

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
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/excel-'.$id.'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/exel.php?id='.$id.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            } else {
				if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/excel-'.$id.'-'.$z.'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/exel.php?id='.$id.'&page='.$z.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            }
				$z++;
			}
		}

                if ($kPage - (($results_amount_all / $def_info_page) - 1) < 0)

                {
        		if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/excel-'.$id.'-'.($kPage+1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_next.'</b></a>';
        		else $next_page = '<a href="'.$def_mainlocation.'/exel.php?id='.$id.'&page='.($kPage+1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_next.'</b></a>';

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
}

else include ( "./includes/error_page.php" );

main_table_bottom();

include ( "./template/$def_template/footer.php" );

?>