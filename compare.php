<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: compare.php
-----------------------------------------------------
 Назначение: Вывод информации по тарифным планам
=====================================================
*/

include( "./defaults.php" );

session_start();

unset($_SESSION['random']);

$_SESSION['random'] = mt_rand(1000000,9999999);

$rand = mt_rand(1, 999);

$incomingline = $def_compare;

$help_section = $compare_help;

include ( "./template/$def_template/header.php" );

?>
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/js/jqueryuid.js"></script>
<link rel="stylesheet" href="<? echo $def_mainlocation. '/template/' . $def_template; ?>/css/jqueryuid.css">
<?

$titlecompare=$def_compare;

main_table_top ($def_compare); // Вверх заголовка

$template = new Template;

$template->set_file('compare.tpl');


// Тарифный план
$template->replace("def_D", $def_D);
$template->replace("def_C", $def_C);
$template->replace("def_B", $def_B);
$template->replace("def_A", $def_A);

// Стоимость пребывания
$template->replace("def_D_price", $def_D_price);
$template->replace("def_C_price", $def_C_price);
$template->replace("def_B_price", $def_B_price);
$template->replace("def_A_price", $def_A_price);

// Срок (в днях)
$template->replace("def_D_expiration", $def_D_expiration);
$template->replace("def_C_expiration", $def_C_expiration);
$template->replace("def_B_expiration", $def_B_expiration);
$template->replace("def_A_expiration", $def_A_expiration);

// name

$template->replace("def_D_name", ifcompare("YES"));
$template->replace("def_C_name", ifcompare("YES"));
$template->replace("def_B_name", ifcompare("YES"));
$template->replace("def_A_name", ifcompare("YES"));

// address
$template->replace("def_D_address", ifcompare($def_D_address));
$template->replace("def_C_address", ifcompare($def_C_address));
$template->replace("def_B_address", ifcompare($def_B_address));
$template->replace("def_A_address", ifcompare($def_A_address));

// zip
$template->replace("def_D_zip", ifcompare($def_D_zip));
$template->replace("def_C_zip", ifcompare($def_C_zip));
$template->replace("def_B_zip", ifcompare($def_B_zip));
$template->replace("def_A_zip", ifcompare($def_A_zip));

// phone
$template->replace("def_D_phone", ifcompare($def_D_phone));
$template->replace("def_C_phone", ifcompare($def_C_phone));
$template->replace("def_B_phone", ifcompare($def_B_phone));
$template->replace("def_A_phone", ifcompare($def_A_phone));

// fax
$template->replace("def_D_fax", ifcompare($def_D_fax));
$template->replace("def_C_fax", ifcompare($def_C_fax));
$template->replace("def_B_fax", ifcompare($def_B_fax));
$template->replace("def_A_fax", ifcompare($def_A_fax));

// mobile
$template->replace("def_D_mobile", ifcompare($def_D_mobile));
$template->replace("def_C_mobile", ifcompare($def_C_mobile));
$template->replace("def_B_mobile", ifcompare($def_B_mobile));
$template->replace("def_A_mobile", ifcompare($def_A_mobile));

// icq
$template->replace("def_D_icq", ifcompare($def_D_icq));
$template->replace("def_C_icq", ifcompare($def_C_icq));
$template->replace("def_B_icq", ifcompare($def_B_icq));
$template->replace("def_A_icq", ifcompare($def_A_icq));

// manager
$template->replace("def_D_manager", ifcompare($def_D_manager));
$template->replace("def_C_manager", ifcompare($def_C_manager));
$template->replace("def_B_manager", ifcompare($def_B_manager));
$template->replace("def_A_manager", ifcompare($def_A_manager));

// email
$template->replace("def_D_email", ifcompare($def_D_email));
$template->replace("def_C_email", ifcompare($def_C_email));
$template->replace("def_B_email", ifcompare($def_B_email));
$template->replace("def_A_email", ifcompare($def_A_email));

// www
$template->replace("def_D_www", ifcompare($def_D_www));
$template->replace("def_C_www", ifcompare($def_C_www));
$template->replace("def_B_www", ifcompare($def_B_www));
$template->replace("def_A_www", ifcompare($def_A_www));

// map
$template->replace("def_D_map", ifcompare($def_D_map));
$template->replace("def_C_map", ifcompare($def_C_map));
$template->replace("def_B_map", ifcompare($def_B_map));
$template->replace("def_A_map", ifcompare($def_A_map));

// filial
$template->replace("def_D_filial", ifcompare($def_D_filial));
$template->replace("def_C_filial", ifcompare($def_C_filial));
$template->replace("def_B_filial", ifcompare($def_B_filial));
$template->replace("def_A_filial", ifcompare($def_A_filial));

// review
$template->replace("def_D_review", ifcompare($def_D_review));
$template->replace("def_C_review", ifcompare($def_C_review));
$template->replace("def_B_review", ifcompare($def_B_review));
$template->replace("def_A_review", ifcompare($def_A_review));

// stat
$template->replace("def_D_stat", ifcompare($def_D_stat));
$template->replace("def_C_stat", ifcompare($def_C_stat));
$template->replace("def_B_stat", ifcompare($def_B_stat));
$template->replace("def_A_stat", ifcompare($def_A_stat));

// social
$template->replace("def_D_social", ifcompare($def_D_social));
$template->replace("def_C_social", ifcompare($def_C_social));
$template->replace("def_B_social", ifcompare($def_B_social));
$template->replace("def_A_social", ifcompare($def_A_social));

