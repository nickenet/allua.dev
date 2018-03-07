<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-2.php
-----------------------------------------------------
 Назначение: Поиск по продукции и услугам
=====================================================
*/

include ( "./defaults.php" );

$incomingline = $def_offers_search;
$help_section = $psearch_help;

if ( isset ( $_POST["type"] ) ) $type_offers = $_POST["type"]; else $type_offers='ANY';

if ( isset ( $_GET["type"] ) ) $type_offers = $_GET["type"];

	$type1 = "";
	if ( $type_offers == "1" ) $type1 = $def_offer_1;
	if ( $type_offers == "2" ) $type1 = $def_offer_2;
	if ( $type_offers == "3" ) $type1 = $def_offer_3;
	if ( $type_offers == "ANY" ) $type1 = $def_search_offers;

	if ( $type_offers != "ANY" ) $type_offers=intval($type_offers);

if ( $_GET["search"] <> "" )

{
	$sstring = rawurldecode ( $_GET["search"] );
}

else

{
	$sstring = $_POST["pkey"];
	if (isset($_POST["skey"])) $sstring .= $_POST["skey"];
}

$sstring = substr ( $sstring, 0, 64 );
$sstring = strip_tags ($sstring);
$sstring = safeHTML ($sstring);
$swords = explode ( " ", $sstring );

if (strlen($sstring)>1) {

$x = 0;

for ( $i=0; $i < count ( $swords ); $i++ )

{
	if ( strlen ( $swords[$i] ) > 1 )

	{
		$word[$x] = "$swords[$i]";
		$x++;
	}
}

@$words = implode ( " ", $word );

$kSpage=intval($_GET[spage]);
$npage = $kSpage + 1;
$ppage = $kSpage - 1;
$page1 = $kSpage * $def_count_srch;

// LIKE
    $likequery .= " * FROM $db_offers WHERE ";
    $likequery .= " ( ( item LIKE '%$words%' ) or ( message LIKE '%$words%' ) ) ";
    if ( $type_offers <> "ANY" ) $likequery .= "AND (type='$type_offers') ";
    $likequery .= " ORDER BY date DESC";

// FULL
    $query = "num, item, date, type, message, quantity, packaging, price, period, firmselector, ";
    $query .= " MATCH (item, message) AGAINST ('$words') ";
    $query .= "AS relevance FROM $db_offers WHERE ";
    $query .= " MATCH (item, message) AGAINST ('$words') ";
    if ( $type_offers <> "ANY" ) $query .= "AND (type='$type_offers') ";
    $query .= " ORDER BY relevance DESC";

if ($def_search_type == "LIKE") $query = $likequery;

$r = $db->query  ( "SELECT $query" );

        $results_amount_max = mysql_num_rows ( $r );

$rz = $db->query  ( "SELECT $query LIMIT $page1, $def_count_srch");

        $results_amount = mysql_num_rows ( $rz );

        $fetchcounter = $def_count_srch;

        $f_max = $results_amount_max - $page1;

$incomingline = $def_offers_search;

$help_section = $psearch_help;

include ( "./template/$def_template/header.php" );

echo phighslide();

include ("./includes/searchoffers.inc.php");

	$sdate1 = date("H:i:s");
	$sdate2 = date("Y-m-d");
	$sdate3 = undate($sdate2, $def_datetype);

?>
 <br>
  <div align="left">
 &nbsp;&nbsp;&nbsp;<?php echo "$def_offers_search <b>( $words, $type1 )</b>
 &nbsp;&nbsp;[ $def_results: <b>$results_amount_max</b> // [ $sdate1, $sdate3 ]"; ?><br>
  </div>
 <br>

<?php

if ( $f_max < $def_count_srch ) $fetchcounter = $results_amount_max - $page1;

 	$last10_offers="NO";

        $search_offers_true="YES";
        
        $category_offers=$cat;
	
        include ("./includes/sub_component/catoffers.php");

$goodencoded = rawurlencode ( $sstring );
$z = 0;

if ( $results_amount_max == 0 ) 
    {
        echo $def_nothing_found.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
        echo '<div style="text-align:left"><br>Попробуйте поискать в каталоге, через поисковые системы: <a rel="nofollow" href="http://yandex.ru/yandsearch?text='.$goodencoded.'&site='.$def_mainlocation.'" target="_blank">Яндекс</a> или <a rel="nofollow" href="http://www.google.ru/search?q='.$goodencoded.'&sitesearch='.$def_mainlocation.'" target="_blank">Google</a></div>';
    }

if ( $results_amount_max > $def_count_srch )

{
        echo "<br>";

	if ($kSpage > 0) echo "<a href=\"search-2.php?search=$goodencoded&amp;type=$type_offers&amp;spage=", $kSpage-1 ,"\"><b>$def_previous</b></a>&nbsp;";

	for ( $x=0; $x < $results_amount_max; $x = $x + $def_count_srch )

	{
		if ( $z == $kSpage )

		{
			echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
			$z++;
		}

		else

		{
			echo "<a href=\"search-2.php?search=$goodencoded&amp;type=$type_offers&amp;spage=$z\"><b>", $z+1 ,"</b></a>&nbsp;";
			$z++;
		}
	}

	if ($kSpage - (($results_amount_max / $def_count_srch) - 1) < 0) echo "<a href=\"search-2.php?search=$goodencoded&amp;type=$type_offers&amp;spage=", $kSpage+1 ,"\"><b>$def_next</b></a>";

	echo "<br><br>";

}

qserch_table($results_amount_max, $words);

if ($kSpage==0)  {

        // поиск по другим разделам
        $result_plus="NO";

        // фирмы
        $query_firms = " selector FROM $db_users WHERE ( ( firmname LIKE '%$words%' ) or ( business LIKE '%$words%' ) ) ";
        $r_firms = $db->query  ( "SELECT $query_firms" );
        $results_amount_firms = mysql_num_rows ( $r_firms );
        if ($results_amount_firms>0) $result_plus="YES";

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

            if ($result_plus=="YES") {
                echo '<div style="text-align:left"><br><br>Запрос (<b>'.$words.'</b>) также найден:';

                if ($results_amount_firms>0) echo '<br> &#187 <a href="search-1.php?search='.$goodencoded.'">'.$def_search_firms.'</a> ('.$results_amount_firms.')';
                if ($results_amount_img>0) echo '<br> &#187 <a href="search-4.php?search='.$goodencoded.'">'.$def_search_img.'</a> ('.$results_amount_img.')';
                if ($results_amount_xls>0) echo '<br> &#187 <a href="search-6.php?skey='.$goodencoded.'">'.$def_search_xls.'</a> ('.$results_amount_xls.')';
                if ($results_amount_pub>0) echo '<br> &#187 <a href="search-5.php?skey='.$goodencoded.'">'.$def_search_pub.'</a> ('.$results_amount_pub.')';

                echo '</div><br><br>';
            }
}

} else

{

include ( "./template/$def_template/header.php" );

if ( $results_amount_max == 0 ) echo $def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';

}

include ( "./template/$def_template/footer.php" );

?>