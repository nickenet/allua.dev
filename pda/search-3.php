<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: search-3.php
-----------------------------------------------------
 Назначение: Расширенный поиск
=====================================================
*/

include ( "./defaults.php" );

$incomingline = $def_search_adv;

if ( $_GET["categoryset"] <> "" ) $category1 = safeHTML(rawurldecode($_GET['categoryset']));
else $category1 = safeHTML($_POST['category']);


if ( $_GET["firmname"] <> "" ) $firmname1 = safehtml(rawurldecode($_GET['firmname']));
else $firmname1 = safehtml($_POST['firmname']);


if ( $_GET["business"] <> "" ) $business = safehtml(rawurldecode($_GET['business']));
else $business = safehtml($_POST['business']);

if ( $_GET["location"] <> "" ) $location1 = safehtml(rawurldecode($_GET["location"]));
else $location1 = safehtml($_POST['location']);


if ( $_GET["state"] <> "" ) $state1 = safehtml(rawurldecode($_GET['state']));
else $state1 = safehtml($_POST['state']);


if ( $_GET["city"] <> "" ) $city1 = safehtml(rawurldecode($_GET['city']));
else $city1 = safehtml($_POST['city']);

if ( $_GET["address"] <> "" ) $address = safehtml(rawurldecode( $_GET['address']));
else $address = safehtml($_POST['address']);

if ( $_GET["zip"] <> "" ) $zip = safehtml(rawurldecode($_GET['zip']));
else 	$zip = safehtml($_POST['zip']);

if ( $_GET["phone"] <> "" ) $phone = safehtml(rawurldecode($_GET['phone']));
else $phone = safehtml($_POST['phone']);

if ( $_GET["fax"] <> "" ) $fax = safehtml(rawurldecode($_GET['fax']));
else $fax = safehtml($_POST['fax']);

if ( $_GET["mobile"] <> "" ) $mobile = safehtml(rawurldecode ($_GET['mobile']));
else $mobile = safehtml($_POST['mobile']);


if ( $_GET["icq"] <> "" ) $icq = safehtml(rawurldecode ($_GET['icq']));
else $icq = safehtml($_POST['icq']);

if ( $_GET["mail"] <> "" ) $mail = safehtml(rawurldecode($_GET['mail']));
else $mail = safehtml($_POST['mail']);

if ( $_GET["www"] <> "" ) $www = safehtml(rawurldecode($_GET['www']));
else $www = safehtml(rawurldecode($_POST['www']));


if ($def_reserved_1_enabled == "YES") {
    if ( $_GET["reserved_1"] <> "" ) $reserved_1 = safehtml(rawurldecode($_GET['reserved_1']));
    else $reserved_1 = safehtml($_POST['reserved_1']);
}

if ($def_reserved_2_enabled == "YES") {
    if ( $_GET["reserved_2"] <> "" ) $reserved_2 = safehtml(rawurldecode($_GET['reserved_2']));
    else $reserved_2 = safehtml($_POST['reserved_2']);
}

if ($def_reserved_3_enabled == "YES") {
    if ( $_GET["reserved_3"] <> "" ) $reserved_3 = safehtml(rawurldecode($_GET['reserved_3']));
    else $reserved_3 = safehtml($_POST['reserved_3']);
}

$KsPage=intval($_GET['spage']);

$npage = $KsPage + 1;
$ppage = $KsPage - 1;
$page1 = $KsPage * $def_count_srch;

$query .= " FROM $db_users WHERE ";

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$query .= " firmstate='on' $hide_d ";

if ( $category1 != "ANY" ) $query .= " AND ((category LIKE '$category1#%') or (category LIKE '%:$category1#%')) ";

if ( $firmname1 != "" ) $query .= " AND firmname LIKE '%$firmname1%' ";

if ( $business != "" ) $query .= " AND business LIKE '%$business%' ";

if ( $location1 != "ANY" ) $query .= " AND location = '$location1' ";

if ( $def_states_allow == "YES" ) {

	if ( $state1 != "ANY" ) $query .= " AND state = '$state1' ";
}

if ( $def_country_allow == "YES" ) {

	if ( $city1 != "" ) $query .= " AND city LIKE '%$city1%' ";
        
}

if ( $address != "" ) $query .= " AND address LIKE '%$address%' ";

if ( $zip != "" ) $query .= " AND zip LIKE '%$zip%' ";

if ( $phone != "" ) $query .= " AND phone LIKE '%$phone%' ";

if ( $fax != "" ) $query .= " AND fax LIKE '%$fax%' ";

if ( $mobile != "" ) $query .= " AND mobile LIKE '%$mobile%' ";

if ( $icq != "" ) $query .= " AND icq LIKE '%$icq%' ";

if ( $mail != "" ) $query .= " AND mail LIKE '%$mail%' ";

if ( $www != "" ) $query .= " AND www LIKE '%$www%' ";

