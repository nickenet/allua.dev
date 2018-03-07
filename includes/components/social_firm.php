<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: social_firm.php
-----------------------------------------------------
 Назначение: Подключение социальной страницы компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

        $link_to_social=$def_mainlocation.'/'.$f['domen'];
        $domen_to_social=$f['domen'];
        $template->replace("metatitle", $incomingline_firm);
        $template->replace("metadescription", $descriptions_meta);
        $template->replace("metakeywords", $keywords_meta);
        $template->replace("id_company", $f['selector']); //id компании
        $template->replace("title", $def_title); // название каталога
        $template->replace("link_to_social",  $link_to_social); // ссылка на социальную страничку
        $template->replace("dir_to_main", $def_mainlocation); // корневое расположение
        $template->replace("dir_to_theme", $def_mainlocation.'/theme/'.$theme); // путь до темы
        $template->replace("dir_to_images_theme", $def_mainlocation.'/theme/'.$theme.'/images'); // путь до папки images темы
        $template->replace("domen", $domen_to_social); // имя страницы

        if ($form_set[19]=='') $header_title=$f['firmname'];
        if ($form_set[19]!='') $header_title=$form_set[19];
        if ($form_set[19]=='notext') $header_title='';

        $template->replace("header_title", $header_title); // заголовок в шапке

        // Меню
        if ($form_set[1]!='') $def_sociall_link_to_main=$form_set[1]; $template->replace("link_to_main", $def_sociall_link_to_main);
        $template->replace("link_to_offers", $offers_link_s);
        $template->replace("link_to_images", $images_link_s);
        $template->replace("link_to_excel", $excel_link_s);
        $template->replace("link_to_video", $video_link_s);
        $template->replace("link_to_news", $news_link_s);
        $template->replace("link_to_tender", $tender_link_s);
        $template->replace("link_to_board", $board_link_s);
        $template->replace("link_to_job", $job_link_s);
        $template->replace("link_to_pressrel", $pressrel_link_s);

        // Переводчик

        if ($form_set[0]==1) $google_translate="
