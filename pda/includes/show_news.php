<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: show_news.php
-----------------------------------------------------
 Назначение: Вывод последних новостей
=====================================================
*/

/* Вы можете задействовать следующие переменные:
 * $header_set_tpl - подключаемый шаблон
 * $header_set_limit - установка количества выводимых последних новостей
 * $header_set_category - категория из которой выводить новости
 * $header_set_category_no - категория из которой не выводить новости
 * $header_set_chars_limit - сколько обрезать символов в краткой версии без тегов
 * $header_set_date_format - формат даты
 * $header_set_main - выводить все новости, без учета параметра главной страницы
 */

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

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

if (!isset($header_set_limit)) $header_set_limit=10;
if (isset($header_set_category)) { $header_set_category=intval($header_set_category); $sql_header= "and category='$header_set_category'"; } else $sql_header="";
if (isset($header_set_category_no)) { $header_set_category_no=intval($header_set_category_no); $sql_header_no= "and category!='$header_set_category_no'"; } else $sql_header_no="";
if (isset($header_set_main)) $sql_main=''; else $sql_main=" and main=0";
$lnz = $db->query ( "SELECT * FROM $db_news WHERE status_off = 0 $sql_header $sql_header_no $sql_main ORDER BY date DESC LIMIT $header_set_limit");
@$results_amount_n = mysql_num_rows ( $lnz );

$pub_news.='';

	for ($ln=0; $ln<$results_amount_n; $ln++ )

	{
		$f_lnews = $db->fetcharray  ( $lnz );

                if (isset($header_set_date_format)) $date_add=date("$header_set_date_format", strtotime( $f_lnews['date'] )); else $date_add=date("d.m.Y", strtotime( $f_lnews['date'] ));
                $title=htmlspecialchars(stripcslashes($f_lnews['title']),ENT_QUOTES,$def_charset);
                $short=stripcslashes($f_lnews['short']);
                $short_no_tag=(strip_tags((stripcslashes($f_lnews['short'])))); // краткая версия без тегов

                if (isset($header_set_chars_limit) and (strlen($short_no_tag) > $header_set_chars_limit))

		{
			$short_no_tag = substr($short_no_tag, 0, $header_set_chars_limit);
			$short_no_tag = substr($short_no_tag, 0, strrpos($short_no_tag, ' '));
			$short_no_tag = trim($short_no_tag) . ' ...';
		}

                $full=stripcslashes($f_lnews['full']);
                $full_no_tag=strip_tags((stripcslashes($f_lnews['full']))); // полная версия без тегов
                $comment=intval($f_lnews['comments']);
                $hits=intval($f_lnews['hit']);
                $comment_news='';

                if ($def_rewrite_news == "YES") {
                    $category_n=htmlspecialchars(stripcslashes($array_cat[$f_lnews['category']]),ENT_QUOTES,$def_charset);
                    $category_url=htmlspecialchars(stripcslashes($array_url[$f_lnews['category']]),ENT_QUOTES,$def_charset);
                    $category_s=intval($f_lnews['category']);
                }

                // Подключаем шаблон $tpl_header_set
		if (isset($header_set_tpl))  $template_header=trim(htmlspecialchars($header_set_tpl)).'.tpl';
                else $template_header='header_news.tpl';

                if (file_exists('./template/' . $def_template . '/'.$template_header)) $template_header = implode ('', file('./template/' . $def_template .'/'. $template_header));
                else die("Не найден шаблон $template_header");

                $template_h = new Template;

                $template_h->load($template_header);

		$template_h->replace("date", $date_add);
                $template_h->replace("title", $title);
                $template_h->replace("shortstory", $short);
                $template_h->replace("fullstory", $full);
                $template_h->replace("shortstory_no_tag", $short_no_tag);
                $template_h->replace("fullstory_no_tag", $full_no_tag);
                $template_h->replace("hits", $hits);
                $template_h->replace("category", $category_n);


                // Формируем линк на полную новость

                $link = $def_mainlocation_pda.'/news.php?id='.$f_lnews['selector'].'&cat='.$f_lnews['category'];

                $template_h->replace("link", $link);

                // Комментарии

                if (!$f_lnews['comment_off']) { $comment_news=$def_comment_news.' ('.$comment.')';
                    $template_h->replace("[com-link]", "<a href=\"$link#comment\">");
                    $template_h->replace("[/com-link]", "</a>");
                }

                $template_h->replace("valcom", $comment);
                $template_h->replace("comment", $comment_news);

                $template_h->replace("path_to_images", $def_mainlocation_pda . "/template/" . $def_template . "/images");

                $template_h->publish();

        }

        unset($template_h, $header_set_limit, $header_set_category, $header_set_date_format, $header_set_tpl, $header_set_chars_limit, $r_cat);

?>