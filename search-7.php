<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: search-7.php
-----------------------------------------------------
 Назначение: Поиск по новостям
=====================================================
*/

include ( "./defaults.php" );

// Функции для рейтинга новостей

function buildRate($id, $val, $inside = 0)
{
        global $def_mainlocation;
	$val = round($val);
	if (!$inside) $rate_img='<div id="rateWrap'.$id.'" class="rateWrap">';

	$rate_img.='<div id="rate'.$id.'">';
	for ($i = 1; $i <= 5; ++$i) {
                if ($val >= $i) $rateOn='rateOn'; else $rateOn='';
		$rate_img.= "<a href=\"#\" class=\"rateItem $rateOn\"
			onclick=\"return rate($id, $i)\"
			onmouseover=\"seeOn(this)\" onmouseout=\"seeOff(this)\"> </a>";
        }
	$rate_img.= '</div>';
	$rate_img.= '<img id="ratePic'.$id.'" src="'.$def_mainlocation.'/images/go.gif" border="0" style="display: none">';
	$rate_img.= '<br>';
	if (!$inside) $rate_img.= '</div>';

        return $rate_img;
}

if ( !empty($_REQUEST['rate']) )
{
	$_REQUEST['rate'] = (int)$_REQUEST['rate'];
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_news WHERE selector = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['rate_news']) ? array() : explode(',', $_COOKIE['rate_news']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('rate_news', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_news SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE selector='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}

// =====================================================================

if ( $_GET['search'] <> '' ) $sstring = rawurldecode ($_GET['search']); else $sstring = $_POST['skey'];

if ( $_GET["category"] <> "" ) $category = intval ( $_GET['category'] );

else

{
	if (!isset($_POST['category'])) $category='ANY'; else $category = $_POST['category'];
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

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_list_news;

// Массив категорий

$r_cat=$db->query ("SELECT * FROM $db_categorynews ORDER BY selector") or die ("mySQL error!");
$array_cat=array();
$array_name=array();
$res_rcat = mysql_num_rows ( $r_cat );
        for ( $jj=0; $jj<$res_rcat; $jj++ ) {
            $f_catf=$db->fetcharray ($r_cat);
            $array_cat[$f_catf['selector']] = $f_catf['category'];
            $array_name[$f_catf['name']] = $f_catf['name'];
            $array_url[$f_catf['selector']] = $f_catf['name'];
        }

$likequery2 = " COUNT(*) ";
$likequery2.= " FROM $db_news WHERE ";
$likequery2.= " ( ( title LIKE '%$sstring%' ) or ( short LIKE '%$sstring%' ) or ( full LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ) AND status_off=0 ";
if ( $category != "ANY"  ) { $category=intval($_POST['category']); $likequery2.= "AND category='$category'"; }

$query = " selector, date, category, title, name, hit, short, full, keywords, short_tpl, rateNum, rateVal, comment_off, comments, ";
$query.= " MATCH (short, full, title, keywords) AGAINST ('$words') ";
$query.= "AS relevance FROM $db_news WHERE ";
$query.= " MATCH (short, full, title, keywords) AGAINST ('$words') or ( title LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ";
$query.= " AND status_off=0 ";
if ( $category != "ANY"  ) { $category=intval($_POST['category']); $query.= "AND category='$category'"; }
$query.= " ORDER BY date DESC, relevance DESC";

$likequery = " * ";
$likequery.= " FROM $db_news WHERE ";
$likequery.= " ( ( title LIKE '%$sstring%' ) or ( short LIKE '%$sstring%' ) or ( full LIKE '%$sstring%' ) or ( keywords LIKE '%$sstring%' ) ) AND status_off=0 ";
if ( $category != "ANY"  ) { $category=intval($_POST['category']); $likequery.= "AND category='$category'"; }
$likequery.= " ORDER BY date DESC";

if ($def_search_type == "LIKE")
{
	$sql = $likequery;
	$sql2 = $likequery2;
        $ra = $db->query  ( "SELECT $sql2" );
        $result_in=mysql_result($ra, 0 ,0);
}
else
{
	$sql = $query;
        $ra = $db->query  ( "SELECT $sql" );
        $result_in=mysql_num_rows($ra);
}

$rz = $db->query  ("SELECT $sql LIMIT $page1, $def_list_news ");

@$results_amount = mysql_num_rows ( $rz );

if ($def_rewrite_news == "YES") $show_news_to_link = $def_mainlocation.'/news/'; else $show_news_to_link = $def_mainlocation.'/allnews.php';

$incomingline =  '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$show_news_to_link.'"><font color="'.$def_status_font_color.'"><u>'.$def_news_title.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$def_news_search.' "'.$sstring.'"</font>';
$incomingline_firm = $sstring;

$help_section = (string)$search_news_help;

include ( "./template/$def_template/header.php" );

if ( $category != "ANY"  ) unset($_SESSION['razdel_news']);

include ("./includes/searchnews.inc.php");

$sdate1 = date("H:i:s");
$sdate2 = date("Y-m-d");
$sdate3 = undate($sdate2, $def_datetype);

?>

 <br />
  <div align="left">
    &nbsp;&nbsp;&nbsp;<?php echo "$def_news_search_rezult <b>( $words )</b>
     &nbsp;&nbsp;[$def_results: <b>$result_in</b> // [ $sdate1, $sdate3 ]"; ?><br />
  </div>
 <br />

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation; ?>/includes/css/rate.css">

<?php

if ( $results_amount > 0 )

{
    include ("./includes/short_news.php");

    // Страницы

    $goodencoded = rawurlencode ( $sstring );

if ( $result_in > $def_list_news )

{
	if ((($kPage*$def_list_news)-($def_list_news*5)) >= 0) $first=($kPage*$def_list_news)-($def_list_news*5);
	else $first=0;

	if ((($kPage*$def_list_news)+($def_list_news*6)) <= $result_in) $last =($kPage*$def_list_news)+($def_list_news*6);
	else $last = $result_in;

	@$z=$first/$def_list_news;

	if ($kPage > 0) {

            $prev_page =  '<a href="'.$def_mainlocation.'/search-7.php?search='.$goodencoded.'&category='.$category.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';

        } else $prev_page = '';

        $page_news = '';

	for ( $xx = $first; $xx < $last; $xx=$xx+$def_list_news )

	{
		if ( $z == $kPage )

		{
			$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
			$z++;
		}

		else

		{
			$page_news .= '<a href="'.$def_mainlocation.'/search-7.php?search='.$goodencoded.'&category='.$category.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
			$z++;
		}
	}

        if ($kPage - (($result_in / $def_list_news) - 1) < 0) {

            $next_page = '<a href="'.$def_mainlocation.'/search-7.php?search='.$goodencoded.'&category='.$category.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';

        } else $next_page ='';

        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

}

include ( "./includes/tag_news.php" ); // подключаем облако тегов

} else {
        $def_message_error=$def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
        include ( "./includes/error_page.php" );
}

} else

{

include ( "./template/$def_template/header.php" );

    $def_message_error=$def_nocorrrect_search.'<br><br><a href="javascript:history.back()">'.$def_back.'</a>';
    include ( "./includes/error_page.php" );

}

if ( $category != "ANY"  ) unset($_SESSION['razdel_news']);

include ( "./template/$def_template/footer.php" );

?>