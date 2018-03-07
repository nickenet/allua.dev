<? /*

Шаблон вывода товаров и услуг

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center"><a href="<?php echo $def_mainlocation.'/foto/'; ?>" target="_blank"><img src="<? echo $img; ?>" width="160" border="0" alt="<?php echo $f_foto['item']; ?>"  title="<? echo $fotoMessage; ?>"></a><br /></td>
    </tr>
    <tr>
	<td align="center"><strong><? echo $f_foto['item']; ?></strong></td>
    </tr>
</table>
<br />


