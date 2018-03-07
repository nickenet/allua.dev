<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & K.Ilya
=====================================================
 Файл: editcommentnews.php
-----------------------------------------------------
 Назначение: Одобрить комментарии к новостям
=====================================================
*/

session_start();

require_once './defaults.php';

check_login_cp('3_9','editcatnews.php?REQ=auth');

$help_section = (string)$reviews_news_help;

$title_cp = 'Одобрить комментарии к новостям - ';
$speedbar = ' | <a href="editallnews.php">Управление новостями</a> | <a href="editcommentnews.php?REQ=auth">Одобрить комментарии к новостям</a>';

        if (empty($_SESSION['comnews'])) {
            $rstat_comnews = $db->query('SELECT * FROM ' . $db_newsrev . ' WHERE status="off"');
            $_SESSION['comnews']=mysql_num_rows($rstat_comnews);
            mysql_free_result($rstat_comnews);
        }

if (isset($_POST['kol_news_rews']))
{
	$_SESSION['kol_news_rews'] = (int)$_POST['kol_news_rews'];
}

if (empty($_SESSION['kol_news_rews']))
{
	$_SESSION['kol_news_rews'] = 5;
}

$can = '';

if (isset($_POST['REQ']) && $_POST['REQ'] == 'complete')
{
	$data = array(	'id' => $_POST['idin'], 
					'message' => '',
					'ok' => 0);

	foreach (array('inbut', 'user', 'review', 'mail') as $key)
	{
		$_POST[$key] = iconv('utf-8', 'windows-1251', $_POST[$key]);
	}
	
	if ($_POST['inbut'] == (string)$def_admin_newreg_approve)
	{
		$user = safeHTML($_POST['user']);
		$message = safeHTML($_POST['review']);

		$mail = safeHTML($_POST['mail']);

		$sql	= 'UPDATE ' . $db_newsrev . ' '
				. 'SET user="' . $user . '", '
				.	'review="' . $message . '", '
				.	'status="on", '
				.	'mail="'. $mail . '" '
				. 'WHERE id="' . $_POST['idin'] . '"';
		$db->query($sql) or die(mysql_error());
                $news=intval($_POST['news']);
                $db->query("UPDATE $db_news SET comments=comments+1 WHERE selector='$news'");

		logsto('Комментарий к новости одобрен - ID = ' . $_POST['idin']);

                unset ($_SESSION['comnews']);

		$can = 'yes';
		$rew_ok = 1;
		
		ob_start();
		msg_text('80%', $def_admin_message_ok, 'Комментарий <b>' . $data['id'] . '</b> добавлен в базу данных.');
		$data['message'] = ob_get_clean();
	}
	else
	{
		$db->query('DELETE FROM ' . $db_newsrev . ' WHERE id="' . $_POST['idin'] . '"') or die('mySQL error!');

		logsto('Комментарий к новости отклонен - ID = ' . $_POST['idin']);

                unset ($_SESSION['comnews']);

		$can = 'yes';
		$rew_ok = 2;

		ob_start();
		msg_text('80%', $def_admin_message_ok, 'Комментарий <b>' . $data['id'] . '</b> отклонен.');
		$data['message'] = ob_get_clean();
	}

	$data['message'] = iconv('windows-1251', 'utf-8', $data['message']);
	$data['ok'] = 1;
	echo json_encode($data);

	exit;
}

if ($_GET['REQ'] != 'auth' && $can != 'yes')
{
	return;
}

require_once 'template/header.php';

?>

<script type="text/javascript">

function textCounter (field, countfield, maxlimit)
{
	if (field.value.length > maxlimit)
	{
		field.value = field.value.substring(0, maxlimit);
	}
	else
	{
		countfield.value = maxlimit - field.value.length;
	}
}


function initForms()
{
	$('.review_form').submit(noAct);
	$('.review_form_but').click(doSubmit);
}


function noAct()
{
	return false;
}


function doSubmit()
{
	$(this.form.inbut).val( $(this).val() );
	
	$('.loader', this.form).css('visibility', 'visible');
	$('.review_form_but', this.form).addClass('disabled').attr('disabled', 'disabled');

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

	$('#comment_' + data.id).slideUp(function() { 
		$(this).replaceWith('<div id="comment_' + data.id + '_mes" align="center" style="display: none">' + data.message + '</div>');
		$('#comment_' + data.id + '_mes').slideDown();
	});
}


