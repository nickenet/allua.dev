<?php
/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: index.php
-----------------------------------------------------
 Назначение: Главная страница каталога мобильной версии
=====================================================
*/

include ( "./defaults.php" );

// Выводим последние новости
if (isset($_GET['lastnews'])) {

    $incomingline_firm = $def_news_title;

    include ("./template/$def_template/header.php");

        include ("./template/$def_template/lastnews.php");

        $url_full_version = 'allnews.php';

    include ( "./template/$def_template/footer.php" );

}

// Лента новостей
if (isset($_GET['lenta'])) {

    $incomingline_firm = $def_lenta_info;

    include ("./template/$def_template/header.php");

        include ("./template/$def_template/sub_info.php");

    include ( "./template/$def_template/footer.php" );

}

// Поиск по первой букве

if ($_GET['letterss']=="1") {

    $incomingline_firm = $def_search;

    include ("./template/$def_template/header.php");

        include ("./template/$def_template/letters.php");

    include ( "./template/$def_template/footer.php" );

}

// Вывод по первой букве

if (isset($_GET['letter'])) {

    $kLetter=safeHTML ($_GET['letter']);

    $incomingline_firm = $def_search.': '.$kLetter;

    include ("./template/$def_template/header.php");

        include ("./includes/alpha.php");

    include ( "./template/$def_template/footer.php" );

}

// *********************************************************

if ( ( !isset($_GET["REQ"] ) ) and ( !isset ( $cat ) ) and ( !isset ( $categorymains ) ) ) {

        $incomingline = $def_catalogue;

	include ( "./template/$def_template/header.php" );        

	if ($_GET['showallcat']==1) { 

            include ( "./template/$def_template/allcat.php" );

        }

        else include ( "./template/$def_template/main_top.php" );
	
include ( "./template/$def_template/footer.php" );

}

// *********************************************************

if ( isset ( $categorymains ) )

