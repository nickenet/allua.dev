<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Lomakin M.
=====================================================
 Файл: catgallery.php
-----------------------------------------------------
 Назначение: Вывод галереи изображений
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$w_h_gal_def=explode("#",$def_gallery_h_w);
$template_sub_gallery = implode ('', file('./template/' . $def_template . '/'.$templ_gal));
			
if ($templ_gal == 'gallery_gallery.tpl') echo '<div class="container-gallery">';
$kol=0;

	for ($ig=0; $ig<$results_amount; $ig++ )

	{
		$fz = $db->fetcharray  ( $rz );

		if ( $ig%2 == 0 ) $color = $def_form_back_color;
		else $color = $def_background;

		$item = $fz['item'];

$img_images = glob('./gallery/'.$fz[num].'-small.*');
$path_small = $img_images[0];
$path_small2=$def_mainlocation.'/gallery/'.basename($path_small);
$path_full = str_replace('-small','',$path_small2);	

$img_src="$def_mainlocation/includes/classes/resize.php?src=$path_small2&h=$w_h_gal_def[0]&w=$w_h_gal_def[1]&zc=1";
			
if ($_SESSION['gallery'] == 'list_full') $img_src = $path_small2;

		$thumb = "<a class='thumbnail' href='$path_full' onclick='return hs.expand(this)'><img src='$img_src' border='0' alt='$fz[item]' title='$fz[item]'></a><span class='highslide-caption'>$fz[item]</span>";

		$thumb_full = "<img src='$path_full' border='0' alt='$fz[item]' title='$fz[item]'>";

		if ($fz["message"]!="") $message=$fz[message]; else $message="";
            
                $date_add = Undate($fz[date], $def_datetype);
                
                $template = new Template;

                $template->load($template_sub_gallery);

                if ($def_image_company=="YES") {
                    $res2 = $db->query  ( "SELECT firmname, category FROM $db_users WHERE selector='$fz[firmselector]'");
                    $fet = $db->fetcharray  ( $res2 );
                    $db->freeresult  ( $res2 );
                    $category_list = explode(":", $fet[category]);
                    $category_list = explode("#", $category_list[0]);

                    if ($def_rewrite == "YES") $item = '<a href="'.$def_mainlocation.'/gallery-'.$fz[firmselector].'-0-'.$category_list[0].'-'.$category_list[1].'-'.$category_list[2].'.html">'.$fz[item].'</a>';
                    else $item = '<a href="'.$def_mainlocation.'/gallery.php?id='.$fz[firmselector].'&amp;cat='.$category_list[0].'&amp;subcat='.$category_list[1].'&amp;subsubcat='.$category_list[2].'">'.$fz[item].'</a>';
                    $company = " [$fet[firmname]]";
                } else { $item = $fz[item]; $company=""; }

                $template->replace("title", "$item");
                $template->replace("company", "$company");
                
                $template->replace("message", "$message");
                $template->replace("date", "$date_add");
                $template->replace("img", "$thumb");
                $template->replace("img_full", "$thumb_full");

                if ($def_rating_img=="NO") $template->replace("rating", "");
                else $template->replace("rating", buildRate($fz['num'], $fz['rateVal']));
                
                $template->replace("color", "$color");

                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");
		
		if (isset($filter_img)) echo '<div class="discounted-item '.$filter_img.'">';

                $template->publish();

		if (isset($filter_img)) echo '</div>';

if ($templ_gal == 'gallery_gallery.tpl') $kol++;
if ($kol==3) { $kol=0; echo '<div class="clearing-gallery"><p>&nbsp;</p></div>'; }

        }
if ($templ_gal == 'gallery_gallery.tpl') echo '<div class="clearing-gallery"><p>&nbsp;</p></div></div>';

unset($filter_img);
?>