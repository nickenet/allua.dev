<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: menu.php
-----------------------------------------------------
 Назначение: Трансляция меню
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

require_once 'includes/menu_classes.php';

menuAdmin::loadData();

$list = array_filter(menuAdmin::$list, array('menuAdmin', 'filterActive'));
uasort($list, array('menuAdmin', 'sortShow'));

table_top ($def_menu);

    require './template/'.$def_template.'/menu.php';

table_bottom ();

?>

