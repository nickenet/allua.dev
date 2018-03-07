<table border="0" cellspacing="2" cellpadding="2">
	<? foreach ($list as $item) : ?>
	<tr>
		<td><? echo $item->showImg(); ?></td>
		<td><? echo $item->showLink(); ?></td>
	</tr>
	<? endforeach; ?>
</table>