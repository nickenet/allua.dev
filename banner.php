<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: banner.php
-----------------------------------------------------
 Назначение: Трансляция баннеров клиентов
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ( $banner_type == "top" ) $folder = "banner"; else $folder = "banner2";

$banners = glob('./' . $folder . '/{*.jpg,*.gif,*.png,*.bmp}', GLOB_BRACE);

if (empty($banners))
{
	return;
}

$bannerKey = array_rand($banners);
$banner = basename($banners[$bannerKey]);
$nameBanner = explode('.', $banner);
$id_banner = intval($nameBanner[0]);

	$r_banner = $db->query ( "SELECT flag, selector, firmname, category, www, banner_show FROM $db_users WHERE selector='$id_banner'" );
	if ( !$r_banner ) error ( "mySQL Error (banner.php)", mysql_error() );

	$f_banner = $db->fetcharray ($r_banner);

	$bannercounter = $f_banner['banner_show']+1;

	$sql = "UPDATE $db_users SET banner_show = " . $bannercounter . " WHERE selector = '$id_banner'";

	$db->query ( $sql );

	if ( ( $def_banner_link == "WEBSITE" ) AND ( $f_banner['www'] != "" ) AND ( $f_banner['www'] != "http://" ) AND ( ifEnabled ( $f_banner['flag'], "www" ) ))	
                
        { 
            
            echo '<a href="'.$def_mainlocation.'/out.php?ID='.$f_banner['selector'].'&amp;banner" target="_blank"><img src="'.$def_mainlocation.'/'. $folder . '/'. $banners[$rban] .'" border="0" alt="'.$f_banner['firmname'].'"></a>';
            
        }

	else

	{

		$cat_temp = explode (":", $f_banner['category']);
		$category = explode ("#", $cat_temp[0]);

		$link = '<a href="'.$def_mainlocation.'/view.php?id='.$id_banner.'&amp;cat='.$category[0].'&amp;subcat='.$category[1].'&amp;subsubcat='.$category[2].'&amp;type='.$folder.'" target="_blank" title="'.$f_banner['firmname'].'">';

		echo $link.'<img src="'.$def_mainlocation.'/'. $folder .'/'. $banner.'" border="0" alt="'.$f_banner['firmname'].'"></a>';

	}

	$db->freeresult ( $r_banner ) or error ( "mySQL Error (banner.php)", "Can't free mySQL result (banner.php)" );

	unset ( $banner_type, $id_banner,$banners,$category  );

?>