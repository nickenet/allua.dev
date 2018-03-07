<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: video.php
-----------------------------------------------------
 Назначение: Видеоролики для компании
=====================================================
*/

include ( "./defaults.php" );

function buildRate($id, $val, $inside = 0)
{
	$val = round($val);
	if (!$inside) $rate_video='<div id="rateWrap'.$id.'" class="rateWrap">';

	$rate_video.='<div id="rate'.$id.'">';
	for ($i = 1; $i <= 5; ++$i) {
                if ($val >= $i) $rateOn='rateOn'; else $rateOn='';
		$rate_video.= "<a href=\"#\" class=\"rateItem $rateOn\"
			onclick=\"return rate($id, $i)\"
			onmouseover=\"seeOn(this)\" onmouseout=\"seeOff(this)\"> </a>";
        }
	$rate_video.= '</div>';
	$rate_video.= '<img id="ratePic'.$id.'" src="images/go.gif" border="0" style="display: none">';
	$rate_video.= '<br>';
	if (!$inside) $rate_video.= '</div>';

        return $rate_video;
}

if ( !empty($_REQUEST['rate']) )
{
	$_REQUEST['rate'] = (int)$_REQUEST['rate'];
        $z_rate = $db->query  ( "SELECT rateNum, rateVal FROM $db_video WHERE num = '$_REQUEST[rate]'" );
        $curFoto = $db->fetcharray  ( $z_rate );
	$tmp = empty($_COOKIE['ratevideo']) ? array() : explode(',', $_COOKIE['ratevideo']);
	if ( !in_array($_REQUEST['rate'], $tmp) )
	{
		$tmp[] = $_REQUEST['rate'];
		setcookie('ratevideo', join(',', $tmp), time() + 24 * 3600,"/");
		$curFoto['rateVal'] = $curFoto['rateNum'] * $curFoto['rateVal'] + (int)$_REQUEST['val'];
		$curFoto['rateVal'] /= ++$curFoto['rateNum'];
                $db->query  ( "UPDATE $db_video SET rateNum='$curFoto[rateNum]', rateVal='$curFoto[rateVal]' WHERE num='$_REQUEST[rate]' " );
	}

	header('Content-Type: text/html; charset=windows-1251');

	echo 'ok';
	echo buildRate($_REQUEST['rate'], $curFoto['rateVal']);

	return;
}

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_info_video;

$r_all = $db->query  ( "SELECT num FROM $db_video WHERE firmselector = '$id'" );
@$results_amount_all = mysql_num_rows ( $r_all );

$rz = $db->query  ( "SELECT * FROM $db_video WHERE firmselector = '$id' ORDER BY sort DESC, num LIMIT $page1, $def_info_video" );
@$results_amount = mysql_num_rows ( $rz );

if ( $results_amount > 0 )

