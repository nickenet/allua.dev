<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: offers.php
-----------------------------------------------------
 Назначение: Показ продукции и услуг для компании
=====================================================
*/

include ( "./defaults.php" );

$kPage=intval($_GET['page']);

$db->query  ( "UPDATE $db_users SET price_show = price_show+1 WHERE selector = '$id'" );

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

$oType=htmlspecialchars(strip_tags($_GET['tyle']),ENT_QUOTES,$def_charset);

if ( $_GET["type"] <> "all" ) {
    
	$oType = intval ($_GET['type']);
	$rz = $db->query  ( "SELECT * FROM $db_offers WHERE firmselector = '$id' and type = '$oType' ORDER BY num DESC LIMIT $page1, $def_info_page" );
        
        $rz_all = $db->query  ( "SELECT COUNT(*) FROM $db_offers WHERE firmselector = '$id' and type = '$oType' ORDER BY num DESC" );
        @$results_amount_all = mysql_result ( $rz_all,0,0 );

}

else {

    $oType="all";

    $rz = $db->query  ( "SELECT * FROM $db_offers WHERE firmselector = '$id' ORDER BY num DESC LIMIT $page1, $def_info_page" );

    $rz_all = $db->query  ( "SELECT COUNT(*) FROM $db_offers WHERE firmselector = '$id' ORDER BY num DESC" );

    @$results_amount_all = mysql_result ( $rz_all,0,0 );
    
}

	$cat_firm = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

@$results_amount = mysql_num_rows ( $rz );

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

if (( $results_amount > 0 ) or (isset($_GET['type']))) {
    $rx = $db->query  ( "SELECT firmname FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
    $fx = $db->fetcharray  ( $rx );
}

if ($def_rewrite == "YES")
    $incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_offers";
else
    $incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_offers";

$help_section = $price_help;
$incomingline_firm = $fx['firmname'].' ('.$def_offers.')';

include ( "./template/$def_template/header.php" );

echo phighslide();

main_table_top($def_offers);

if (( $results_amount > 0 ) or (isset($_GET['type']))) {

     $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id'" );

     include ("./includes/sub.php");

     $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
     require 'includes/components/stat.php'; // Подключаем файл статистики

echo "<noindex><div align=\"right\"><a rel=\"nofollow\" href=\"$def_mainlocation/offers.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=1\">$def_offer_1_s</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/offers.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=2\">$def_offer_2_s</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/offers.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=3\">$def_offer_3_s</a> | <a rel=\"nofollow\" href=\"$def_mainlocation/offers.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=all\">$def_offer_all_s</a></div></noindex>";

 	$last10_offers="NO";
        
        $category_offers=$cat;
	
        include ("./includes/sub_component/catoffers.php");

            if ($results_amount==0) {
                $def_message_error=$def_error_offers_type;
                include ( "./includes/error_page.php" );
            }

        // Страницы

        echo '<br><br>';

	if ( $results_amount_all > $def_info_page )

	{
		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount_all) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount_all;

		@$z=$first/$def_info_page;

		if ($kPage > 0)

		{
			if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/offers-'.$id.'-'.($kPage-1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'-'.$oType.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="offers.php?id='.$id.'&page='.($kPage-1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'&type='.$oType.'"><b>'.$def_previous.'</b></a>&nbsp;';
                        
		} else $prev_page = '';

                $page_news = '';

		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{
			if ( $z == $kPage )

			{
				$page_news .= '[ <b>'.($z+1).' </b> ]&nbsp;';
				$z++;
			}

			else

			{
				if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/offers-'.$id.'-'.$z.'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'-'.$oType.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="offers.php?id='.$id.'&page='.$z.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'&type='.$oType.'"><b>'.($z+1).'</b></a>&nbsp;';
				$z++;
			}
		}

                if ($kPage - (($results_amount_all / $def_info_page) - 1) < 0)

                {
        		if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/offers-'.$id.'-'.($kPage+1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'-'.$oType.'.html"><b>'.$def_next.'</b></a>';
        		else $next_page = '<a href="offers.php?id='.$id.'&page='.($kPage+1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'&type='.$oType.'"><b>'.$def_next.'</b></a>';

                } else $next_page = '';

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