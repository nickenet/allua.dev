<?php /*

Шаблон вывода нижней части расширенного поиска

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

main_table_bottom();

?>

<div style="text-align: left; padding-top: 10px;">
<b>Ссылка на страницу результата поиска</b> - <a href="<?php echo $def_mainlocation; ?>/search-3.php?<?php echo $link_to_find.$link_to_find1; ?>"><?php echo $def_mainlocation; ?>/search-3.php?<?php echo $link_to_find.$link_to_find1; ?></a><br>
<b>Повторить поиск с другими условиями</b> - <a href="<?php echo $def_mainlocation; ?>/search.php"><?php echo $def_mainlocation; ?>/search.php</a><br>
<br><br><b>Также ищут в каталоге:</b><br>
<?php echo $requests->get(10); ?>
</div>