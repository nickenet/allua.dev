<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: view.php
-----------------------------------------------------
 Назначение: Информационная страница компании
=====================================================
*/

include ("./defaults.php");

if ($_GET['mobile']=='no') $_SESSION['no_mobile']='YES';

if ( check_smartphone() and empty($_SESSION['no_mobile']) and $def_auto_smart!=2 and $def_auto_smart!=4) { $def_mainlocation_pda .= '/view.php?id='.$id; goto_url($def_mainlocation_pda); }

$kPage = 0;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

if (isset($_GET['id'])) $r = $db->query ( "SELECT * FROM $db_users WHERE selector='$id' $hide_d" );
if (isset($_GET['name'])) {

    $domen=mysql_real_escape_string(safeHTML(strip_tags($_GET['name'])));
    $r = $db->query ( "SELECT * FROM $db_users WHERE (domen LIKE '$domen') $hide_d" );

}

if ( $db->numrows($r) == 1 )

{
        // Запоминиаем просмотр фирмы
        if (isset($_COOKIE['history'])) {
            
            $data_history = explode(',', $_COOKIE['history']);
            
            if (!in_array($id, $data_history)) { $data_historymy = $_COOKIE[history]; $data_historymy .= ",$id"; } else $data_historymy = $_COOKIE[history];
        
        } else $data_historymy=$id;

        setcookie('history', $data_historymy, $cookie_time, "/");

        $f = $db->fetcharray ( $r );
        $id=intval($f['selector']);

        // определяем социальную страничку и тему оформления
        $include_soc_page=false;
        if ((isset($_GET['name'])) and ($f['domen']!='')) {
            $include_soc_page=true;
            if ($f['theme']=='') $theme='theme1'; else $theme=$f['theme'];
        }

        // Формируем speedbar

	$incomingline = "<a href=\"$def_mainlocation\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a>";

	if ($cat != 0)
	{
	$res2 = $db->query ( "SELECT * FROM $db_category WHERE selector='$cat'");
	$fe2 = $db->fetcharray ( $res2 );
	$db->freeresult ( $res2 );
	$showcategory2 = $fe2["category"];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showcategory2)) ."/$cat-$kPage.html\">";
		else
		$incomingline.= " | <a href=\"index.php?category=$cat\">";

		$incomingline.= "<font color=\"$def_status_font_color\"><u>$showcategory2</u></font></a>";
	}

	if ($subcat != 0)
	{
	$res = $db->query ( "SELECT * FROM $db_subcategory WHERE catsubsel='$subcat'");
	$fe = $db->fetcharray ( $res );
	$db->freeresult ( $res );
	$showcategory = $fe["subcategory"];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showcategory2)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/$cat-$subcat-$kPage.html\">";
		else
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat\">";

		$incomingline.= " <font color=\"$def_status_font_color\"><u>$showcategory</u></font></a>";
	}

	if ($subsubcat != 0)
	{
	$res3 = $db->query ( "SELECT * FROM $db_subsubcategory WHERE catsel='$cat' and catsubsel='$subcat' and catsubsubsel='$subsubcat'");
	$fe3 = $db->fetcharray ( $res3 );
	$db->freeresult ( $res3 );
	$showsubcategory = $fe3["subsubcategory"];

		if ($def_rewrite == "YES")
		$incomingline.= " | <a href=\"$def_mainlocation/". str_replace(' ', "_", rewrite($showcategory2)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory)) ."/$cat-$subcat-$subsubcat-$kPage.html\">";
		else
		$incomingline.= " | <a href=\"index.php?cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";

		$incomingline.= "  <font color=\"$def_status_font_color\"><u>$showsubcategory</u></font></a>";
	}

	$category_list = explode(":", $f[category]);
	$category_list = explode("#", $category_list[0]);

	if ($cat!=0) $incomingline.= "  | $f[firmname]"; else { $incomingline= $f['firmname']; $cat=$category_list[0]; $subcat=$category_list[1]; $subsubcat=$category_list[2]; }

	$help_section = $cat_help_3;

	$show_banner="NO";

        // Формируем мета-теги
	if ($f['metatitle']!='') $incomingline_firm=$f['metatitle']; else $incomingline_firm=$f['firmname'];
        if ($f['metadescr']!='') $descriptions_meta=$f['metadescr'];
        else {
            $descriptions_meta = chek_meta($f['business']);
            $descriptions_meta = substr($descriptions_meta, 0, 200);
            $descriptions_meta = substr($descriptions_meta, 0, strrpos($descriptions_meta, ' '));
            $descriptions_meta = trim($descriptions_meta);
        }
        if ($f['metakeywords']!='') $keywords_meta=$f['metakeywords'];
        else $keywords_meta=check_keywords($f['business']);

        // Код для рейтинга
        $kod_top="<a href=\"$def_mainlocation/view.php?id=$id\" title=\"$f[firmname]\"><img src=\"$def_mainlocation/images/ratingtop.gif\" alt=\"Участник каталога\" border=0></a>";

        // Логотип организации

