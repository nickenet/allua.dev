<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: maps_find.php
-----------------------------------------------------
 Назначение: Выборка данных с карты
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

 if ($results_maps>0) {
for ( $maps=0; $maps<$results_maps; $maps++ )
{
$fmaps = $db->fetcharray  ( $rmaps );

	if ($fmaps['map'] != '') {
            
            $maps_view = 'YES';
	$coords.="[$fmaps[map]],";

	switch($fmaps[flag]){
		case 'A': $iconFlag=$def_map_iconA;	break;
                case 'B': $iconFlag=$def_map_iconB;	break;
		case 'C': $iconFlag=$def_map_iconC;	break;
                default: $iconFlag=$def_map_iconD;
	}

$styleKeys.="$iconFlag,";
							 
	$Header.="'$fmaps[firmname]',";
	$link='<a href="'.$def_mainlocation.'/view.php?id='.$fmaps[selector].'">'.$def_page_mobile.'</a>';
	$Footer.="'$link',";
	
	}
}
$coords= rtrim($coords, ',');

}


?>
