<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: catoffers.php
-----------------------------------------------------
 Назначение: Вывод продукции и услуг
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($full_offers_array!="YES") $template_sub_offers = implode ('', file('./template/' . $def_template . '/short_offers.tpl'));
else $template_sub_offers = implode ('', file('./template/' . $def_template . '/full_offers.tpl'));

 	For ($i=0; $i<$results_amount; $i++ )

 	{
 		If ($full_offers_array!="YES") $fz = $db->fetcharray ($rz);

 		If ( $i%2 == 0 ) $color = $def_form_back_color;
 		Else $color = $def_background;

 		$item = $fz['item'];
                $thumb="";
                $noimage="";

                $thumb = glob('./offer/'.$fz['num'].'-small.*');
                if ($thumb[0]!='') $thumb = '<a href="'.$def_mainlocation.'/offer/'.$fz[num].'.jpg" onclick="return hs.expand(this)"><img src="'.$def_mainlocation.'/offer/'.basename($thumb[0]).'" border="0"  alt="'.$item.'" title="'.$item.'"></a><span class="highslide-caption">'.$item.'</span>';
                else $thumb = "";

                if ($thumb=="") $noimage='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/noimage.gif" border="0"  alt="нет изображения" title="нет изображения">';

 		$type = "";

 		If ( $fz[type] == "1" ) { $type = $def_offer_1_s; $class_type='oType1'; }
 		If ( $fz[type] == "2" ) { $type = $def_offer_2_s; $class_type='oType2'; }
 		If ( $fz[type] == "3" ) { $type = $def_offer_3_s; $class_type='oType3'; }

 		if ($fz[quantity]!='') { $txt_quantity=$def_offers_quantity; $quantity = $fz[quantity]; } else { $quantity=''; $txt_quantity=''; }
 		if ($fz[packaging]!='') { $txt_packaging=$def_offers_packaging; $packaging = $fz[packaging]; } else { $txt_packaging=''; $packaging = ''; }
 		if ($fz[price]!='') { $txt_price=$def_offers_price; $price = $fz[price]; } else { $txt_price=''; $price = ''; }

		If ($last10_offers=="YES")
			{
			$maincatx = Explode (":", $fz[category]);
			$maincat = Explode ("#", $maincatx[0]);
			$category_offers = $maincat[0];
			$cat=$maincat[0];
			$subcat=$maincat[1];
			$subsubcat=$maincat[2];
			}

                If (($search_offers_true=="YES") or ($full_offers_array=="YES"))
			{
                    $res_category = $db->query  ( "SELECT category FROM $db_users WHERE selector='$fz[firmselector]'");
                    $fet_category = $db->fetcharray  ( $res_category );
			$maincatx = Explode (":", $fet_category[category]);
			$maincat = Explode ("#", $maincatx[0]);
			$category_offers = $maincat[0];
			$cat=$maincat[0];
			$subcat=$maincat[1];
			$subsubcat=$maincat[2];
			}


		if ($full_offers_array!="YES") $item="<a href=\"$def_mainlocation/alloffers.php?idfull=$fz[firmselector]&amp;full=$fz[num]&amp;catfirm=$category_offers\" Title=\"$fz[firmname]\"><strong>$item</strong></a>";
		else $item="<strong>$item</strong>";

 		$class_offers='company'.$fz[flag];

 		If ($fz["message"]!='') $message=$fz['message']; else $message='';

                if (($def_short_message_offers!=0) and ($full_offers_array!="YES")) $message=isb_sub(strip_tags(stripcslashes($message),'<li><br><br />'),$def_short_message_offers);

 		$date_day = Date ( "d" );
 		$date_month = Date ( "m" );
 		$date_year = Date ( "y" );

 		List ( $on_year, $on_month, $on_day ) = preg_split ( '#[/.-]#', $fz[date] );

 		$first_date = Mktime ( 0,0,0,$on_month,$on_day,$on_year );
 		$second_date = Mktime ( 0,0,0,$date_month,$date_day,$date_year );

 		If ( $second_date > $first_date ) $days = $second_date-$first_date;
 		Else $days = $first_date-$second_date;

 		$current_result =  Round( $fz[period] - ( ( $days ) / ( 60 * 60 * 24 ) ) );
                
                $date_add = Undate($fz[date], $def_datetype);
                
                $template = new Template;

                $template->load($template_sub_offers);
                
                $template->replace("title", $item);
                $template->replace("type", $type);
                $template->replace("shortstory", $message);
                $template->replace("date", $date_add);

                if ($fz['period']!=0) {
                    $template->replace("resilt", $current_result);
                    $template->replace("txt_resilt", $def_days_left);
                }
                else {
                    $template->replace("resilt", $def_period_offers);
                    $template->replace("txt_resilt", "");
                }

                $template->replace("img", $thumb);
                $template->replace("noimage", $noimage);
                $template->replace("txt_quantity", $txt_quantity);
                $template->replace("quantity", $quantity);
                $template->replace("txt_packaging", $txt_packaging);
                $template->replace("packaging", $packaging);
                $template->replace("txt_price", $txt_price);
                $template->replace("price", $price);
                
                $template->replace("color", $color);
                $template->replace("class_offers", $class_offers);
                $template->replace("class_otype", $class_type);
             
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                $template->publish();

 	}
?>
