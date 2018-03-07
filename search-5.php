<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-5.php
-----------------------------------------------------
 Назначение: Поиск по публикациям
=====================================================
*/

include ( "./defaults.php" );

$kPage = intval($_GET[page]);

$incomingline = "Поиск публикаций";
$help_section = $adv_search5_help;

if ( $_GET["type"] <> "" ) $type = intval ( $_GET["type"] ); else $type = intval($_POST[type]);

$kType=$type;

if ( $_GET['skey'] <> "" ) $item_short_full = rawurldecode ( $_GET['skey'] ); else $item_short_full = safehtml($_POST['skey']);

$item_short_full=strip_tags(trim(mysql_real_escape_string($item_short_full)));

if (strlen($item_short_full)>1) {

if ( $_GET['form_n1'] <> "" ) $form_n1 = rawurldecode ( $_GET['form_n1'] ); else $form_n1 = safehtml($_POST['form_n1']);

$form_n1 = trim(mysql_real_escape_string($form_n1));

if ( $_GET['form_n2'] <> "" ) $form_n2 = rawurldecode ( $_GET['form_n2'] ); else $form_n2 = safehtml($_POST['form_n2']);

$form_n2 = trim(mysql_real_escape_string($form_n2));

if ( $_GET['form_n3'] <> "" ) $form_n3 = rawurldecode ( $_GET['form_n3'] ); else $form_n3 = safehtml($_POST['form_n3']);

$form_n3 = trim(mysql_real_escape_string($form_n3));

if ( $_GET['form_n4'] <> "" ) $form_n4 = rawurldecode ( $_GET['form_n4'] ); else $form_n4 = safehtml($_POST['form_n4']);

$form_n4 = trim(mysql_real_escape_string($form_n4));

if ( $_GET['form_n5'] <> "" ) $form_n5 = rawurldecode ( $_GET['form_n5'] ); else $form_n5 = safehtml($_POST['form_n5']);

$form_n5 = trim(mysql_real_escape_string($form_n5));

if ( $_GET['form_n6'] <> "" ) $form_n6 = rawurldecode ( $_GET['form_n6'] ); else $form_n6 = safehtml($_POST['form_n6']);

$form_n6 = trim(mysql_real_escape_string($form_n6));

if ( $_GET['form_n7'] <> "" ) $form_n7 = rawurldecode ( $_GET['form_n7'] ); else $form_n7 = safehtml($_POST['form_n7']);

$form_n7 = trim(mysql_real_escape_string($form_n7));

if ( $_GET['form_n8'] <> "" ) $form_n8 = rawurldecode ( $_GET['form_n8'] ); else $form_n8 = safehtml($_POST['form_n8']);

$form_n8 = trim(mysql_real_escape_string($form_n8));

if ( $_GET['form_n9'] <> "" ) $form_n9 = rawurldecode ( $_GET['form_n9'] ); else $form_n9 = safehtml($_POST['form_n9']);

$form_n9 = trim(mysql_real_escape_string($form_n9));

if ( $_GET['form_n10'] <> "" ) $form_n10 = rawurldecode ( $_GET['form_n10'] ); else $form_n10 = safehtml($_POST['form_n10']);

$form_n10 = trim(mysql_real_escape_string($form_n10));

$query .= " FROM $db_info WHERE ";

$query .= " ( (item LIKE '%$item_short_full%') or (shortstory LIKE '%$item_short_full%') or (fullstory LIKE '%$item_short_full%') ) ";

if ( $form_n1 != "" ) $query .= " AND f_name1 LIKE '%$form_n1%' ";

if ( $form_n2 != "" ) $query .= " AND f_name2 LIKE '%$form_n2%' ";

if ( $form_n3 != "" ) $query .= " AND f_name3 LIKE '%$form_n3%' ";

if ( $form_n4 != "" ) $query .= " AND f_name4 LIKE '%$form_n4%' ";

if ( $form_n5 != "" ) $query .= " AND f_name5 LIKE '%$form_n5%' ";

if ( $form_n6 != "" ) $query .= " AND f_name6 LIKE '%$form_n6%' ";

if ( $form_n7 != "" ) $query .= " AND f_name7 LIKE '%$form_n7%' ";

if ( $form_n8 != "" ) $query .= " AND f_name8 LIKE '%$form_n8%' ";

if ( $form_n9 != "" ) $query .= " AND f_name9 LIKE '%$form_n9%' ";

if ( $form_n10 != "" ) $query .= " AND f_name10 LIKE '%$form_n10%' ";

if ($type!=0) { $query .= " AND type=$type";

$type_on=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);

$mytype='по разделу: <u>'.$type_on[$type].'</u>';

} else { $filter_pub=$query; $mytype='по всем типам публикаций'; }

