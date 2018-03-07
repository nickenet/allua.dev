<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: vote.php
-----------------------------------------------------
 Назначение: Управление голосованиями
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$vote_help;

$title_cp = 'Управление голосованиями - ';
$speedbar = ' | <a href="vote.php">Управление голосованиями</a>';

check_login_cp('3_2','vote.php');

require_once 'template/header.php';

table_item_top ('Управление голосованиями','xprof.png');

require 'inc/votetop.php';

if ( get_magic_quotes_gpc() )
{
	foreach ($_POST as $k => $v)
	{
		if ( is_array($v) )
		{
			foreach ($v as $s_k => $s_v)
			{
				$v[$s_k] = stripslashes($s_v);
			}
		}
		else
		{
			$v = stripslashes($v);
		}

		$_POST[$k] = $v;
	}
}

$data = file_exists($cur_file) ? file_get_contents($cur_file) : '';
$data = unserialize($data);

$arc = file_exists($arc_file) ? file_get_contents($arc_file) : '';
$arc = unserialize($arc);
isset($arc['max_id']) ? 0 : $arc['max_id'] = 0;
isset($arc['max_sub_id']) ? 0 : $arc['max_sub_id'] = 0;

if ( !empty($_POST['new']) )
{
	$data = array();
	$data['id'] = ++$arc['max_id'];
	$data['title'] = $_POST['title'];
	$data['total'] = 0;
	$data['list'] = array();
	$tmp = explode("\n", $_POST['subs']);
	foreach ($tmp as $k => $v)
	{
		$v = trim($v);
		if ($v != '')
		{
			$data['list'][ ++$arc['max_sub_id'] ] = array('text' => $v, 'num' => 0);
		}
	}

	file_put_contents($cur_file, serialize($data));
	file_put_contents($arc_file, serialize($arc));
}
elseif (!empty($_POST['save']) && $data['id'] == $_POST['save'])
{
	if ( !empty($_POST['arc']) )
	{
		$arc[] = $data;
		$data = '';
		file_put_contents($cur_file, '');
		file_put_contents($arc_file, serialize($arc));
	}
	else
	{
		$data['title'] = htmlspecialchars_decode($_POST['title']);
		foreach ($_POST['sub_ids'] as $k => $v)
		{
			$data['list'][$k]['text'] = htmlspecialchars_decode($v);
		}

		file_put_contents($cur_file, serialize($data));
	}
}
elseif ( !empty($_POST['back']) && empty($data) )
{
	$_POST['back'] = (int)$_POST['back'];
	foreach ($arc as $k => $v)
	{
		if (is_array($v) && $v['id'] == $_POST['back'])
		{
			$data = $v;
			unset($arc[$k]);
			file_put_contents($cur_file, serialize($data));
			file_put_contents($arc_file, serialize($arc));
			break;
		}
	}
}
elseif ( !empty($_POST['del']) && is_array($arc) )
{
	$_POST['del'] = (int)$_POST['del'];
	foreach ($arc as $k => $v)
	{
		if (is_array($v) && $v['id'] == $_POST['del'])
		{
			unset($arc[$k]);
			file_put_contents($arc_file, serialize($arc));
			break;
		}
	}
}

if ( empty($data) ) : 

table_fdata_top ('Новый опрос');

?>

<form method="post" action="?">
<input name="new" value="now" type="hidden">
<table>
	<tr>
		<td align="right">Заголовок вопроса:</td>
		<td><input name="title" value="" type="text" style="width: 300px" /></td>
	</tr>
	<tr>
		<td align="right">Варианты ответов:<br><font color="#666666">Каждая новая строка является новым вариантом ответа</font></td>
		<td><textarea name="subs" rows="10" cols="20" style="width: 300px"></textarea></td>
	</tr>
	<tr>
		<th colspan="2">
			<input value="Создать" type="submit" style="background:#00FFFF; width: 100px;" />
		</th>
	</tr>
</table><br />
</form>

<? 

table_fdata_bottom();

else : 

table_fdata_top ('Текущий опрос');

?>

<form method="post" action="?">
<input name="save" value="<? echo $data['id']; ?>" type="hidden">
<table>
	<tr>
		<td colspan="3">
			<input name="title" value="<? echo htmlspecialchars($data['title'],ENT_QUOTES,$def_charset); ?>" type="text"
				style="width: 300px" />
		</td>
	</tr>
	<? foreach ($data['list'] as $k => $v) : ?>
	<tr>
		<td>
			<input name="sub_ids[<? echo $k; ?>]" value="<? echo htmlspecialchars($v['text'],ENT_QUOTES,$def_charset); ?>" type="text"
				style="width: 200px" />
		</td>
		<td><? echo $v['num']; ?> | </td>
		<td><? echo @floor($v['num'] / $data['total'] * 100); ?> %</td>
	</tr>
	<? endforeach; ?>
	<tr>
		<th colspan="3">
			<input value="Сохранить" type="submit" style="background:#0066FF; width: 100px;" /><br />
			<input name="arc" value="Архивировать" type="submit" style="background:#FFCC66; width: 100px;" />
		</th>
	</tr>
</table><br />
</form>

<? table_fdata_bottom(); endif;

unset($arc['max_id'], $arc['max_sub_id']);
if ( empty($arc) ) { $msgvotetypes='Архив пуст <br />';} else { $msgvotetypes=''; };

echo '<br />'; table_fdata_top ('Архив опросов');

echo $msgvotetypes; ?>

<table align="left">
<? foreach ($arc as $k => $data) : ?>
	<tbody>
	<tr>
		<td class="slink" align="left">
			<a href="#" onclick="document.getElementById('arc_<? echo $data['id']; ?>').style.display=''">
				<? echo htmlspecialchars($data['title'],ENT_QUOTES,$def_charset); ?>
			</a>
		</td>
		<td colspan="2">
			<form method="post" action="?" style="float: right">
			<input name="del" value="<? echo $data['id']; ?>" type="hidden" />
			<input value="Удалить" type="submit" style="background:#FF3366; width: 100px;" />
			</form>
			<form method="post" action="?" style="float: right">
			<input name="back" value="<? echo $data['id']; ?>" type="hidden" />
			<input value="Вернуть" type="submit" style="background:#00CC66; width: 100px;" />
			</form>
		</td>
	</tr>
	</tbody>
	<tbody id="arc_<? echo $data['id']; ?>" style="display: none">
	<? foreach ($data['list'] as $v) : ?>
	<tr>
		<td class="slink" align="left"><? echo $v['text']; ?></td>
		<td class="slink" align="left"><? echo $v['num']; ?></td>
		<td class="slink" align="left"><? echo @floor($v['num'] / $data['total'] * 100); ?> %</td>
	</tr>
	<? endforeach; ?>
	<tr>
		<td	colspan="3"><br></td>
	</tr>
	</tbody>
<? endforeach; ?>
</table><br />

<?

table_fdata_bottom();

require_once 'template/footer.php';

?>
