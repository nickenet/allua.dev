<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & K.Ilya
=====================================================
 Файл: firms.php
-----------------------------------------------------
 Назначение: Активация контрагентов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$firms_help;

$title_cp = 'Активация контрагентов - ';
$speedbar = ' | <a href="firms.php?REQ=auth">Активация контрагентов</a>';

check_login_cp('1_3','firms.php?REQ=auth');

$def_descr_size=2000;

if (isset($_POST['kol_firms']))
{
	$_SESSION['kol_firms'] = (int)$_POST['kol_firms'];
}

if (empty($_SESSION['kol_firms']))
{
	$_SESSION['kol_firms'] = 5;
}

if (isset($_POST['sort_afirms']))
{
	$_SESSION['sort_afirms'] = (string)$_POST['sort_afirms'];
}

if (empty($_SESSION['sort_afirms']))
{
	$_SESSION['sort_afirms'] = 'ORDER BY selector DESC';
}

$can = '';

require_once 'template/header.php';

// Отказать всем в регистрации

if ($_GET['REQ'] == 'del')
{
	$r_del = $db->query('SELECT firmname, date, mail, selector FROM ' . $db_users . ' WHERE firmstate="off"');
	$kol_del = mysql_num_rows($r_del);

	if ($kol_del > 0)
	{
		for ($zzz = 0; $zzz < $kol_del; $zzz++)
		{
			$fe = $db->fetcharray($r_del);

			// Отправляем письмо контрагенту об отказе регистрации в каталоге

                        $template_mail = file_get_contents ('../template/' . $def_template . '/mail/rejected.tpl');

                        $template_mail = str_replace("*title*", $def_title, $template_mail);
                        $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                        $template_mail = str_replace("*include_message*", "", $template_mail);
                        $template_mail = str_replace("*firmname*", $fe['firmname'], $template_mail);
                        $template_mail = str_replace("*mail*", $fe['mail'], $template_mail);
                        $template_mail = str_replace("*date*", $fe['date'], $template_mail);

                        mailHTML($fe['mail'],$rejected_subject,$template_mail,$def_from_email);

                        @unlink ( ".././logo/$fe[selector].gif" );
			@unlink ( ".././logo/$fe[selector].jpg" );
			@unlink ( ".././logo/$fe[selector].png" );
                        @unlink ( ".././logo/$fe[selector].bmp" );
		}

		$db->query('DELETE FROM ' . $db_users . ' WHERE firmstate="off"');

		$firm_mess = 1;
	}
	else
	{
		$firm_mess = 2;
	}

	$can = 'yes';
}