$query .= " ORDER BY date DESC, datetime DESC";

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

$ra = $db->query  ( "SELECT * $query" );

@$results_amount_search = mysql_num_rows ( $ra );
@$db->freeresult  ( $ra );

if (isset($filter_pub) and ($results_amount_search>0) ) {

    $goodencoded = rawurlencode ( $item_short_full );
    $type_search='<br><br>&nbsp;&nbsp;<b>Фильтр:</b>&nbsp;';
    $fp_t1 = $db->query  ( "SELECT * $filter_pub AND type='1' ORDER BY date DESC, datetime DESC" );
    $results_amount_fp_t1 = mysql_num_rows ( $fp_t1 );
    if ($results_amount_fp_t1>0) $type_search .= '<a href="search-5.php?skey='.$goodencoded.'&type=1">'.$def_info_news.'</a> ('.$results_amount_fp_t1.')&nbsp;';

    $fp_t2 = $db->query  ( "SELECT * $filter_pub AND type='2' ORDER BY date DESC, datetime DESC" );
    $results_amount_fp_t2 = mysql_num_rows ( $fp_t2 );
    if ($results_amount_fp_t2>0) $type_search .= '<a href="search-5.php?skey='.$goodencoded.'&type=2">'.$def_info_tender.'</a> ('.$results_amount_fp_t2.')&nbsp;';

    $fp_t3 = $db->query  ( "SELECT * $filter_pub AND type='3' ORDER BY date DESC, datetime DESC" );
    $results_amount_fp_t3 = mysql_num_rows ( $fp_t3 );
    if ($results_amount_fp_t3>0) $type_search .= '<a href="search-5.php?skey='.$goodencoded.'&type=3">'.$def_info_board.'</a> ('.$results_amount_fp_t3.')&nbsp;';

    $fp_t4 = $db->query  ( "SELECT * $filter_pub AND type='4' ORDER BY date DESC, datetime DESC" );
    $results_amount_fp_t4 = mysql_num_rows ( $fp_t4 );
    if ($results_amount_fp_t4>0) $type_search .= '<a href="search-5.php?skey='.$goodencoded.'&type=4">'.$def_info_job.'</a> ('.$results_amount_fp_t4.')&nbsp;';

    $fp_t5 = $db->query  ( "SELECT * $filter_pub AND type='5' ORDER BY date DESC, datetime DESC" );
    $results_amount_fp_t5 = mysql_num_rows ( $fp_t5 );
    if ($results_amount_fp_t5>0) $type_search .= '<a href="search-5.php?skey='.$goodencoded.'&type=5">'.$def_info_pressrel.'</a> ('.$results_amount_fp_t5.')&nbsp;';
    
}

$re = $db->query  ( "SELECT * $query LIMIT $page1, $def_info_page");
$results_amount_2 = $db->numrows ( $re );

include ( "./template/$def_template/header.php" );

include ("./includes/searchinfo.inc.php");

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

