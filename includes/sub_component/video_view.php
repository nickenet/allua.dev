<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: video_view.php
-----------------------------------------------------
 Назначение: Вывод видеороликов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$template_video = set_tFile('video.tpl');

	for ($i=0; $i<$results_amount; $i++ )
	{
		$fz = $db->fetcharray  ( $rz );

		if ( $it%2 == 0 ) $color = $def_form_back_color;
		else $color = $def_background;

		$item = $fz['item'];

                $message_len = array();
                preg_match('#_mlen(\d+)#', $template_video, $message_len);

                if ( $fz['message']!='' ) $message=isb_sub($fz['message'],$message_len[1]); else $message='';
                $replace_short_tags = 'shortvideo_mlen'.$message_len[1];

                $parts_whv = array();
                preg_match('#wvr(\d+)_hvr(\d+)#', $template_video, $parts_whv);
                $widht_video = $parts_whv[1];
                $height_video = $parts_whv[2];
                $replace_video_tags='video_wvr'.$widht_video.'_hvr'.$height_video;

                require_once 'includes/classes/video_firm.php';

                $vf = new Fvideo();
                $vf->video_widht=$widht_video;
                $vf->video_height=$height_video;
                $vf->link_video=$fz['urlv'];

                $template = new Template;

                $template->load($template_video);

		$template->replace("title", $item);
                $template->replace( $replace_short_tags, $message);
                $template->replace($replace_video_tags, $vf->showVideo('video'));

		if ($fz['name']=="") $fz['name']=rewrite($fz['item']);

                if ($def_rewrite == "YES") $link_to_full = $def_mainlocation.'/'.$fz['num'].$def_rewrite_split.'video'.$def_rewrite_split.$fz['name'].'.html';
                else $link_to_full = $def_mainlocation.'/videofull.php?id='.$fz['num'].'&cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat;

                $template->replace("link", $link_to_full);

                if ($def_rating_video=="NO") $template->replace("rating", "");
                else $template->replace("rating", buildRate($fz['num'], $fz['rateVal']));

                $template->replace("color", $color);
                
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                require 'includes/apx/apx_video.php'; // Подключаем дополнительный контент (для сторонних разработок)

                $template->publish();
	}


?>
