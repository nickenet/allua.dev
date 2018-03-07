<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: reklama_stat.php
-----------------------------------------------------
 Назначение: Отображение статистики клиента по рекламе
=====================================================
*/

require_once '../includes/reklama_classes.php';

reklamAdmin::loadData();
reklamAdmin::$pageData = isset($_GET['klient']) ? (int)$_GET['klient'] : 0;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="ru">
<head>
	<title>Просмотр рекламной статистики</title>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
	<style type="text/css">
		.error {
			color: #f00;
			text-align: center;
			padding-top: 30px;
		}
		.main_list {
			width: 80%;
			border-collapse: collapse;
			margin-top: 20px;
		}
		.main_list td, .main_list th {
			border: 1px solid #000;
			padding: 0px 3px;
			text-align: center;
		}
		.tdl {
			text-align: left;
		}
		.tr_off {
			color: #CCCCCC;
			background-color: #E5E5E5;
		}
	</style>
</head>
<body>
	<?
	$foundPartner = false;
	ob_start();
	?>
	Ваш код клиента - <b><? echo reklamAdmin::$pageData; ?></b><br />
	
	<table class="main_list" cellpadding="0" cellspacing="0">
		<tr>
			<th>Статус</th>
			<th>Дата</th>
			<th>Название</th>
			<th>Тип</th>
			<th>Показов</th>
			<th>Кликов</th>
			<th>CTR, %</th>
		</tr>
		<? foreach (reklamAdmin::$list as $place) : ?>
			<? foreach ($place->subs as $row) : ?>
				<?
				if ($row->partner != reklamAdmin::$pageData)
				{
					continue;
				}

				$foundPartner = true;
				?>
				<tr <? echo $row->active ? '' : 'class="tr_off"'; ?>>
					<td>
						<? echo $row->active ? 'вкл.' : 'выкл.'; ?>
					</td>
					<td>
						<? echo date(reklamAdmin::dateFormat, $row->dateCreate); ?>
					</td>
					<td>
						<? echo htmlspecialchars($row->title,ENT_QUOTES,$def_charset); ?>
					</td>
					<td>
						<? echo reklamAdmin::$types[$row->type]; ?>
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
	<?
	$output = ob_get_clean();
	if (reklamAdmin::$pageData && $foundPartner)
	{
		echo $output;
	}
	else
	{
		?>
		<div class="error">
			Извините, Ваш код клиента не найден. Обратитесь к администратору каталога.
		</div>
		<?
	}
	?>

</body>
</html>