// Активировать всех
if ($_GET['REQ'] == 'all')
{
	$r_del = $db->query('SELECT * FROM ' . $db_users . ' WHERE firmstate="off"');
	$kol_del = mysql_num_rows($r_del);

	if ($kol_del > 0)
	{
		for ($zzz = 0; $zzz < $kol_del; $zzz++)
		{
			$fe = $db->fetcharray($r_del);

			$category_list = explode(':', $fe['category']);

			for ($index = 0; $index < count($category_list); $index++)
			{
				if ($category_list[$index] != '')
				{
					if ($def_onlypaid != 'YES' || $fe['flag'] != 'D')
					{
						$new_cat = explode('#', $category_list[$index]);

						if ($new_cat[0] != $prev_cat)
						{
							$sql = 'UPDATE ' . $db_category . ' SET fcounter = fcounter+1
								WHERE selector=' . $new_cat[0];
							$db->query($sql);
						}

						if (!empty($new_cat[1]) && $new_cat[1] != $prev_subcat)
						{
							$sql = 'UPDATE ' . $db_subcategory . ' SET fcounter = fcounter+1
								WHERE catsel=' . $new_cat[0] . ' AND catsubsel=' . $new_cat[1];
							$db->query($sql);
						}

						if (!empty($new_cat[1]) && !empty($new_cat[2]))
						{
							$sql = 'UPDATE ' . $db_subsubcategory . ' SET fcounter = fcounter+1 
								WHERE catsel=' . $new_cat[0] . ' 
									AND catsubsel=' . $new_cat[1] . ' 
									AND catsubsubsel=' . $new_cat[2];
							$db->query($sql);
						}
					}

					$prev_cat = $new_cat[0];
					$prev_subcat = $new_cat[1];
				}
			}

                        $prev_cat = ""; $prev_subcat = "";

			$db->query('UPDATE ' . $db_users . '
					SET firmstate = "on",
						flag = "D",
						prices = "' . $def_D_setproducts . '",
						images = "' . $def_D_setimages . '",
						exel = "' . $def_D_setexel . '",
						video = "' . $def_D_setvideo . '"
					WHERE selector = "' . $fe['selector'] . '"');

                        $template_mail = file_get_contents ('../template/' . $def_template . '/mail/approved.tpl');

                        if ($fe['domen']!='') $domen=$fe['domen']; else $domen='создайте страницу';

                        $template_mail = str_replace("*title*", $def_title, $template_mail);
                        $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                        $template_mail = str_replace("*include_message*", safeHTML($_POST['email_plus']), $template_mail);
                        $template_mail = str_replace("*firmname*", $fe['firmname'], $template_mail);
                        $template_mail = str_replace("*login*", $fe['login'], $template_mail);
                        $template_mail = str_replace("*mail*", $fe['mail'], $template_mail);
                        $template_mail = str_replace("*id_firm*", $fe['selector'], $template_mail);
                        $template_mail = str_replace("*domen*", $domen, $template_mail);
                        $template_mail = str_replace("*date*", $date, $template_mail);

			// Отправляем письмо контрагенту об успешной активации

                        mailHTML($fe['mail'],$approved_subject,$template_mail,$def_from_email);

			$firm_mess = 3;

                        unset($fe);
		}
	}
	else
	{
		$firm_mess = 4;
	}

	$can = 'yes';
}

// Обработать запрос

if (isset($_POST['REQ']) && $_POST['REQ'] == 'complete')
{
	ob_clean();
	
	$data = array(	'id' => $_POST['idin'],
					'message' => '',
					'ok' => 0);

	foreach ($_POST as &$val)
	{
		if (!is_array($val))
		{
			$val = iconv('utf-8', 'windows-1251', $val);
		}
	}

	unset($val);
	
	if ($_POST['inbut'] == (string)$def_admin_newreg_approve)
	{
		$date = date('Y-m-d');
		
		if ($_POST['www'] != '')
		{
			if (!preg_match('#^http://#', $_POST['www']))
			{
				$_POST['www'] = 'http://' . $_POST['www'];
			}
		}

		$safeList = array('firmname', 'business', 'address', 'zip', 'phone', 'fax', 'mobile', 
			'icq', 'manager', 'mail', 'www', 'comment',
			'reserved_1', 'reserved_2', 'reserved_3');
		foreach ($safeList as $key)
		{
			$$key = safeHTML($_POST[$key]);
		}
		
		if ($def_country_allow == 'YES')
		{
			$city = safeHTML($_POST['city']);
		}
		else
		{
			$city = 'No city';
		}

		if (in_array($_POST['listing'], array('A', 'B', 'C')))
		{
			$date_upgrade = $date;
		}
		else
		{
			$date_upgrade = '';
		}

		$sql = 'SELECT * FROM ' . $db_users . ' WHERE selector="' . $_POST['idin'] . '" AND firmstate="off"';
		$rrr = $db->query($sql);
		$exist = mysql_num_rows($rrr);

		if ($exist > 0)
		{
			$index_category = 1;
			$category_index = array();
			for ($index = 0; $index < count($_POST['category']); $index++)
			{
				if ($_POST['category'][$index] != '')
				{
					$category_index[$index_category] = $_POST['category'][$index];
					$index_category++;

					if ($def_onlypaid != 'YES' || $_POST['listing'] != 'D')
					{
						$new_cat = explode('#', $_POST['category'][$index]);

						if ($new_cat[0] != $prev_cat)
						{
							$sql = 'UPDATE ' . $db_category . ' SET fcounter = fcounter+1
								WHERE selector=' . $new_cat[0];
							$db->query($sql);
						}

						if (!empty($new_cat[1]) && $new_cat[1] != $prev_subcat)
						{
							$sql = 'UPDATE ' . $db_subcategory . ' SET fcounter = fcounter+1
								WHERE catsel=' . $new_cat[0] . ' AND catsubsel=' . $new_cat[1];
							$db->query($sql);
						}

						if (!empty($new_cat[1]) && !empty($new_cat[2]))
						{
							$sql = 'UPDATE ' . $db_subsubcategory . ' SET fcounter = fcounter+1
								WHERE catsel=' . $new_cat[0] . '
									AND catsubsel=' . $new_cat[1] . '
									AND catsubsubsel=' . $new_cat[2];
							$db->query($sql);
						}
					}

					$prev_cat = $new_cat[0];
					$prev_subcat = $new_cat[1];
				}
			}

			$category = join(':', $category_index);
		}

		$set_products = 'def_' . $_POST['listing'] . '_setproducts';
		$set_images = 'def_' . $_POST['listing'] . '_setimages';
		$set_exel = 'def_' . $_POST['listing'] . '_setexel';
		$set_video = 'def_' . $_POST['listing'] . '_setvideo';

		$prices = $$set_products;
		$images = $$set_images;
		$exel = $$set_exel;
		$video = $$set_video;

		if ($exist > 0)
		{
			$sql = array();
			$sqlList = array('comment', 'category', 'firmname', 'business', 'city', 'address', 
				'zip', 'phone', 'fax', 'mobile', 'icq', 'manager', 'mail', 'www', 'prices', 
				'images', 'exel', 'video', 'date', 'date_upgrade', 
				'reserved_1', 'reserved_2', 'reserved_3');
			foreach ($sqlList as $key)
			{
				$sql[] = $key . '="' . $$key . '"';
			}

			$db->query('UPDATE ' . $db_users . '
				SET firmstate = "on",
					flag = "' . $_POST['listing'] . '",
					' . join(', ', $sql) . '
				WHERE selector="' . $_POST['idin'] . '"');
		}

		ob_start();
		logsto($def_admin_log_newadded . ' ' . $_POST['firmname'] . ' (id: ' . $_POST['idin'] . ')');
		msg_text('80%', $def_admin_message_ok, $def_admin_log_newadded . ' [ID=' . $_POST['idin'] . ']');
		$data['message'] = ob_get_clean();

		$sql = 'SELECT * FROM ' . $db_users . ' WHERE selector="' . $_POST['idin'] . '"';
		$re = $db->query($sql);
		$fe = $db->fetcharray($re);

		$template_mail = file_get_contents ('../template/' . $def_template . '/mail/approved.tpl');

                if ($fe['domen']!='') $domen=$fe['domen']; else $domen='создайте страницу';

                $template_mail = str_replace("*title*", $def_title, $template_mail);
                $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                $template_mail = str_replace("*include_message*", safeHTML($_POST['email_plus']), $template_mail);
                $template_mail = str_replace("*firmname*", $fe['firmname'], $template_mail);
                $template_mail = str_replace("*login*", $fe['login'], $template_mail);
                $template_mail = str_replace("*mail*", $fe['mail'], $template_mail);
                $template_mail = str_replace("*id_firm*", $fe['selector'], $template_mail);
                $template_mail = str_replace("*domen*", $domen, $template_mail);
                $template_mail = str_replace("*date*", $date, $template_mail);

		// Отправляем письмо контрагенту об успешной активации

                mailHTML($fe['mail'],$approved_subject,$template_mail,$def_from_email);

		$can = 'yes';
	}
	else
	{
		$sql = 'SELECT * FROM ' . $db_users . ' WHERE selector="' . $_POST['idin'] . '"';
		$re = $db->query($sql);
		$fe = $db->fetcharray($re);

		$exist = mysql_num_rows($re);

		if ($exist > 0)
		{
			$sql = 'DELETE FROM ' . $db_users . ' WHERE selector="' . $_POST['idin'] . '"';
			$db->query($sql);
		}
		else
		{
			echo 'This listing is no longer exists';
		}

		ob_start();
		msg_text('80%', $def_admin_message_ok, $def_admin_log_newremoved . ' [ID=' . $_POST['idin'] . ']');
		logsto($def_admin_log_newremoved . ' ' . $_POST['firmname'] . ' (id: ' . $_POST['idin'] . ')');
		$data['message'] = ob_get_clean();

		// Отправляем письмо контрагенту об отказе регистрации в каталоге

                $template_mail = file_get_contents ('../template/' . $def_template . '/mail/rejected.tpl');

                $template_mail = str_replace("*title*", $def_title, $template_mail);
                $template_mail = str_replace("*dir_to_main*", $def_mainlocation, $template_mail);
                $template_mail = str_replace("*include_message*", safeHTML($_POST['email_plus']), $template_mail);
                $template_mail = str_replace("*firmname*", $fe['firmname'], $template_mail);
                $template_mail = str_replace("*mail*", $fe['mail'], $template_mail);
                $template_mail = str_replace("*date*", $fe['date'], $template_mail);

                mailHTML($fe['mail'],$rejected_subject,$template_mail,$def_from_email);

                @unlink ( ".././logo/$fe[selector].gif" );
		@unlink ( ".././logo/$fe[selector].jpg" );
		@unlink ( ".././logo/$fe[selector].png" );
                @unlink ( ".././logo/$fe[selector].bmp" );

		$can = 'yes';
	}

	$data['message'] = iconv('windows-1251', 'utf-8', $data['message']);
	$data['ok'] = 1;
	echo json_encode($data);

	exit;
}

if ($_GET['users'] == 'all')
{
	$sql = 'SELECT * FROM ' . $db_users . ' WHERE firmstate="off" and firmname="" '.$_SESSION['sort_afirms'];
}
else
{
	$sql = 'SELECT * FROM ' . $db_users . ' WHERE firmstate="off" and firmname!="" '.$_SESSION['sort_afirms'];
}

$r = $db->query($sql);
$newfirms = mysql_num_rows($r);


?>
<script type="text/javascript">
	function textCounter(elmForm)
	{
		var maxLimit = <? echo $def_descr_size; ?>;
		$('.check_descr_length', elmForm).each(function(){
			if (this.value.length > maxLimit)
			{
				this.value = this.value.substring(0, maxLimit);
			}
			
			$('.check_descr_mes', this.form).val(maxLimit - this.value.length);
		});
	}
	

	function initChBoxes()
	{
		$('.ch_map').click(function(){
			$('.map_content', this.form).toggleClass('hhh', !$(this).attr('checked'));
		});
	}


	function initForms()
	{
		$('.firm_form').submit(noAct);
		$('.firm_form_but').click(doSubmit);
	}


	function noAct()
	{
		return false;
	}


	function doSubmit()
	{
		$(this.form.inbut).val( $(this).val() );
		$('.loader', this.form).css('visibility', 'visible');
		$('.firm_form_but', this.form).addClass('disabled').attr('disabled', 'disabled');
		
		$.post(	$(this.form).attr('action'),
				$(this.form).serialize(),
				showSubmit,
				'json'
				);
	}


	function showSubmit(data)
	{
		if (!data.ok)
		{
			alert('Ошибка обработки запроса' + "\n" + data);

			return;
		}
		
		$('#firm_' + data.id).get(0).scrollIntoView();
		$('#firm_' + data.id).slideUp(1000, function() {
			var newElm 	= $('<div id="firm_' + data.id + '_mes" align="center" style="display: none">' 
						+ data.message + '</div>');
			$(this).replaceWith(newElm);
			newElm.slideDown();
		});
	}


	$(window).load(function() {
		initChBoxes();
		initForms();
		textCounter();
	});
</script>

<style type="text/css">
	.hhh {
		display: none;
	}
	.loader {
		background: no-repeat url('images/go.gif');
		width: 16px;
		height: 16px;
		visibility: hidden;
	}	
	.disabled {
		color: #ccc !important;
		border-color: #ccc !important;
	}
</style>

<form action="firms.php?REQ=auth" method="post">
<table width="100%" border="0">
  <tr>
    <td><img src="images/activations.png" width="32" height="32" align="absmiddle" alt="" /><span class="maincat"><? echo $def_admin_newreg; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34" alt="" /></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" alt="" /></td>
            <td width="160" class="vclass"><img src="images/allactiv.gif" width="31" height="31" align="absmiddle" alt="" /><a href="firms.php?REQ=all" onclick="return confirm('Вы действительно желаете одобрить все регистрации?');"><? echo $def_admin_newreg_all; ?></a></td>
            <td width="160" class="vclass"><img src="images/delactiv.gif" width="31" height="31" align="absmiddle" alt="" /><a href="firms.php?REQ=del" onclick="return confirm('Вы действительно желаете отклонить все регистрации?');"><? echo $def_admin_newreg_del; ?></a></td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" alt="" /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="22">
		<? echo $def_admin_newreg_sum; ?>: <b><? echo $newfirms; ?></b>&nbsp;
		<img src="images/info_t.gif" width="5" height="22" align="absmiddle" alt="" />&nbsp;
		<? echo $def_admin_newreg_page; ?>:
		<select name="kol_firms" onchange="this.form.submit();">
			<?
			for ($jkf = 1; $jkf < 20; $jkf++)
			{
				echo '<option value="' . $jkf . '"',
					($_SESSION['kol_firms'] == $jkf ? ' selected="selected"' : ''),
					'>' . $jkf . '</option>';
			}
			?>
		</select>
 		&nbsp;<img src="images/info_t.gif" width="5" height="22" align="absmiddle" alt="" />&nbsp;Сортировать по:
  		<select name="sort_afirms" onchange="this.form.submit();">
    		<option value="ORDER BY selector DESC" <? if ($_SESSION['sort_afirms']=='ORDER BY selector DESC') echo 'selected="ORDER BY selector DESC"'; ?>>по дате (новые)</option>
    		<option value="ORDER BY selector" <? if ($_SESSION['sort_afirms']=='ORDER BY selector') echo 'selected="ORDER BY selector"'; ?>>по дате (старые)</option>
		<option value="ORDER BY firmname" <? if ($_SESSION['sort_afirms']=='ORDER BY firmname') echo 'selected="ORDER BY firmname"'; ?>>по названию (A->Я)</option>
    		<option value="ORDER BY firmname DESC" <? if ($_SESSION['sort_afirms']=='ORDER BY firmname DESC') echo 'selected="ORDER BY firmname DESC"'; ?>>по названию (Я->А)</option>
  		</select>
	</td>
  </tr>
</table>
</form>
<?
// Пишим логи и выдаем сообщение
switch ($firm_mess)
{
	case 1: // Удалили всех успешно
	{
		logsto($def_admin_log_newaddeddel);
		msg_text('80%', $def_admin_message_ok, $def_admin_log_newaddeddel);
	}
		break;

	case 2: // Удалять некого
	{
		msg_text('80%', $def_admin_message_error, $def_admin_newreg_no);
	}
		break;

	case 3: // Активировали всех успешно
	{
		logsto($def_admin_log_newaddedall);
		msg_text('80%', $def_admin_message_ok, $def_admin_log_newaddedall);
	}
		break;

	case 4: // Активировать некого
	{
		msg_text('80%', $def_admin_message_error, $def_admin_newreg_no);
	}
		break;

	default:
		break;
}

// Смотрим фирмы на активацию

if ($_GET['REQ'] == 'auth' or $can == 'yes' or $_GET['users'] == 'all')
{
	if ($newfirms > 0)
	{
		$rowsc = $newfirms;
		if ($_SESSION['kol_firms'] < $newfirms)
		{
			$rowsc = $_SESSION['kol_firms'];
		}
		
		for ($a = 0; $a < $rowsc; $a++)
		{
			$f = $db->fetcharray($r);

			if ($def_int_dle == 'YES')
			{
				?>
				<a href="./firms.php?users=all">
					<strong><font color="red">Показать только пользователей</font></strong></a>
				<br /><br />
				<?
			}

			$seichas = $a + 1;
			?>
<br />
<table id="firm_<? echo $f['selector']; ?>" width="80%" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="4"><img src="images/table_sys_01.gif" width="4" height="26" alt="" /></td>
		<td background="images/table_sys_02.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="16" align="center"><img src="images/table_sys_vdv.gif" width="8" height="20" alt="" /></td>
					<td width="100">№ <? echo $seichas; ?> <? echo $def_admin_newreg_iz; ?> <? echo $newfirms; ?></td>
					<td>ID = <? echo $f['selector']; ?></td>
					<td width="16" align="right"><img src="images/table_sys_zn.gif" width="16" height="16" alt="" /></td>
				</tr>
			</table>
		</td>
		<td width="5"><img src="images/table_sys_03.gif" width="5" height="26" alt="" /></td>
	</tr>
	<tr>
		<td width="4" background="images/table_sys_04.gif">&nbsp;</td>
		<td>
			<br />
			<form action="firms.php" method="post" class="firm_form">
			<table width="100%" border="0" cellspacing="0" cellpadding="1" align="center">
				<tr>
					<td align="right">
						<? echo $def_admin_comments; ?>: &nbsp;&nbsp;
					</td>
					<td align="left">
						<input type="text" name="comment" size="40" maxlength="100"
							   value="<? echo $f['comment']; ?>">
					</td>
				</tr>
				<tr>
					<td align="right">
						<? echo $def_admin_category; ?>: &nbsp;&nbsp;
					</td>
					<td align="left">
						<select name="category[]" multiple style="width:550px; height:210px;">
<?php
$category_list = explode(':', $f['category']);

$re = $db->query('SELECT * FROM ' . $db_category . ' ORDER BY category');
$results_amount1 = mysql_num_rows($re);

for ($i = 0; $i < $results_amount1; $i++)
{
	$fe = $db->fetcharray($re);

	$sql = 'SELECT * FROM ' . $db_subcategory . '
		WHERE catsel = ' . $fe['selector'] . '
		ORDER BY subcategory';
	$ree = $db->query($sql, 1);
	$results_amount2 = mysql_num_rows($ree);

	if ($results_amount2 == 0)
	{
		$results_amount2 = 1;
	}

	for ($j = 0; $j < $results_amount2; $j++)
	{
		$fee = $db->fetcharray($ree);
		$sql = 'SELECT * FROM ' . $db_subsubcategory . '
			WHERE catsel = "' . $fe['selector'] . '" AND catsubsel = "' . $fee['catsubsel'] . '"
			ORDER BY subsubcategory';
		$reee = $db->query($sql, 1);
		$results_amount3 = mysql_num_rows($reee);

		if ($results_amount3 == 0)
		{
			$results_amount3 = 1;
		}

		for ($k = 0; $k < $results_amount3; $k++)
		{
			$found = false;
			$feee = $db->fetcharray($reee);

			for ($cat1 = 0; $cat1 < count($category_list); $cat1++)
			{
				if (!isset($fee['catsubsel']))
				{
					$fee['catsubsel'] = 0;
				}
				
				if (!isset($feee['catsubsubsel']))
				{
					$feee['catsubsubsel'] = 0;
				}

				$tmp = $fe['selector'] . '#' . $fee['catsubsel'] . '#' . $feee['catsubsubsel'];
				if ($category_list[$cat1] == $tmp)
				{
					$found = true;
				}
			}

			$key = $fe['selector'] . '#' . $fee['catsubsel'] . '#' . $feee['catsubsubsel'];
			$val = $fe['category'];
			if ($fee['catsubsel'] != 0)
			{
				$val .= ' / ' . $fee['subcategory'];
				if ($feee['catsubsubsel'] != 0)
				{
					$val .= ' / ' . $feee['subsubcategory'];
				}
			}

			echo '<option value="' . $key . '"',
				($found ? 'selected="selected"' : ''),
				'>' . $val . '</option>';
		}
	}
}
?>
						</select>
					</td>
				</tr>
<?
$ree = $db->query('SELECT * FROM ' . $db_location . ' WHERE locationselector="' . $f['location'] . '"', 1);
$fee = $db->fetcharray($ree);

echo '<tr><td align=right>',
		($def_country_allow == 'YES' ? $def_admin_country : $def_admin_city),
		': &nbsp;&nbsp;</td>
	<td align=left><font face=verdana size=1>' . $fee['location'] . '</font></td></tr>';

if ($def_states_allow == 'YES')
{
	$ree = $db->query('SELECT * FROM ' . $db_states . ' WHERE stateselector="' . $f['state'] . '"', 1);
	$fee = $db->fetcharray($ree);

	echo '<tr><td align="right">' . $def_admin_state . ': &nbsp;&nbsp;</td>
		<td align="left"><font face="verdana" size="1">' . $fee['state'] . '</font></td></tr>';
}

foreach (array('A', 'B', 'C', 'D') as $key)
{
	$tmpVar = 'def_' . $key . '_enable';
	$tmpVal = 'def_' . $key;

	if ($key != 'D' && $$tmpVar != 'YES')
	{
		continue;
	}

	echo '<tr><td align="right"><label for="listing_' . $key. '">' . $$tmpVal . ':</label> &nbsp;&nbsp;</td>
		<td align="left">
			<input id="listing_' . $key. '" type="radio" name="listing" value="' . $key. '" 
				style="border:0;" ',
			($key == 'D' ? 'checked="checked"' : ''),
		'></td></tr>';
}

echo '<tr><td align="right"><b>' . $def_admin_title . ':</b> <font color="red" size="1">*</font></td>
	<td align="left">
		<input type="text" name="firmname" maxlength="100" size="40" value="' . $f['firmname'] . '">
	</td></tr>';

$f['business'] = str_replace('<br>', "\n", $f['business']);

echo '<tr>
	<td align="right" valign="middle">
		' . $def_admin_descr . ':&nbsp;&nbsp;
	</td>
	<td align="left">
		<font face="verdana" size="1">
			<textarea name="business" cols="20" rows="5" style="width:550px;" class="check_descr_length"
				onKeyDown="textCounter(this.form);"
				onKeyUp="textCounter(this.form);"
				>' . $f['business'] . '</textarea>
			<br>
			<input readonly type="text" size="4" maxlength="4" value="' . $def_descr_size . '" class="check_descr_mes">
			' . $def_characters_left . '
		</font>
	</td>
</tr>';

if ($def_country_allow == 'YES')
{
	echo '<tr><td align="right">' . $def_admin_city . ': <font color="red" size="1">*</font></td>
		<td align="left">
			<input type="text" maxlength="100" name="city" size="40" value="' . $f['city'] . '">
		</td></tr>';
}

foreach (array('address', 'zip', 'phone', 'fax', 'mobile', 'icq', 'manager', 'mail', 'www') as $key)
{
	$tmpVal = 'def_admin_' . $key;
	
	$attr = 'maxlength="100"';
	
	if ($key == 'address')
	{
		$attr = 'maxlength="200"';
	}
	elseif ($key == 'mail')
	{
		$attr .= ' onBlur="checkemail(this.value)"';
	}

	
	
	echo '<tr><td align="right">' . $$tmpVal . ': &nbsp;&nbsp;</td>
		<td align="left">
			<input type="text" name="' . $key . '" size="40" ' . $attr . ' value="' . $f[$key] . '" />';
	if ($key == 'icq' && $f['icg'] != '')
	{
		echo '<img src="http://web.icq.com/whitepages/online?icq=' . $f['icq'] . '&img=21" alt="" />';
	}
	
	echo '</td></tr>';
}

if ($def_reserved_1_enabled == "YES") 
 echo '<tr><td align="right">'.$def_reserved_1_name.': &nbsp;&nbsp;</td><td align="left"><input type="text" name="reserved_1" size="40" value="'.$f[reserved_1].'" maxlength="100" /></td></tr>';

if ($def_reserved_2_enabled == "YES") 
 echo '<tr><td align="right">'.$def_reserved_2_name.': &nbsp;&nbsp;</td><td align="left"><input type="text" name="reserved_2" size="40" value="'.$f[reserved_2].'" maxlength="100" /></td></tr>';

if ($def_reserved_3_enabled == "YES") 
 echo '<tr><td align="right">'.$def_reserved_3_name.': &nbsp;&nbsp;</td><td align="left"><input type="text" name="reserved_3" size="40" value="'.$f[reserved_3].'" maxlength="100" /></td></tr>';


echo '<tr><td align="right">' . $def_admin_registered . ': &nbsp;&nbsp;</td>
	<td align="left"><font face="verdana" size="1">',
		undate($f['date'], $def_datetype),
	'</font></td></tr>';

echo '<tr><td align="right">IP: &nbsp;&nbsp;</td>
	<td align="left"><font face="verdana" size="1">' . $f['ip'] . '</font></td></tr>';

echo '<tr><td align="right">' . $def_admin_login . ': &nbsp;&nbsp;</td>
	<td align="left"><font face="verdana" size="1">' . $f['login'] . '</font></td></tr>';

// Ищем похожие компании

echo '<tr><td align=right>' . $def_admin_newreg_related . ': &nbsp;&nbsp;</td>';

	$rel_firms = array('ЧП', 'ИП', 'ТОО', 'АО', 'ООО', 'ОО');

	$firmname_r = str_replace($rel_firms, '', $f['firmname']);

	$firmname_r = trim($firmname_r);

	$sql = 'SELECT * FROM ' . $db_users . ' 
		WHERE firmstate="on" AND firmname != "" AND firmname LIKE "%' . $firmname_r . '%"';
	$f_reg = $db->query($sql, 1);

	$results_amount_f_reg = mysql_num_rows($f_reg);

	echo '<td align=left>';

	if ($results_amount_f_reg>0)
	{
		echo '<img src="images/stop.gif" width="16" height="16" align="absmiddle">
			<font face="verdana" size="1">' . $def_admin_newreg_related_find . ':
				<b>' . $results_amount_f_reg . '</b></font><br />';

		for ($iii = 0; $iii < $results_amount_f_reg; $iii++)
		{
			$rel_f = $db->fetcharray($f_reg);
			echo '&nbsp;&nbsp;', ($iii + 1),
				'.<a href="' . $def_mainlocation . '/view.php?id=' . $rel_f['selector'] . '" target="_blank">',
					$rel_f['firmname'] . '</a> (' . $rel_f['mail'] . ')<br />';
		}
	}
	else
	{
		echo '0';
	}

echo '</td></tr>';

?>
	<tr>
		<td align="right" valign="top">
			<label>Добавить сообщение&nbsp;<input class="ch_map" type="checkbox" /></label>&nbsp;&nbsp;
		</td>
		<td align="left">
			<div class="map_content hhh">
				<textarea name="email_plus" cols="45" rows="5" style="width:550px;"></textarea>
			</div>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2">
			<input type="hidden" name="idin" value="<? echo $f['selector']; ?>" />
			<input type="hidden" name="REQ" value="complete" />
			<input type="hidden" name="inbut" value="" />
			
			<table>
				<tr>
					<td>
						<input type="button" value="<? echo $def_admin_newreg_approve; ?>" border="0"
							   class="firm_form_but" />&nbsp;
						<input type="button" value="<? echo $def_admin_newreg_remove; ?>" class="firm_form_but"
							   style="color: #FFFFFF; background: #D55454;" />
					</td>
					<td>
						<div class="loader"> </div>
					</td>
				</tr>
			</table>
				   
		</td>
	</tr>
</table>
</form><br />

		</td>
		<td width="5" background="images/table_sys_06.gif">&nbsp;</td>
	</tr>
	<tr>
		<td width="4"><img src="images/table_sys_07.gif" width="4" height="5" alt="" /></td>
		<td background="images/table_sys_08.gif"><img src="images/table_sys_08.gif" width="4" height="5" alt="" /></td>
		<td width="5"><img src="images/table_sys_09.gif" width="4" height="5" alt="" /></td>
	</tr>
</table>
<br /><br />
			<?
		} // endfor для списка фирм
	}
	// Новые фирмы отсутствуют
	else
	{
		msg_text('80%', $def_admin_message_mess, $def_admin_nonewregs);
		if ($def_int_dle == 'YES')
		{
			?>
			<strong>
				<a href="./firms.php?users=all"><font size="+1">Показать только пользователей</font></a>
			</strong>
			<?
		}
	}
}

require_once 'template/footer.php';

?>
