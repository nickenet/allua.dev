<?php /*

Шаблон вывода типа показа изображений в каталогах (галерея, список, полный)

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<noindex><div style="margin-top: -30px; float: right;"><span id="icon-gal"><a rel="nofollow" href="<?php echo $link_type_list; ?>output=gallery" title="Галерея"><i class="icon-gal icon-gal-gallery <?php echo $active1; ?>"></i></a>&nbsp;&nbsp;<a rel="nofollow" href="<?php echo $link_type_list; ?>output=list" title="Список"><i class="icon-gal icon-gal-list <?php echo $active2; ?>"></i></a>&nbsp;&nbsp;<a rel="nofollow" href="<?php echo $link_type_list; ?>output=list_full" title='Полная версия'><i class="icon-gal icon-gal-list_full <?php echo $active3; ?>"></i></a></span></div></noindex>
