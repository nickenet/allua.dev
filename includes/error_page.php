<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: error_page.php
-----------------------------------------------------
 Назначение: Вывод информации об ошибки
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

        $template_error = implode ('', file('./template/' . $def_template . '/error.tpl'));

        $template_e = new Template;

        $template_e->load($template_error);

        $template_e->replace("title", $def_title_error);

        $template_e->replace("message", $def_message_error);

        $template_e->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

        $template_e->publish();

?>