if ( $reserved_1 != "" ) $query .= " AND reserved_1 LIKE '%$reserved_1%' ";

if ( $reserved_2 != "" ) $query .= " AND reserved_2 LIKE '%$reserved_2%' ";

if ( $reserved_3 != "" ) $query .= " AND reserved_3 LIKE '%$reserved_3%' ";

$query .= " ORDER BY flag, firmname";

$ra = $db->query  ( "SELECT COUNT(*) $query" );
$results_amount_search = mysql_result ( $ra, 0, 0 );
@$db->freeresult  ( $ra );

$r = $db->query  ( "SELECT * $query LIMIT $page1, $def_count_srch");
$results_amount2 = $db->numrows ( $r );

$r_filter = $db->query  ( "SELECT * $query LIMIT $page1, $def_count_srch");

include ( "./template/$def_template/header.php" );

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

include ("./template/$def_template/search_full_begin.php");

if ($def_count_srch > $results_amount2) $fetchcounter = $results_amount2;
else $fetchcounter = $def_count_srch;

include ("./includes/sub.php");

if ( $results_amount_search == 0 )echo $def_nothing_found;

$category2 = rawurlencode ( $category1 );
$firmname2 = rawurlencode ( $firmname1 );
$business2 = rawurlencode ( $business );
$location2 = rawurlencode ( $location1 );
$state2 = rawurlencode ( $state1 );
$city2 = rawurlencode ( $city1 );
$address2 = rawurlencode ( $address );
$zip2 = rawurlencode ( $zip );
$phone2 = rawurlencode ( $phone );
$fax2 = rawurlencode ( $fax );
$mobile2 = rawurlencode ( $mobile );
$icq2 = rawurlencode ( $icq );
$mail2 = rawurlencode ( $mail );
$www2 = rawurlencode ( $www );
$reserved_1_2 = rawurlencode ( $reserved_1 );
$reserved_2_2 = rawurlencode ( $reserved_2 );
$reserved_3_2 = rawurlencode ( $reserved_3 );

if ( $results_amount_search > $def_count_srch )

{
        echo '<div class="pagination"><ul>';

        if ((($KsPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($KsPage*$def_count_srch)-($def_count_srch*5);
	else $first=0;

	if ((($KsPage*$def_count_srch)+($def_count_srch*6)) <= $results_amount_search) $last =($KsPage*$def_count_srch)+($def_count_srch*6);
	else $last = $results_amount_search;

	@    $z=$first/$def_count_srch;

        if ($KsPage > 0) echo "<li><a href=\"search-3.php?categoryset=$category2&amp;firmname=$firmname2&amp;business=$business2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;address=$address2&amp;zip=$zip2&amp;phone=$phone2&amp;fax=$fax2&amp;mobile=$mobile2&amp;icq=$icq2&amp;manager=$manager2&amp;mail=$mail2&amp;www=$www2&amp;reserved_1=$reserved_1_2&amp;reserved_2=$reserved_2_2&amp;reserved_3=$reserved_3_2&amp;spage=", $KsPage-1 ,"&amp;page=$kPage\">$def_previous</a></li>";

	for ( $x=$first; $x < $last; $x=$x+$def_count_srch )
	{
		if ( $z == $KsPage )

		{
			echo "<li class=\"disabled\"><a href=\"#\">", $z+1 ,"</a></li>";
			$z++;
		}

		else

		{
			echo "<li><a href=\"search-3.php?categoryset=$category2&amp;firmname=$firmname2&amp;business=$business2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;address=$address2&amp;zip=$zip2&amp;phone=$phone2&amp;fax=$fax2&amp;mobile=$mobile2&amp;icq=$icq2&amp;manager=$manager2&amp;mail=$mail2&amp;www=$www2&amp;reserved_1=$reserved_1_2&amp;reserved_2=$reserved_2_2&amp;reserved_3=$reserved_3_2&amp;spage=$z&amp;page=$kPage\">", $z+1 ,"</a></li>";
			$z++;
		}
	}

	if ($KsPage - (($results_amount_search / $def_count_srch) - 1) < 0) echo "<li><a href=\"search-3.php?categoryset=$category2&amp;firmname=$firmname2&amp;business=$business2&amp;location=$location2&amp;state=$state2&amp;city=$city2&amp;address=$address2&amp;zip=$zip2&amp;phone=$phone2&amp;fax=$fax2&amp;mobile=$mobile2&amp;icq=$icq2&amp;manager=$manager2&amp;mail=$mail2&amp;www=$www2&amp;reserved_1=$reserved_1_2&amp;reserved_2=$reserved_2_2&amp;reserved_3=$reserved_3_2&amp;spage=", $KsPage+1 ,"&amp;page=$kPage\">$def_next</a></li>";

        echo '</ul></div>';
}

include ( "./template/$def_template/footer.php" );

?>