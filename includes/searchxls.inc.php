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

        $template_xls = new Template;

        $template_xls->set_file('searchform_xls.tpl');

        $template_xls->replace("bgcolor", $def_form_back_color_search);
        $template_xls->replace("file_find", "$def_mainlocation/search-6.php");
        $template_xls->replace("text_find", $def_xls_search);
        $template_xls->replace("rezult", htmlspecialchars($item_xls,ENT_QUOTES,$def_charset));
        $template_xls->replace("button_search", $def_search);
        $template_xls->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_xls->publish();
?>
