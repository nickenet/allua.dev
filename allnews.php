<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: allnews.php
-----------------------------------------------------
 Назначение: Новости каталога
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

$help_section = (string)$allnews_help;

// ---------------------------------
// Выводим каталог с категориями
// ---------------------------------

if (!isset($_REQUEST[category] ))

{

$incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$def_news_title.'</font>';

if ($def_news_meta_title!='') $incomingline_firm=$def_news_meta_title; else $incomingline_firm=$def_news_title;
$descriptions_meta=$def_news_meta_descriptions;
$keywords_meta=$def_news_meta_keywords;

$show_banner="NO";

include ( "./template/$def_template/header.php" );

include ("./includes/searchnews.inc.php");

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/filter.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation; ?>/includes/css/rate.css">

<br />
  <table cellpadding="0" cellspacing="0" border="0" width="100%">
   <tr>
    <td width="100%" valign="top" align="center">
     <table cellspacing="0" cellpadding="0" border="0" width="90%">
      <tr>
       <td width="50%" valign="top">
<?php

 $r = $db->query ( "SELECT * FROM $db_categorynews WHERE status_off!='1' ORDER BY category " );
 
	if (!$r) error ("mySQL error", mysql_error() );

 $results = $db->numrows ( $r );

 $res = round ( $results/2 );

 $template_view_news_category = implode ('', file('./template/' . $def_template . '/category_news.tpl'));

 for ( $i=0;$i<$res;$i++ )

 {
 	$f = $db->fetcharray ( $r );
        include ("./includes/sub_component/category_news.php");
 }

echo "<br /> <br /> 
         </td>
         <td width=\"50%\" valign=\"top\">";

 for ( $x=$res;$x<$results;$x++ )

 {
 	$f = $db->fetcharray ( $r );
        include ("./includes/sub_component/category_news.php");
 }

?>
   </td>
    </tr></table>
   </td>
  </tr>
 </table>

<?php

require 'includes/array_cat_news.php'; // массив категорий

main_table_top  ($def_news_title);

echo '<div id="catpicker" style="text-align:center; padding:5px;"><a href="#" id="newimg" class="filter">Новые</a> | <a href="#" id="rateVal" class="filter">Популярные</a> | <a href="#" id="randomimg" class="filter">Случайные</a></div>';

$rz = $db->query ( "SELECT * FROM $db_news WHERE status_off = 0 ORDER BY fixed DESC, date DESC LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

                $filter_img="newimg";
		include ("./includes/short_news.php");              
}

$rz = $db->query ( "SELECT * FROM $db_news WHERE status_off = 0 ORDER BY hit DESC, rateVal DESC, rateNum DESC LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

                $filter_img="rateVal";
		include ("./includes/short_news.php");
}

$rz = $db->query ( "SELECT * FROM $db_news WHERE status_off = 0 ORDER BY RAND() LIMIT 10");
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 ) {

	$filter_img="randomimg";
        include ("./includes/short_news.php");
}

main_table_bottom();

echo '<div align="right"><a href="'.$def_mainlocation.'/rss.php?type=7">Rss</a> <img src="'.$def_mainlocation.'/images/rss.gif" border="0" align="absmiddle"></div><br /><br />';

}

else

