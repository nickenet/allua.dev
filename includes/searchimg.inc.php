<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: searchxls.php
-----------------------------------------------------
 Назначение: Форма поиска прайс листов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

echo qautocomplete_echo();

        $template_img = new Template;

        $template_img->set_file('searchform_img.tpl');

        $template_img->replace("bgcolor", $def_form_back_color_search);
        $template_img->replace("file_find", "$def_mainlocation/search-4.php");
        $template_img->replace("text_find", $def_img_search);
        $template_img->replace("rezult", htmlspecialchars($words,ENT_QUOTES,$def_charset));
        $template_img->replace("button_search", $def_search);
        $template_img->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_img->publish();
?>
