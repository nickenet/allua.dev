<?php

$vote_title="Опрос пользователей";

table_top ($vote_title);

require 'votetop.php';

$data = file_exists($cur_file) ? file_get_contents($cur_file) : '';
$data = unserialize($data);
if ( empty($data) ) :
?>
<center>Все опросы завершены</center><br>
<?php 

else : ?>
<form method="get" action="" id="vote_form" onsubmit="return vote_do()">
<table style="width: 100%">
	<tr>
		<td id="vote_results" style="display: none">
		<?php print_results($data); ?>
		</td>
	</tr>

	<tr>
		<td id="vote_body">

<table style="width: 100%">
	<tr>
		<td colspan="3" align="center"><strong><?php echo htmlspecialchars($data['title'],ENT_QUOTES,$def_charset); ?></strong></td>
	</tr>
	<?php foreach ($data['list'] as $k => $v) : ?>
	<tr>
		<td colspan="2"><input name="vote" value="<?php echo $k; ?>" type="radio" style="border: 0px; background:none"></td>
		<td><?php echo $v['text']; ?></td>
	</tr>
	<?php endforeach; ?>
	<tr>
		<td colspan="3" align="center">
			<input value="Голосовать" type="submit" style="width: 100px;"><br>
			<input value="Результаты" type="submit" style="width: 100px;"><br>
			<img id="vote_pic" src="./images/go.gif" border="0" style="display: none">
		</td>
	</tr>
</table>

		</td>
	</tr>
</table>
</form>
<?php endif; ?>
<?php
table_bottom();
?>