// logo
$template->replace("def_D_logo", ifcompare($def_D_logo));
$template->replace("def_C_logo", ifcompare($def_C_logo));
$template->replace("def_B_logo", ifcompare($def_B_logo));
$template->replace("def_A_logo", ifcompare($def_A_logo));

// sxema
$template->replace("def_D_sxema", ifcompare($def_D_sxema));
$template->replace("def_C_sxema", ifcompare($def_C_sxema));
$template->replace("def_B_sxema", ifcompare($def_B_sxema));
$template->replace("def_A_sxema", ifcompare($def_A_sxema));

// maps
$template->replace("def_D_maps", ifcompare($def_D_maps));
$template->replace("def_C_maps", ifcompare($def_C_maps));
$template->replace("def_B_maps", ifcompare($def_B_maps));
$template->replace("def_A_maps", ifcompare($def_A_maps));

// banner
$template->replace("def_D_banner", ifcompare($def_D_banner));
$template->replace("def_C_banner", ifcompare($def_C_banner));
$template->replace("def_B_banner", ifcompare($def_B_banner));
$template->replace("def_A_banner", ifcompare($def_A_banner));

// banner2
$template->replace("def_D_banner2", ifcompare($def_D_banner2));
$template->replace("def_C_banner2", ifcompare($def_C_banner2));
$template->replace("def_B_banner2", ifcompare($def_B_banner2));
$template->replace("def_A_banner2", ifcompare($def_A_banner2));

// infoblock
$template->replace("def_D_infoblock", ifcompare($def_D_infoblock));
$template->replace("def_C_infoblock", ifcompare($def_C_infoblock));
$template->replace("def_B_infoblock", ifcompare($def_B_infoblock));
$template->replace("def_A_infoblock", ifcompare($def_A_infoblock));

// setinfo
$template->replace("def_D_setinfo", $def_D_setinfo);
$template->replace("def_C_setinfo", $def_C_setinfo);
$template->replace("def_B_setinfo", $def_B_setinfo);
$template->replace("def_A_setinfo", $def_A_setinfo);

// products
$template->replace("def_D_products", ifcompare($def_D_products));
$template->replace("def_C_products", ifcompare($def_C_products));
$template->replace("def_B_products", ifcompare($def_B_products));
$template->replace("def_A_products", ifcompare($def_A_products));

// setproducts
$template->replace("def_D_setproducts", $def_D_setproducts);
$template->replace("def_C_setproducts", $def_C_setproducts);
$template->replace("def_B_setproducts", $def_B_setproducts);
$template->replace("def_A_setproducts", $def_A_setproducts);

// thumbnail
$template->replace("def_D_offer_thumbnail", ifcompare($def_D_offer_thumbnail));
$template->replace("def_C_offer_thumbnail", ifcompare($def_C_offer_thumbnail));
$template->replace("def_B_offer_thumbnail", ifcompare($def_B_offer_thumbnail));
$template->replace("def_A_offer_thumbnail", ifcompare($def_A_offer_thumbnail));

// offerIM
$template->replace("def_D_offerIM", ifcompare($def_D_offerIM));
$template->replace("def_C_offerIM", ifcompare($def_C_offerIM));
$template->replace("def_B_offerIM", ifcompare($def_B_offerIM));
$template->replace("def_A_offerIM", ifcompare($def_A_offerIM));

// images
$template->replace("def_D_images", ifcompare($def_D_images));
$template->replace("def_C_images", ifcompare($def_C_images));
$template->replace("def_B_images", ifcompare($def_B_images));
$template->replace("def_A_images", ifcompare($def_A_images));

// setimages
$template->replace("def_D_setimages", $def_D_setimages);
$template->replace("def_C_setimages", $def_C_setimages);
$template->replace("def_B_setimages", $def_B_setimages);
$template->replace("def_A_setimages", $def_A_setimages);

// exel
$template->replace("def_D_exel", ifcompare($def_D_exel));
$template->replace("def_C_exel", ifcompare($def_C_exel));
$template->replace("def_B_exel", ifcompare($def_B_exel));
$template->replace("def_A_exel", ifcompare($def_A_exel));

// setexel
$template->replace("def_D_setexel", $def_D_setexel);
$template->replace("def_C_setexel", $def_C_setexel);
$template->replace("def_B_setexel", $def_B_setexel);
$template->replace("def_A_setexel", $def_A_setexel);

// video
$template->replace("def_D_video", ifcompare($def_D_video));
$template->replace("def_C_video", ifcompare($def_C_video));
$template->replace("def_B_video", ifcompare($def_B_video));
$template->replace("def_A_video", ifcompare($def_A_video));

// setvideo
$template->replace("def_D_setvideo", $def_D_setvideo);
$template->replace("def_C_setvideo", $def_C_setvideo);
$template->replace("def_B_setvideo", $def_B_setvideo);
$template->replace("def_A_setvideo", $def_A_setvideo);

$template->replace("dir_to_main", $def_mainlocation);
$template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

$template->replace("security", "<img src=\"security.php?$rand\" />");

if (isset($_SESSION['login'])) { 
    $link_to_tarif='users/user.php?REQ=authorize&mod=tarif';
    $template->replace_all("open_tarif", "");
} else $link_to_tarif='#';

$template->replace("link", $link_to_tarif);

$template->publish();

main_table_bottom(); // Низ заголовка

include ( "./template/$def_template/footer.php" );

?>