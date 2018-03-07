<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: reklama.php
-----------------------------------------------------
 Назначение: Управление рекламными местами
=====================================================
*/

session_start(); 

require_once './defaults.php';

$help_section = (string)$reklama_help;

$title_cp = 'Рекламные места ';
$speedbar = ' | <a href="reklama.php">Рекламные места</a>';

check_login_cp('3_5','reklama.php');

require_once 'template/header.php';

table_item_top ('Рекламные места','reklama.png');

require_once '../includes/reklama_classes.php';

reklamAdmin::checkSystem();
reklamAdmin::loadData();
reklamAdmin::checkPost();

?>

	
	<script type="text/javascript" src="../includes/jquery.validate.min.js"></script>
	<script type="text/javascript" src="../includes/uidata.js"></script>
	<script type="text/javascript" src="../includes/messages_ru.js"></script>
	<link rel="stylesheet" href="template/uidata/uidata.css" type="text/css" />
	<style type="text/css">
		.error {
			color: #f00;
		}
		.hh {
			display: none;
		}
		.ll {
			float: left;
		}
		label.error, .new_content {
			padding-left: 5px;
		}
		.new_content {
			white-space: nowrap;
		}
		.main_list {
			border-collapse: collapse;
			margin-top: 2px;
			margin: 2px 0;
			width: 80%;
			background-color: #fff;

		}
		.main_list td {
			border: 1px solid #A6B2D5;
			padding: 5px;
			text-align: center;
		}
		.main_list th {
			background-image: url(images/table_files_bg.gif);
	                height: 25px;
			border: 1px solid #A6B2D5;
			padding: 2px;
			text-align: center;
		}

		.tdr {
			text-align: right;
		}
		.tdl {
			text-align: left;
		}
		.tr_off {
			color: #CCCCCC;
			background-color: #E5E5E5;
		}
		.short {
			width: 50px;
		}
		.middle {
			width: 80px;
		}
		.long {
			width: 300px;
		}
	</style>
	<script type="text/javascript">
		function showNewPlace()
		{
			$(this).attr('disabled', true);
			$('#new_place').slideDown(function(){
				$('#new_place input[name="title"]').focus();
			});
		}


		function showNewContent()
		{
			$(this).attr('disabled', true);
			var elmId = $(this).attr('id').split('_')[1];
			$('#c_' + elmId).animate({width: 'toggle'});
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


		$.validator.setDefaults({
			submitHandler: function(form) {
				$(form).find('input[type="submit"]').attr('disabled', true);
				form.submit();
			}
		});

		$(document).ready(function(){
			$('#new_place_but').click(showNewPlace);
			$('#new_place_form').validate({
				rules: {
					title: 'required'
				}
			});

			$('.new_content_but').click(showNewContent);

			$('.new_content_form').each(function(){
				$(this).validate();
			});

			$('#process_form').validate({
				submitHandler: function(form) {
					var list = [];
					$(form).find('input[type="submit"]').attr('disabled', true);
					$('.ch_list:checked').each(function(){
						list.push( $(this).val() );
					});
					list = list.join(',');
					$(form).find('input[name="list"]').val(list);
					form.submit();
				}
			});

			var chOption;
			chOption = {
					title: 'required',
					partner: 'number',
					fWidth: 'number',
					fHeight: 'number',
					maxClick: 'number',
					numClick: 'number',
					maxShow: 'number',
					numShow: 'number'
				};
			$('#edit_html_form').validate({
				rules: $.extend({}, chOption,
						{code: 'required'})
			});

			if (!$('#img_info').length)
			{
				$.extend(chOption, 
						{upload: 'required'});
			}

			$('#edit_img_form').validate({
				rules: $.extend({}, chOption,
						{url: 'required url'})
			});

			$('#edit_flash_form').validate({
				rules: $.extend({}, chOption,
						{url: 'url'})
			});

			$('#date_from').datepicker();
			$('#date_to').datepicker();
			
			initChInput('max_show');
			initChInput('max_click');
			initChInput('f_width');
			initChInput('f_height');
		});
	</script>

<? $mess_reklama_list = join('<br />', reklamAdmin::$messages); if ($mess_reklama_list!="") { msg_text('80%', $def_admin_message_mess, $mess_reklama_list); logsto("Обновлена информация в рекламных местах"); } ?>

<? if (reklamAdmin::$page == 'edit_place') : ?>

	<? table_fdata_top ('Рекламное место'); ?>
	<form action="?" method="post">
		<input name="action" value="save_place" type="hidden" />
		<input name="id" value="<? echo reklamAdmin::$pageData->id; ?>" type="hidden" />
		Название<br />
		<input name="title" value="<? echo htmlspecialchars(reklamAdmin::$pageData->title,ENT_QUOTES,$def_charset); ?>"
			   type="text" class="long" /><br />
		Комментарий<br />
		<textarea name="info" cols="30" rows="3"
				  class="long"><? echo htmlspecialchars(reklamAdmin::$pageData->info,ENT_QUOTES,$def_charset); ?></textarea><br />
		<label><input name="do_del" type="checkbox" value="1" /> удалить</label><br />
		<br />
		<input type="submit" value="Сохранить" />
	</form>
	<? table_fdata_bottom(); ?>
	
<? elseif (reklamAdmin::$page == 'edit') : ?>

	<? table_fdata_top ('Рекламный материал'); ?>
	<div align="left">
	<form id="edit_<? echo reklamAdmin::$pageData->type; ?>_form" action="?" method="post"
		  enctype="multipart/form-data">
		<input name="action" value="save" type="hidden" />
		<input name="id" value="<? echo reklamAdmin::$pageData->id; ?>" type="hidden" />
		<input name="pid" value="<? echo reklamAdmin::$pageData->pid; ?>" type="hidden" />
		<input name="type" value="<? echo reklamAdmin::$pageData->type; ?>" type="hidden" />
		<table>
			<tr>
				<td class="tdr">Название:</td>
				<td><input name="title" value="<? echo htmlspecialchars(reklamAdmin::$pageData->title,ENT_QUOTES,$def_charset); ?>" type="text" class="long" /></td>
			</tr>
			<tr>
				<td class="tdr"><label for="ch_active">Включить</label></td>
				<td><input name="active" id="ch_active" type="checkbox" value="1" <? echo reklamAdmin::$pageData->active ? 'checked="checked"' : ''; ?> /></td>
			</tr>
			<tr>
				<td class="tdr">Код клиента:</td>
				<td><input name="partner" value="<? echo htmlspecialchars(reklamAdmin::$pageData->partner); ?>" type="text" class="short" /></td>
			</tr>
			<tr>
				<td class="tdr">Интервал показа<br />(DD.MM.YYYY)</td>
				<td>
					<?
					$dateFrom = '';
					if ( !empty(reklamAdmin::$pageData->dateFrom) )
					{
						$dateFrom = date(reklamAdmin::dateFormat, reklamAdmin::$pageData->dateFrom);
					}

					$dateTo = '';
					if ( !empty(reklamAdmin::$pageData->dateTo) )
					{
						$dateTo = date(reklamAdmin::dateFormat, reklamAdmin::$pageData->dateTo);
					}
					?>
					с
					<input name="dateFrom" 
						   value="<? echo $dateFrom; ?>"
						   id="date_from" type="text" class="middle" />
					по
					<input name="dateTo" 
						   value="<? echo $dateTo; ?>"
						   id="date_to" type="text" class="middle" />
				</td>
			</tr>
			<?
			reklamAdmin::$pageData->showEdit();
			?>
			<tr>
				<td class="tdr"><label for="ch_max_show_on">Максимальное число показов</label></td>
				<td>
					<input name="maxShowOn" id="ch_max_show_on" type="checkbox" value="1"
					  <? echo reklamAdmin::$pageData->maxShowOn ? 'checked="checked"' : ''; ?> />
					<input name="maxShow" value="<? echo htmlspecialchars(reklamAdmin::$pageData->maxShow); ?>"
						   id="max_show" type="text" class="short" />
				</td>
			</tr>
			<tr>
				<td class="tdr">Комментарий:</td>
				<td><textarea name="info" cols="30" rows="3" class="long"><? echo htmlspecialchars(reklamAdmin::$pageData->info,ENT_QUOTES,$def_charset); ?></textarea><br /></td>
			</tr>
			<tr>
				<td class="tdr"></td>
				<td><input type="submit" value="Сохранить" /></td>
			</tr>
		</table>
	</form>
	</div>
	<? table_fdata_bottom(); ?>

<? else : ?>
	
	<div style="padding: 10px 20px;">
		<button id="new_place_but" type="button">Новое рекламное место</button>
		<div id="new_place" class="hh">
			<form id="new_place_form" action="" method="post">
				<input name="action" value="new_place" type="hidden" />
				Название<br />
				<input name="title" value="" type="text" class="long" /><br />
				Комментарий<br />
				<textarea name="info" cols="30" rows="3" class="long"></textarea><br />
				<input type="submit" value="Добавить" />
			</form>
		</div>
	</div>
	<div align="center">
	<table class="main_list" cellpadding="0" cellspacing="0">
		<tr>
			<th colspan="2"></th>
			<th>Статус</th>
			<th>Дата</th>
			<th>Название</th>
			<th>Тип</th>
			<th>Код</th>
			<th>Показов</th>
			<th>Кликов</th>
			<th>CTR, %</th>
		</tr>
		<? foreach (reklamAdmin::$list as $place) : ?>
			<tr>
				<td colspan="10" class="tdl slink">
					<div class="ll">
						<b><a title="<? echo htmlspecialchars($place->info,ENT_QUOTES,$def_charset); ?>"
						   href="?action=edit_place&id=<? echo $place->id; ?>">
							<? echo htmlspecialchars($place->title,ENT_QUOTES,$def_charset); ?></a></b>&nbsp;
						<button id="b_<? echo $place->id; ?>" class="new_content_but" type="button">Добавить</button>
					</div>
					<div id="c_<? echo $place->id; ?>" class="new_content hh ll">
						<form class="new_content_form" action="" method="post">
							<input name="action" value="new_content" type="hidden" />
							<input name="pid" value="<? echo $place->id; ?>" type="hidden" />
							<select name="type">
								<? foreach (reklamAdmin::$types as $val => $type) : ?>
								<option value="<? echo $val; ?>"><? echo htmlspecialchars($type,ENT_QUOTES,$def_charset); ?></option>
								<? endforeach; ?>
							</select>
							<input type="submit" value="Добавить" />
						</form>
					</div>
				</td>
			</tr>
			<? foreach ($place->subs as $row) : ?>
				<tr <? echo $row->active ? '' : 'class="tr_off"'; ?>>
					<td style="width: 50px">
						
					</td>
					<td>
						<input class="ch_list" type="checkbox" value="<? echo $row->id; ?>" />
					</td>
					<td>
						<? echo $row->active ? 'вкл.' : 'выкл.'; ?>
					</td>
					<td>
						<? echo date(reklamAdmin::dateFormat, $row->dateCreate); ?>
					</td>
					<td class="slink">
						<a title="<? echo htmlspecialchars($row->info); ?>" 
						   href="?action=edit&id=<? echo $row->id; ?>">
							<? echo htmlspecialchars($row->title,ENT_QUOTES,$def_charset); ?></a>
					</td>
					<td>
						<? echo reklamAdmin::$types[$row->type]; ?>
					</td>
					<td>
						<? echo $row->partner; ?>
					</td>
					<td>
						<? echo (int)$row->numShow . ($row->maxShowOn ? ' / ' . $row->maxShow : ''); ?>
					</td>
					<td>
						<? 
						if ( isset($row->numClick) )
						{
							echo (int)$row->numClick . ($row->maxClickOn ? ' / ' . $row->maxClick : '');
						}
						else
						{
							echo '&mdash;';
						}
						?>
					</td>
					<td>
						<?
						if ( isset($row->numClick) )
						{
							echo reklamAdmin::countCtr($row);
						}
						else
						{
							echo '&mdash;';
						}
						?>
					</td>
				</tr>
			<? endforeach; ?>
		<? endforeach; ?>
	</table>
	</div>
	<br />
	<div style="padding: 0px 20px;">
	<form id="process_form" action="" method="post">
		<input name="action" value="process" type="hidden" />
		<input name="list" value="" type="hidden" />
		<select name="do">
			<option value="">Действие...</option>
			<option value="on">Включить</option>
			<option value="off">Выключить</option>
			<option value="del">Удалить</option>
		</select>
		<input type="submit" value="Применить" />
	</form>
	</div>

<? endif; ?>

<? require_once 'template/footer.php'; ?>