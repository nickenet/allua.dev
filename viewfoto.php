<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi & Ilya K.
  =====================================================
  Файл: viewfoto.php
  -----------------------------------------------------
  Назначение: Вывод случайным образом фотографии с фотогалереи
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

$folder = 'foto';

$banners = glob('./' . $folder . '/s_*.*');


if (empty($banners))
{
	return;
}

if ($def_foto_showNum > count($banners))
{
	$def_foto_showNum = count($banners);
}

# Подгрузка всех предложений сразу
$idBanners = array();
for ($num = 0; $num < $def_foto_showNum; $num++)
{
	$bannerKey = array_rand($banners);
	$banner = basename($banners[$bannerKey]);
	unset($banners[$bannerKey]);        

	$nameParts = explode('s_', $banner);                        
	$idBanners[ (int)$nameParts[1] ] = $banner;
}

$sql = 'SELECT * FROM ' . $db_foto . ' WHERE num IN (' . join(', ', array_keys($idBanners)) . ') ORDER BY RAND()';

$fotoDb = $db->query($sql);

$rndserviceTitle = $def_foto_view;

table_top($rndserviceTitle);

while($f_foto = $db->fetcharray($fotoDb))
        
{
    $fotoMessage = isb_sub(strip_tags(stripcslashes($f_foto['message'])),$def_rnd_descr_size);

    $img = $def_mainlocation . '/' . $folder . '/' . $idBanners[ $f_foto['num'] ];    

    include ( "./template/$def_template/randomfoto.php" );
}

table_bottom();

unset($banners);
unset($category);
?>