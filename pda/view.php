<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Maid
=====================================================
 Файл: view.php
-----------------------------------------------------
 Назначение: Страница компании
=====================================================
*/

include ("./defaults.php");

$kPage = 0;

if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

$r = $db->query ( "SELECT * FROM $db_users WHERE selector='$id' and firmstate='on' $hide_d" );

if ( $db->numrows($r) == 1 )

{
	$f = $db->fetcharray ( $r );

$incomingline_firm=$f['firmname'];
$url_full_version = 'view.php?id='.$id.'&mobile=no';

include ( "./template/$def_template/header.php" );

		if ($def_onlypaid == "YES") $hide_d=" AND flag <> 'D' ";

		$template_sub = implode ('', file('./template/' . $def_template . '/main_' . strtolower($f[flag]) . '.tpl'));

		$template = new Template;

		$template->load($template_sub);

		$template->replace("directory_url", "$def_title / " . $def_mainlocation_pda . "/view.php?id=" . $f[selector]);

		$template->replace("flag", $f['flag']);
                $template->replace("id", $f['selector']);
                if (($f['off_mail'] != '1') and ($f['mail']!='')) {
                    $mail = "<span class=\"icon-tmf-s\"></span> <a href=$def_mainlocation_pda/mail.php?id=".$f['selector'].">$def_sendmessage</a>";
                    $template->replace("mail", $mail);
                } else $template->replace("mail", "");

		$template->replace("company", $f['firmname']);
		$template->replace("description", strip_tags($f['business'],'<li><br><br />'));

		$template->replace("date", undate($f['date'], $def_datetype));

		$location_r = $db->query  ( "SELECT location FROM $db_location WHERE locationselector = '$f[location]'" );
                $location_f = $db->fetcharray   ( $location_r );

                if ( $def_country_allow == "YES" ) { $country = $location_f['location']; $city = $f['city']; }
                if ( $def_country_allow != "YES" ) { $city = $location_f['location']; $country = ""; }
                if ( $def_states_allow == "YES" ) {
                    $state_r = $db->query  ( "SELECT state FROM $db_states WHERE stateselector = '$f[state]'" );
                    $state_f = $db->fetcharray   ( $state_r );
                    $state = $state_f['state'];
                } else $state = "";


                if ($country!='') $template->replace("country", "$country<br />"); else $template->replace("country", "");
                if ($state!='') $template->replace("state", "$state<br />"); else $template->replace("state", "");
                if ($city!='') $template->replace("city", "$city, "); else $template->replace("city", "");

                $fastquotes = array (' ', '(', ')', '-', '\\', '"', "{", "}", "[", "]", "<", ">");

                if ($f['phone']!='') {
                    $phone=str_replace( $fastquotes, '', $f['phone'] );
                    $phone=str_replace( ';', ',', $phone );
                    $phone=explode(",", $phone);
                
                    unset($pvalue);
                    $tophone="<div class=\"padr\"><span class=\"icon-tmf-t\"></span>";

                        foreach ($phone as $pvalue) {
                            $tophone.="<a href=\"tel:$pvalue\" class=\"tphone\">$pvalue</a>&nbsp;|&nbsp;";
                        }

                    $tophone.='</div>';

                }
                
                if ((ifEnabled($f[flag], "phone")) and  ($tophone!='')) $template->replace("phone", $tophone); else $template->replace("phone", "");

                if ($f['mobile']!='') {
                    $mobile=str_replace( $fastquotes, '', $f['mobile'] );
                    $mobile=str_replace( ';', ',', $mobile );
                    $mobile=explode(",", $mobile);

                    unset($mvalue);
                    $topmobile="<div class=\"padr\"><span class=\"icon-tmf-m\"></span>";

                        foreach ($mobile as $mvalue) {
                            $topmobile.="<a href=\"tel:$mvalue\" class=\"tphone\">$mvalue</a> | ";
                        }

                    $topmobile.='</div>';
                }

                if ((ifEnabled($f[flag], "mobile")) and  ($f['mobile']!='')) $template->replace("mobile", $topmobile); else $template->replace("mobile", "");
                
                if ($f['fax']!='') {
                    $fax=str_replace( $fastquotes, '', $f['fax'] );
                    $fax=str_replace( ';', ',', $fax );
                    $fax=explode(",", $fax);

                    unset($fvalue);
                    $topfax="<div class=\"padr\"><span class=\"icon-tmf-f\"></span>";

                        foreach ($fax as $fvalue) {
                            $topfax.="<a href=\"tel:$fvalue\" class=\"tphone\">$fvalue</a> | ";
                        }

                    $topfax.='</div>';
                }

                if ((ifEnabled($f[flag], "fax")) and  ($f['fax']!='')) $template->replace("fax", $topfax); else $template->replace("fax", "");

                if ((ifEnabled($f[flag], "address")) and  ($f['address']!='')) $template->replace("address", "<div class=\"padr\"><span class=\"icon-tmf-c\"></span><span class=\"adress\">".$f['address']."</span></div>"); else $template->replace("address", "");
                if (ifEnabled($f[flag], "zip") and  ($f['zip']!='')) $template->replace("zip", $f['zip'].', '); else $template->replace("zip", "");
                         
                if (ifEnabled($f[flag], "manager") and  ($f['manager']!='')) $template->replace("contact", "<div class=\"padr\"><span class=\"icon-tmf-u\"></span>$f[manager]</div>"); else $template->replace("contact", "");
                
		if ( (ifEnabled($f['flag'], "www")) and ($f['www'] != "") ) $template->replace("www", "<div class=\"padr\"><a href=\"$def_mainlocation/out.php?ID=$f[selector]\" target=\"new\">$f[www]</a></div>"); else $template->replace("www", "");
                if ($f[icq] != "") $template->replace("icq", "<div class=\"padr\"><a href=\"http://www.icq.com/people/$f[icq]\">$f[icq]</a><img src=\"http://web.icq.com/whitepages/online?icq=$f[icq]&amp;img=5\" align=\"absmiddle\"></div>"); else $template->replace("icq", "");

		$template->replace("hits", $f['counter']);

		$template->replace("path_to_images", $def_mainlocation_pda . "/template/" . $def_template . "/images");

		$template->replace("reserved_1", $f[reserved_1]);
		$template->replace("reserved_2", $f[reserved_2]);
		$template->replace("reserved_3", $f[reserved_3]);
        
                // Положение на карте

                $parts_wh = array();
                preg_match('#hym(\d+)#', $template_sub, $parts_wh);
                $height_map = $parts_wh[1];
                $replace_maps_tags='Yandex_map_hym'.$height_map;

                if (($f['map']!='') and (ifEnabled($f['flag'], "maps"))) {

		$maps_view_all=explode(',',$f['map']);
		$shirota=round($maps_view_all[0],3);
		$dolgota=round($maps_view_all[1],3);

		$template->replace("shirota", $shirota); $template->replace("dolgota", $dolgota);
                $template->replace("koordinata", $def_koord);
                $template->replace("shirota_text", $def_shirota); $template->replace("dolgota_text", $def_dolgota);
                
                $yandex_mobile_map = "<div id=\"ymap\" class=\"border_maps\" style=\"width:100%;height:".$height_map."px;\"></div> 
                <script src=\"https://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU\" type=\"text/javascript\"></script>
                             
                <script type=\"text/javascript\">
                        ymaps.ready(init);
			function init () {
				var myMap = new ymaps.Map(\"ymap\", {
					center: [".$f['map']."],
					zoom: $def_map_zoom,
					type: 'yandex#".$f['mapstype']."'
				}),
				myPlacemark = new ymaps.Placemark([".$f['map']."], {
					// Свойства
					iconContent: '".$f['firmname']."'
				}, {
					// Опции
					preset: 'twirl#blueStretchyIcon' // иконка растягивается под контент
				});
				// Добавляем метку на карту
				myMap.geoObjects.add(myPlacemark);
				myMap.controls
				.add('typeSelector')
				.add('smallZoomControl', { right: 5, top: 75 });
			}
		</script>";
		
                        $template->replace($replace_maps_tags, $yandex_mobile_map);

                } else {
                    $template->replace($replace_maps_tags, "");
                    $template->replace("shirota", ""); $template->replace("dolgota", "");
                    $template->replace("koordinata", "");
                    $template->replace("shirota_text", ""); $template->replace("dolgota_text", "");
                }

                // Социальные сети
                 if (($f['social']!=':::') and ($f['social']!='')) {
                 $social = explode(":", $f['social']);

                     if ($social[0]!='') $twitter='<a rel="nofollow" href="https://twitter.com/'.$social[0].'" target="_blank"><img src="'.$def_mainlocation_pda.'/template/'.$def_template.'/images/twitter_big.png" alt="twitter" align="absmiddle" border="0"></a>'; else $twitter='';
                     if ($social[1]!='') $facebook='<a rel="nofollow" href="https://facebook.com/'.$social[1].'" target="_blank"><img src="'.$def_mainlocation_pda.'/template/'.$def_template.'/images/facebook_big.png" alt="facebook" align="absmiddle" border="0"></a>'; else $facebook='';
                     if ($social[2]!='') $vkontakte='<a rel="nofollow" href="https://vk.com/'.$social[2].'" target="_blank"><img src="'.$def_mainlocation_pda.'/template/'.$def_template.'/images/vkontakte_big.png" alt="vkontakte" align="absmiddle" border="0"></a>'; else $vkontakte='';
                     if ($social[3]!='') $odnoklassniki='<a rel="nofollow" href="https://odnoklassniki.ru/'.$social[3].'" target="_blank"><img src="'.$def_mainlocation_pda.'/template/'.$def_template.'/images/odnoklassniki_big.png" alt="odnoklassniki" align="absmiddle" border="0"></a>'; else $odnoklassniki='';

                     $template->replace("twitter", $twitter);
                     $template->replace("facebook", $facebook);
                     $template->replace("vkontakte", $vkontakte);
                     $template->replace("odnoklassniki", $odnoklassniki);
                     $template->replace("[/div_socnet]", '</div>');
                     $template->replace("[div_socnet]", '<div class="socnet">');


                 } else {

                     $template->replace("twitter", "");
                     $template->replace("facebook", "");
                     $template->replace("vkontakte", "");
                     $template->replace("odnoklassniki", "");
                     $template->replace("[/div_socnet]", "");
                     $template->replace("[div_socnet]", "");
                 }

                 $my_social_page='';
                 $img_my_social_page='';
                 if ($f['domen']!='') {
                     $my_social_page=$def_mainlocation.'/'.$f['domen'];
                     $img_my_social_page='<a rel="nofollow" href="'.$def_mainlocation.'/'.$f['domen'].'" target="_blank"><img src="'.$def_mainlocation_pda.'/template/'.$def_template.'/images/social_big.png" alt="SP" align="absmiddle" border="0"></a>';
                 }
                 $template->replace("social_link", $my_social_page);
                 $template->replace("img_social_link", $img_my_social_page);

	   	$template->publish();

                $ip_table=$f['counterip']; $hits_d=($f['hits_d']); $hits_m=intval($f['hits_m']);
                require 'includes/stat.php'; // Подключаем файл статистики

	include ( "./template/$def_template/footer.php" );

}

else

{
 header("HTTP/1.1 301 Moved Permanently");
 header('Location: ' . $def_mainlocation . '/' . $def_pda);
 exit();
}

?>