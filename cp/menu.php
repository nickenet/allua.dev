<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: menu.php
-----------------------------------------------------
 Назначение: Управление меню
=====================================================
*/

session_start(); 

require_once './defaults.php';

$help_section = (string)$menu_help;

$title_cp = 'Упраление меню - ';
$speedbar = ' | <a href="menu.php">Управление меню</a>';

check_login_cp('3_7','menu.php');

require_once '../includes/menu_classes.php';

require_once 'template/header.php';

@menuAdmin::checkSystem();
@menuAdmin::loadData();
@menuAdmin::processPost();

ob_start();

?>
	<script type="text/javascript" src="../includes/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../includes/messages_ru.js"></script>
	<script type="text/javascript" src="../includes/jqueryui.js"></script>
	<style type="text/css">
		#menu_list {
			list-style-type: none;
			margin: 0;
			padding: 0;
		}
		#menu_list li {
			clear: left;
		}
		form {
			margin: 0px;
		}
		.arrow {
			width: 16px;
			height: 16px;
			background: url('../images/arrows.png') no-repeat;
			display: block;
			margin: auto;
		}
		.w100 {
			width: 100px;
		}
		.w50 {
			width: 50px;
		}
		.w20 {
			width: 20px;
		}
		.w2 {
			width: 40%;
		}
		.row {
			border-collapse: collapse;
			margin: 2px 0;
			width: 80%;
			background-color: #fff;
		}
		.row td {
			border: 1px solid #A6B2D5;
			padding: 2px;
		}

		.row th {
			background-image: url(images/table_files_bg.gif);
	                height: 25px;
			border: 1px solid #A6B2D5;
			padding: 2px;
		}

		.row img {
			max-width: 100px;
		}
		.row_off {
			background-color: #ccc;
		}
		.cc {
			text-align: center;
		}
		.rr {
			text-align: right;
		}
		.short {
			width: 50px;
		}
		.long {
			width: 300px;
		}

		label.error {
			padding-left: 5px;
		}
	</style>
	<script type="text/javascript">
		$(function() {
			$("#menu_list").sortable();
			$("#menu_list").disableSelection();
			
			$('#edit_item').validate({
				rules: {
						name: 'required',
						url: 'required',
						fWidth: 'number',
						fHeight: 'number'
					},
				submitHandler: function(form) {
					$(form).find('input[type="submit"]').attr('disabled', true);
					form.submit();
				}
			});

			initChInput('force_width');
			initChInput('force_height');
		});


		function checkSelect()
		{
			var sel = !!$('#menu_list input[name="id"]:checked').length;
			if (!sel)
			{
				alert('Выберите пункт меню!');
			}

			return sel;
		}

		
		function doChInput(event)
		{
			var doCh = !$('#ch_' + event.data.id + '_on:checked').val();
			$('#' + event.data.id).attr('disabled', doCh);
		}


		function initChInput(id)
		{
			if (!$('#' + id).length)
			{
				return;
			}

			var tmp = {};
			tmp.data = {id: id};
			$('#ch_' + id + '_on').bind('click', tmp.data, doChInput);
			doChInput(tmp);
		}
		
		// Костыль для ИЕ7, ибо value у button отрицает.
		function setDo(elm)
		{
			elm.form['do'].value = $(elm).attr('do');
		}
	</script>

<? table_item_top ('Управление меню','kmenu.png'); ?>

<? $mess_menu_list = join('<br />', menuAdmin::$messages); if ($mess_menu_list!="") msg_text('80%', $def_admin_message_mess, $mess_menu_list); ?>

<div align="center">
<table class="row"><tr>
	<th class="w50">Выбор</th>
	<th class="w20"></th>
	<th class="w100">Иконка</th>
	<th class="w2">Название раздела</th>
	<th>URL для перехода</th>
	<th class="w100">Параметры</th>
</tr></table>
<form action="" method="post">
	<ul id="menu_list">
	<? foreach (menuAdmin::$list as $item) : ?>
		<li><table class="row <? echo $item->active ? '' : 'row_off' ; ?>"><tr>
				<td class="w50 cc"><input type="radio" name="id" value="<? echo $item->id; ?>" /></td>
				<td class="w20 cc"><span class="arrow"></span></td>
				<td class="w100 cc"><? echo $item->showImg(1); ?></td>
				<td class="w2" align="left"><? echo $item->name; ?></td>
				<td align="left"><? echo $item->url; ?></td>
				<td class="w100">
					<label><input type="checkbox" name="active[]" value="<? echo $item->id; ?>"
								<? echo $item->active ? 'checked="checked"' : ''; ?> /> вкл.</label>
					[<? echo $item->noindex ? '-' : '+'; ?>]
					<input type="hidden" name="sort[]" value="<? echo $item->id; ?>" />
				</td>
			</tr></table>
		</li>
	<? endforeach; ?>
	</ul>
