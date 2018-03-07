<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: banner.php
-----------------------------------------------------
 Назначение: Управление баннерами компаний
=====================================================
*/

session_start(); 

$tmpSet = ini_set('session.use_cookies', 1);

require_once './defaults.php';

$help_section = (string)$banner_contr_help;

$title_cp = 'Баннеры контрагентов';
$speedbar = ' | <a href="banner.php">'.$def_admin_banner_contr.'</a>';

check_login_cp('1_7','banner.php');

require_once '../includes/banner_classes.php';

bannerAdmin::initConf();
bannerAdmin::checkPost();
bannerAdmin::loadData();

require_once 'template/header.php';

?>

	<script type="text/javascript" src="../includes/js/jeditable.js"></script>
	<style type="text/css">
		#message {
			color: #f00;
		}
		.rr {
			float: right;
		}
		.preview {
			max-width: 500px;
			max-height: 500px;
			border: 0px;
		}
		.main_list {
			width: 98%;
			border-collapse: collapse;
			margin-top: 20px;
		}
		.main_list td, .main_list th {
			padding: 0px 3px;
			text-align: center;
		}
		.activeBut {
			background-color: yellow;
		}
		.editable {
			cursor: crosshair;
		}
		.eInput {
			width: 30px
		}
		.changed {
			background-color: #eee;
			padding: 5px;
		}
	</style>
	<script type="text/javascript">
		function updateCtr()
		{
			var row, newVal, numClick, numShow;
			row = $(this).parents('tr');

			numClick = row.find('.click');
			if (numClick.find('.eInput').length)
			{
				numClick = numClick.find('.eInput').val();
			}
			else
			{
				numClick = numClick.html();
			}

			numShow = row.find('.show');
			if (numShow.find('.eInput').length)
			{
				numShow = numShow.find('.eInput').val();
			}
			else
			{
				numShow = numShow.html();
			}

			newVal = parseInt(numClick) / parseInt(numShow);
			newVal = Math.ceil(newVal * 100) + ' %';
			$('.update_ctr', row).html(newVal);
		}


		$(document).ready(function(){
			$('#config_form select').change(function(){
				$('#config_form').submit();
			});

			$('#process_form').submit(function(){
				var list = [];
				$('.ch_list:checked').each(function(){
					list.push($(this).val());
				});
				
				list = list.join(',');
				if (list === '')
				{
					alert('Список к удалению пуст!');
					
					return false;
				}
				
				$(this.list).val(list);
			});

			$('#config_form input[value="<? echo bannerAdmin::$conf['type']; ?>"]').addClass('activeBut');
			$('#config_form select[name="l"]').val(<? echo bannerAdmin::$conf['limit']; ?>);
			$('#config_form select[name="p"]').val(<? echo bannerAdmin::$conf['page']; ?>);
		});
	</script>

<?php

echo '
<form id="config_form" action="" method="post">
<table width="100%" border="0">
  <tr>
    <td align="left"><img src="images/banner.png" width="32" height="32" align="absmiddle"><span class="maincat">'.$def_admin_banner_contr.'</span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34"></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31"></td>
            <td width="760" align="left">
';

?>
<? echo "$def_admin_type_banner_contr"; ?>&nbsp;<input name="t" value="side" type="submit" />&nbsp;&nbsp;<input name="t" value="top" type="submit" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<? echo "$def_admin_vivod_page1"; ?>
		<select name="l">
			<option value="5">5</option>
			<option value="10">10</option>
			<option value="20">20</option>
			<option value="50">50</option>
		</select>
		&nbsp;<? echo "$def_admin_vivod_page2"; ?>
	  </td>
	  <td align="right"><? echo "$def_admin_page_banner"; ?>
			<select name="p">
				<?
				$pages = range(1, bannerAdmin::$conf['max_page']);
				foreach ($pages as $num)
				{
					echo '<option value="' . $num . '">' . $num . '</option>';
				}
				?>
			</select></td>
          </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34"></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
	<table class="main_list" cellpadding="0" cellspacing="0" align="center">
		<tr>
			<td id="table_files_b">&nbsp;</td>
			<td id="table_files_bc"><? echo "$def_images_item"; ?></td>
			<td id="table_files_b"><? echo "$def_admin_title"; ?></td>
			<td id="table_files_bc" align="center"><? echo "$def_admin_view_banner_stat"; ?></td>
			<td id="table_files_b"><? echo "$def_admin_clicks_banner_stat"; ?></td>
			<td id="table_files_bc">CTR, %</td>
			<td id="table_files_b"><? echo "$def_admin_down_banner"; ?></td>
			<td id="table_files_bc"><? echo "$def_offers_type"; ?></td>
			<td id="table_files_b"><? echo "$def_admin_sizekb_banner"; ?></td>
		</tr>
		<? foreach (bannerAdmin::$list as $id => $row) : ?>
			<tr>
				<td id="table_files_ib">
					<input class="ch_list" type="checkbox" value="<? echo $id . '.' . $row['ext']; ?>" />
				</td>
				<td id="table_files_ib_c">
					<a href="offers.php?REQ=auth&id=<? echo $id; ?>" target="_blank"><img src="<? echo $row['url']; ?>" class="preview" alt="banner <? echo $id; ?>" /></a>
				</td>
				<td id="table_files_ib" class="slink">
					<a href="offers.php?REQ=auth&id=<? echo $id; ?>" target="_blank"><? echo htmlspecialchars($row['firm'],ENT_QUOTES,$def_charset); ?></a>
				</td>
				<td id="table_files_ib_c">
					<span class="editable show"><? echo (int)$row['show']; ?></span>
				</td>
				<td id="table_files_ib">
					<span class="editable click"><? echo (int)$row['click']; ?></span>
				</td>
				<td id="table_files_ib_c">
					<span class="update_ctr"><? echo bannerAdmin::countCtr($row); ?></span>
				</td>
				<td id="table_files_ib">
					<? echo date('d.m.Y', $row['date']); ?>
				</td>
				<td id="table_files_ib_c">
					<? echo $row['ext']; ?>
				</td>
				<td id="table_files_ib">
					<? echo round($row['size'] / 1024) . ' KB'; ?>
				</td>
			</tr>
		<? endforeach; ?>
	</table>
	<br /><div style="padding-left:60px; text-align:left;">
	<form id="process_form" action="" method="post">
		<input name="action" value="delete" type="hidden" />
		<input name="list" value="" type="hidden" />
		<label><input name="update_stat" value="1" type="checkbox" /><?echo "$def_admin_null_banner_stat"; ?></label><br />
		<br />
		<input type="submit" value="<? echo "$def_images_delete"; ?>" />
	</form></div>

<?php

require_once 'template/footer.php';

?>