$logo_img = glob('./logo/'.$id.'.*');
if ($logo_img[0]!='') $logo_mail='<img src="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" hspace="3" vspace="3" />'; else $logo_mail="";

    // Логотип организации

if ($def_rewrite == "YES") {
    $link_cat_url = str_replace(' ', "_", rewrite($showcategory2)) ."/". str_replace(' ', "_", rewrite($showcategory)) ."/". str_replace(' ', "_", rewrite($showsubcategory));
    $link = '/'.$link_cat_url.'/'.$cat.'-'.$subcat.'-'.$subsubcat.'-'.$id.'-0-0.html';
    $link=str_replace("///", "/", $link);
    $link=str_replace("//", "/", $link);
    $link=$def_mainlocation.$link;
} else $link=$def_mainlocation.'/view.php?id='.$id;

$meta_system ='<meta property="og:site_name" content="'.$def_title.'" />
<meta property="og:type" content="article" />
<meta property="og:title" content="'.$incomingline_firm.'" />
<meta property="og:url" content="'.$link.'" />
<meta property="news_keywords" content="'.$f['keywords'].'" />    
';

if ($logo_img[0]!='') $meta_system .= '<meta property="og:image" content="'.$def_mainlocation.'/logo/'.basename($logo_img[0]).'" />'."\n"; else $meta_system .="\n";

