<? /*

Шаблон вывода товаров и услуг

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<table width="99%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center"><a href="<? echo $link; ?>" target="_blank"><img src="<? echo $img; ?>" width="150" border="0" alt="<? echo $offer['firmname']; ?>"><br /></a>
        </td>
    </tr>
    <tr>
	<td align="center"><strong><? echo $offer['item']; ?></strong></td>
    </tr>
<? if ($offerMessage != '') echo '<tr><td>' . $offerMessage . '</td></tr>'; ?>
<? if ($offer['price'] != '') echo '<tr><td align="right" style="padding-top:2px; padding-bottom:2px; padding-right:3px;">'.$offer['price'].'</td></tr>'; ?>
</table>
<br />
