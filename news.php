<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: news.php
-----------------------------------------------------
 Назначение: Вывод полной новости
=====================================================
*/

include ("./defaults.php");

header('Cache-control: private');

// Функции для рейтинга новости

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

require 'includes/array_cat_news.php'; // массив категорий

// Полная версия публикации

$full_news = $db->query ( "SELECT * FROM $db_news WHERE selector='$id' and status_off=0 LIMIT 1" );
@$results_amount_n = mysql_num_rows ( $full_news );

if ($results_amount_n==1) {

    $f_n= $db->fetcharray($full_news);

	$incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';

        if ($def_rewrite_news == "YES") $show_news_to_link = $def_mainlocation.'/news/'; else $show_news_to_link = $def_mainlocation.'/allnews.php';

        $incomingline .= ' | <a href="'.$show_news_to_link.'"><font color="'.$def_status_font_color.'"><u>'.$def_news_title.'</u></font></a>';

	if (isset($_REQUEST['cat']))

	{
                $category_news_get=$_GET['cat'];
                if (is_numeric($category_news_get)) $category_news_get=intval($_GET['cat']);
                else { if (substr ( $_GET['cat'], - 1, 1 ) == '/') $_GET['cat'] = substr ( $_GET['cat'], 0, - 1 );
                $category_news_get=mysql_real_escape_string(strip_tags(safeHTML($_GET['cat']))); }

		if ($def_rewrite_news == "YES")
		$incomingline.= ' | <a href="'.$def_mainlocation.'/news/'.htmlspecialchars ($array_name[$category_news_get],ENT_QUOTES,$def_charset).'/">';
		else
		$incomingline.= ' | <a href="'.$def_mainlocation.'/allnews.php?category='.$category_news_get.'">';

		$incomingline.= '<font color="'.$def_status_font_color.'"><u>'.htmlspecialchars ($array_cat[$f_n['category']],ENT_QUOTES,$def_charset).'</u></font></a>';

                $incomingline.= ' | '.$f_n['title'];

	} else $incomingline= htmlspecialchars ($f_n['title'],ENT_QUOTES,$def_charset);

	$help_section = (string)$news_help;

	$show_banner="NO";

	if ($f_n['metatitle']!='') $incomingline_firm =  htmlspecialchars($f_n['metatitle'],ENT_QUOTES,$def_charset); else $incomingline_firm =  htmlspecialchars($f_n['title'],ENT_QUOTES,$def_charset);
	if ($f_n['metadescr']!='') $descriptions_meta = htmlspecialchars($f_n['metadescr'],ENT_QUOTES,$def_charset);
        if ($f_n['metakeywords']!='') $keywords_meta = htmlspecialchars($f_n['metakeywords'],ENT_QUOTES,$def_charset);

                // Формируем ссылку на полную новость
        
                $selector=intval($f_n['selector']);
                
                $category_n=htmlspecialchars(stripcslashes($array_cat[$f_n['category']]),ENT_QUOTES,$def_charset);
                $category_url=htmlspecialchars(stripcslashes($array_url[$f_n['category']]),ENT_QUOTES,$def_charset);
                $category_s=intval($f_n['category']);                

                if ($def_rewrite_news == "YES") $link=$def_mainlocation.'/news/'.$category_url.'/'.$selector.'-'.htmlspecialchars($f_n['name'],ENT_QUOTES,$def_charset).'.html';
                else $link = $def_mainlocation.'/news.php?id='.$selector.'&cat='.$category_s;

                $link_print = $def_mainlocation.'/news.php?id='.$selector.'&cat='.$category_s.'&print';        
        
$meta_system ='<meta property="og:site_name" content="'.$def_title.'" />
<meta property="og:type" content="article" />
<meta property="og:title" content="'.$incomingline_firm.'" />
<meta property="og:url" content="'.$link.'" />
<meta property="news_keywords" content="'.$f_n['keywords'].'" />    
';        

if (!isset($_GET['print']))  { include ( "./template/$def_template/header.php" );

?>
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/rate.js"></script>
<link rel="stylesheet" href="<? echo $def_mainlocation; ?>/includes/css/rate.css">
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/js/jqueryuid.js"></script>
<link rel="stylesheet" href="<? echo $def_mainlocation. '/template/' . $def_template; ?>/css/jqueryuid.css">

<?php

}

// Обрабатываем переменые

		if ($f_n['full_tpl']!='')  $template_full=trim(htmlspecialchars($f_n['full_tpl'],ENT_QUOTES,$def_charset)).'.tpl';
                else $template_full='full_news.tpl';

                if (isset($_GET['print'])) $template_full='print_news.tpl';

                if (file_exists('./template/' . $def_template . '/'.$template_full)) $template_full_news = implode ('', file('./template/' . $def_template . '/'.$template_full));
                else die("Не найден шаблон $template_full");

                $date_add=data_to_news($f_n['date']);
                $title=$f_n['title'];                
                $short=stripcslashes($f_n['short']);
                $full=stripcslashes($f_n['full']);

                    if ($full=='') $full=$short;

                $comment=intval($f_n['comments']);
                $hits=intval($f_n['hit']);
                $comment_news='';

                // Ключевые слова - метки, теги

                if ($f_n['keywords']!='') { $keywords = array();
                $f_n['keywords'] = explode(",", htmlspecialchars(stripcslashes($f_n['keywords']),ENT_QUOTES,$def_charset));

                foreach($f_n['keywords'] as $value)  {
                    $value = trim ($value);
                    $keywords[] = "<a href=\"$def_mainlocation/get.php?skey=". urlencode( $value ) ."\">$value</a>";
                }
                $keywords=implode(", ",$keywords);
                } else $keywords='';

                // Количество просмотров

		@	$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		if ($ip == "") {$ip=$_SERVER["REMOTE_ADDR"];}

		if ($ip != $f_n['ip']) {
                    $hits++;
                    $db->query ( "UPDATE $db_news SET hit = '$hits', ip = '$ip' WHERE selector='$selector'" );
                }

                // Похожие новости
                $related_news='';
                if ($def_news_related=="YES")
		{
                    if( strlen( $f_n['full'] ) < strlen( $f_n['short'] ) ) $bodynews = $f_n['short'];
		    else $bodynews = $f_n['full'];

		$bodynews=mysql_real_escape_string(strip_tags(stripslashes( $f_n['title']." ".$bodynews )));

		if (strlen($bodynews)>75)
		{                  
			$related = $db->query ( "SELECT selector, title, short, category, name FROM $db_news WHERE MATCH (short, full, title, keywords) AGAINST ('$bodynews') AND selector!='$f_n[selector]' AND status_off=0 LIMIT $def_news_sum_related" ) or die();
			$results_related = mysql_num_rows ( $related );
                        
                        if ($results_related>0) {

			$related_news='<div align="left"><strong>'.$def_news_related_view.'</strong></div>';
				for ( $iiii=0;$iiii<$results_related;$iiii++ )
				{
					$relatedf = $db->fetcharray ( $related );
                                        $related_short=strip_tags(stripcslashes($relatedf['short']));
                                        $related_short = substr($related_short, 0, $def_news_txt_related);
                                        $related_short = substr($related_short, 0, strrpos($related_short, ' '));
                                        $related_short = trim($related_short) . ' ...';

                                        if ($def_rewrite_news == "YES")
                                        $link_rel= $def_mainlocation.'/news/'.$array_url[$relatedf['category']].'/'.$relatedf['selector'].'-'.$relatedf['name'].'.html';
                                        else
                                        $link_rel= $def_mainlocation.'/news.php?id='.$relatedf['selector'].'&cat='.$relatedf['category'];

					$related_news.='<div style="text-align: left; padding: 3px;">&raquo; <a href="'.$link_rel.'">'.$relatedf['title'].'</a><br /><span class="boxdescr">'.$related_short.'</span></div>';
				}
                        }
		}}

                $template = new Template;

                $template->load($template_full_news);

		$template->replace("date", $date_add);
                $template->replace("title", $title);
                $template->replace("shortstory", $short);
                $template->replace("fullstory", $full);
                $template->replace("hits", $hits);
                $template->replace("category", $category_n);
                $template->replace("keywords", $keywords);

                $template->replace("rating", buildRate($f_n['selector'], $f_n['rateVal']));
                $template->replace("color", $color);

                $template->replace("valcom", $comment);

                $template->replace("related", $related_news);

                $template->replace("link", $link);
                $template->replace("link_print", $link_print);

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                // Добавить в блог

                $echo_blog ='
                <div id="myblog_isb" title="'.$def_news_add_myblog.'">
                    <textarea style="width: 370px; height: 280px;"><p>'.$title.'</p>'.$short.'<br /><a href="'.$link.'">'.$def_mainlocation.'</a></textarea><br /><br />
                    '.$def_news_add_myblog_link.'<br /><input type="text" value="'.$link.'" style="width: 370px;" />
                </div>
                 <a href="#"  id="open_isb">'.$def_news_add_myblog.'</a>';

                $template->replace("blog", $echo_blog);

                // QR код с URL страницы

                $qr_code='<img src="https://chart.apis.google.com/chart?cht=qr&chs=120x120&chl='.$link.'" />';

                $template->replace("qr", $qr_code);

                $template->publish();

// Комментарии к новостям

if (!$f_n['comment_off'] and !isset($_GET['print'])) {

    $sum_comments=$f_n['comments'];
    $forma_comment=true;

        if (!isset($_SESSION['random'])) $_SESSION['random'] = mt_rand(1000000, 9999999);
        $rand = mt_rand(1, 999);
        

// Обработка комментария

        if ($_POST['hiddenbut'] == 'go' and $_POST['security'] != $_SESSION['random'])
        {
            unset($_SESSION['random']);
            $def_message_error = 'Код безопасности не соответствует отображённому!<br>';
            include ( "./includes/error_page.php" );
        }

        elseif ($_POST['hiddenbut'] == 'go' and $_POST['security'] == $_SESSION['random'])
        {

            unset($_SESSION['random']);

            require 'includes/loginza/init.php'; // Подключаем логинзу

            	$texty = safeHTML(strip_tags($_POST['texty']));
                $texty = substr($texty, 0, $def_review_size);
                $userName = safehtml($_POST['user_name']);
                $email = safehtml($_POST['email']);

	if ($userName == '') $error .= $def_specify_your_name.'!<br />';
	if ($texty == '') $error .= $def_specifyyourmessage.'!<br />';

	if (!isset($error))
	{
		$date = date("Y-m-d");
		$avatar = '';
		$status = 'off';
		$profil = '';
		if (!empty($_SESSION['loginza']['is_auth']))
		{
			$status = 'on';
			$profil = $LoginzaProfile->genUserSite();
			if (!empty($_SESSION['loginza']['profile']->photo))
			{
				$avatar = $_SESSION['loginza']['profile']->photo;
			}
		}

                $db->query("INSERT INTO $db_newsrev SET news = '$selector', date = '$date', user = '$userName', status = '$status', review = '$texty', mail = '$email', profil = '$profil', avatar = '$avatar'"	) or die(mysql_error());
               
		if ($status=='on') { $sum_comments++; $db->query("UPDATE $db_news SET comments='$sum_comments' WHERE selector='$selector'"); }

		// Отправляем письмо администратору

			$text_rev = <<<MAIL
Здравствуйте.

Уведомляем вас о том, что на сайт  $def_mainlocation ($def_title) был добавлен комментарий

------------------------------------------------
Текст комментария
------------------------------------------------

MAIL;

			$text_rev .= $texty;

			if ($status=='off') $text_comment_add='Комментарий отправлен на проверку'; else $text_comment_add='Комментарий занесен в базу данных';

			$text_rev .= <<<MAIL

К новости $def_mainlocation/news.php?id=$selector

$text_comment_add

------------------------------------------------
Помните, что администрация сайта не несет ответственности за содержание данного письма

С уважением,

Администрация $def_mainlocation
MAIL;

			$to =  $def_adminmail;
			mail($to, 'Новый комментарий к новости в каталоге', stripcslashes($text_rev), "FROM: " . $def_adminmail . "\r\nContent-Type: text/plain; charset=windows-1251\r\n");

                        if ($status=='off') {
                            $def_message_error = $def_review_approved;
                            $def_title_error = $def_comment_news;
                            include ( "./includes/error_page.php" );
                        }
                        $forma_comment=false;
                        unset ($_SESSION['comnews']);

	} else { $def_message_error=$error; include ( "./includes/error_page.php" ); }

}

// Вывод комментариев

$npage = $kPage + 1;
$ppage = $kPage - 1;
$page1 = $kPage * $def_list_news;

$sort_rd="";
if ($def_news_sort_reviews==2) $sort_rd="DESC";

$rz = $db->query ( "SELECT * FROM $db_newsrev WHERE news='$selector' and status='on' ORDER BY date $sort_rd LIMIT $page1, $def_list_news" );
@$results_amount = mysql_num_rows ( $rz );

$result_in=intval($sum_comments);

    if ($results_amount>0) {

        echo '<a name="comment"></a>';

        include ("./includes/news_review.php");

    }

    // Страницы комментариев

if ( $result_in > $def_list_news )

{
	if ((($kPage*$def_list_news)-($def_list_news*5)) >= 0) $first=($kPage*$def_list_news)-($def_list_news*5);
	else $first=0;

	if ((($kPage*$def_list_news)+($def_list_news*6)) <= $result_in) $last =($kPage*$def_list_news)+($def_list_news*6);
	else $last = $result_in;

	@$z=$first/$def_list_news;

	if ($kPage > 0) {

            if ($def_rewrite_news == "YES") $prev_page = '<a href="'.$def_mainlocation.'/news/'.$category_url.'/page/'.($kPage-1).'/'.$selector.'-'.htmlspecialchars($f_n['name'],ENT_QUOTES,$def_charset).'.html"><b>'.$def_previous.'</b></a>&nbsp;'; else $prev_page =  '<a href="'.$def_mainlocation.'/news.php?id='.$selector.'&cat='.$category_s.'&page='.($kPage-1).'"><b>'.$def_previous.'</b></a>&nbsp;';

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
			if ($def_rewrite_news == "YES") $page_news .= '<a href="'.$def_mainlocation.'/news/'.$category_url.'/page/'.$z.'/'.$selector.'-'.htmlspecialchars($f_n['name'],ENT_QUOTES,$def_charset).'.html"><b>'.($z+1).'</b></a>&nbsp;'; else $page_news .= '<a href="'.$def_mainlocation.'/news.php?id='.$selector.'&cat='.$category_s.'&page='.$z.'"><b>'.($z+1).'</b></a>&nbsp;';
			$z++;
		}
	}

        if ($kPage - (($result_in / $def_list_news) - 1) < 0) {

            if ($def_rewrite_news == "YES") $next_page = '<a href="'.$def_mainlocation.'/news/'.$category_url.'/page/'.($kPage+1).'/'.$selector.'-'.htmlspecialchars($f_n['name'],ENT_QUOTES,$def_charset).'.html"><b>'.$def_next.'</b></a>&nbsp;'; else $next_page = '<a href="'.$def_mainlocation.'/news.php?id='.$selector.'&cat='.$category_s.'&page='.($kPage+1).'"><b>'.$def_next.'</b></a>&nbsp;';

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

// Форма комментариев

    if ($forma_comment) {
        require 'includes/loginza/init.php'; // Подключаем логинзу
	require './includes/review_form_news.php'; // Подключаем форму
    }

}

// Конец блока комментарии

if (!isset($_GET['print'])) include ( "./template/$def_template/footer.php" );

}

else

{
        $incomingline = '<a href="'.$def_mainlocation.'"><font color="'.$def_status_font_color.'"><u>'.$def_catalogue.'</u></font></a>';

        if ($def_rewrite_news == "YES") $show_news_to_link = $def_mainlocation.'/news/'; else $show_news_to_link = $def_mainlocation.'/allnews.php';

        $incomingline .= ' | <a href="'.$show_news_to_link.'"><font color="'.$def_status_font_color.'"><u>'.$def_news_title.'</u></font></a>';

        $incomingline_firm = $def_title_error;

	@header( "HTTP/1.0 404 Not Found" );
	include ( "./template/$def_template/header.php" );
            include ( "./includes/error_page.php" );
	include ( "./template/$def_template/footer.php" );
}

?>