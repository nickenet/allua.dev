<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-1.php
-----------------------------------------------------
 Назначение: Быстрый поиск по фирме
=====================================================
*/

include ( "./defaults.php" );

require_once 'includes/zsearch.php';

$requests = new zSearch;

$incomingline = $def_company_search;
$help_section = $search_help;

if ( $_GET["search"] <> "" ) $sstring = rawurldecode ( $_GET["search"] ); else $sstring = "$_POST[skey]";

if ( $_GET["locationcoded"] <> "" ) $locationcoded = rawurldecode ( $_GET["locationcoded"] );

else

{
	if (!isset($_POST[location])) $locationcoded='ANY'; else $locationcoded = "$_POST[location]";
}

if ( get_magic_quotes_gpc() )
{
     $sstring = stripcslashes($sstring);
     $locationcoded = stripcslashes($locationcoded);
}

$sstring = substr ( $sstring, 0, 64 );
$sstring = strip_tags ($sstring);
$sstring = safeHTML ($sstring);
$sstring = mysql_real_escape_string($sstring);
$locationcoded = mysql_real_escape_string($locationcoded);

if (strlen($sstring)>1) {

$swords = explode ( " ", $sstring );

$x = 0;

for ( $pa=0; $pa < count ( $swords ); $pa++ )

{
	if ( strlen ( $swords[$pa] ) > 1 )

	{
		$word[$x] = "$swords[$pa]";$x++;
	}
}

@$words = implode ( " ", $word );

$goodencoded = rawurlencode ( $sstring );
$locationcoded2 = rawurlencode ( $locationcoded );

$kSpage=intval($_GET['spage']);

$npage = $kSpage + 1;
$ppage = $kSpage - 1;
$page1 = $kSpage * $def_count_srch;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$query2 = " COUNT(*)  ";
$query2.= " FROM $db_users WHERE ";
$query2.= " MATCH (firmname, business) AGAINST ('$words') AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY"  )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$query2.= "AND state='$locationcoded'";
	}
	else

	$query2.= "AND location='$locationcoded'";
}

$query2.= "or ( keywords LIKE '%$sstring%' )";

$likequery2 = " COUNT(*)  ";
$likequery2.= " FROM $db_users WHERE ";
$likequery2.= " ( ( firmname LIKE '%$sstring%' ) or ( business LIKE '%$sstring%' )  or ( keywords LIKE '%$sstring%' ) ) AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY" )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$likequery2.= "AND state='$locationcoded'";
	}
	else

	$likequery2.= "AND location='$locationcoded'";
}

$query = "flag, selector, firmname, business, location, state, city, address, category, phone, prices, date, rating, votes, countrating, mail, icq, fax, mobile, manager, www, ";
$query.= " MATCH (firmname, business) AGAINST ('$words') ";
$query.= "AS relevance FROM $db_users WHERE ";
$query.= "MATCH (firmname, business) AGAINST ('$words') AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY" )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$query.= "AND state='$locationcoded'";
	}
	else

	$query.= "AND location='$locationcoded'";
}

$query.= " or ( keywords LIKE '%$sstring%' ) ORDER BY flag, relevance DESC";

// Запрос для карты

$query_map = "flag, firmname, map, selector, ";
$query_map.= " MATCH (firmname, business) AGAINST ('$words') ";
$query_map.= "AS relevance FROM $db_users WHERE ";
$query_map.= "MATCH (firmname, business) AGAINST ('$words') AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY" )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$query_map.= "AND state='$locationcoded'";
	}
	else

	$query_map.= "AND location='$locationcoded'";
}

$query_map.= " or ( keywords LIKE '%$sstring%' ) ORDER BY flag, relevance DESC";

// ------------------------------


$likequery = " * ";
$likequery.= "FROM $db_users WHERE ";
$likequery.= " ( ( firmname LIKE '%$sstring%' ) or ( business LIKE '%$sstring%' )  or ( keywords LIKE '%$sstring%' ) ) AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY" )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$likequery.= "AND state='$locationcoded'";
	}
	else

	$likequery.= "AND location='$locationcoded'";
}

$likequery.= " ORDER BY flag, firmname";

// Запрос для карты

$likequery_map = " flag, firmname, map, selector ";
$likequery_map.= "FROM $db_users WHERE ";
$likequery_map.= " ( ( firmname LIKE '%$sstring%' ) or ( business LIKE '%$sstring%' )  or ( keywords LIKE '%$sstring%' ) ) AND firmstate='on' $hide_d ";

if ( $locationcoded != "ANY" )

{
	if (($def_index_state == "YES") and ( $def_states_allow == "YES"))
	{
		$likequery_map.= "AND state='$locationcoded'";
	}
	else

	$likequery_map.= "AND location='$locationcoded'";
}

$likequery_map.= " ORDER BY flag, firmname";

// ------------------------------------

if ($def_search_type == "LIKE")
{
	$sql = $likequery;
	$sql2 = $likequery2;
        $sql_map = $likequery_map;
}
else
{
	$sql = $query;
	$sql2 = $query2;
        $sql_map = $query_map;
}

$ra = $db->query  ( "SELECT $sql2" );
$results_amount = mysql_result ( $ra,0,0 );
@$db->freeresult  ( $ra );

