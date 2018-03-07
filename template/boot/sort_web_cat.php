<?php /*

Шаблон вывода сортировки в сайтах организаций

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>
<div style="text-align: right;"><b><?php echo $def_sort; ?>&nbsp;</b><a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allweb.php?category=<?php echo $category_web; ?>&sort=2"><?php echo $def_sort_firm; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allweb.php?category=<?php echo $category_web.$pages_offers; ?>&sort=1"><?php echo $def_sort_data; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/allweb.php?category=<?php echo $category_web; ?>&amp;sort=4"><?php echo $def_sort_rating; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/rss.php?category=<?php echo $category_web; ?>&type=2">Rss</a> <img alt="rss изображений" src="<?php echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" />
    <div id="flavor-nav"><a rel="all" href="#">Все</a> | <a rel="twitter" href="#">twitter</a> | <a rel="facebook" href="#">facebook</a> | <a rel="vkontakte" href="#">В контакте</a> | <a rel="odnoklassniki" href="#">Одноклассники</a> | <a rel="map" id="maps" href="#">Показать на карте</a></div>

<?php if ($razdel!='') { ?>

<form action="" method="post" class="form-control">
<select style="width: 250px;" name="go_subcat_web" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><?php echo $razdel; ?></select>
</form>

<?php } ?>

</div>

<div id="results_map"></div>
</noindex>