if (($_GET['type'] != "print") and (!$include_soc_page)) include ( "./template/$def_template/header.php" ); // подключили header

	if ( $f['firmstate']=="off" ) echo $def_notreviewedyet;
	else {
		if ( $_REQUEST['type'] == "rate" )
		{
			$ip_internal = $_SERVER["HTTP_X_FORWARDED_FOR"];
			$ip_external = $_SERVER["REMOTE_ADDR"];

			$r1 = $db->query ( "SELECT * FROM $db_rating WHERE id='$id' and ip_internal='$ip_internal' and ip_external='$ip_external'" );

			if ( $db->numrows ( $r1 ) > 0 ) $rate_error = $def_rate_error_1;
			else {
                            $rating=array(1,2,3,4,5);
                            $rate_post=intval($_POST['rate']);
                            if (!in_array($rate_post, $rating))  $rate_error = $def_rate_error_2;
         		    else {
					$new_rate = $f['rating'] + $rate_post;
					$new_votes = $f['votes'] + 1;
					$countrating = $new_rate / $new_votes;

					$db->query ( "INSERT INTO $db_rating (id, rating, ip_internal, ip_external) VALUES ($id, $countrating, '$ip_internal', '$ip_external')" );
					$db->query ( "UPDATE $db_users SET rating=$new_rate, votes=$new_votes, countrating=$countrating WHERE selector='$id'" );

if (($f[on_rating]=='1') and ($f[mail]!="")) {
		
		// Отправляем письмо контрагенту

    $template_mail = file_get_contents ('template/' . $def_template . '/mail/rating.tpl');

    $template_mail = str_replace("*title*", $def_title, $template_mail);
    $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
    $template_mail = str_replace("*firmname*", $f['firmname'], $template_mail);
    $template_mail = str_replace("*rating*", $rate_post, $template_mail);
    $template_mail = str_replace("*logo*", $logo_mail, $template_mail);
    if ($f['manager']!='') $template_mail = str_replace("*manager*", $f['manager'], $template_mail); else $template_mail = str_replace("*manager*", $def_manager_firms, $template_mail);

    mailHTML($f['mail'],$def_mail_rating,$template_mail,$def_from_email);
    
		}
					$rate_error = $def_rate_error_3;
				}
			}
		}

		if ( $_GET['type'] == "rate" ) { echo '<br /><div style="color:#FF0000; text-align:center;">'.$rate_error.'<br /></div>'; }
		if ( ( isset ( $_GET['type'] ) ) and ( $_GET['type'] == "mail" ) ) { echo '<br /><div style="color:#FF0000; text-align:center;">'.$def_message.'<br /></div>'; }
		if ( ( isset ( $_GET['type'] ) ) and ( $_GET['type'] == "mail2" ) ) { echo '<br /><div style="color:#FF0000; text-align:center;">'.$def_message2.'<br /></div>'; }

if ($_GET['type'] == "print") $template_sub = implode ('', file('./template/' . $def_template . '/main_print.tpl'));

else
		if ($include_soc_page) $template_sub = implode ('', file('./theme/' . $theme . '/main.tpl'));
                else $template_sub = implode ('', file('./template/' . $def_template . '/main_' . strtolower($f['flag']) . '.tpl'));

		$template = new Template;

		$template->load($template_sub);

                $form_set=explode(":",$f['setting_s']); // Установки социальной страницы

		$template->replace("charset", "$def_charset");
		$template->replace("style", "$def_style");
		$template->replace("directory_url", "$def_title / " . $def_mainlocation . "/view.php?id=" . $f[selector]);

		$notepad_link='<a href="'.$def_mainlocation.'/view.php?id='.$f['selector'].'" onclick="return notepadAdd('.$f['selector'].')" id="notepad_link">Добавить в мой блокнот</a><a href="'.$def_mainlocation.'/view.php?id='.$f['selector'].'" onclick="return notepadDel('.$f['selector'].')" id="notepad_link_del" style="display: none">Удалить из блокнота</a>';
		$template->replace("notepad",$notepad_link);

                require 'includes/components/data_firm.php'; // Подключаем основные данные о компании

                // Похожие компании
		if ($def_firm_related=="YES")
		{
                    $bodydes=mysql_real_escape_string(strip_tags(stripslashes( $f['business'] )));
                    if (strlen($bodydes)>75)
                    {
			$related = $db->query ( "SELECT selector, firmname, business FROM $db_users WHERE MATCH (business) AGAINST ('$bodydes') AND selector!='$f[selector]' AND firmstate='on' LIMIT 5" );
			$results_related = $db->numrows ( $related );
                        $related_firms='';
				for ( $iiii=0;$iiii<$results_related;$iiii++ )
				{
					$relatedf = $db->fetcharray ( $related );
					$related_des=strip_tags(parseDescription("X", $relatedf['business']));
					$related_firms.='<div align="left">&raquo; <a href="'.$def_mainlocation.'/view.php?id='.$relatedf['selector'].'">'.$relatedf['firmname'].'</a><br><span class="boxdescr">'.$related_des.'</span></div>';
				}
                                if ($related_firms!='') $related_firms='<div align="left"><strong>'.$def_related_company.'</strong></div>'.$related_firms;
			$template->replace("related_firms", $related_firms);
                    } else $template->replace("related_firms","");
		}else $template->replace("related_firms","");

                // Рейтинг компании
		if ($def_rewrite == "YES") $link_rate = "<form action=\"$def_mainlocation/rating-$id-$cat-$subcat-$subsubcat-$kPage.html\" method=POST>";
		else $link_rate = "<form action=\"$def_mainlocation/view.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=rate\" method=POST>";

		$link_rate.= "
                    <select onchange=\"this.form.submit()\" name=\"rate\">
                        <option value=''>$def_rate</option>
                        <option value='5'>$def_excellent</option>
                        <option value='4'>$def_verygood</option>
                        <option value='3'>$def_good</option>
                        <option value='2'>$def_fair</option>
                        <option value='1'>$def_poor</option>
                    </select>
                 </form>";

		$template->replace("rate", $link_rate);

                // Написать другу
		if ($def_friend_enable == "YES")

		{
                    if ($form_set[11]!='') $def_friend=$form_set[11];
			if ($def_rewrite == "YES")
			$friend = "<a href=\"$def_mainlocation/mail2-$id-$cat-$subcat-$subsubcat-$kPage.html\">$def_friend</a>";
			else
			$friend = "<a href=\"$def_mainlocation/mail2.php?id=$id&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">$def_friend</a>";
		}
		if ($f[off_friends]=='1') $friend=$def_closed_company;

		$template->replace("friend", $friend);

                // Версия для печати

		if ($def_print_enable == "YES") $print = " <a href=\"$def_mainlocation/view.php?id=$f[selector]&type=print\" target=\"_blank\">$def_print</a>";

		$template->replace("print", $print);

		$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                // Подключаем компоненты

                require 'includes/components/category_firm.php'; // Подключаем определение категории

                require 'includes/components/content_firm.php'; // Подключаем контент компании

                require 'includes/components/info_firm.php'; // Подключаем информационный блок компании

                require 'includes/components/socnet_firm.php'; // Подключаем социальные страницы компании

                require 'includes/components/maps_firm.php'; // Подключаем карты компании

                require 'includes/components/filial_firm.php'; // Подключаем филиалы компании

                require 'includes/components/review_firm.php'; // Подключаем комментарии компании

                require 'includes/components/complaint_firms.php'; // Подключаем ссылку на жалобу
              
                if ($include_soc_page) require 'includes/components/social_firm.php'; // Подключаем социальную страничку

                $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
                require 'includes/components/stat.php'; // Подключаем файл статистики

                require 'includes/apx/apx_view.php'; // Подключаем файл дополнительных данных (для сторонних разработок)

           $template->publish();

		if ( ( isset ( $_GET['type'] ) ) and (( $_GET['type'] == "banner" ) or ( $_GET['type'] == "banner2" )) )
		{
			$banner_click = $f['banner_click'];
			$banner_click++;
			$db->query ( "UPDATE $db_users SET banner_click=$banner_click WHERE selector='$id'" );
		}
	}

if (($_GET['type'] != "print") and (!$include_soc_page)) include ( "./template/$def_template/footer.php" ); // Подключили footer

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