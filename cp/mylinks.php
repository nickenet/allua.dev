<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi
  =====================================================
  Файл: mylinks.php
  -----------------------------------------------------
  Назначение: Управление ссылками
  =====================================================
 */
session_start();
ob_start();

require_once './defaults.php';

$help_section = (string)$mylinks_help;

$title_cp = 'Мои ссылки - ';
$speedbar = ' | <a href="mylinks.php">Мои ссылки</a>';

check_login_cp('3_10', 'mylinks.php');

$messages = array();
$showAjax = !empty($_REQUEST['ajax']);
$action = empty($_REQUEST['action']) ? '' : $_REQUEST['action'];
switch ($action)
{
	case 'new':
		{
			$sql = array();
			$sql[] = 'date=NOW()';
			foreach (array('name', 'url', 'metka') as $key)
			{
				$val = iconv('utf-8', 'windows-1251', $_REQUEST[$key]);
				$sql[] = $key . ' = "' . mysql_real_escape_string($val) . '"';
			}

			$sql = 'INSERT INTO ' . $db_links . ' SET ' . join(', ', $sql);
			$res = $db->query($sql);
			if ($res)
			{
				$messages[] = 'Ссылка успешно добавлена.';
			}
			else
			{
				$messages[] = 'Ошибка при добавлении ссылки.';
			}
		}
		break;

	case 'save':
		{
			$sql = array();
			foreach (array('selector', 'name', 'url', 'metka') as $key)
			{
				$val = iconv('utf-8', 'windows-1251', $_REQUEST[$key]);
				$sql[] = $key . ' = "' . mysql_real_escape_string($val) . '"';
			}

			$sql = 'INSERT INTO ' . $db_links . ' SET ' . join(', ', $sql) . '
				ON DUPLICATE KEY UPDATE name = VALUES(name), url = VALUES(url), metka = VALUES(metka)';
			$res = $db->query($sql);
			if ($res)
			{
				$messages[] = 'Сохранено успешно.';
			}
			else
			{
				$messages[] = 'Ошибка при сохранении.';
			}
		}
		break;

	case 'mass_delete':
		{
			$list = array();
			foreach ($_REQUEST['links'] as $id)
			{
				$list[] = (int)$id;
			}

			$list = array_unique($list);
			$sql = 'DELETE FROM ' . $db_links . ' WHERE selector IN (' . join(', ', $list) . ')';
			$res = $db->query($sql);
			if ($res)
			{
				$messages[] = 'Ссылки успешно удалены.';
			}
			else
			{
				$messages[] = 'Ошибка при удалении.';
			}
		}
		break;

	case 'mass_empty_hits':
		{
			$list = array();
			foreach ($_REQUEST['links'] as $id)
			{
				$list[] = (int)$id;
			}

			$list = array_unique($list);
			$sql = 'UPDATE ' . $db_links . ' SET hit = 0 WHERE selector IN (' . join(', ', $list) . ')';
			$res = $db->query($sql);
			if ($res)
			{
				$messages[] = 'Обновлено успешно.';
			}
			else
			{
				$messages[] = 'Ошибка при обновлении.';
			}
		}
		break;
}

$sUrl = '?sort=';
$sort = array('current' => array(), 'html' => array());
$sort['current']['key'] = empty($_SESSION['sort']['key']) ? 'date' : $_SESSION['sort']['key'];
$sort['current']['val'] = empty($_SESSION['sort']['val']) ? 'A' : $_SESSION['sort']['val'];

if (isset($_REQUEST['sort']))
{
	list($sKey, $sVal) = explode('_', $_REQUEST['sort']);
	$sort['current']['key'] = $sKey;
	$sort['current']['val'] = $sVal;
}

foreach (array('date', 'url', 'name', 'metka') as $key)
{
	if ($sort['current']['key'] == $key)
	{
		$val = $sort['current']['val'];
		$sVal = ($val == 'A' ? 'Z' : 'A');
		$html = '<a href="' . $sUrl . $key . '_' . $sVal . '">'
				. '<img src="../images/sort' . $val . '.gif" alt="' . $val . '" /></a>';
	}
	else
	{
		$html = '<a href="' . $sUrl . $key . '_A">'
				. '<img src="../images/sortA.gif" alt="A" /></a>'
				. '<a href="' . $sUrl . $key . '_Z">'
				. '<img src="../images/sortZ.gif" alt="Z" /></a>';
	}

	$sort['html'][$key] = $html;
}

$filter = array();
$filter['limit'] = empty($_SESSION['filter']['limit']) ? '30' : $_SESSION['filter']['limit'];
if (isset($_REQUEST['filter_limit']))
{
	$filter['limit'] = $_REQUEST['filter_limit'];
}

$filter['metka'] = empty($_SESSION['filter']['metka']) ? '' : $_SESSION['filter']['metka'];
if (isset($_REQUEST['filter_metka']))
{
	$filter['metka'] = $_REQUEST['filter_metka'];
}

