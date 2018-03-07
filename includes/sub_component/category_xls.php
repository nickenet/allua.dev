<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_xls.php
-----------------------------------------------------
 Назначение: Вывод категорий прайс листов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$template_cxls = new Template;

	$template_cxls->load($template_view_xls_category);

        $img_xls_category_tpl=imgM_Cat($f[img],$f[selector]);

        if ($def_rewrite == "YES") $link_xls_category=$def_mainlocation.'/'.$f['selector'].'-price'.$def_rewrite_split.rewrite($f['category']).'/'; else $link_xls_category=$def_mainlocation.'/allxls.php?category='.$f['selector'];

        $template_cxls->replace("name_cat", $f['category']);

        $template_cxls->replace("link", $link_xls_category);

        $template_cxls->replace("img", $img_xls_category_tpl);

        $template_cxls->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template_cxls->publish();

?>
