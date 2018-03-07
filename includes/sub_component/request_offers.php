<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: request_offers.php
-----------------------------------------------------
 Назначение: Форма заявки товара или услуги
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$template_request=set_tFile('request_offers.tpl');

$template = new Template;

$template->load($template_request);

if ($def_rewrite == "YES") {
    $link_type = "$def_mainlocation/offers-$id-0-$cat-$subcat-$subsubcat-$fz[type].html";
    $link_type_all = "$def_mainlocation/offers-$id-0-$cat-$subcat-$subsubcat-all.html";
}
else {
    $link_type = "$def_mainlocation/offers.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat&type=$fz[type]";
    $link_type_all = "$def_mainlocation/offers.php?id=$id&cat=$cat&subcat=$subcat&subsubcat=$subsubcat&type=all";
}

    $template->replace("company", $fz['firmname']);
    $template->replace("link_type", $link_type);
    $template->replace("link_type_all", $link_type_all);
    $template->replace("type", $type);
    $template->replace("title", $fz['item']);
    $template->replace("full_offers", $full_offers);
    $template->replace("id_firm", $id_firm);
    $template->replace("cat_firm", $cat_firm);

    $template->replace("rezult_name", htmlspecialchars($_POST['name'],ENT_QUOTES,$def_charset));
    $template->replace("rezult_firm", htmlspecialchars($_POST['firm'],ENT_QUOTES,$def_charset));
    $template->replace("rezult_phone", htmlspecialchars($_POST['tel'],ENT_QUOTES,$def_charset));
    $template->replace("rezult_mail", htmlspecialchars($_POST['mail'],ENT_QUOTES,$def_charset));
    $template->replace("rezult_text", htmlspecialchars($_POST['text'],ENT_QUOTES,$def_charset));

    $template->replace("security", "<img src=\"security.php?$rand\" />");

                

                $template->replace("color", $color);
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                require 'includes/apx/apx_request_offers.php'; // Подключаем дополнительный контент (для сторонних разработок)

                $template->publish();


?>
