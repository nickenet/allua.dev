<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: price_view.php
-----------------------------------------------------
 Назначение: Вывод прайс-листов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$template_xls=set_tFile('prices.tpl');

        for ($it=0; $it<$results_amount; $it++ )
	{
		$fz = $db->fetcharray  ( $rz );

		if ( $it%2 == 0 ) $color = $def_form_back_color;
		else $color = $def_background;
                
                $date_add = undate($fz['date'], $def_datetype);
		$item = $fz['item'];
                if ( $fz['message']!='' ) $message=$fz['message']; else $message='';

                $files_e = glob('exel/'.$fz['num'].'.*');
                if ($files_e[0]!='') $link_e = $def_mainlocation.'/'.$files_e[0]; else $link_e='#';

                $fSize	= filesize($files_e[0]);
                $fSize	= round(($fSize / 1024),2) . ' KB';
                $ext = pathinfo('exel/'.$files_e[0], PATHINFO_EXTENSION);

                $template = new Template;

                $template->load($template_xls);

                $company='';
                $category_list = explode(":", $fz['category']);
                $category_list = explode("#", $category_list[0]);
                if ($allxls=="YES") { if ($def_rewrite == "YES") $company='&nbsp;[&nbsp;<a href="'.$def_mainlocation.'/excel-'.$fz['firmselector'].'-0-'.$category_list[0].'-'.$category_list[1].'-'.$category_list[2].'.html">'.$fz['firmname'].'</a>&nbsp;]&nbsp;'; else $company='&nbsp;[&nbsp;<a href="'.$def_mainlocation.'/exel.php?id='.$fz['firmselector'].'&cat='.$category_list[0].'&subcat='.$category_list[1].'&subsubcat='.$category_list[2].'">'.$fz['firmname'].'</a>&nbsp;]&nbsp;'; }
                if ($allxls=="SEARCH") $company='&nbsp;[&nbsp;<noindex><a rel="nofollow" href="'.$def_mainlocation.'/exel.php?id='.$fz['firmselector'].'&cat='.$category_list[0].'&subcat='.$category_list[1].'&subsubcat='.$category_list[2].'">'.$def_xls_all.' &raquo;</a></noindex>&nbsp;]&nbsp;';
                 
                
                $template->replace("date", $date_add);
		$template->replace("title", $item);
                $template->replace("shortprice", $message);
                $template->replace("link", $link_e);
                $template->replace("size", $fSize);

                $icon_type = glob('./images/icoprice/'.$ext.'.*');
                $icon_type_img = basename($icon_type[0]);

                $template->replace("ico", "<img alt=\"$ext\" src=\"$def_mainlocation/images/icoprice/$icon_type_img\" border=\"0\" />" );
                $template->replace("ext", $ext);

                $template->replace("company", $company);

                $template->replace("color", $color);
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");
                
                require 'includes/apx/apx_price.php'; // Подключаем дополнительный контент (для сторонних разработок)
                
                $template->publish();
        }        

?>
