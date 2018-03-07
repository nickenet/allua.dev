<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: catweb.php
-----------------------------------------------------
 Назначение: Вывод сайтов компаний
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if (isset($_GET['page'])) $num=intval($_GET['page'])*$def_count_srch;

$template_web=set_tFile('website.tpl');

?>

<script type="text/javascript" src="<? echo "$def_mainlocation/includes/js/"; ?>filter.js"></script>

<?
For ($i=0; $i<$results_amount; $i++ )

{
	$fz = $db->fetcharray  ( $rz );
	$num++;
	$ulr_web=str_replace("http://","",$fz['www']);
	if ($fz[webcounter] != NULL) $web_count=$fz['webcounter']; else $web_count=0;
	if ($fz[business]!="") $busness_web=strip_tags(parseDescription("X", $fz[business])); else $busness_web="<br>";

	$s1[]=$web_count;
        $namefirm[]=isb_sub(chek_meta(strip_tags($fz['firmname'])),15);

                $template = new Template;

                $template->load($template_web);

                $template->replace("company", $fz['firmname']);
                $template->replace("rate", show_rating($fz['rating'],$fz['votes']));
                $template->replace("hit", $web_count);
                $template->replace("description", $busness_web);
                $template->replace("site", $fz['www']);
                $template->replace("url", $ulr_web);
                $template->replace("num", $num);
                
                if ($def_rewrite == "YES") $template->replace("link_site", 'out-'.$fz['selector'].'.html'); else $template->replace("link_site", 'out.php?ID='.$fz['selector']);
                $category_list = explode(":", $fz['category']);
                $category_list = explode("#", $category_list[0]);
                $link_to_firm=$def_mainlocation.'/view.php?id='.$fz['selector'].'&cat='.$category_list[0].'&subcat='.$category_list[1].'&subsubcat='.$category_list[2];
                $template->replace("link", $link_to_firm);

                $img_qr='<a href="https://chart.apis.google.com/chart?cht=qr&chs=250x250&chl='.$fz['www'].'" onclick="return hs.expand(this)"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/qr.png" width="16" height="16" border="0"  alt="QR" title="QR" align="absmiddle"></a><span class="highslide-caption">'.$fz['www'].'</span>';

                $template->replace("qr", $img_qr);

                $filter="";

                if ($fz['social']!='') {

                    $fastquotes = array ("http://", "https://", "twitter.com", "facebook.com", "vk.com", "odnoklassniki.ru", "//", "www.", "www");
                    $fz['social']=str_replace( $fastquotes, '', $fz['social'] );

                 $social = explode(":", $fz['social']);

                     if ($social[0]!='') { $filter.=' twitter'; $twitter='<a rel="nofollow" href="https://twitter.com/'.$social[0].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/twitter.png" alt="twitter" align="absmiddle" border="0"></a>'; } else $twitter='';
                     if ($social[1]!='') { $filter.=' facebook'; $facebook='<a rel="nofollow" href="https://facebook.com/'.$social[1].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/facebook.png" alt="facebook" align="absmiddle" border="0"></a>'; } else $facebook='';
                     if ($social[2]!='') { $filter.=' vkontakte'; $vkontakte='<a rel="nofollow" href="https://vk.com/'.$social[2].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/vkontakte.png" alt="vkontakte" align="absmiddle" border="0"></a>'; } else $vkontakte='';
                     if ($social[3]!='') { $filter.=' odnoklassniki'; $odnoklassniki='<a rel="nofollow" href="https://odnoklassniki.ru/'.$social[3].'" target="_blank"><img src="'.$def_mainlocation.'/template/'.$def_template.'/images/odnoklassniki.png" alt="odnoklassniki" align="absmiddle" border="0"></a>'; } else $odnoklassniki='';

                     $template->replace("twitter", $twitter);
                     $template->replace("facebook", $facebook);
                     $template->replace("vkontakte", $vkontakte);
                     $template->replace("odnoklassniki", $odnoklassniki);

                 } else {

                     $template->replace("twitter", "");
                     $template->replace("facebook", "");
                     $template->replace("vkontakte", "");
                     $template->replace("odnoklassniki", "");

                 }

                if ($fz['map']!="") $filter.=" map";

                $template->replace("filter", $filter);

                $template->replace("dir_to_main", $def_mainlocation);
                $template->replace("color", $color);
                $template->replace("path_to_images", $def_mainlocation . "/template/" . $def_template . "/images");

                $template->publish();

}
 		
?>
