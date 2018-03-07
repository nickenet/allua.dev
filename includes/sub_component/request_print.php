<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: request_print.php
-----------------------------------------------------
 Назначение: Печать заявки товара или услуги
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$full_req = intval($_GET['full']);

$data_req = safeHTML($_GET['data']);
$number_req=intval($_GET['number']);

	$r = $db->query  ( "SELECT firmname, selector, map, mapstype, address, phone, mobile FROM $db_users WHERE selector = '$id' LIMIT 1" );
        $f = $db->fetcharray  ( $r );
	
	$rz = $db->query  ( "SELECT * FROM $db_offers WHERE num = '$full_req' LIMIT 1" );
	$fz = $db->fetcharray  ( $rz );

                $thumb = glob('./offer/'.$full_req.'-small.*');
                if ($thumb[0]!='') $img_req='<img src="'.$def_mainlocation.'/offer/'.basename($thumb[0]).'" hspace="3" vspace="3" />';


                if ($thumb[0]=="") $img_req='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/noimage.gif" border="0"  hspace="3" vspace="3" alt="Нет изображения" title="Нет изображения">';

 		$type = "";

 		If ( $fz[type] == "1" ) { $type = $def_offer_1_s; $class_type='oType1'; }
 		If ( $fz[type] == "2" ) { $type = $def_offer_2_s; $class_type='oType2'; }
 		If ( $fz[type] == "3" ) { $type = $def_offer_3_s; $class_type='oType3'; }

 		if ($fz[quantity]!='') { $txt_quantity=$def_offers_quantity; $quantity = $fz[quantity]; } else { $quantity=''; $txt_quantity=''; }
 		if ($fz[packaging]!='') { $txt_packaging=$def_offers_packaging; $packaging = $fz[packaging]; } else { $txt_packaging=''; $packaging = ''; }
 		if ($fz[price]!='') { $txt_price=$def_offers_price; $price = $fz[price]; } else { $txt_price=''; $price = ''; }


		$link_offer=$def_mainlocation.'/alloffers.php?idfull='.$id.'&full='.$full_req;
                $link_firm=$def_mainlocation.'/view.php?id='.$id;

 		if ($fz['message']!='') $message=$fz['message']; else $message='';
                
                $template_sub = implode ('', file('./template/' . $def_template . '/request_print.tpl'));

                $template = new Template;

                $template->load($template_sub);
                // $template->set_file('request_print.tpl');
                
                $parts_wh = array();
                preg_match('#wym(\d+)_hym(\d+)#', $template_sub, $parts_wh);
                $widht_map = $parts_wh[1];
                $height_map = $parts_wh[2];
                $replace_maps_tags='Yandex_map_wym'.$widht_map.'_hym'.$height_map;
                
                $template->replace("title", $fz['item']);
                $template->replace("type", $type);
                $template->replace("shortstory", $message);
                $template->replace("date", $date_add);
                $template->replace("resilt", "$current_result");
                $template->replace("txt_resilt", "$def_days_left");
                $template->replace("img", $img_req);
                $template->replace("txt_quantity", $txt_quantity);
                $template->replace("quantity", $quantity);
                $template->replace("txt_packaging", $txt_packaging);
                $template->replace("packaging", $packaging);
                $template->replace("txt_price", $txt_price);
                $template->replace("link_req", $link_offer);
                $template->replace("price", $price);
                $template->replace("number", $number_req);
                $template->replace("data", $data_req);
                $template->replace("company", $f['firmname']);
                $template->replace("address", $f['address']);
                $template->replace("phone", $f['phone']);
                $template->replace("mobile", $f['mobile']);
                $template->replace("link_firm", $link_firm);
                
                if ($f['map']!='') {
                $maps_view_all=explode(',',$f['map']);
		$shirota=round($maps_view_all[0],3);
		$dolgota=round($maps_view_all[1],3);

		$template->replace("shirota", $shirota); $template->replace("dolgota", $dolgota);
                $template->replace("koordinata", $def_koord);
                $template->replace("shirota_text", $def_shirota); $template->replace("dolgota_text", $def_dolgota);

			$type_static_map="map";
			if ($f['mapstype']=="map") $type_static_map="map";
			if ($f['mapstype']=="satellite") $type_static_map="sat";
			if ($f['mapstype']=="hybrid") $type_static_map="sat,skl";
			if ($f['mapstype']=="publicMap") $type_static_map="pmap";
			if ($f['mapstype']=="publicMapHybrid") $type_static_map="pmap,sat,skl";


                $ymap="<img src=\"http://static-maps.yandex.ru/1.x/?ll=$dolgota,$shirota&size=$widht_map,$height_map&z=$def_map_zoom&l=$type_static_map&pt=$dolgota,$shirota\" />";
		$template->replace("$replace_maps_tags",$ymap);
                } else { 
                $template->replace("$replace_maps_tags","");
		$template->replace("shirota", ""); $template->replace("dolgota", "");
                $template->replace("koordinata", "");
                $template->replace("shirota_text", ""); $template->replace("dolgota_text", "");
		}

                
                $qr_firm='<img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$def_mainlocation.'/view.php?id='.$id.'" />';
                $qr_offer='<img src="http://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$def_mainlocation.'/alloffers.php?idfull='.$id.'&full='.$full_req.'" />';
                
                $template->replace("qr_firm", $qr_firm);
                $template->replace("qr_req", $qr_offer);
                
                $url_dir=$def_mainlocation.'/alloffers.php?id='.$id.'&full='.$full_req.'&data='.$data_req.'&number='.$number_req.'&print=request';
                
                $template->replace("directory_url", $url_dir);
                
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                $template->publish();
?>