<div id=\"google_translate_element\" style=\"padding-top:2px; pading-bottom:2px;\"></div>
<script>
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'ru',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
<script src=\"//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit\"></script>";
        else $google_translate='';

        $template->replace("translate", $google_translate);

        // QR код

       if ($form_set[17]==1) $qr_code='<img src="https://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$def_mainlocation.'/'.$f['domen'].'" />'; else $qr_code='';

       $template->replace("qr", $qr_code);

        // Последние комментарии

        if ($reviews > 0) {

            $t_reviews='';
            $template_reviews = file_get_contents ('./theme/' . $theme . '/review.tpl');
            if ($reviews<$def_social_reviews) $def_social_reviews=$reviews;
            for ( $sr=0; $sr<$def_social_reviews; $sr++ ) {
                $f_rew = $db->fetcharray  ( $rx );
                $review=$f_rew['review'];
                $link_reviews=$def_mainlocation.'/reviews.php?id='.$f['selector'];
                $review=isb_sub($review, $def_social_reviews_chars);
                $date_add = undate($f_rew['date'], $def_datetype);
                $user=htmlspecialchars($f_rew['user']);
                $t_reviews.=str_replace(array('*user*', '*review*', '*date*', '*link_reviews*', '*link_to_social*', '*domen*'), array($user, $review, $date_add, $link_reviews, $link_to_social, $domen), $template_reviews);
            }
         $template->replace("reviews", $t_reviews);
        } else $template->replace("reviews", $def_social_not_reviews);

        // Ключевые слова

        if ($keywords!='') {

            $template_keywords = file_get_contents ('./theme/' . $theme . '/keywords.tpl');
            $view_keywords=str_replace("*keywords*", $keywords, $template_keywords);
            $template->replace("view_keywords", $view_keywords);
            }
        else $template->replace("view_keywords", "");

        // Последние публикации

        if ($f['info'] > 0) {

            $lInfo=array(1 => $def_info_news, 2 => $def_info_tender, 3 => $def_info_board, 4 => $def_info_job, 5 => $def_info_pressrel);
            
            $r_info = mysql_query ( "SELECT type, num, date, datetime, item, shortstory FROM $db_info WHERE firmselector='$id' ORDER BY date DESC, datetime DESC LIMIT $def_social_publication" );
            @$results_r_info = mysql_num_rows ( $r_info );
            
            $t_info='';
            $template_info = file_get_contents ('./theme/' . $theme . '/publications.tpl');
            if ($form_set[14]!='') $def_social_publication=$form_set[14];
            if ($results_r_info<$def_social_publication) $def_social_publication=$results_r_info;
            for ( $si=0; $si<$def_social_publication; $si++ ) {
                $f_info = $db->fetcharray  ( $r_info );
                $item_info=$f_info['item'];
                $short_info=$f_info['shortstory'];
                $shortstory_info=isb_sub($short_info, $def_social_info_chars);
                $date_info = undate($f_info['date'], $def_datetype);
                $type_info=$lInfo[$f_info['type']];
                $num_info=$f_info['num'];
                $link_pub=$def_mainlocation.'/viewinfo.php?vi='.$num_info;
                $t_info.=str_replace(array('*item*', '*shortstory*', '*date*','*num*','*dir_to_main*','*type*','*short*', '*link_pub*','*link_to_social*','*domen*'), array($item_info, $shortstory_info, $date_info,$num_info, $def_mainlocation, $type_info, $short_info, $link_pub, $link_to_social, $domen), $template_info);
            }
         $template->replace("publications", $t_info);
        } else $template->replace("publications", "");

        // Товары и услуги

        if ($results_amount>0){

            $t_offers='';
            $template_offers = file_get_contents ('./theme/' . $theme . '/offers.tpl');
            if ($form_set[15]!='') $def_social_offers=$form_set[15];
            if ($results_amount<$def_social_offers) $def_social_offers=$results_amount;
             for ( $so=0; $so<$def_social_offers; $so++ ) {
                $f_offers = $db->fetcharray  ( $r );
                $item_offers=$f_offers['item'];
                $short_offers=isb_sub(strip_tags(stripcslashes($f_offers['message'])),$def_social_offers_chars);
		$short_offers=str_replace('"','',$short_offers);
                $num_offers=$f_offers['num'];
                $link_offer=$def_mainlocation.'/alloffers.php?idfull='.$f['selector'].'&full='.$f_offers['num'];
                if ($f_offers['price']!='') $price_offers=$f_offers['price']; else $price_offers=$def_price_not;
                $short_offers=isb_sub($short_offers, $def_social_offers_chars);
                $img_offers = array();
                $img_offers = glob('./offer/'.$num_offers.'-small.*');
                if ($img_offers[0]!='') $img_offers='<img src="'.$def_mainlocation.'/offer/'.basename($img_offers[0]).'" alt="'.$item_offers.'" />'; else $img_offers='<img src="'.$def_mainlocation.'/theme/'.$theme.'/images/noimages.gif" alt="'.$item_offers.'" />';
                $t_offers.=str_replace(array('*item*', '*num*','*dir_to_main*','*short*', '*price*', '*img*','*id_company*','*link_offer*','*link_to_social*','*domen*'), array($item_offers, $num_offers, $def_mainlocation, $short_offers, $price_offers, $img_offers, $f['selector'], $link_offer, $link_to_social, $domen), $template_offers);
             }
             $template->replace("view_offers", $t_offers);
        } else $template->replace("view_offers", "");

        // Изображения

        if ($results_amount_images>0){

            $t_images='';
            $template_images = file_get_contents ('./theme/' . $theme . '/images.tpl');
            if ($form_set[16]!='') $def_social_images=$form_set[16];
            if ($results_amount_images<$def_social_images) $def_social_images=$results_amount_images;
             for ( $sim=0; $sim<$def_social_images; $sim++ ) {
                $f_images = $db->fetcharray  ( $rc );
                $item_images=$f_images['item'];
                $short_images=$f_images['message'];
                $num_images=$f_images['num'];
                $link_images=$def_mainlocation.'/gallery.php?id='.$f['selector'];
                $short_images=isb_sub($short_images, $def_social_images_chars);
                $img_images = array();
                $img_images = glob('./gallery/'.$num_images.'-small.*');
                if ($img_images[0]!='') $img_gallery='<img src="'.$def_mainlocation.'/gallery/'.basename($img_images[0]).'" alt="'.$item_images.'" />'; else $img_gallery='<img src="'.$def_mainlocation.'/theme/'.$theme.'/images/noimages.gif" alt="'.$item_offers.'" />';
                $t_images.=str_replace(array('*item*', '*num*','*dir_to_main*','*short*','*img*','*id_company*','*link_images*','*link_to_social*','*domen*'), array($item_images, $num_images, $def_mainlocation, $short_images, $img_gallery, $f['selector'], $link_images, $link_to_social, $domen), $template_images);
             }
             $template->replace("view_images", $t_images);
        } else $template->replace("view_images", "");

        // Шапка и фон

        $img_header = array();
        $img_header = glob('./design/header/'.$f['selector'].'.*');
        if ($img_header[0]!='') $img_header=$def_mainlocation.'/design/header/'.basename($img_header[0]); else $img_header=$def_mainlocation.'/theme/'.$theme.'/images/top.jpg';
        $template->replace("css_img_header", $img_header);

        $img_size = getimagesize ( $img_header );
        $img_height = $img_size[1];
        $template->replace("css_height_header", $img_height);

        $img_bg = array();
        $img_bg = glob('./design/background/'.$f['selector'].'.*');
        if ($img_bg[0]!='') $img_bg=$def_mainlocation.'/design/background/'.basename($img_bg[0]); else $img_bg=$def_mainlocation.'/theme/'.$theme.'/images/bg.jpg';
        $template->replace("css_img_bg", $img_bg);

        if ($form_set[20]!='') $css_h1_color=$form_set[20]; else $css_h1_color='';
        $template->replace("css_h1_color", $css_h1_color);
        
        if ($form_set[21]!='') $css_header_left=$form_set[21]; else $css_header_left=300;
        if ($form_set[22]!='') $css_header_top=$form_set[22]; else $css_header_top=40;
        $template->replace("css_header_left", $css_header_left);
        $template->replace("css_header_top", $css_header_top);

        $template->replace_all("<li></li>", "");
?>