{

// ###################### Выборка новостей из категории

$category_news_get=$_GET['category'];

if (is_numeric($category_news_get)) { $category_news_get=intval($_GET['category']); $where_news="selector='$category_news_get'"; }
else { if (substr ( $_GET['category'], - 1, 1 ) == '/') $_GET['category'] = substr ( $_GET['category'], 0, - 1 );
$category_news_get=mysql_real_escape_string(strip_tags(safeHTML($_GET['category']))); $where_news="name LIKE '$category_news_get'"; }

	$r1 = $db->query ( "SELECT * FROM $db_categorynews WHERE $where_news LIMIT 1");
	$f1= $db->fetcharray($r1);

        $ip = $_SERVER["REMOTE_ADDR"];

	if ($ip != "$f1[ip]") $db->query ( "UPDATE $db_categorynews SET top = top+1, ip = '$ip' WHERE $where_news" );

// speedbar
if ($def_rewrite_news == "YES") $show_news_to_link = $def_mainlocation.'/news/'; else $show_news_to_link = $def_mainlocation.'/allnews.php';

if ($f1['status_off']==1) $incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1[category].'</font>';
else $incomingline = '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$show_news_to_link.'"><font color="'.$def_status_font_color.'"><u>'.$def_news_title.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$f1[category].'</font>';

    // Мета-теги
	if ($f1['metatitle']!='') $incomingline_firm = htmlspecialchars($f1['metatitle']); else $incomingline_firm=htmlspecialchars($f1['category']);
        if ($f1['metadescr']!='') $descriptions_meta=htmlspecialchars($f1['metadescr']);
        if ($f1['metakeywords']!='') $keywords_meta=htmlspecialchars($f1['metakeywords']);

        $def_news_title_cat=htmlspecialchars($f1['category']);

        $help_section = (string)$allnews_help;

include ( "./template/$def_template/header.php" );

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation; ?>/includes/css/rate.css">

<?php

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_list_news;

if (isset($_GET['page'])) $pages_news='&page='.$kPage;

$pages_news=htmlspecialchars($pages_news);
$category_news=htmlspecialchars($f1['selector']);

if ($kPage==0)
{
	echo '<div align="right"><noindex><b>'.$def_sort.'</b>&nbsp;<a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.$pages_news.'&sort=2">'.$def_sort_name.'</a> | <a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.$pages_news.'&sort=1">'.$def_sort_data.'</a> | <a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.$pages_news.'&sort=3">'.$def_sort_rating.'</a> | <a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.$pages_news.'&sort=4">'.$def_sort_hits.'</a> |</noindex> <a href="'.$def_mainlocation.'/rss.php?category='.$category_news.'&type=7">Rss</a> <img src="'.$def_mainlocation.'/images/rss.gif" border="0" align="absmiddle"></div><br /><br />';
}
else echo '<div align="right"><a href="'.$def_mainlocation.'/rss.php?category='.$category_news.'&type=7">Rss</a> <img src="'.$def_mainlocation.'/images/rss.gif" border="0" align="absmiddle"></div><br /><br />';

	if (isset($_GET['sort']))
	{
	$p_sort=intval($_GET['sort']);
        $s_page='&sort='.$p_sort;
        $s_page=htmlspecialchars($s_page);
	
		switch ($p_sort) {
			  case 2:
			    $o_sort=" ORDER BY title";
			    break;
			  case 3:
			    $o_sort=" ORDER BY rateVal DESC, rateNum DESC";
			    break;
			  case 4:
			    $o_sort=" ORDER BY hit DESC";
			    break;
			  break;
			   default:
			   $o_sort=" ORDER BY fixed DESC, date DESC";
		}
	}

	else $o_sort=" ORDER BY fixed DESC, date DESC";

main_table_top($def_news_title_cat);

$rz = $db->query ( "SELECT * FROM $db_news WHERE category='$category_news' and status_off=0 $o_sort LIMIT $page1, $def_list_news" );
@$results_amount = mysql_num_rows ( $rz );

$result_in=intval($f1['ncount']);

if ( $results_amount > 0 )

{

include ("./includes/short_news.php");

// Страницы

if ( $result_in > $def_list_news )

{

	if ((($kPage*$def_list_news)-($def_list_news*5)) >= 0) $first=($kPage*$def_list_news)-($def_list_news*5);
	else $first=0;

	if ((($kPage*$def_list_news)+($def_list_news*6)) <= $result_in) $last =($kPage*$def_list_news)+($def_list_news*6);
	else $last = $result_in;

	@$z=$first/$def_list_news;

	if ($kPage > 0) {
            
            if (($def_rewrite_news == "YES") and (empty($_GET['sort']))) $prev_page = '<a href="'.$def_mainlocation.'/news/'.htmlspecialchars ($f1['name']).'/page/'.($kPage-1).'/"><b>'.$def_previous.'</b></a>&nbsp;'; else $prev_page =  '<a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.'&page='.($kPage-1).$o_page.$s_page.'"><b>'.$def_previous.'</b></a>&nbsp;';

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
			if (($def_rewrite_news == "YES") and (empty($_GET['sort']))) $page_news .= '<a href="'.$def_mainlocation.'/news/'.htmlspecialchars ($f1['name']).'/page/'.$z.'/"><b>'.($z+1).'</b></a>&nbsp;'; else $page_news .= '<a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.'&page='.$z.$o_page.$s_page.'"><b>'.($z+1).'</b></a>&nbsp;';
			$z++;
		}
	}

        if ($kPage - (($result_in / $def_list_news) - 1) < 0) {

            if (($def_rewrite_news == "YES") and (empty($_GET['sort']))) $next_page = '<a href="'.$def_mainlocation.'/news/'.htmlspecialchars ($f1['name']).'/page/'.($kPage+1).'/"><b>'.$def_next.'</b></a>&nbsp;'; else $next_page = '<a href="'.$def_mainlocation.'/allnews.php?category='.$category_news.'&page='.($kPage+1).$o_page.$s_page.'"><b>'.$def_next.'</b></a>&nbsp;';

        } else $next_page ='';
        
        include ( "./template/$def_template/pages.php" ); // подключаем обработку страниц

        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

}

echo '<div style="text-align: left; padding-top: 10px; padding-bottom: 10px;">'.$def_news_sum.' - <b>'.$result_in.'</b></div>';

include ( "./includes/tag_news.php" ); // подключаем облако тегов

}

else

    include ( "./includes/error_page.php" );

main_table_bottom();

}

$db->freeresult ( $fz );

include ( "./template/$def_template/footer.php" );

?>