<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi & Ilya.K
  =====================================================
  Файл: cpmemberships.php
  -----------------------------------------------------
  Назначение: Обновить тарифную сетку
  =====================================================
 */
session_start();

require_once './defaults.php';
require_once '../includes/classes/tarif_manager.php';

$help_section = (string)$memberships_ch_help;

$title_cp = 'Управление тарифными планами - ';
$speedbar = ' | <a href="cpmemberships.php">Управление тарифными планами</a>';

check_login_cp('4_5', 'cpmemberships.php');

require_once 'template/header.php';

table_item_top('Обновить тарифную сетку', 'memberships.png');

$tm = new TarifManager();
$tm->load_config();

if (!empty($_POST['update_tarif']))
{
	$messages = $tm->update();
	$messages = join('<br>', $messages);

	msg_text('80%', $def_admin_message_ok, 'Тарифные планы успешно обновлены.<br>' . $messages);

	logsto('Обновление тарифной сетки');
}
?>
<style type="text/css">
	.tarif_list {
		border-collapse: collapse;
		margin: auto;
	}
	.tarif_list td {
		border: 1px solid #000;
		text-align: center;
		height: 23px;
	}
	.tarif_list input {
		text-align: center
	}
	td.row_title {
		text-align: right;
		padding-right: 5px; 
		font-weight: normal;
	}
</style>
<form name="tarif" action="" method="post">
	<input type="hidden" name="update_tarif" value="yes" />
<table width="1000" border="0" class="tarif_list" cellpadding="0" cellspacing="0">
	<tr>
		<td width="200" id="table_files_b">Название</td>
		<td width="200" id="table_files_bc"><? echo $def_D?></td>
		<td width="200" id="table_files_b"><? echo $def_C?></td>
		<td width="200" id="table_files_bc"><? echo $def_B?></td>
		<td width="200" id="table_files_b"><? echo $def_A?></td>
	</tr>
	<?
	$tm->edit_all();
	?>
    <tr>
		<td colspan="5" align="center">
			<input type="submit" value="Обновить" />
		</td>
	</tr>
</table>
</form>
<?
require_once 'template/footer.php';
?>
