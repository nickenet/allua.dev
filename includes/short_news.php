<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: short_news.php
-----------------------------------------------------
 Назначение: Вывод кратких новостей
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$could_tag = '';

	for ($ir=0; $ir<$results_amount; $ir++ )

	{
		$f_rew = $db->fetcharray  ( $rz );

                $date_add=data_to_news($f_rew['date']);
                $title=$f_rew['title'];
                $short=stripcslashes($f_rew['short']);
                $full=stripcslashes($f_rew['full']);
                $comment=intval($f_rew['comments']);
                $hits=intval($f_rew['hit']);
                $comment_news='';

                // Формируем список тегов
                $keywords=htmlspecialchars(stripcslashes($f_rew['keywords']));
                if ($keywords!='') $could_tag.=$keywords.', ';

                // есть ли категория
                if (empty($f1['category'])) {
                    $category_n=htmlspecialchars(stripcslashes($array_cat[$f_rew['category']]));
                    $category_url=htmlspecialchars(stripcslashes($array_url[$f_rew['category']]));
                    $category_s=intval($f_rew['category']);
                } else {
                $category_n=htmlspecialchars(stripcslashes($f1['category']));
                $category_url=htmlspecialchars(stripcslashes($f1['name']));
                $category_s=intval($f1['selector']);
                }

                // Подключаем шаблон
		if ($f_rew['short_tpl']!='')  $template_short=trim(htmlspecialchars($f_rew['short_tpl'])).'.tpl';  
                elseif ($f1['short_tpl']!='') $template_short=trim(htmlspecialchars($f1['short_tpl'])).'.tpl'; 
                else $template_short='short_news.tpl';
                
                if (file_exists('./template/' . $def_template . '/'.$template_short)) $template_short_news = implode ('', file('./template/' . $def_template . '/'.$template_short));  
                else die("Не найден шаблон $template_short");
                
                $template = new Template;

                $template->load($template_short_news);

		$template->replace("date", $date_add);
                $template->replace("title", $title);
                $template->replace("shortstory", $short);
                $template->replace("fullstory", $full);
                $template->replace("hits", $hits);
                $template->replace("category", $category_n);

 
                $template->replace("rating", buildRate($f_rew['selector'], $f_rew['rateVal']));               
                $template->replace("color", $color);

                // Формируем линк на полную новость

                if ($def_rewrite_news == "YES") $link=$def_mainlocation.'/news/'.$category_url.'/'.$f_rew['selector'].'-'.$f_rew['name'].'.html';
                else $link = $def_mainlocation.'/news.php?id='.$f_rew['selector'].'&cat='.$category_s;

                $template->replace("link", $link);

                // Комментарии

                if (!$f_rew['comment_off']) { $comment_news=$def_comment_news.' ('.$comment.')';
                    $template->replace("[com-link]", "<a href=\"$link#comment\">");
                    $template->replace("[/com-link]", "</a>");
                } else {
                    $template->replace("[com-link]", "");
                    $template->replace("[/com-link]", "");
                }

                $template->replace("valcom", $comment);
                $template->replace("comment", $comment_news);

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                if (isset($filter_img)) echo '<div class="discounted-item '.$filter_img.'">';

                $template->publish();

                if (isset($filter_img)) echo '</div>';

        }

        unset($filter_img);

?>