<?php /*

Шаблон вывода сортировки в каталоге изображений

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<noindex>

<div style="float:left;" class="btn-group"><span class="btn btn-default"><?php echo $v_sort1; ?> Название</span><span class="btn btn-default"><?php echo $v_sort2; ?> Цена</span><span class="btn btn-default"><?php echo $v_sort3; ?> Дата</span></div>

<div align="right" style="padding: 3px;"><a rel="nofollow" href="<?php echo $def_mainlocation; ?>/alloffers.php?category=<?php echo $category_offers; ?>&type=1"><?php echo $def_offer_1_s; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/alloffers.php?category=<?php echo $category_offers; ?>&type=2"><?php echo $def_offer_2_s; ?></a> | <a rel="nofollow" href="<?php echo $def_mainlocation; ?>/alloffers.php?category=<?php echo $category_offers; ?>&type=3"><?php echo $def_offer_3_s; ?></a> | <a rel="nofollow" href="<?php $def_mainlocation; ?>/alloffers.php?category=<?php echo $category_offers; ?>&type=ALL">Показать все</a> | </noindex><a href="<?php echo $def_mainlocation; ?>/rss.php?category=<?php echo $category_offers; ?>&type=1">Rss</a> <img src="<?php echo $def_mainlocation; ?>/images/rss.gif" border="0" align="absmiddle" alt="rss"></div>

<?php if ($razdel!='') { ?>
<div align="right" style="padding: 15px;">
<form action="" method="post" class="form-control">
<select style="width: 250px;" name="go_subcat_offer" onchange="this.form.submit();"><option value="ALL">Все подразделы</option><?php echo $razdel; ?></select>
</form>
</div>
<?php } ?>

</noindex>