{

	$cat_firm = 0;
	$maincategory = "";

	$subcategory = 0;
	$mainsubcategory = "";

	$subsubcategory = 0;
	$mainsubsubcategory = "";

	$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | ";

        $link_cat = '';

if ($cat != 0)

	{
		$res = $db->query  ( "SELECT selector, category FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe['category'];
		$cat_firm = $fe['selector'];

		if ($def_rewrite == "YES")
		$incomingline.= "<a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= "<a href=\"index.php?category=$cat\">";

		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showmaincategory</u></font></a>";
	}

if ($subcat != 0)

	{
		$res = $db->query  ( "SELECT catsubsel, subcategory FROM $db_subcategory WHERE catsubsel = '$subcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showcategory = $fe['subcategory'];
		$subcategory = $fe['catsubsel'];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else

		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

if ($subsubcat != 0)

	{
		$res = $db->query  ( "SELECT catsubsubsel, subsubcategory FROM $db_subsubcategory WHERE catsel = '$cat' and catsubsel = '$subcat' and catsubsubsel = '$subsubcat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showsubcategory = $fe['subsubcategory'];
		$subsubcategory = $fe['catsubsubsel'];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showmaincategory)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
		else
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";

		$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

// Формируем ЧПУ для компании

if (($cat_firm == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$id-$kPage-0.html";
if (($cat_firm != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$cat_firm-0-0-$id-$kPage-0.html";
if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$cat_firm-$subcategory-0-$id-$kPage-0.html";
if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$cat_firm-$subcategory-$subsubcategory-$id-$kPage-0.html";

if ( $results_amount > 0 ) {
    $rx = $db->query  ( "SELECT firmname, category FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
    $fx = $db->fetcharray  ( $rx );
}

// Контроль правильности адреса
correct_url($fx['category'],'video',$id);
$to_canonical=to_canonical($fx['category'],$cat,$subcat,$subsubcat);
if ($to_canonical!=0) {
    if ($def_rewrite == "YES") $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/video-'.$id.'-0-'.$to_canonical[0].'-'.$to_canonical[1].'-'.$to_canonical[2].'.html" />'."\n";
    else $meta_system='<link rel="canonical" href="'.$def_mainlocation.'/video.php?id='.$id.'&cat='.$to_canonical[0].'&subcat='.$to_canonical[1].'&subsubcat='.$to_canonical[2].'" />'."\n";
}

if ($def_rewrite == "YES")
    $incomingline.= " | <a href=$links_view><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_video";
else
    $incomingline.= " | <a href=\"view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\"><font color=\"$def_status_font_color\"><u>$fx[firmname]</u></font></a> | $def_video";

$help_section = $video_help_1;

$incomingline_firm = $fx['firmname'].' ('.$def_video.')';

include ( "./template/$def_template/header.php" );

?>

<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo "$def_mainlocation/includes/css/"; ?>rate.css">

<?php
        $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$id' and firmstate = 'on'" );
        
	include ("./includes/sub.php");

        $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
        require 'includes/components/stat.php'; // Подключаем файл статистики

        main_table_top($def_video);

        require 'includes/sub_component/video_view.php';

       // Страницы

        echo '<br><br>';

	if ( $results_amount_all > $def_info_video )

	{
                $prev_page=''; $page_news=''; $next_page='';

		if ((($kPage*$def_info_video)-($def_info_video*5)) >= 0) $first=($kPage*$def_info_video)-($def_info_video*5);
		else $first=0;

		if ((($kPage*$def_info_video)+($def_info_video*6)) <= $results_amount_all) $last =($kPage*$def_info_video)+($def_info_video*6);
		else $last = $results_amount_all;

		@$z=$first/$def_info_video;

		if ($kPage > 0) {

                    $z_prev=$kPage-1;

                     if ($z_prev==0) {
                        if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/video-'.$id.'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/video.php?id='.$id.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     } else {
			if ($def_rewrite == "YES") $prev_page = '<a href="'.$def_mainlocation.'/video-'.$id.'-'.($kPage-1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_previous.'</b></a>&nbsp;';
			else $prev_page = '<a href="'.$def_mainlocation.'/video.php?id='.$id.'&page='.($kPage-1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_previous.'</b></a>&nbsp;';
                     }
		}

                $page_news = '';

		for ( $x=$first; $x<$last;$x=$x+$def_info_video )

		{
			if ( $z == $kPage )

			{
				$page_news .= '[ <b>'.($z+1).'</b> ]&nbsp;';
				$z++;
			}

			else

			{
                            if ($z==0) {
                                if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/video-'.$id.'-0-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/video.php?id='.$id.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            } else {
				if ($def_rewrite == "YES") $page_news .= '<a href="'.$def_mainlocation.'/video-'.$id.'-'.$z.'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.($z+1).'</b></a>&nbsp;';
				else $page_news .= '<a href="'.$def_mainlocation.'/video.php?id='.$id.'&page='.$z.'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.($z+1).'</b></a>&nbsp;';
                            }
				$z++;
			}
		}

                if ($kPage - (($results_amount_all / $def_info_video) - 1) < 0)

                {
        		if ($def_rewrite == "YES") $next_page = '<a href="'.$def_mainlocation.'/video-'.$id.'-'.($kPage+1).'-'.$cat_firm.'-'.$subcategory.'-'.$subsubcategory.'.html"><b>'.$def_next.'</b></a>';
        		else $next_page = '<a href="'.$def_mainlocation.'/video.php?id='.$id.'&page='.($kPage+1).'&cat='.$cat_firm.'&subcat='.$subcategory.'&subsubcat='.$subsubcategory.'"><b>'.$def_next.'</b></a>';

                }
                
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
        
      main_table_bottom();
      
      include ( "./template/$def_template/footer.php" );
}

else

{
        $incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';
        $incomingline_firm = $def_title_error;
	@header( "HTTP/1.0 404 Not Found" );
            include ( "./template/$def_template/header.php" );
                $def_message_error=$def_error_company;
                include ( "./includes/error_page.php" );
            include ( "./template/$def_template/footer.php" );
}

?>