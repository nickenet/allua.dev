<? /*

Шаблон вывода товаров и услуг

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<div class="block_offers">
<div><a href="<?php echo $def_mainlocation.'/foto/'; ?>" target="_blank"><img src="<? echo $img; ?>" width="160" border="0" alt="<?php echo $f_foto['item']; ?>"  title="<? echo $fotoMessage; ?>"></a></div>
<div class="title_o"><? echo $f_foto['item']; ?></div>
</div>


