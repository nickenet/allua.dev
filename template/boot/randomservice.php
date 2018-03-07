<?php /*

Шаблон вывода товаров и услуг

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<div class="block_offers">

<div><a href="<?php echo $link; ?>" target="_blank"><img src="<?php echo $img; ?>" width="150" border="0" alt="<?php echo $offer['firmname']; ?>"></a></div>
<div class="title_o"><?php echo $offer['item']; ?></div>
<?php if ($offerMessage != '') echo '<div>' . $offerMessage . '</div>'; ?>

</div>
<?php if ($offer['price'] != '') echo '<div class="price_o ">'.$offer['price'].'</div>'; ?>


