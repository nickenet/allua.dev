<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: get.php
-----------------------------------------------------
 Назначение: Вывод меток новости
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

if ( $_GET['skey'] <> '' ) $metka_get = rawurldecode ($_GET['skey']);

$metka_get=htmlspecialchars ( strip_tags ( stripslashes ( trim ( $metka_get ) ) ), ENT_QUOTES ) ;

if (strlen($metka_get)>1) {
    
$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_list_news;

require 'includes/array_cat_news.php'; // массив категорий

$rz = $db->query ("SELECT * FROM $db_news WHERE  (keywords LIKE '%$metka_get%') and status_off=0 ORDER BY date DESC LIMIT $page1, $def_list_news");
    $rez_in=$db->query ("SELECT COUNT(*) FROM $db_news WHERE  (keywords LIKE '%$metka_get%') and status_off=0");
    $result_in=mysql_result($rez_in, 0 ,0);

@$results_amount = mysql_num_rows ( $rz );

if ($def_rewrite_news == "YES") $show_news_to_link = $def_mainlocation.'/news/'; else $show_news_to_link = $def_mainlocation.'/allnews.php';

$incomingline =  '<a href="'.$def_mainlocation.'/index.php"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | <a href="'.$show_news_to_link.'"><font color="'.$def_status_font_color.'"><u>'.$def_news_title.'</u></font></a> | <font color="'.$def_status_font_color.'">'.$def_news_metka_s.' "'.$metka_get.'"</font>';
$incomingline_firm = $metka_get;

        $help_section = (string)$get_help;

include ( "./template/$def_template/header.php" );

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation; ?>/includes/css/rate.css">

<?php

main_table_top($metka_get);

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

            $prev_page =  '<a href="'.$def_mainlocation.'/get.php?skey='.$metka_get.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';

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
			$page_news .= '<a href="'.$def_mainlocation.'/get.php?skey='.$metka_get.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
			$z++;
		}
	}

        if ($kPage - (($result_in / $def_list_news) - 1) < 0) {

            $next_page = '<a href="'.$def_mainlocation.'/get.php?skey='.$metka_get.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';

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
    
        include ( "./includes/error_page.php" );
        
}

main_table_bottom();

} else

{

$incomingline =  $def_title_error;

include ( "./template/$def_template/header.php" );

    include ( "./includes/error_page.php" );

}

include ( "./template/$def_template/footer.php" );

?>