$(window).load(function() {
	initForms();
});
</script>

<style type="text/css">
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

<form action="editcommentnews.php?REQ=auth" method="post">
<table width="100%" border="0">	
	<tr>	
		<td><img src="images/news.png" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;Одобрить комментарии к новостям</span></td>
	</tr>	
	<tr>	
		<td height="1" bgcolor="#D7D7D7"></td>
	</tr>	
	<tr>	
		<td>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">	
				<tr>	
					<td width="3"><img alt="" src="images/button-l.gif" width="3" height="34" /></td>	
					<td background="images/button-b.gif">
<table width="100%" border="0" cellspacing="0" cellpadding="0">	
	<tr>	
		<td width="13" align="center"><img alt="" src="images/vdv.gif" width="13" height="31" /></td>	
		<td width="160" class="vclass"><img alt="" src="images/find.gif" width="31" height="31" align="absmiddle" /><a href="editcommentnews2.php?REQ=auth">Поиск комментариев</a></td>
		<td width="160" class="vclass"><img alt="" src="images/delactiv.gif" width="31" height="31" align="absmiddle" /><a href="editcommentnews.php?REQ=auth&del=del"><? echo $def_admin_newreg_del; ?></a> <? if($_SESSION['comnews']) echo '('.$_SESSION['comnews'].')'; ?></td>
		<td align="right"> 
			Показать на странице 
			<select name="kol_news_rews" onchange="this.form.submit();">
				<?
				for ($jkf = 1; $jkf < 21; $jkf++)
				{
					echo '<option value="' . $jkf . '"',
						($_SESSION['kol_news_rews'] == $jkf ? ' selected="selected"' : ''),
						'>' . $jkf . '</option>';
				}
				?>
			</select>
		</td>
	</tr>
</table>
						</td>
					<td width="3"><img alt="" src="images/button-r.gif" width="5" height="34" /></td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</form>
<br />

<?

if ($_GET['del'] == 'del')
{
        $db->query('DELETE FROM ' . $db_newsrev . ' WHERE status="off"') or die('mySQL error!');

	logsto('Отклонены все комментарии к новостям');

        unset ($_SESSION['comnews']);

	msg_text('80%', $def_admin_message_ok, 'Все комментарии были отклонены.');

}

$ra = $db->query('SELECT * FROM ' . $db_newsrev . ' WHERE status="off"') or die('mySQL error!');

