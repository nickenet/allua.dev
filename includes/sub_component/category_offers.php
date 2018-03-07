<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_img.php
-----------------------------------------------------
 Назначение: Вывод категорий галереи
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$template_cimg = new Template;

	$template_cimg->load($template_view_img_category);

        $img_img_category_tpl=imgM_Cat($f['img'],$f['selector']);

        if ($def_rewrite == "YES") $link_img_category=$def_mainlocation.'/'.$f['selector'].'-product'.$def_rewrite_split.rewrite($f['category']).'/'; else $link_img_category=$def_mainlocation.'/alloffers.php?category='.$f['selector'];

        $template_cimg->replace("name_cat", $f['category']);

        $template_cimg->replace("link", $link_img_category);

        $template_cimg->replace("img", $img_img_category_tpl);

        $template_cimg->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template_cimg->publish();

?>