$sql = 'SELECT COUNT(*) AS num FROM ' . $db_links;
if ($filter['metka'])
{
	$sql .= ' WHERE metka LIKE "%' . mysql_real_escape_string($filter['metka']) . '%"';
}

$res = $db->query($sql);
$total = $db->fetcharray($res);
$total = $total['num'];

$maxPages = ceil($total / $filter['limit']);
if ($maxPages < 1)
{
	$maxPages = 1;
}

$filter['page'] = empty($_SESSION['filter']['page']) ? '1' : $_SESSION['filter']['page'];
if (isset($_REQUEST['filter_page']))
{
	$filter['page'] = $_REQUEST['filter_page'];
}

if ($filter['page'] > $maxPages)
{
	$filter['page'] = $maxPages;
}

$_SESSION['filter'] = $filter;
$_SESSION['sort'] = $sort['current'];

$sql = 'SELECT * FROM ' . $db_links;
if ($filter['metka'])
{
	$sql .= ' WHERE metka LIKE "' . mysql_real_escape_string($filter['metka']) . '" ';
}

$sql .= ' ORDER BY ' . $sort['current']['key'] . ' ' . ($sort['current']['val'] == 'A' ? 'ASC' : 'DESC') . '
	LIMIT ' . ($filter['page'] - 1) * $filter['limit'] . ', ' . $filter['limit'];
$res = $db->query($sql);

$list = array();
while ($row = $db->fetcharray($res))
{
	$list[] = $row;
}

require_once 'template/header.php';

table_item_top('Мои ссылки', 'mylinks.png');
?>
<script type="text/javascript" src="../includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="../includes/uidata.js"></script>
<script type="text/javascript" src="../includes/messages_ru.js"></script>
<link type="text/css" rel="stylesheet" href="template/uidata/uidata.css" />

<style type="text/css">
    .main_list {
		border: 1px solid #A6B2D5;
		border-collapse: collapse;
		margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
        text-align: center;
		border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
		height: 25px;
		padding-top: 2px;
		padding-left: 5px;
		text-align: center;
		border: 1px solid #A6B2D5;
	}
    hr {
		border: 1px dotted #CCCCCC;
	}
	.error {
		color: #f00;
	}
	.hh {
		display: none;
	}
	.ll {
		float: left;
	}
	label.error {
		padding-left: 5px;
		display: block;
	}
	.do_edit, .do_cancel, .do_save {
		cursor: pointer;
	}
	.do_save {
		margin-left: 5px;
	}
	.selecttr input[type="text"] {
		width: 100%
	}
	.messages {
		text-align: center;
	}
</style>

<script type="text/javascript">
	function ckeck_uncheck_all(elm) {
		$('.selecttr [type="checkbox"]').attr('checked', elm.checked);
	}

	$(function(){
		$('#new_link_form').validate({
			rules: {
				name: 'required',
				url: {
					required: true,
					url: true
				}
			},
			submitHandler: function(form) {
				var data = {};
				$(form).find('input[type="text"], input[type="hidden"]').each(function(){
					var elm = $(this);
					if (elm.attr('name') == '')
					{
						return;
					}

					data[elm.attr('name')] = elm.val();
				});

				data['ajax'] = true;
				$('#main_list_wrap').load('', data);
				form.reset();
			}
		});
	});

	function init()
	{
		$('.edit_mode').hide();
		$('.do_edit').click(function(){
			edit_mode(this);
		});
		$('.do_save').click(function(){
			// ajax save
			var data = {};
			$(this).parents('.selecttr').find('input[type="text"], input[type="hidden"]').each(function(){
				var elm = $(this);
				if (elm.attr('name') == '')
				{
					return;
				}

				data[elm.attr('name')] = elm.val();
			});

			data['ajax'] = true;
			$('#main_list_wrap').load('', data);
		});
		$('.do_cancel').click(function(){
			show_mode(this);
		});
	}
	
	function edit_mode(elm)
	{
		var row = $(elm).parents('.selecttr');
		$('.show_mode', row).hide();
		$('.edit_mode', row).show();
		$('.do_edit').hide();
	}

	function show_mode(elm)
	{
		var row = $(elm).parents('.selecttr');
		$('.show_mode', row).show();
		$('.edit_mode', row).hide();
		$('.do_edit').show();
	}
</script>


