<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: company_city.php
-----------------------------------------------------
 Назначение: Вывод компаний города
=====================================================
*/

include ( "./defaults.php" );

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_dir;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r_count = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE firmstate = 'on' $hide_d $_SESSION[where_city] ");

$r = $db->query ( "SELECT * FROM $db_users WHERE firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$r_filter = $db->query ( "SELECT mobile, map, category FROM $db_users WHERE firmstate = 'on' $hide_d $_SESSION[where_city] ORDER BY flag, firmname LIMIT $page1, $def_count_dir" );

$results_amount=mysql_result ( $r_count,0,0 );

$fetchcounter = $def_count_dir;
$f = $results_amount - $page1;

if ( $f < $def_count_dir ) { $fetchcounter = $results_amount - $page1; }

$incomingline_firm = $_SESSION['smycity'];

include ("./template/$def_template/header.php");

if ($results_amount > 0)

{
        include ("./includes/sub.php");

	if ( $results_amount > $def_count_dir )

	{
            echo '<div class="pagination"><ul>';

		if ((($kPage*$def_count_dir)-($def_count_dir*5)) >= 0) $first=($kPage*$def_count_dir)-($def_count_dir*5);
		else $first=0;

		if ((($kPage*$def_count_dir)+($def_count_dir*6)) <= $results_amount) $last =($kPage*$def_count_dir)+($def_count_dir*6);
		else $last = $results_amount;

		@    $z=$first/$def_count_dir;

		if ($kPage > 0) echo "<li><a href=\"company_city.php?page=", $kPage-1 ,"\">$def_previous</a></li>";

		for ( $x=$first; $x<$last;$x=$x+$def_count_dir )

		{

			if ( $z == $kPage )

			{
				echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
				$z++;
			}

			else

			{
				echo "<li><a href=\"company_city.php?page=$z\">", $z+1 ,"</a></li>";
				$z++;
			}
		}

                if ($kPage - (($results_amount / $def_count_dir) - 1) < 0) echo "<li><a class=\"next_page\" href=\"company_city.php?page=", $kPage+1 ,"\">$def_next</a></li>";

             echo '</ul></div>';
	}
} elseif ($res<=0) { $class_alert="alert alert-error"; $alert_info = $def_nothing_found_cyti3; include ("./template/$def_template/alert.php"); }

    $view_cat_city = array_count_values( $category_city );
    arsort( $view_cat_city );
    $view_cat_city = array_keys( $view_cat_city );
    $view_cat_city = array_slice( $view_cat_city, 0, $def_count_dir );
    $category = implode(",", $view_cat_city);

    echo '<h1>'.$def_cat_yes_mobile.'</h1><div class="category">';

    $r = $db->query ( " SELECT fcounter, selector, category FROM $db_category WHERE selector IN ($category)");
    	 $results = $db->numrows ( $r );
	 $res = round ( $results);
	 for ( $i=0;$i<=$res;$i++ ) {

 		$f = $db->fetcharray ( $r );
	 	if ( $f['fcounter'] > 0 ) echo '<p>&nbsp;&raquo; <a href="index.php?category='.$f['selector'].'">'.$f['category'].'</a></p>';
	}

    echo '</div>';
    

include ( "./template/$def_template/footer.php" );

?>