<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_web.php
-----------------------------------------------------
 Назначение: Вывод категорий сайтов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$template_cweb = new Template;

	$template_cweb->load($template_view_web_category);

        $web_img_category_tpl=imgM_Cat($f['img'],$f['selector']);

        if ($def_rewrite == "YES") $link_web_category=$def_mainlocation.'/'.$f['selector'].'-site'.$def_rewrite_split.rewrite($f['category']).'/'; else $link_web_category=$def_mainlocation.'/allweb.php?category='.$f['selector'];

        $template_cweb->replace("name_cat", $f['category']);

        $template_cweb->replace("link", $link_web_category);

        $template_cweb->replace("img", $web_img_category_tpl);

        $template_cweb->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template_cweb->publish();

?>
