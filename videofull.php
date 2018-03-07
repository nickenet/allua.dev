<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: videofull.php
-----------------------------------------------------
 Назначение: Вывод полной версии видеоролика
=====================================================
*/

include ("./defaults.php");

header('Cache-control: private');

// Функции для рейтинга новости

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

// Полная версия публикации

$full_video = $db->query ( "SELECT * FROM $db_video WHERE num='$id' LIMIT 1" );
@$results_amount = mysql_num_rows ( $full_video );

if ($results_amount==1) {

        $f_v= $db->fetcharray($full_video);

	$incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a> | ';

        @$firm_video = $db->query ( "SELECT firmname, category FROM $db_users WHERE selector='$f_v[firmselector]' LIMIT 1" );
        @$firmname= $db->fetcharray($firm_video);

        if (($cat==0) or !isset($cat)) {

            $category_list = explode(":", $firmname['category']);
            $category_list = explode("#", $category_list[0]);
            $cat=$category_list[0]; $subcat=$category_list[1]; $subsubcat=$category_list[2];
        }

	if ($cat != 0) 
        {
            
		$res = $db->query  ( "SELECT selector, category FROM $db_category WHERE selector = '$cat'" );
		$fe = $db->fetcharray  ( $res );
		$db->freeresult  ( $res );
		$showmaincategory = $fe['category'];
		$category = $fe['selector'];

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

        if (($category == "") and ($subcategory == "") and ($subsubcategory == "")) $links_view="$def_mainlocation/EmptyCategory/0-0-0-$f_v[firmselector]-$kPage-0.html";
        if (($category != 0) and ($subcategory == 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/" . rewrite($showmaincategory) . "/$cat-0-0-$f_v[firmselector]-$kPage-0.html";
        if (($subcategory != 0) and ($subsubcategory == 0)) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/$cat-$subcat-0-$f_v[firmselector]-$kPage-0.html";
        if ($subsubcategory != 0) $links_view="$def_mainlocation/".rewrite($showmaincategory)."/".rewrite($showcategory)."/".rewrite($showsubcategory)."/$cat-$subcat-$subsubcat-$f_v[firmselector]-$kPage-0.html";
        
        if ($def_rewrite == "YES") $incomingline.= " | <a href=\"$links_view\" ><font color=\"$def_status_font_color\"><u>$firmname[firmname]</u></font></a> | <a href=\"$def_mainlocation/video-$f_v[firmselector]-$kPage-$cat-$subcat-$subsubcat.html\" ><font color=\"$def_status_font_color\"><u>$def_video</u></font></a> | $f_v[item]";
        else $incomingline.= " | <a href=\"view.php?id=$f_v[firmselector]&cat=$cat&subcat=$subcat&subsubcat=$subsubcat \" ><font color=\"$def_status_font_color\"><u>$firmname[firmname]</u></font></a> | <a href=\"video.php?id=$f_v[firmselector]&cat=$cat&subcat=$subcat&subsubcat=$subsubcat \" ><font color=\"$def_status_font_color\"><u>$def_video</u></font></a> | $f_v[item]";

	$show_banner="NO";

        // Формируем мета-теги
	if ($f_v['metatitle']!='') $incomingline_firm =  htmlspecialchars($f_v['metatitle'],ENT_QUOTES,$def_charset); else $incomingline_firm =  htmlspecialchars($f_v['item'],ENT_QUOTES,$def_charset);
	if ($f_v['metadescr']!='') $descriptions_meta = $f_v['metadescr']; else {
            $descriptions_meta = chek_meta($f_v['full']);
            $descriptions_meta = substr($descriptions_meta, 0, 200);
            $descriptions_meta = substr($descriptions_meta, 0, strrpos($descriptions_meta, ' '));
            $descriptions_meta = trim($descriptions_meta);
        }
        if ($f_v['metakeywords']!='') $keywords_meta=$f_v['metakeywords'];
        else $keywords_meta=check_keywords($f_v['full']);

        // Формируем ссылку на полную новость

	if ($f_v['name']=="") $name_video_full=rewrite($f_v['item']); else $name_video_full=$f_v['name'];

        if ($def_rewrite == "YES") $link=$def_mainlocation.'/'.$f_v['num'].$def_rewrite_split.'video'.$def_rewrite_split.$name_video_full.'.html';
        else $link = $def_mainlocation.'/videofull.php?id='.$f_v['num'].'&cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat;

        require_once 'includes/classes/video_firm.php';

        // Формируем мета-теги для социальных страниц и прочие компоненты

        $vf = new Fvideo();
        $vf->link_video=$f_v['urlv'];
$meta_system =
'<meta property="og:site_name" content="'.$def_title.'" />
 <meta property="og:type" content="article" />
 <meta property="og:title" content="'.$incomingline_firm.'" />
 <meta property="og:url" content="'.$link.'" />
 <meta property="og:video" content="'.$vf->showVideo('url').'" />';
        
$help_section = (string)$videofull_help;        

include ( "./template/$def_template/header.php" );

main_table_top($f_v['item']);

            $r = $db->query  ( "SELECT * FROM $db_users WHERE selector = '$f_v[firmselector]'" );

            include ("./includes/sub.php");

    	    $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
            require 'includes/components/stat.php'; // Подключаем файл статистики

?>
<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation; ?>/includes/css/rate.css">
<script type="text/javascript" src="<?php echo $def_mainlocation; ?>/includes/js/jqueryuid.js"></script>
<link rel="stylesheet" href="<?php echo $def_mainlocation. '/template/' . $def_template; ?>/css/jqueryuid.css">
<?php
                // Обрабатываем переменые и выводим шаблон

                $template_video = set_tFile('videofull.tpl');

		$item = $f_v['item'];

                if ($f_v['full']=='') $full = $f_v['message']; else $full = $f_v['full'];
                $parts_whv = array();
                preg_match('#wvr(\d+)_hvr(\d+)#', $template_video, $parts_whv);
                $widht_video = $parts_whv[1];
                $height_video = $parts_whv[2];
                $replace_video_tags='video_wvr'.$widht_video.'_hvr'.$height_video;

                $vv = new Fvideo();
                $vv->video_widht=$widht_video;
                $vv->video_height=$height_video;
                $vv->link_video=$f_v['urlv'];

                $template = new Template;

                $template->load($template_video);

		$template->replace("title", $item);
                // $date_add = Undate($f_v['date'], $def_datetype);

                $date_add = str_replace(array(',',':'), array('',''), data_to_news($f_v['date']));

                $template->replace("date", $date_add);
                $template->replace("fullstory", $full);
                $template->replace($replace_video_tags, $vv->showVideo('video'));

                if ($def_rating_video=="NO") $template->replace("rating", "");
                else $template->replace("rating", buildRate($f_v['num'], $f_v['rateVal']));

                $template->replace("color", $color);

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");              

                // Количество просмотров

		$hits=intval($f_v['hits']);

		$ip='';

		@$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		if ($ip == "") {$ip=$_SERVER["REMOTE_ADDR"];}

                    $hits++;
                    $db->query ( "UPDATE $db_video SET hits = '$hits', ip = '$ip' WHERE num='$f_v[num]'" );

                $template->replace("hits", $hits);


                $template->replace("rating", buildRate($f_v['selector'], $f_v['rateVal']));
                $template->replace("color", $color);

                $template->replace("related", $related_news);

                $template->replace("link", $link);

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                // Добавить в блог

                $echo_blog ='
                <div id="myblog_isb" title="'.$def_news_add_myblog.'">
                    <textarea style="width: 370px; height: 280px;"><p>'.$f_v['item'].'</p>'.$f_v['message'].'<br />'.$vv->showVideo('video').'<br /><br /><a href="'.$link.'">'.$def_mainlocation.'</a></textarea><br /><br />
                    '.$def_news_add_myblog_link.'<br /><input type="text" value="'.$link.'" style="width: 370px;" />
                </div>
                 <a href="#"  id="open_isb">'.$def_news_add_myblog.'</a>';

                $template->replace("blog", $echo_blog);

                // QR код с URL страницы

                $qr_code='<img src="https://chart.apis.google.com/chart?cht=qr&chs=120x120&chl='.$link.'" />';

                $template->replace("qr", $qr_code);

                // Рекомендуемые видеоролики
                if ($f_v['recommend']!='') {

                    $rec_video = $db->query ( "SELECT num, item, urlv, message, name FROM $db_video WHERE num IN ($f_v[recommend]) " );
                    @$results_amount_rec = mysql_num_rows ( $rec_video );

                    $template->replace("txt_recommend", $def_video_recommend);

                } else $template->replace("txt_recommend", '');

                $template->publish();

                // Рекомендуемые видеоролики подключаем модуль
                if ( $results_amount_rec > 0 ) require 'includes/sub_component/video_view_rec.php';

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