<form action="" method="post">
	&nbsp;&nbsp;Ссылок на странице:
	<select name="filter_limit" onchange="this.form.submit();">
		<?php
		$stranica = "5#10#15#20#30#50#100";
		$stranica = explode("#", $stranica);
		for ($a = 0; $a < count($stranica); $a++)
		{
			if ($filter['limit'] == $stranica[$a])
			{
				echo '<option value="' . $stranica[$a] . '" selected>' . $stranica[$a] . '</option>';
			}
			else
			{
				echo '<option value="' . $stranica[$a] . '">' . $stranica[$a] . '</option>';
			}
		}
		?>
	</select>
	&nbsp;<img alt="" src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Страница:
	<select name="filter_page" onchange="this.form.submit();">
		<?php
		$option = '<option value="%s" %s>%s</option>';
		for ($i = 1; $i <= $maxPages; $i++)
		{
			$sel = ($i == $filter['page'] ? 'selected="selected"' : '');
			printf($option, $i, $sel, $i);
		}
		?>
	</select>
    &nbsp;<img alt="" src="images/info_t.gif" width="5" height="22" align="absmiddle" />&nbsp;Метка:
	<input type="text" name="filter_metka" maxlength="30" style="width: 100px;" value="<?php echo $filter['metka']; ?>" />&nbsp;<input type="submit" value="Показать" />

</form>

<form action="" method="post" name="mylinkform">
	<div id="main_list_wrap">
		<?php
		if ($showAjax)
		{
			ob_clean();
			header('Content-Type: text/html;charset=windows-1251');
		}
		?>
		<div class="error messages"><?= join('<br/>', $messages) ?></div>
		<table width="1000" class="main_list" align="center">
			<tr>
				<th width="45"> </th>
				<th width="150">Метка <?= $sort['html']['metka'] ?></th>
				<th>URL полной ссылки <?= $sort['html']['url'] ?></th>
				<th width="120">Имя <?= $sort['html']['name'] ?></th>
				<th width="100">Дата <?= $sort['html']['date'] ?></th>
				<th width="60">Просмотров</th>
				<th width="40">ID</th>
				<th width="20">
					<input type="checkbox" title="Выбрать все" onclick="ckeck_uncheck_all(this)">
				</th>
			</tr>
			<?php foreach ($list as $item) : ?>
				<tr class="selecttr">
					<td>
						<img class="do_edit show_mode" src="images/icon_edit.png" alt="edit" title="Редактировать" />
						<img class="do_cancel edit_mode" src="images/icon_cancel.png" alt="cancel" title="Отменить" />
						<img class="do_save edit_mode" src="images/icon_save.png" alt="save" title="Сохранить" />
					</td>
					<td>
						<span class="show_mode"><?= $item['metka'] ?></span>
						<span class="edit_mode"><input type="text" name="metka" value="<?= $item['metka'] ?>" /></span>
					</td>
					<td class="slink">
						<span class="show_mode ll">
							<a href="<?= $def_mainlocation . '/gl.php?id=' . $item['selector'] ?>" target="_blank"><?= $item['url'] ?></a>
						</span>
						<span class="edit_mode"><input type="text" name="url" value="<?= $item['url'] ?>" /></span>
					</td>
					<td>
						<span class="show_mode"><?= $item['name'] ?></span>
						<span class="edit_mode"><input type="text" name="name" value="<?= $item['name'] ?>" /></span>
					</td>
					<td>
					<?= $item['date'] ?>
				</td>
				<td>
					<?= $item['hit'] ?>
				</td>
				<td>
					<?= $item['selector'] ?>
					<input type="hidden" name="selector" value="<?= $item['selector'] ?>" />
					<input name="action" value="save" type="hidden" />
				</td>
				<td>
					<input name="links[]" value="<?= $item['selector'] ?>" type="checkbox" />
				</td>
			</tr>
			<?php endforeach; ?>
					<tr>
						<td colspan="8">
							<div style="margin-bottom:5px; margin-top:5px; text-align: right;">
								<select name="action">
									<option value="">-Действие-</option>
									<option value="mass_empty_hits">Очистить количество просмотров</option>
									<option value="mass_delete">Удалить ссылки</option>
								</select>
								<input type="submit" value="Выполнить" />
							</div>
						</td>
					</tr>
				</table>
				<script type="text/javascript">
					init();
				</script>
		<?php
					if ($showAjax)
					{
						ob_end_flush();
						exit;
					}
		?>
				</div>
				<br />
			</form>

			<form id="new_link_form" action="" method="post">
				<input name="action" value="new" type="hidden" />
				<table width="700" border="0" cellspacing="0" cellpadding="0" class="main_list" align="center">
					<tr>
						<th colspan="3">Добавить ссылку</th>
					</tr>
					<tr>
						<td>URL ссылки: <span style="color:#FF0000;">*</span> <input type="text" name="url" value="" /></td>
						<td>Имя: <span style="color:#FF0000;">*</span> <input type="text" name="name" value="" /></td>
						<td>Метка: <input type="text" name="metka" value="" /></td>
					</tr>
					<tr>
						<td colspan="3"><input type="submit" value="Добавить" /></td>
					</tr>
				</table>
			</form>

<?php
					require_once 'template/footer.php';
?>
