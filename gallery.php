<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Lomakin M.
=====================================================
 Файл: gallery.php
-----------------------------------------------------
 Назначение: Показ галереи изображений для компании
=====================================================
*/

include ( "./defaults.php" );

if (empty($_SESSION['gallery'])) $_SESSION['gallery'] = $def_gallery_outputmethod;
if ($_GET[output] == 'gallery' or ($_SESSION['gallery'] == 'gallery' and $_GET[output] == ''))  {
    $_SESSION['gallery'] = 'gallery';
    $templ_gal = 'gallery_gallery.tpl';
    $active1 = 'active';
    $def_info_page=$def_gallery_gallery;
}
if ($_GET[output] == 'list' or ($_SESSION['gallery'] == 'list' and $_GET[output] == '')) {
    $_SESSION['gallery'] = 'list';
    $templ_gal = 'gallery_list.tpl';
    $active2 = 'active';
}
if ($_GET[output] == 'list_full' or ($_SESSION['gallery'] == 'list_full' and $_GET[output] == '')) {
    $_SESSION['gallery'] = 'list_full';
    $templ_gal = 'gallery_list.tpl';
    $active3 = 'active';
}
 
function buildRate($id, $val, $inside = 0)
{
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
	$rate_img.= '<img id="ratePic'.$id.'" src="images/go.gif" border="0" style="display: none">';
	$rate_img.= '<br>';
	if (!$inside) $rate_img.= '</div>';

        return $rate_img;
}

if ( !empty($_REQUEST['rate']) )
{
	$_REQUEST['rate'] = (int)$_REQUEST['rate'];
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_images WHERE num = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['rateimg']) ? array() : explode(',', $_COOKIE['rateimg']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('rateimg', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_images SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE num='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_page;

$r_all = $db->query  ( "SELECT num FROM $db_images WHERE firmselector = '$id'" );
@$results_amount_all = mysql_num_rows ( $r_all );

$rz = $db->query  ( "SELECT * FROM $db_images WHERE firmselector = '$id' ORDER BY sort, num DESC LIMIT $page1, $def_info_page" );
@$results_amount = mysql_num_rows ( $rz );

	$category = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

	$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

if ($cat != 0)

	{
	$res = $db->query  ( "SELECT * FROM $db_category WHERE selector = '$cat'" );
	$fe = $db->fetcharray  ( $res );
	$db->freeresult  ( $res );
	$showmaincategory = $fe["category"];
	$category = $fe[selector];

	if ($def_rewrite == "YES")
	$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
	else
	$incomingline.= "<a href=\"index.php?category=$cat\">";
	$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}


if ($subcat != 0)

	{
	$res = $db->query  ( "SELECT * FROM $db_subcategory WHERE catsubsel = '$subcat'" );
	$fe = $db->fetcharray  ( $res );
	$db->freeresult  ( $res );
	$showcategory = $fe["subcategory"];
	$subcategory = $fe[catsubsel];

	if ($def_rewrite == "YES")
	$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
	else
	$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat\">";
	$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

if ($subsubcat != 0)

	{
	$res = $db->query  ( "SELECT * FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
	$fe = $db->fetcharray  ( $res );
	$db->freeresult  ( $res );
	$showsubcategory = $fe["subsubcategory"];
	$subsubcategory = $fe[catsubsubsel];

	if ($def_rewrite == "YES")
	$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
	else
	$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
	$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

// Формируем ЧПУ для компании

if (($category == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$category-0-0-$id-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$category-$subcategory-0-$id-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$category-$subcategory-$subsubcategory-$id-$kPage-0.html";

if ( $results_amount > 0 ) {
    $rx = $db->query  ( "SELECT firmname,category FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
    $fx = $db->fetcharray  ( $rx );
}

// Контроль правильности адреса
correct_url($fx['category'],'gallery',$id);
$to_canonical=to_canonical($fx['category'],$cat,$subcat,$subsubcat);
if ($to_canonical!=0) {
    if ($def_rewrite == "YES") $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/gallery-'.$id.'-0-'.$to_canonical[0].'-'.$to_canonical[1].'-'.$to_canonical[2].'.html" />'."\n";
    else $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/gallery.php?id='.$id.'&cat='.$to_canonical[0].'&subcat='.$to_canonical[1].'&subsubcat='.$to_canonical[2].'" />'."\n";
}

if ($def_rewrite == "YES")
    $incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_images";
else
    $incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_images";

$help_section = $images_help_1;
$incomingline_firm = $fx['firmname'].' ('.$def_images.')';

if (!isset($fx['firmname'])) { $incomingline_firm=$def_title_error; $incomingline=$def_title_error; }

include ( "./template/$def_template/header.php" );

echo phighslide();

?>

<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<? echo "$def_mainlocation/includes/css/"; ?>rate.css">
<?

if ( $results_amount > 0 )

{
        $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );

	include ("./includes/sub.php");

        $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
        require 'includes/components/stat.php'; // Подключаем файл статистики

        $link_type_list = $def_mainlocation.'/gallery.php?id='.$id.'&cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat.'&';

        include ( "./template/$def_template/type_list.php" ); // Подключаем шаблон выбора типа трансляции

        main_table_top($def_images);

        include ("./includes/sub_component/catgallery.php");

        // Страницы

        echo '<br><br>';

	if ( $results_amount_all > $def_info_page )

	{
                $prev_page=''; $page_news=''; $next_page='';

		if ((($kPage*$def_info_page)-($def_info_page*5)) >= 0) $first=($kPage*$def_info_page)-($def_info_page*5);
		else $first=0;

		if ((($kPage*$def_info_page)+($def_info_page*6)) <= $results_amount_all) $last =($kPage*$def_info_page)+($def_info_page*6);
		else $last = $results_amount_all;

		@$z=$first/$def_info_page;

		if ($kPage > 0) {

                    $z_prev=$kPage-1;

                     if ($z_prev==0) {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/gallery-'.$id.'-0-'.$category.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/gallery.php?id='.$id.'&cat='.$category.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     } else {
			if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/gallery-'.$id.'-'.($kPage-1).'-'.$category.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/gallery.php?id='.$id.'&page='.($kPage-1).'&cat='.$category.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     }
		} 

                $page_news = '';

		for ( $x=$first; $x<$last;$x=$x+$def_info_page )

		{
			if ( $z == $kPage )

			{
				$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
				$z++;
			}

			else

			{
                            if ($z==0) {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/gallery-'.$id.'-0-'.$category.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/gallery.php?id='.$id.'&cat='.$category.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            } else {
				if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/gallery-'.$id.'-'.$z.'-'.$category.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/gallery.php?id='.$id.'&page='.$z.'&cat='.$category.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            }
				$z++;
			}
		}

                if ($kPage - (($results_amount_all / $def_info_page) - 1) < 0)

                {
        		if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/gallery-'.$id.'-'.($kPage+1).'-'.$category.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_next.'</b></a>';
        		else $next_page = '<a href="'.$def_mainlocation.'/gallery.php?id='.$id.'&page='.($kPage+1).'&cat='.$category.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_next.'</b></a>';
                
                }

	$template_page_news = set_tFile('pages.tpl');

        $template_page_news = implode ('', file('./template/' . $def_template . '/pages.tpl'));

        $template_pages = new Template;

        $template_pages->load($template_page_news);

        $template_pages->replace("prev", $prev_page);
        $template_pages->replace("next", $next_page);
        $template_pages->replace("page", $page_news);

        $template_pages->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_pages->publish();

	}
}

else

{
	include ( "./includes/error_page.php" );
}

main_table_bottom();

include ( "./template/$def_template/footer.php" );

?>