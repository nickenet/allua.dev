<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: content_firm.php
-----------------------------------------------------
 Назначение: Контент компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
		// Продукция и услуги

		if (( $f['prices'] > 0 ) and ($def_allow_products == "YES") and (ifEnabled($f['flag'], "products")))

		{
				$r = mysql_query ( "SELECT num, item, message, price FROM $db_offers WHERE firmselector='$id' ORDER BY date DESC" );
				@$results_amount = mysql_num_rows ( $r );

				if ( $results_amount > 0 )
				{
					if ($def_rewrite == "YES")
					$link = "<a href=\"$def_mainlocation/offers-$f[selector]-$kPage-$cat-$subcat-$subsubcat-all.html\">";
					else
					$link = "<a href=\"offers.php?id=$f[selector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat&amp;type=all\">";
                                        if ($form_set[2]!='')  $offers_link_s=$link.$form_set[2].'</a>'; else $offers_link_s=$link.$def_offers.'</a>';
					$link.= "$def_offers</a> [$results_amount]";

					$offers_link = $def_offers_mark;
				}
				else
				{
                                        $offers_link_s="";
					$link = "$def_offers&nbsp;&nbsp;[0]";
					$offers_link="";
				}

		}
				else
				{
                                        $offers_link_s="";
					$link = "$def_offers&nbsp;&nbsp;[0]";
					$offers_link="";
				}

		// Галерея изображений

		if (( $f['images'] > 0 ) and ($def_allow_images == "YES") and (ifEnabled($f['flag'], "images")))

		{
			$rc = mysql_query ( "SELECT num, item, message FROM $db_images WHERE firmselector='$id' ORDER BY sort, date DESC" );
			@$results_amount_images = mysql_num_rows ( $rc );

			if ( $results_amount_images > 0 )
			{
				if ($def_rewrite == "YES")
				$link2 = "<a href=\"$def_mainlocation/gallery-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link2 = "<a href=\"gallery.php?id=$f[selector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[3]!='') $images_link_s=$link2.$form_set[3].'</a>'; else $images_link_s=$link2.$def_images.'</a>';
				$link2.= "$def_images</a>&nbsp;&nbsp;[$results_amount_images]";

				$images_link = $def_images_mark;
			}
			else
 			{
                                $images_link_s="";
				$link2 = "$def_images&nbsp;&nbsp;[0]";
				$images_link = "";
			}
		}
			else
			{
                                $images_link_s="";
 				$link2 = "$def_images&nbsp;&nbsp;[0]";
				$images_link = "";
			}

		// Excel прайсы

		if (( $f['exel'] > 0 ) and ($def_allow_exel == "YES") and (ifEnabled($f['flag'], "exel")))

		{
			$rce = mysql_query ( "SELECT num FROM $db_exelp WHERE firmselector='$id'" );
			@$results_amount_exel = mysql_num_rows ( $rce );

			if ( $results_amount_exel > 0 )
			{
				if ($def_rewrite == "YES")
				$link3 = "<a href=\"$def_mainlocation/excel-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link3 = "<a href=\"exel.php?id=$f[selector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[4]!='') $excel_link_s=$link3.$form_set[4].'</a>'; else $excel_link_s=$link3.$def_exelp.'</a>';
				$link3.= "$def_exelp</a>&nbsp;&nbsp;[$results_amount_exel]";

				$exel_link = $def_exel_mark;
			}
			else
			{
                                $excel_link_s="";
 				$link3 = "$def_exelp&nbsp;&nbsp;[0]";
				$exel_link = "";
			}
		}
			else
			{
                                $excel_link_s="";
 				$link3 = "$def_exelp&nbsp;&nbsp;[0]";
				$exel_link = "";
			}

		// Видеоролики

		if (( $f['video'] > 0 ) and ($def_allow_video == "YES") and (ifEnabled($f['flag'], "video")))

		{
			$rcv = mysql_query ( "SELECT num FROM $db_video WHERE firmselector='$id'" );
			@$results_amount_video = mysql_num_rows ( $rcv );

			if ( $results_amount_video > 0 )
			{
				if ($def_rewrite == "YES")
				$link4 = "<a href=\"$def_mainlocation/video-$f[selector]-$kPage-$cat-$subcat-$subsubcat.html\">";
				else
				$link4 = "<a href=\"video.php?id=$f[selector]&amp;cat=$cat&amp;subcat=$subcat&amp;subsubcat=$subsubcat\">";
                                if ($form_set[5]!='') $video_link_s=$link4.$form_set[5].'</a>'; else $video_link_s=$link4.$def_video.'</a>';
				$link4.= "$def_video</a>&nbsp;&nbsp;[$results_amount_video]";

				$video_link = $def_video_mark;
			}
			else
			{
                                $video_link_s="";
 				$link4 = "$def_video&nbsp;&nbsp;[0]";
				$video_link = "";
			}

		}


			else
			{
 				$video_link_s="";
                                $link4 = "$def_video&nbsp;&nbsp;[0]";
				$video_link = "";
			}


		$template->replace("productslist", $link);

		$template->replace("offers", $offers_link);

		$template->replace("imageslist", $link2);

		$template->replace("images", $images_link);

		$template->replace("exellist", $link3);

		$template->replace("exel", $exel_link);

		$template->replace("videolist", $link4);

		$template->replace("video", $video_link);

?>
