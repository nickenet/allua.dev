<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: video_view_rec.php
-----------------------------------------------------
 Назначение: Вывод рекомендуемых видеороликов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$template_video = set_tFile('video_rec.tpl');

	for ($i=0; $i<$results_amount_rec; $i++ )
	{
		$f_rec = $db->fetcharray  ( $rec_video );

		$item_rec = $f_rec['item'];

                $message_len = array();
                preg_match('#_mlen(\d+)#', $template_video, $message_len);

                if ( $f_rec['message']!='' ) $message=isb_sub($f_rec['message'],$message_len[1]); else $message='';
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
                $vf->link_video=$f_rec['urlv'];

                $template = new Template;

                $template->load($template_video);

		$template->replace("title", $item_rec);
                $template->replace( $replace_short_tags, $message);
                $template->replace($replace_video_tags, $vf->showVideo('video'));

		if ($f_rec['name']=="") $f_rec['name']=rewrite($f_rec['item']);

                if ($def_rewrite == "YES") $link_to_full = $def_mainlocation.'/'.$f_rec['num'].$def_rewrite_split.'video'.$def_rewrite_split.$f_rec['name'].'.html';
                else $link_to_full = $def_mainlocation.'/videofull.php?id='.$f_rec['num'].'&cat='.$cat.'&subcat='.$subcat.'&subsubcat='.$subsubcat;

                $template->replace("link", $link_to_full);
           
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                $template->publish();
	}


?>