<br />
	<input type="hidden" name="do" value="" />
	<button type="submit" do="add" onclick="setDo(this);">Добавить</button>
	<button type="submit" do="edit" onclick="setDo(this); return checkSelect();">Редактировать</button>
	<button type="submit" do="update" onclick="setDo(this);">Обновить</button>
	<button type="submit" do="delete" onclick="setDo(this); return checkSelect() && confirm('Точно желаете удалить?');">Удалить</button>
</form>
</div>
<br />

<? table_fdata_top ($def_item_form_data); ?>

		
<form id="edit_item" action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="do" value="save" />
	<input type="hidden" name="id" value="<? echo menuAdmin::$formItem->id; ?>" />
	<table>
		<tr>
			<td class="rr">Название раздела:</td>
			<td align="left"><input class="long" type="text" name="name" value="<? echo menuAdmin::$formItem->name; ?>" /></td>
		</tr>
		<tr>
			<td class="rr">URL для перехода:</td>
			<td align="left"><input class="long" type="text" name="url" value="<? echo menuAdmin::$formItem->url; ?>" /></td>
		</tr>
		<tr>
			<td class="rr">Где развернуть URL (атрибут target):</td>
			<td align="left">
				<select name="target" class="long">
					<?
					foreach (menuAdmin::$targets as $key => $val)
					{
						$sel = $key == menuAdmin::$formItem->target ? ' selected="selected"' : '';
						echo '<option value="' . $key . '"' . $sel . '>' . htmlspecialchars($val,ENT_QUOTES,$def_charset) . '</option>';
					}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="rr">Текст всплывающей подсказки (атрибут title):</td>
			<td align="left"><input class="long" type="text" name="title" value="<? echo menuAdmin::$formItem->title; ?>" /></td>
		</tr>
		<tr>
			<td class="rr"><label for="noindex_ch">Запретить индексацию поисковикам:</label></td>
			<td align="left">
				<input type="checkbox" name="noindex" value="y" id="noindex_ch"
					    <? echo menuAdmin::$formItem->noindex ? 'checked="checked"' : ''; ?> /></td>
		</tr>
		<tr>
			<td class="rr"><label for="active_ch">Включить показ</label></td>
			<td align="left">
				<input type="checkbox" name="active" value="y" id="active_ch"
					    <? echo menuAdmin::$formItem->active ? 'checked="checked"' : ''; ?> /></td>
		</tr>
		<tr>
			<td class="rr">Загрузить иконку</td>
			<td align="left">
				<?
				if (menuAdmin::$formItem->image)
				{
					$fUrl	= '../' . menuAdmin::imgUrl . menuAdmin::$formItem->id . '.' . menuAdmin::$formItem->image;
					$fName	= menuAdmin::imgPath . menuAdmin::$formItem->id . '.' . menuAdmin::$formItem->image;

					$size	= getimagesize($fName);
					$size	= $size[0] . ' x ' . $size[1] . ' px';

					$fSize	= filesize($fName);
					$fSize	= round($fSize / 1024) . ' KB';

					?>
					<div id="img_info">
						<img src="<? echo $fUrl; ?>" alt="" /><br />
						Формат: <? echo menuAdmin::$formItem->image; ?><br />
						Размер: <? echo $size; ?><br />
						Вес: <? echo $fSize; ?>
					</div>
					<?
				}
				?>
				<input type="file" name="image" value="" />
			</td>
		</tr>
		<tr>
			<td class="rr">Задать строгий размер иконки (пиксели):</td>
			<td align="left">
				<input name="fWidthOn" id="ch_force_width_on" type="checkbox" value="1"
				  <? echo menuAdmin::$formItem->fWidthOn ? 'checked="checked"' : ''; ?> />
				ширина
				<input name="fWidth" id="force_width" value="<? echo menuAdmin::$formItem->fWidth; ?>" type="text" class="short" />

				<input name="fHeightOn" id="ch_force_height_on" type="checkbox" value="1"
				  <? echo menuAdmin::$formItem->fHeightOn ? 'checked="checked"' : ''; ?> />
				высота
				<input name="fHeight" id="force_height" value="<? echo menuAdmin::$formItem->fHeight; ?>" type="text" class="short" />
			</td>
		</tr>
	</table>
	<input type="submit" value="<? echo menuAdmin::$formButton; ?>" /><br /><br />
</form>

<?php

table_fdata_bottom();

require_once 'template/footer.php';

?>