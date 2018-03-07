<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: vote.php
-----------------------------------------------------
 Назначение: Голосование
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$cur_file = '../system/current.dat';
$arc_file = '../system/archive.dat';


function print_results($data)
{
	$n = 0;
	?>
<table style="width: 100%">
	<tr>
		<th colspan="3"><? echo htmlspecialchars($data['title']); ?></th>
	</tr>
	<? foreach ($data['list'] as $v) : ?>
	<tr>
		<td><? echo $v['text']; ?></td>
		<td style="width: 50px; text-align: right"><? echo $v['num']; ?> | </td>
		<td style="width: 50px; text-align: left"><? echo @floor($v['num'] / $data['total'] * 100); ?> %</td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: left">
			<img src="poll<? echo $n++ % 2 ? '' : '_' ?>.gif" style="border: 1px solid black"
				height="10" width="<? echo @floor($v['num'] / $data['total'] * 100); ?>%">
		</td>
	</tr>
	<? endforeach; ?>
	<tr>
		<th colspan="3">Голосов: <? echo $data['total']; ?></th>
	</tr>
</table>

<?php

}

?>