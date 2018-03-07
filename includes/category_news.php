<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_news.php
-----------------------------------------------------
 Назначение: Вывод категорий новостей
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$template_news = new Template;

	$template_news->load($template_view_news_category);

	$img_news_category_tpl = imgM_Cat($f[img],$f[selector],true);

	$template_news->replace("img", "$img_news_category_tpl");

        if ($f[ncount]>0) {

        if ($def_rewrite_news == "YES") $template_news->replace("[link_cat]", "<a href=\"$def_mainlocation/news/$f[name]/\">");
        else $template_news->replace("[link_cat]", "<a href=\"$def_mainlocation/allnews.php?category=$f[selector]\">");
        
        $template_news->replace("[/link_cat]", "</a>");

        } else { $template_news->replace("[link_cat]", ""); $template_news->replace("[/link_cat]", ""); }

        $f[category]=htmlspecialchars( strip_tags( stripslashes( $f['category'] ) ),ENT_QUOTES,$def_charset );
	
	$template_news->replace("name_cat", $f[category]);

        $f[description]=stripslashes($f[description]);

	$template_news->replace("description_cat", $f[description]);

        $f[ncount]=intval($f[ncount]);

	$template_news->replace("count_cat", $f[ncount]);

        $template_news->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template_news->publish();

?>