if ( $results_amount != 0 ) {

$r = $db->query  ( "SELECT $sql LIMIT $page1, $def_count_srch");
$fetchcounter = $def_count_srch;
$f = $results_amount - $page1;

$rmaps = $db->query  ( "SELECT $sql_map LIMIT $page1, $def_count_srch");
$results_maps = $db->numrows ( $rmaps);

require 'includes/components/maps_find.php'; // выборка данных для карты

if (($page1==0) and (!isset($_GET[spage]))) $requests->add($sstring, $results_amount);

$incomingline_firm .= $words.' - '.$def_company_search;

include ( "./template/$def_template/header.php" );

include ("./includes/searchfirms.inc.php");

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

include ( "./template/$def_template/search1_top.php" ); // Подключаем верхний шаблон поиска

if ( $f < $def_count_srch ) $fetchcounter = $results_amount - $page1;

include ("./includes/sub.php");

if ( $results_amount > $def_count_srch )

{
        $prev_page=''; $page_news=''; $next_page='';

	if ((($kSpage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kSpage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($kSpage*$def_count_srch)+($def_count_srch*6)) <= $results_amount) $last =($kSpage*$def_count_srch)+($def_count_srch*6);
	else $last = $results_amount;

	@$z=$first/$def_count_srch;

	if ($kSpage > 0) {
            
                // $z_prev=$KsPage-1;
                if ($z_prev==0) $prev_page = '<a href="'.$def_mainlocation.'/search-1.php?&locationcoded='.$locationcoded2.'&search='.$goodencoded.'"><b>'.$def_previous.'</b></a>&nbsp;';
                else $prev_page = '<a href="'.$def_mainlocation.'/search-1.php?&locationcoded='.$locationcoded2.'&search='.$goodencoded.'&spage='.($kSpage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';         
            
        }

	for ( $x = $first; $x < $last; $x=$x+$def_count_srch )
	{
		if ( $z == $kSpage )

		{
			$page_news.= '[ <b>'. ($z+1) .'</b> ]&nbsp;';
			$z++;
		}

		else

		{
                    if ($z==0) $page_news.= '<a href="'.$def_mainlocation.'/search-1.php?&locationcoded='.$locationcoded2.'&search='.$goodencoded.'"><b>'.($z+1).'</b></a>&nbsp;';
                    else $page_news.= '<a href="'.$def_mainlocation.'/search-1.php?&locationcoded='.$locationcoded2.'&search='.$goodencoded.'&spage='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
                    $z++;
		}
	}

	if ($kSpage - (($results_amount / $def_count_srch) - 1) < 0)
        $next_page = '<a href="'.$def_mainlocation.'/search-1.php?&locationcoded='.$locationcoded2.'&search='.$goodencoded.'&spage='.($kSpage+1).'"><b>'.$def_next.'</b></a>&nbsp;';
	
        include ( "./template/$def_template/pages.php" ); // подключаем обработку страниц
        
        $template_page_news = set_tFile('pages.tpl');

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

}

qserch_table($results_amount, $words);

if ($kSpage==0)  {
    
        // поиск по другим разделам

        $result_plus="NO";

        // товары и услуги
        $query_offers = " num FROM $db_offers WHERE ( ( item LIKE '%$words%' ) or ( message LIKE '%$words%' ) ) ";
        $r_offers = $db->query  ( "SELECT $query_offers" );
        $results_amount_offers = mysql_num_rows ( $r_offers );
        if ($results_amount_offers>0) $result_plus="YES";

        // изображения
        $query_img = " num FROM $db_images WHERE ( ( item LIKE '%$words%' ) or ( message LIKE '%$words%' ) ) ";
        $r_img = $db->query  ( "SELECT $query_img" );
        $results_amount_img = mysql_num_rows ( $r_img );
        if ($results_amount_img>0) $result_plus="YES";

        // прайс-листы
        $query_xls = " num FROM $db_exelp WHERE ( ( item LIKE '%$words%' ) or ( message LIKE '%$words%' ) ) ";
        $r_xls = $db->query  ( "SELECT $query_xls" );
        $results_amount_xls = mysql_num_rows ( $r_xls );
        if ($results_amount_xls>0) $result_plus="YES";

        // публикации
        $query_pub = " num FROM $db_info WHERE ( ( item LIKE '%$words%' ) or ( shortstory LIKE '%$words%' ) or ( fullstory LIKE '%$words%' ) ) ";
        $r_pub = $db->query  ( "SELECT $query_pub" );
        $results_amount_pub = mysql_num_rows ( $r_pub );
        if ($results_amount_pub>0) $result_plus="YES";
} 

include ( "./template/$def_template/search1_bottom.php" ); // Подключаем нижний шаблон поиска

} else {
    
    // Ничего не найдено
    
    $meta_index='<meta name="robots" content="noindex,nofollow" />'."\n";    
    
    include ( "./template/$def_template/header.php" );

    $def_title_error = $def_warning_msg;
    $def_message_error = $def_nothing_found.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
    $def_message_error .='<div style="text-align:left"><br>Попробуйте поискать в каталоге, через поисковые системы: <a rel="nofollow" href="http://yandex.ru/yandsearch?text='.$goodencoded.'&site='.$def_mainlocation.'" target="_blank">Яндекс</a> или <a rel="nofollow" href="http://www.google.ru/search?q='.$goodencoded.'&sitesearch='.$def_mainlocation.'" target="_blank">Google</a></div><br><br>';
            
    include ( "./includes/error_page.php" );	
}

}

else {
    
    // Если не корретный запрос
    
    $meta_index='<meta name="robots" content="noindex,nofollow" />'."\n";

    include ( "./template/$def_template/header.php" );
    
    $def_title_error = $def_warning_msg;
    $def_message_error = $def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';

    include ( "./includes/error_page.php" );

}

include ( "./template/$def_template/footer.php" );

?>