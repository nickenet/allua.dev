<?php
$cur_file = './system/current.dat';
$arc_file = './system/archive.dat';


function print_results($data)
{

global $def_charset;
global $def_mainlocation;

	$n = 0;
	?>
<table style="width: 100%">
	<tr>
		<td colspan="3"><strong><?php echo htmlspecialchars($data['title'],ENT_QUOTES,$def_charset); ?></strong></td>
	</tr>
	<?php foreach ($data['list'] as $v) : ?>
	<tr>
		<td><?php echo $v['text']; ?></td>
		<td style="width: 50px; text-align: right"><?php echo $v['num']; ?> | <?php echo @floor($v['num'] / $data['total'] * 100); ?> %</td>
		<td></td>
	</tr>
	<tr>
		<td colspan="3" style="text-align: left">
			<img src="<?php echo $def_mainlocation; ?>/images/poll<? echo $n++ % 2 ? '' : '_' ?>.gif" style="border: 1px solid black"
				height="10" width="<?php echo @floor($v['num'] / $data['total'] * 100); ?>%">
		</td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="3" style="text-align: center"><strong>Всего проголосовало: <?php echo $data['total']; ?></strong></td>
	</tr>
</table>
	<?php
}

?>