?>

 <br>
  <div align="left">
    &nbsp;&nbsp;<?php echo "Результаты поиска публикаций <b>($item_short_full)</b> $mytype
     &nbsp;[&nbsp;$def_results: <b>$results_amount_search</b> // [ $sdate1, $sdate3 ]&nbsp;&nbsp;$type_search"; ?><br>
  </div>
 <br>

<?php

if ( $results_amount_2 > 0 )

{
	$modul_info="YES";

	include ("./includes/pubsub.php");

	if ( $results_amount_search > $def_info_page )

	{
            echo "<br>";

		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount_search) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount_search;

		@    $z=$first/$def_info_page;

		if ($kPage > 0)	echo "<a href=\"search-5.php?type=$kType&amp;page=", $kPage-1 ,"\"><b>$def_previous</b></a>&nbsp;";

		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{
			if ( $z == $kPage )

			{
				echo "[ <b>", $z+1 ,"</b> ]&nbsp;";
				$z++;
			}

			else

			{
				echo "<a href=\"search-5.php?type=$kType&amp;page=$z\"><b>", $z+1 ,"</b></a>&nbsp;";
				$z++;
			}
		}

                if ($kPage - (($results_amount_search / $def_info_page) - 1) < 0) echo "<a href=\"search-5.php?type=$kType&amp;page=", $kPage+1 ,"\"><b>$def_next</b></a>";

                echo "<br><br>";
	}

        qserch_table($results_amount_search, $item_short_full);

        if ($kPage==0)  {

        // поиск по другим разделам
        $result_plus="NO";

        $goodencoded = rawurlencode ( $item_short_full );

        // фирмы
        $query_firms = " selector FROM $db_users WHERE ( ( firmname LIKE '%$item_short_full%' ) or ( business LIKE '%$item_short_full%' ) ) ";
        $r_firms = $db->query  ( "SELECT $query_firms" );
        $results_amount_firms = mysql_num_rows ( $r_firms );
        if ($results_amount_firms>0) $result_plus="YES";

        // изображения
        $query_img = " num FROM $db_images WHERE ( ( item LIKE '%$item_short_full%' ) or ( message LIKE '%$item_short_full%' ) ) ";
        $r_img = $db->query  ( "SELECT $query_img" );
        $results_amount_img = mysql_num_rows ( $r_img );
        if ($results_amount_img>0) $result_plus="YES";

        // товары и услуги
        $query_offers = " num FROM $db_offers WHERE ( ( item LIKE '%$item_short_full%' ) or ( message LIKE '%$item_short_full%' ) ) ";
        $r_offers = $db->query  ( "SELECT $query_offers" );
        $results_amount_offers = mysql_num_rows ( $r_offers );
        if ($results_amount_offers>0) $result_plus="YES";

        // прайс-листы
        $query_xls = " num FROM $db_exelp WHERE ( ( item LIKE '%$item_short_full%' ) or ( message LIKE '%$item_short_full%' ) ) ";
        $r_xls = $db->query  ( "SELECT $query_xls" );
        $results_amount_xls = mysql_num_rows ( $r_xls );
        if ($results_amount_xls>0) $result_plus="YES";

            if ($result_plus=="YES") {
                echo '<div style="text-align:left"><br><br>Запрос (<b>'.$item_short_full.'</b>) также найден:';

                if ($results_amount_firms>0) echo '<br> &#187 <a href="search-1.php?search='.$goodencoded.'">'.$def_search_firms.'</a> ('.$results_amount_firms.')';
                if ($results_amount_img>0) echo '<br> &#187 <a href="search-4.php?search='.$goodencoded.'">'.$def_search_img.'</a> ('.$results_amount_img.')';
                if ($results_amount_offers>0) echo '<br> &#187 <a href="search-2.php?skey='.$goodencoded.'">'.$def_search_offerss.'</a> ('.$results_amount_offers.')';
                if ($results_amount_xls>0) echo '<br> &#187 <a href="search-6.php?skey='.$goodencoded.'">'.$def_search_xls.'</a> ('.$results_amount_xls.')';

                echo '</div><br><br>';
            }
        }
 }

 else

 {
        $goodencoded = rawurlencode ( $item_short_full );
        echo $def_nopublic.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
        echo '<div style="text-align:left"><br>Попробуйте поискать в каталоге, через поисковые системы: <a rel="nofollow" href="http://yandex.ru/yandsearch?text='.$goodencoded.'&site='.$def_mainlocation.'" target="_blank">Яндекс</a> или <a rel="nofollow" href="http://www.google.ru/search?q='.$goodencoded.'&sitesearch='.$def_mainlocation.'" target="_blank">Google</a></div>';
 }

echo "<br><br>";

} else

{

include ( "./template/$def_template/header.php" );

echo $def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';

}

include ( "./template/$def_template/footer.php" );

?>