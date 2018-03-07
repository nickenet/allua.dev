<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-6.php
-----------------------------------------------------
 Назначение: Поиск по прайс-листам 
=====================================================
*/

include ( "./defaults.php" );

$kPage = intval($_GET['page']);

$incomingline = $def_xls_search;
$help_section = $xls_help;

if ( $_GET['skey'] <> "" ) $item_xls = rawurldecode ( $_GET['skey'] ); else $item_xls = safehtml($_POST['skey']);

$item_xls=mysql_real_escape_string(trim(strip_tags($item_xls)));

if (strlen($item_xls)>1) {

$query .= " FROM $db_exelp WHERE ";

$query .= " ( (item LIKE '%$item_xls%') or (message LIKE '%$item_xls%') ) ";

$query .= " ORDER BY date DESC";

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_count_srch;

$ra = $db->query  ( "SELECT * $query" );
@$results_amount_search = mysql_num_rows ( $ra );
@$db->freeresult  ( $ra );

$rz = $db->query  ( "SELECT * $query LIMIT $page1, $def_count_srch");
$results_amount = $db->numrows ( $rz );

include ( "./template/$def_template/header.php" );

include ("./includes/searchxls.inc.php");

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

?>

 <br>
  <div align="left">
    &nbsp;&nbsp;<?php echo "$def_xls_search_result <b>($item_xls)</b>
     &nbsp;&nbsp;[&nbsp;$def_results: <b>$results_amount_search</b> // [ $sdate1, $sdate3 ]"; ?><br>
  </div>
 <br>

<?php

if ( $results_amount > 0 )

{

$allxls="SEARCH";

require 'includes/sub_component/price_view.php';

$goodencoded = rawurlencode ( $item_xls );

	// Страницы

	if ( $results_amount_search > $def_count_srch )

	{

            echo "<br>";

		if ((($kPage*$def_count_srch)-($def_count_srch*5)) >= 0) $first=($kPage*$def_count_srch)-($def_count_srch*5);
		else $first=0;

		if ((($kPage*$def_count_srch)+($def_count_srch*6)) <= $results_amount_search) $last =($kPage*$def_count_srch)+($def_count_srch*6);
		else $last = $results_amount_search;

		@    $z=$first/$def_count_srch;

		if ($kPage > 0)	$prev_page = '<a href="'.$def_mainlocation.'/search-6.php?skey='.$goodencoded.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';

		for ( $x=$first; $x<$last;$x=$x+$def_count_srch )

		{
			if ( $z == $kPage )

			{
				$page_news.= '[ <b>'.($z+1).'</b> ]&nbsp;';
				$z++;
			}

			else

			{
				$page_news.= '<a href="'.$def_mainlocation.'/search-6.php?skey='.$goodencoded.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
        			$z++;
			}
		}

                if ($kPage - (($results_amount_search / $def_count_srch) - 1) < 0) $next_page = '<a href="'.$def_mainlocation.'/search-6.php?skey='.$goodencoded.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>';

        $template_page_news = set_tFile('pages.tpl');

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

        echo "<br><br>";
        
	}

        qserch_table($results_amount_search, $item_xls);

        if ($kPage==0)  {

        // поиск по другим разделам
        $result_plus="NO";

        // фирмы
        $query_firms = " selector FROM $db_users WHERE ( ( firmname LIKE '%$item_xls%' ) or ( business LIKE '%$item_xls%' ) ) ";
        $r_firms = $db->query  ( "SELECT $query_firms" );
        $results_amount_firms = mysql_num_rows ( $r_firms );
        if ($results_amount_firms>0) $result_plus="YES";

        // изображения
        $query_img = " num FROM $db_images WHERE ( ( item LIKE '%$item_xls%' ) or ( message LIKE '%$item_xls%' ) ) ";
        $r_img = $db->query  ( "SELECT $query_img" );
        $results_amount_img = mysql_num_rows ( $r_img );
        if ($results_amount_img>0) $result_plus="YES";

        // товары и услуги
        $query_offers = " num FROM $db_offers WHERE ( ( item LIKE '%$item_xls%' ) or ( message LIKE '%$item_xls%' ) ) ";
        $r_offers = $db->query  ( "SELECT $query_offers" );
        $results_amount_offers = mysql_num_rows ( $r_offers );
        if ($results_amount_offers>0) $result_plus="YES";

        // публикации
        $query_pub = " num FROM $db_info WHERE ( ( item LIKE '%$item_xls%' ) or ( shortstory LIKE '%$item_xls%' ) or ( fullstory LIKE '%$item_xls%' ) ) ";
        $r_pub = $db->query  ( "SELECT $query_pub" );
        $results_amount_pub = mysql_num_rows ( $r_pub );
        if ($results_amount_pub>0) $result_plus="YES";

            if ($result_plus=="YES") {
                echo '<div style="text-align:left"><br><br>Запрос (<b>'.$item_xls.'</b>) также найден:';

                if ($results_amount_firms>0) echo '<br> &#187 <a href="search-1.php?search='.$goodencoded.'">'.$def_search_firms.'</a> ('.$results_amount_firms.')';
                if ($results_amount_img>0) echo '<br> &#187 <a href="search-4.php?search='.$goodencoded.'">'.$def_search_img.'</a> ('.$results_amount_img.')';
                if ($results_amount_offers>0) echo '<br> &#187 <a href="search-2.php?skey='.$goodencoded.'">'.$def_search_offerss.'</a> ('.$results_amount_offers.')';
                if ($results_amount_pub>0) echo '<br> &#187 <a href="search-5.php?skey='.$goodencoded.'">'.$def_search_pub.'</a> ('.$results_amount_pub.')';

                echo '</div><br><br>';
            }
        }
 }

 else

 {
        $goodencoded = rawurlencode ( $item_xls );
        echo $def_noexcel.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
        echo '<div style="text-align:left"><br>Попробуйте поискать в каталоге, через поисковые системы: <a rel="nofollow" href="http://yandex.ru/yandsearch?text='.$goodencoded.'&site='.$def_mainlocation.'" target="_blank">Яндекс</a> или <a rel="nofollow" href="http://www.google.ru/search?q='.$goodencoded.'&sitesearch='.$def_mainlocation.'" target="_blank">Google</a></div>';
 }

echo "<br><br>";

} else

{

    $incomingline=$def_nocorrrect_search;

include ( "./template/$def_template/header.php" );

    $def_message_error=$def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
    include ( "./includes/error_page.php" );

}

include ( "./template/$def_template/footer.php" );

?>