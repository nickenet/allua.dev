<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: socnet_firm.php
-----------------------------------------------------
 Назначение: Подключение социальных страниц компании
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}
                // Социальные сети
                 if ($f['social']!='') {
                 $social = explode(":", $f['social']);

                     if ($social[0]!='') $twitter='<a rel="nofollow" href="https://twitter.com/'.$social[0].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter_big.png" alt="twitter" align="absmiddle" border="0"></a>'; else $twitter='';
                     if ($social[1]!='') $facebook='<a rel="nofollow" href="https://facebook.com/'.$social[1].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook_big.png" alt="facebook" align="absmiddle" border="0"></a>'; else $facebook='';
                     if ($social[2]!='') $vkontakte='<a rel="nofollow" href="https://vk.com/'.$social[2].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte_big.png" alt="vkontakte" align="absmiddle" border="0"></a>'; else $vkontakte='';
                     if ($social[3]!='') $odnoklassniki='<a rel="nofollow" href="https://odnoklassniki.ru/'.$social[3].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki_big.png" alt="odnoklassniki" align="absmiddle" border="0"></a>'; else $odnoklassniki='';

                     $template->replace("twitter", $twitter);
                     $template->replace("facebook", $facebook);
                     $template->replace("vkontakte", $vkontakte);
                     $template->replace("odnoklassniki", $odnoklassniki);


                     if ($social[0]!='') $twitter_print='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter_big.png" alt="twitter" vspace="2" align="absmiddle" border="0"> https://twitter.com/'.$social[0].'<br>'; else $twitter_print='';
                     if ($social[1]!='') $facebook_print='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook_big.png" alt="facebook" vspace="2" align="absmiddle" border="0"> https://facebook.com/'.$social[1].'<br>'; else $facebook_print='';
                     if ($social[2]!='') $vkontakte_print='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte_big.png" alt="vkontakte" vspace="2" align="absmiddle" border="0"> https://vk.com/'.$social[2].'<br>'; else $vkontakte_print='';
                     if ($social[3]!='') $odnoklassniki_print='<img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki_big.png" alt="odnoklassniki" vspace="2" align="absmiddle" border="0"> https://odnoklassniki.ru/'.$social[3]; else $odnoklassniki_print='';

                     $template->replace("twitter_print", $twitter_print);
                     $template->replace("facebook_print", $facebook_print);
                     $template->replace("vkontakte_print", $vkontakte_print);
                     $template->replace("odnoklassniki_print", $odnoklassniki_print);

                 } else {

                     $template->replace("twitter", "");
                     $template->replace("facebook", "");
                     $template->replace("vkontakte", "");
                     $template->replace("odnoklassniki", "");

                     $template->replace("twitter_print", "");
                     $template->replace("facebook_print", "");
                     $template->replace("vkontakte_print", "");
                     $template->replace("odnoklassniki_print", "");

                 }

                 $my_social_page='';
                 $img_my_social_page='';
                 if ($f['domen']!='') {
                     $my_social_page=$def_mainlocation.'/'.$f['domen'];
                     $img_my_social_page='<a rel="nofollow" href="'.$def_mainlocation.'/'.$f['domen'].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/social_big.png" alt="SP" align="absmiddle" border="0"></a>';
                 } 
                 $template->replace("social_link", $my_social_page);
                 $template->replace("img_social_link", $img_my_social_page);

                 if ($_GET['type'] == "print") $qr_print='<img src="https://chart.apis.google.com/chart?cht=qr&chs=150x150&chl='.$def_mainlocation.'/view.php?id='.$f['selector'].'" />'; else $qr_print='';

                 $template->replace("qr_print", $qr_print);
                 $template->replace("id_print", $f['selector']);

?>
