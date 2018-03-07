<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: searchnews.php
-----------------------------------------------------
 Назначение: Форма быстрого поиска по новостям
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo();

        $template_news_searchform = implode ('', file('./template/' . $def_template . '/searchform_news.tpl'));

        $template_sfn = new Template;

        $template_sfn->load($template_news_searchform);

        $template_sfn->replace("bgcolor", $def_form_back_color_search);
        $template_sfn->replace("file_find", "$def_mainlocation/search-7.php");
        $template_sfn->replace("text_find", $def_news_search);
        $template_sfn->replace("rezult", htmlspecialchars($words,ENT_QUOTES,$def_charset));
        $template_sfn->replace("button_search", $def_search);
        $template_sfn->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        if (empty($_SESSION['razdel_news'])) {

            $razdel_news = '';

	$r_ncat = $db->query ( "SELECT category, selector  FROM $db_categorynews WHERE status_off = 0 ORDER BY category" );
	$results_amount_ncat = $db->numrows ( $r_ncat );
	if ($_POST['category']=='ANY') $razdel_news .= '<option value="ANY" selected>'.$def_news_search_cat.'</option>'; else $razdel_news .= '<option value="ANY">'.$def_news_search_cat.'</option>';

	for($i_index=0;$i_index<$results_amount_ncat;$i_index++){
		$f_ncat=$db->fetcharray($r_ncat);
                if ($_POST['category']==$f_ncat['selector']) $razdel_news .= '<option value="'.htmlspecialchars ($f_ncat['selector'],ENT_QUOTES,$def_charset).'" selected> &#187 '.htmlspecialchars ($f_ncat['category'],ENT_QUOTES,$def_charset).'</option>';
                else $razdel_news .= '<option value="'.htmlspecialchars ($f_ncat['selector'],ENT_QUOTES,$def_charset).'"> &#187 '.htmlspecialchars ($f_ncat['category'],ENT_QUOTES,$def_charset).'</option>';
        }

            $_SESSION['razdel_news']=$razdel_news;

        }
        
        $template_sfn->replace("select_razdel", $_SESSION['razdel_news']);

        $template_sfn->publish();

?>



