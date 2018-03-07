<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: search-1.php
-----------------------------------------------------
 Назначение: Быстрый поиск
=====================================================
*/

include ( "./defaults.php" );

$incomingline = $def_company_search;

if ( $_GET["search"] <> "" ) $sstring = rawurldecode ( $_GET['search'] ); else $sstring = $_POST['skey'];

if ( $_GET["locationcoded"] <> "" ) $locationcoded = rawurldecode ( $_GET['locationcoded'] ); else $locationcoded = $_POST['location'];

if ($locationcoded=='') $locationcoded="ANY";

if ( get_magic_quotes_gpc() )
{
 $sstring = stripcslashes($sstring);
 $locationcoded = stripcslashes($locationcoded);
}

$KsPage=intval($_GET['spage']);

$sstring = substr ( $sstring, 0, 64 );
$sstring = preg_replace( "#<script#i", "", $sstring );
$sstring = preg_replace ( "/[^\w\x7F-\xFF\s]/", " ", $sstring );
$sstring = strip_tags($sstring );
$sstring = trim ( $sstring );
$sstring = mysql_real_escape_string($sstring);
$sstring = str_replace ( " +"," ",$sstring );
$locationcoded = mysql_real_escape_string($locationcoded);

$swords = explode ( " ", $sstring );

$x = 0;

for ( $pa=0; $pa < count ( $swords ); $pa++ ) {

if ( strlen ( $swords[$pa] ) > 1 )
	{
		$word[$x] = $swords[$pa];$x++;
	}
}

@$words = implode ( " ", $word );

$npage = $KsPage + 1;
$ppage = $KsPage - 1;
$page1 = $KsPage * $def_count_srch;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$likequery2 = " COUNT(*)  ";
$likequery2.= " FROM $db_users WHERE ";
$likequery2.= " ( ( firmname LIKE '%$sstring%' ) or ( business LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ) AND firmstate='on' $hide_d $_SESSION[where_city]";

$likequery = " * ";
$likequery.= "FROM $db_users WHERE ";
$likequery.= " ( ( firmname LIKE '%$sstring%' ) or ( business LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ) AND firmstate='on' $hide_d $_SESSION[where_city]";

if ( $locationcoded != "ANY" ) { 
	if (($def_index_state == "YES") and ( $def_states_allow == "YES")) $likequery.= "AND state='$locationcoded'";
	else $likequery.= "AND location='$locationcoded'";
}

$likequery.= " ORDER BY flag, firmname";

	$sql = $likequery;
	$sql2 = $likequery2;

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

include ( "./template/$def_template/header.php" );
        
$ra = $db->query  ( "SELECT $sql2" );
$results_amount = mysql_result ( $ra,0,0 );

if ($results_amount>0) {
@$db->freeresult  ( $ra );

$r = $db->query  ( "SELECT $sql LIMIT $page1, $def_count_srch");
$r_filter = $db->query  ( "SELECT $sql LIMIT $page1, $def_count_srch");
$fetchcounter = $def_count_srch;
$f = $results_amount - $page1;

$def_count_dir=$def_count_srch;

include ("./template/$def_template/search_begin.php");

if ( $f < $def_count_srch ) $fetchcounter = $results_amount - $page1;

$string_where='fetchcounter='.$fetchcounter.'&page1='.$page1.'&def_count_dir='.$def_count_dir.'&string='.$sstring;

include ("./includes/sub.php");

$goodencoded = rawurlencode ( $sstring );

$locationcoded2 = rawurlencode ( $locationcoded );

if ( $results_amount > $def_count_srch )

{
        echo '<div class="pagination"><ul>';

	if ((($KsPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($KsPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($KsPage*$def_count_srch)+($def_count_srch*6)) <= $results_amount) $last =($KsPage*$def_count_srch)+($def_count_srch*6);
	else $last = $results_amount;

	@    $z=$first/$def_count_srch;

	if ($KsPage > 0)

	echo "<li><a href=\"search-1.php?search=$goodencoded&amp;locationcoded=$locationcoded2&amp;cat=$cat&amp;subcat=$subcat&amp;spage=", $KsPage-1 ,"&amp;page=$kPage\">$def_previous</a></li>";

	for ( $x = $first; $x < $last; $x=$x+$def_count_srch )

	{
		if ( $z == $KsPage )

		{
			echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
			$z++;
		}

		else

		{
			echo "<li><a href=\"search-1.php?search=$goodencoded&amp;locationcoded=$locationcoded2&amp;cat=$cat&amp;subcat=$subcat&amp;spage=$z&amp;page=$kPage\">", $z+1 ,"</a></li>";
			$z++;
		}
	}

	if ($KsPage - (($results_amount / $def_count_srch) - 1) < 0) echo "<li><a href=\"search-1.php?search=$goodencoded&amp;locationcoded=$locationcoded2&amp;cat=$cat&amp;subcat=$subcat&amp;spage=", $KsPage+1 ,"&amp;page=$kPage\">$def_next</a></li>";

	echo '</ul></div>';
}

} else { include ("./template/$def_template/search_begin.php");

$goodencoded = rawurlencode ( $sstring );

if ($_SESSION[where_city]!='') $def_nothing_found = $def_nothing_found.$def_nothing_found_cyti;

	echo '<br />'.$def_nothing_found.'<br /><br /><a href="javascript:history.back()">'.$def_back.'</a><br />';
        echo '<p style="text-align:left">'.$def_find_y_g.' <a rel="nofollow" href="http://yandex.ru/yandsearch?text='.$goodencoded.'&site='.$def_mainlocation.'" target="_blank">Яндекс</a> или <a rel="nofollow" href="http://www.google.ru/search?q='.$goodencoded.'&sitesearch='.$def_mainlocation.'" target="_blank">Google</a></p>';

}

include ( "./template/$def_template/footer.php" );

?>