{
	$ra = $db->query ( "SELECT category,top FROM $db_category WHERE selector=$categorymains" );
	$fa = $db->fetcharray ( $ra );
	$db->freeresult ( $ra );

	$ip = $_SERVER["REMOTE_ADDR"];

	$top=$fa[top] + 1;

	if ($ip != "$fa[ip]") $db->query ( "UPDATE $db_category SET top = '$top', ip = '$ip' WHERE selector='$categorymains'" );

	$incomingline_firm = $fa['category'];

	include ( "./template/$def_template/header.php" );

?>

<div style="text-align:left; padding: 5px;">

<?php

if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0 "; else $sql = "";

$r = $db->query ( "SELECT * FROM $db_subcategory WHERE catsel='$categorymains' $sql ORDER BY subcategory" );
$results = $db->numrows ( $r );

$res =$results-1;

for ( $i=0;$i<=$res;$i++ )

{
	$f = $db->fetcharray ( $r );
	if ( $f[fcounter] > 0 ) include ( "./template/$def_template/allsubcat.php" );

}

?>

</div>

<?php

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_dir;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r_count = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE (category LIKE '$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0' or category LIKE '$categorymains#0#0') and firmstate = 'on' $hide_d $_SESSION[where_city] ");

$r = $db->query ( "SELECT * FROM $db_users WHERE (category LIKE '$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0' or category LIKE '$categorymains#0#0') and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$r_filter = $db->query ( "SELECT mobile, map FROM $db_users WHERE (category LIKE '$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0:%' or category LIKE '%:$categorymains#0#0' or category LIKE '$categorymains#0#0') and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$results_amount=mysql_result ( $r_count,0,0 );

$fetchcounter = $def_count_dir;
$f = $results_amount - $page1;

if ( $f < $def_count_dir ) { $fetchcounter = $results_amount - $page1; }

if ($results_amount > 0)

{
        $string_where='cat='.$categorymains.'&fetchcounter='.$fetchcounter.'&page1='.$page1.'&def_count_dir='.$def_count_dir;

	include ("./includes/sub.php");

	if ( $results_amount > $def_count_dir )

	{
            echo '<div class="pagination"><ul>';

		if ((($kPage*$def_count_dir)-($def_count_dir*5)) >= 0) $first=($kPage*$def_count_dir)-($def_count_dir*5);
		else $first=0;

		if ((($kPage*$def_count_dir)+($def_count_dir*6)) <= $results_amount) $last =($kPage*$def_count_dir)+($def_count_dir*6);
		else $last = $results_amount;

		@    $z=$first/$def_count_dir;

		if ($kPage > 0) echo "<li><a href=\"index.php?category=$categorymains&amp;page=", $kPage-1 ,"\">$def_previous</a></li>";

		for ( $x=$first; $x<$last;$x=$x+$def_count_dir )

		{

			if ( $z == $kPage )

			{
				echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
				$z++;
			}

			else

			{
				echo "<li><a href=\"index.php?category=$categorymains&amp;page=$z\">", $z+1 ,"</a></li>";
				$z++;
			}
		}

                if ($kPage - (($results_amount / $def_count_dir) - 1) < 0) echo "<li><a class=\"next_page\" href=\"index.php?category=$categorymains&amp;page=", $kPage+1 ,"\">$def_next</a></li>";

             echo '</ul></div>';
	}
} elseif ($results<=0) { $class_alert="alert alert-error"; $alert_info = $def_nothing_found_cyti3; include ("./template/$def_template/alert.php"); }

$url_full_version = 'index.php?category='.$categorymains.'&page='.$kPage.'&mobile=no';

include ( "./template/$def_template/footer.php" );

}

// *********************************************************

if ( (isset ( $cat )  and (isset ( $subcat )) and (!isset ( $subsubcat ) ) and (!isset ( $_GET["REQ"] ) )) )

{
	$ra2 = $db->query ( "SELECT * FROM $db_subcategory WHERE catsel=$cat and catsubsel=$subcat" );
	$fa2 = $db->fetcharray ( $ra2 );
	$db->freeresult ( $ra2 );

	$incomingline_firm = $fa2[subcategory];

	include ("./template/$def_template/header.php");
?>

<div style="text-align:left; padding: 5px;">

<?php

if ($def_empty_hidden == "YES") $sql = " AND fcounter > 0 ";  else $sql = "";

$r = $db->query ( "SELECT * FROM $db_subsubcategory WHERE catsel='$cat' and catsubsel='$subcat' $sql ORDER BY 'subsubcategory'" );
$results = $db->numrows ( $r );

$res = $results;

for ( $i=0;$i<$res;$i++ )

{
	$f = $db->fetcharray ( $r );
	if ( $f[fcounter] > 0 ) include ( "./template/$def_template/allsubsubcat.php" );
}

?>

</div>

<?php

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_dir;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r_count = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE ((category LIKE '%:$cat#$subcat#0:%') or (category LIKE '$cat#$subcat#0:%') or (category LIKE '%:$cat#$subcat#0') or (category LIKE '$cat#$subcat#0')) and firmstate = 'on' $hide_d $_SESSION[where_city] " );

$r = $db->query ( "SELECT * FROM $db_users WHERE ((category LIKE '%:$cat#$subcat#0:%') or (category LIKE '$cat#$subcat#0:%') or (category LIKE '%:$cat#$subcat#0') or (category LIKE '$cat#$subcat#0')) and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$r_filter = $db->query ( "SELECT mobile, map FROM $db_users WHERE ((category LIKE '%:$cat#$subcat#0:%') or (category LIKE '$cat#$subcat#0:%') or (category LIKE '%:$cat#$subcat#0') or (category LIKE '$cat#$subcat#0')) and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$results_amount=mysql_result ( $r_count,0,0 );

$fetchcounter = $def_count_dir;
$f = $results_amount - $page1;

if ( $f < $def_count_dir ) { $fetchcounter = $results_amount - $page1; } 

if ($results_amount > 0)

{
        $string_where='cat='.$cat.'&subcat='.$subcat.'&fetchcounter='.$fetchcounter.'&page1='.$page1.'&def_count_dir='.$def_count_dir;

	include ("./includes/sub.php");

	if ( $results_amount > $def_count_dir )

	{
            
            echo '<div class="pagination"><ul>';
            
		if ((($kPage*$def_count_dir)-($def_count_dir*5)) >= 0) $first=($kPage*$def_count_dir)-($def_count_dir*5);
		else $first=0;

		if ((($kPage*$def_count_dir)+($def_count_dir*6)) <= $results_amount) $last =($kPage*$def_count_dir)+($def_count_dir*6);
		else $last = $results_amount;

		@    $z=$first/$def_count_dir;

		if ($kPage > 0)

		{
			echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=", $kPage-1 ,"\">$def_previous</a></li>";
		}

		for ( $x=$first; $x<$last;$x=$x+$def_count_dir )

		{
			if ( $z == $kPage )

			{
				echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
				$z++;
			}

			else

			{
				echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=$z\">", $z+1 ,"</a></li>";
				$z++;
			}

		}

                if ($kPage - (($results_amount / $def_count_dir) - 1) < 0) echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;page=", $kPage+1 ,"\">$def_next</a></li>";

                echo '</ul></div>';
	}
} elseif ($res<=0) { $class_alert="alert alert-error"; $alert_info = $def_nothing_found_cyti3; include ("./template/$def_template/alert.php"); }

$url_full_version = 'index.php?cat='.$cat.'&subcat='.$subcat.'&page='.$kPage.'&mobile=no';

include ( "./template/$def_template/footer.php" );

}

// *********************************************************


$r = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsubsubsel='$subsubcat'" );
$f = $db->fetcharray   ( $r );
$showsubcategory = $f["subsubcategory"];

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_dir;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$incomingline_firm = $showsubcategory;

include ( "./template/$def_template/header.php" );

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r_count = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE (category LIKE '$cat#$subcat#$subsubcat%' or category LIKE '%:$cat#$subcat#$subsubcat:%' or category LIKE '%:$cat#$subcat#$subsubcat' or category LIKE '$cat#$subcat#$subsubcat') and firmstate = 'on' $hide_d $_SESSION[where_city] " );

$r = $db->query  ( "SELECT * FROM $db_users WHERE (category LIKE '$cat#$subcat#$subsubcat%' or category LIKE '%:$cat#$subcat#$subsubcat:%' or category LIKE '%:$cat#$subcat#$subsubcat' or category LIKE '$cat#$subcat#$subsubcat') and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$r_filter = $db->query  ( "SELECT mobile, map FROM $db_users WHERE (category LIKE '$cat#$subcat#$subsubcat%' or category LIKE '%:$cat#$subcat#$subsubcat:%' or category LIKE '%:$cat#$subcat#$subsubcat' or category LIKE '$cat#$subcat#$subsubcat') and firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$results_amount=mysql_result ( $r_count,0,0 );

$fetchcounter = $def_count_dir;
$f = $results_amount - $page1;

if ( $f < $def_count_dir ) { $fetchcounter = $results_amount - $page1; }

$string_where='cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat.'&fetchcounter='.$fetchcounter.'&page1='.$page1.'&def_count_dir='.$def_count_dir;

if ($results_amount > 0) { 

    include ("./includes/sub.php");

if ( $results_amount > $def_count_dir )

{  
        echo '<div class="pagination"><ul>';

	if ((($kPage*$def_count_dir)-($def_count_dir*5)) >= 0) $first=($kPage*$def_count_dir)-($def_count_dir*5);
	else $first=0;

	if ((($kPage*$def_count_dir)+($def_count_dir*6)) <= $results_amount) $last =($kPage*$def_count_dir)+($def_count_dir*6);
	else $last = $results_amount;

	@    $z=$first/$def_count_dir;

	if ($kPage > 0) echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=", $kPage-1 ,"\">$def_previous</a></li>";

	for ( $x=$first; $x<$last;$x=$x+$def_count_dir )

	{
		if ( $z == $kPage )

		{
			echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
			$z++;
		}

		else

		{
			echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=$z\">", $z+1 ,"</a></li>";
			$z++;
		}
	}
        
        if ($kPage - (($results_amount / $def_count_dir) - 1) < 0) echo "<li><a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;page=", $kPage+1 ,"\">$def_next</a></li>";
     
        echo '</ul></div>';
}

} else { $class_alert="alert alert-error"; $alert_info = $def_nothing_found_cyti3; include ("./template/$def_template/alert.php"); }

$url_full_version = 'index.php?cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat.'&page='.$kPage.'&mobile=no';

include ( "./template/$def_template/footer.php" );

?>