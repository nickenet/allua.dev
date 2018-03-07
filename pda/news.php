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

// Полная версия публикации

$full_news = $db->query ( "SELECT * FROM $db_news WHERE selector='$id' and status_off=0 LIMIT 1" );
@$results_amount_n = mysql_num_rows ( $full_news );

if ($results_amount_n==1) {

    $f_n= $db->fetcharray($full_news);

	if ($f_n['metatitle']!='') $incomingline_firm =  htmlspecialchars($f_n['metatitle'],ENT_QUOTES,$def_charset); else $incomingline_firm =  htmlspecialchars($f_n['title'],ENT_QUOTES,$def_charset);

include ("./template/$def_template/header.php");


// Обрабатываем переменые

		if ($f_n['full_tpl']!='')  $template_full=trim(htmlspecialchars($f_n['full_tpl'],ENT_QUOTES,$def_charset)).'.tpl';
                else $template_full='full_news.tpl';

                if (file_exists('./template/' . $def_template . '/'.$template_full)) $template_full_news = implode ('', file('./template/' . $def_template . '/'.$template_full));
                else die("Не найден шаблон $template_full");

                $date_add=data_to_news($f_n['date']);
                $title=htmlspecialchars(stripcslashes($f_n['title']),ENT_QUOTES,$def_charset);
                $selector=intval($f_n['selector']);
                $short=stripcslashes($f_n['short']);
                $full=stripcslashes($f_n['full']);

                    if ($full=='') $full=$short;

                $comment=intval($f_n['comments']);
                $hits=intval($f_n['hit']);
                $comment_news='';

                // Количество просмотров

		@	$ip=$_SERVER["HTTP_X_FORWARDED_FOR"];
		if ($ip == "") {$ip=$_SERVER["REMOTE_ADDR"];}

		if ($ip != $f_n['ip']) {
                    $hits++;
                    $db->query ( "UPDATE $db_news SET hit = '$hits', ip = '$ip' WHERE selector='$selector'" );
                }

                $category_n=htmlspecialchars(stripcslashes($array_cat[$f_n['category']]),ENT_QUOTES,$def_charset);
                $category_url=htmlspecialchars(stripcslashes($array_url[$f_n['category']]),ENT_QUOTES,$def_charset);
                $category_s=intval($f_n['category']);

                $template = new Template;

                $template->load($template_full_news);

		$template->replace("date", $date_add);
                $template->replace("title", $title);
                $template->replace("shortstory", $short);
                $template->replace("fullstory", $full);
                $template->replace("hits", $hits);
                $template->replace("category", $category_n);
                $template->replace("keywords", $keywords);

                $template->replace("color", $color);

                $template->replace("valcom", $comment);

                $template->replace("related", $related_news);

                // Формируем ссылку на полную новость

                $link = $def_mainlocation_pda.'/news.php?id='.$selector.'&cat='.$category_s;

                $link_print = $def_mainlocation_pda.'/news.php?id='.$selector.'&cat='.$category_s.'&print';

                $template->replace("link", $link);

                $template->replace("path_to_images", $def_mainlocation_pda . "/template/" . $def_template . "/images");

                $template->publish();

$url_full_version = 'news.php?id='.$selector.'&cat='.$category_s.'&mobile=no';     

include ( "./template/$def_template/footer.php" );

}

?>