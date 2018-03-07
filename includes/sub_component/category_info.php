<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: category_info.php
-----------------------------------------------------
 Назначение: Вывод категорий инфоблока
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	$template_cinfo = new Template;

	$template_cinfo->load($template_view_info_category);

        $info_info_category_tpl=imgM_Cat($f['img'],$f['selector']);

        if ($def_rewrite == "YES") $link_info_category=$def_mainlocation.'/'.$f['selector'].'-'.$name_url_info.$def_rewrite_split.rewrite($f['category']).'/'; else $link_info_category=$def_mainlocation.'/allinfo.php?category='.$f['selector'].'&type='.$kType;

        $template_cinfo->replace("name_cat", $f['category']);

        $template_cinfo->replace("link", $link_info_category);

        $template_cinfo->replace("img", $info_info_category_tpl);

        $template_cinfo->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

	$template_cinfo->publish();

?>