if (mysql_num_rows($ra) > 0)
{
	$newfirms = mysql_num_rows($ra);
	$rowsc = $newfirms;
	if ($_SESSION['kol_news_rews'] < $rowsc)
	{
		$rowsc = $_SESSION['kol_news_rews'];
	}

	for ($a = 0; $a < $rowsc; $a++)
	{
		$fa = $db->fetcharray($ra);

		$nn_com = $a + 1;

		$sql = 'SELECT * FROM ' . $db_news . ' WHERE selector = "' . $fa['news'] . '"';
		$r = $db->query($sql) or die('mySQL error!');
		$firm = $db->fetcharray($r);

		$fa['review'] = str_replace('<br>', "\n", $fa['review']);
		?>

<table id="comment_<? echo $fa['id']; ?>" width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="4"><img alt="" src="images/table_sys_01.gif" width="4" height="26" /></td>
		<td background="images/table_sys_02.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="16" align="center"><img alt="" src="images/table_sys_vdv.gif" width="8" height="20" /></td>
					<td>Комментарий <? echo $nn_com; ?> из <? echo $newfirms; ?> [ ID = <? echo $fa['id']; ?> ]</td>
					<td width="16" align="right"><img alt="" src="images/table_sys_zn.gif" width="16" height="16" border="0" /></td>
				</tr>
			</table>
		</td>
		<td width="5"><img alt="" src="images/table_sys_03.gif" width="5" height="26" /></td>
	</tr>
	<tr>
		<td width="4" background="images/table_sys_04.gif">&nbsp;</td>
		<td bgcolor="#FFFFFF" align="center">
			<br />
			<form action="editcommentnews.php?REQ=auth" method="post" class="review_form">
			<table width="800" border="0" cellspacing="2" cellpadding="1">
				<tr>
					<td width="180" align="right">Новость:</td>
					<td align="left">			
                                                    <? echo '<b>' . $firm['title'] . '</b> [id=' . $firm['selector'] . ']'; ?>
					</td>
				</tr>
				<tr>
					<td width="180" align="right">Посетитель:</td>
					<td align="left">
						<input type="text" name="user" size="40" value="<? echo $fa['user']; ?>" maxlength="100" />
					</td>
				</tr>
				<tr>
					<td width="180" align="right">Email:</td>
					<td align="left">
						<input type="text" name="mail" size="40" value="<? echo $fa['mail']; ?>" maxlength="100" />
					</td>
				</tr>
				<tr>
					<td width="180" align="right">
						Комментарий: <span style="color:#FF0000;">*</span>
					</td>
					<td align="left">
						<textarea name="review" cols="20" rows="5" 
								  onKeyDown="textCounter(this.form.review, this.form.remLen, <? echo $def_review_size; ?>);"
								  onKeyUp="textCounter(this.form.review, this.form.remLen, <? echo $def_review_size; ?>);"
								  style="width:516px;"><? echo $fa['review']; ?></textarea>
					</td>
				</tr>
				<tr>
					<td align="right">&nbsp;</td>
					<td align="left">
						<input readonly type="text" name="remLen" size="4" maxlength="4"
							   value="<? echo $def_review_size; ?>">
						<? echo $def_characters_left; ?>
					</td>
				</tr>
				<tr>
					<td width="180" align="right">&nbsp;</td>
					<td align="left">
						<input type="hidden" name="idin" value="<? echo $fa['id']; ?>" />
                                                <input type="hidden" name="news" value="<? echo $fa['news']; ?>" />
						<input type="hidden" name="REQ" value="complete" />
						<input type="hidden" name="inbut" value="" />
							   
						<table>
							<tr>
								<td>
									<input type="button" value="<? echo $def_admin_newreg_approve; ?>" border="0"
										   class="review_form_but" />&nbsp;
									<input type="button" value="<? echo $def_admin_newreg_remove; ?>" class="review_form_but"
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
			</form>
			<br />
		</td>
		<td width="5" background="images/table_sys_06.gif">&nbsp;</td>
	</tr>
	<tr>
		<td width="4"><img src="images/table_sys_07.gif" width="4" height="5" alt="" /></td>
		<td background="images/table_sys_08.gif"><img src="images/table_sys_08.gif" width="4" height="5" alt="" /></td>
		<td width="5"><img src="images/table_sys_09.gif" width="4" height="5" alt="" /></td>
	</tr>
</table>
<br />

		<?
	}
}
else 
{
	msg_text('80%',$def_admin_message_mess,'Нет новых комментариев.');

	?>

<br />
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
	<tr>
		<td width="4"><img src="images/table_sys_01.gif" width="4" height="26" alt="" /></td>
		<td background="images/table_sys_02.gif">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="16" align="center"><img src="images/table_sys_vdv.gif" width="8" height="20" alt="" /></td>
					<td>Искать комментарий</td>
					<td width="16" align="right"><img src="images/table_sys_zn.gif" width="16" height="16" border="0" alt="" /></a></td>
				</tr>
			</table>
		</td>
		<td width="5"><img src="images/table_sys_03.gif" width="5" height="26" alt="" /></td>
	</tr>
	<tr>
		<td width="4" background="images/table_sys_04.gif">&nbsp;</td>
		<td bgcolor="#FFFFFF" align="center">
			<br />
			<form action="editcommentnews2.php?REQ=auth" method="post">
				<table width="100%" cellpadding="2" cellspacing="1" border="0">
					<tr>
						<td align="right">ID комментария: &nbsp;&nbsp;</td>
						<td align="left"><input type="text" name="id" maxlength="100" size="40" /></td>
					</tr>
					<tr>
						<td align="center" colspan="2"><input type="submit" name="inbut" value="Искать" /></td>
					</tr>
				</table>
			</form>
			<br />
		</td>
		<td width="5" background="images/table_sys_06.gif">&nbsp;</td>
	</tr>
	<tr>
		<td width="4"><img src="images/table_sys_07.gif" width="4" height="5" alt="" /></td>
		<td background="images/table_sys_08.gif"><img src="images/table_sys_08.gif" width="4" height="5" alt="" /></td>
		<td width="5"><img src="images/table_sys_09.gif" width="4" height="5" alt="" /></td>
	</tr>
</table>

	<?
}

require_once 'template/footer.php';

?>
