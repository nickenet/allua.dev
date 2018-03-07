<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya K.
  =====================================================
  Файл: seo.php
  -----------------------------------------------------
  Назначение: Имя страницы и SEO
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

// Генератор метатегов
// мета-тег title

$meta_title_ex = chek_meta($f['firmname']);

// мета-тег description
$meta_descr_ex = chek_meta($f['business']);
$meta_descr_ex = substr($meta_descr_ex, 0, 200);
$meta_descr_ex = substr($meta_descr_ex, 0, strrpos($meta_descr_ex, ' '));
$meta_descr_ex = trim($meta_descr_ex);
// мета-тег keywords
$meta_keyw_ex = check_keywords($f['business']);


// Изменение мета-тегов
if ($_POST["changed"] == "true")
{

	$title_asd = safeHTML($_POST['title']);
	$descr_asd = safeHTML($_POST['descr']);
	$keywords_asd = safeHTML($_POST['keywords']);

	$domen = safeHTML($_POST['domen']);

	$submit_error = '';

         if ($domen!='') {

        $domen=strtr($domen,'_','*');
	$domen = rewrite($domen);
        $domen=strtr($domen,'*','_');
	$r_d = $db->query("SELECT selector FROM $db_users WHERE domen='$domen' and selector!='$f[selector]' ");
	$domens = mysql_num_rows($r_d);

	if ($domens > 0)
	{
		$submit_error = $def_reg_domen_used;
		$domen = '';
	}
        }

	$db->query("UPDATE $db_users SET metatitle='$title_asd', metadescr='$descr_asd', metakeywords='$keywords_asd', domen='$domen' WHERE login='$_SESSION[login]' and selector='$f[selector]'");

	if ($submit_error == '')
		echo '<center><div align="center" id="messages">Ваши данные успешно обновлены! <img src="' . $def_mainlocation . '/users/template/images/ok.gif" width="64" height="64" hspace="2" vspace="2" align="middle"></div></center>';
	else
		echo '<center><div align="center" id="messages"><img src="' . $def_mainlocation . '/users/template/images/error.gif" width="64" height="64" hspace="2" vspace="2"><br><font color=red><b>Ошибка!</b></font><br>' . $submit_error . '</div></center>';
}



if (empty($_POST["changed"]))
{
	?>

	<table width="100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
	        <td><div id="TabbedPanels1" class="TabbedPanels">
					<ul class="TabbedPanelsTabGroup">
						<li class="TabbedPanelsTab" tabindex="0">Имя страницы и SEO</li>
					</ul>
					<div class="TabbedPanelsContentGroup">
						<div class="TabbedPanelsContent">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
									<td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Имя и SEO параметры страницы</span></td>
												<td width="50">&nbsp;</td>
											</tr>
										</table></td>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
								</tr>
								<tr>
									<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
									<td class="tb_cont">

										<form action="?REQ=authorize&mod=seo" method="post" id='regform'>

											<table border="0" cellspacing="2" cellpadding="2">
												<tr>
													<td align="right">Мета-тег &lt;title&gt;:&nbsp;</td>
													<td align="left">
														<input type="text" name="title" maxlength="100" style="width:300px;" value="<? echo $f['metatitle']; ?>" id="meta_title_content"> <span class="txt tooltip-main well">[<a title="Укажите только название вашей компании, с кратким описанием основного вида деятельности." rel="tooltip" href="#">?</a>]</span>&nbsp;<a class="btn btn-large disabled" data-toggle="modal" href="#myModal" >Пример</a>
													</td>
												</tr>
												<tr>
													<td align="right">Мета-тег description:&nbsp;</td>
													<td align="left">
														<input type="text" name="descr" maxlength="250" style="width:300px;" value="<? echo $f['metadescr']; ?>" id="meta_desc_content"> <span class="txt tooltip-main well">[<a title="Очень кратко сформируйте основное описание деятельности Вашей компании." rel="tooltip" href="#">?</a>]</span>
													</td>
												</tr>
												<tr>
													<td align="right" valign="top">Мета-тег keywords:&nbsp;<br><br>
														<input type="button" id="fill_meta" value="Сгенерировать" class="btn"><br>
														<input type="button" id="clean_meta" value="Очистить" class="btn">
													</td>
													<td align="left">
														<textarea name="keywords" cols="20" rows="4" style="width:400px;" id="meta_keys_content"><? echo $f['metakeywords']; ?></textarea> <span class="txt tooltip-main well">[<a title="Перечислите через запятую ключевые слова Вашего бизнеса, которые обязательно присутствуют в описании компании." rel="tooltip" href="#">?</a>]</span>
													</td>
												</tr>
												<tr>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<tr>
													<td align="right">Имя Вашей странички:&nbsp;<? echo $def_mainlocation . '/'; ?></td>
													<td align="left">
														<input type="text" name="domen" id="domen" maxlength="55" style="width:300px;" <? if (($def_soc_dis_D=="YES") and ($f['flag']=='D')) echo 'disabled="true"'; ?> value="<? echo $f['domen']; ?>">
														<input type="button" onclick="checkDomen()" value="Проверить" class="btn">&nbsp;<img id="domen_loader" src="../images/go.gif" alt="loading" style="visibility:hidden">
														<div id="domen_list"></div>
													</td>
												</tr>
												<tr>
													<td align="right"><input type="submit" name="button" value="Сохранить"><input type="hidden" name="changed" value="true"></td>
													<td>&nbsp;</td>
												</tr>
											</table>

										</form>

										<div id="myModal" class="modal hide fade">
											<div class="modal-header">
												<h2>Пример описания мета-тегов</h2>
											</div>
											<div class="modal-body">
												<p><b class="btn btn-large disabled">Мета-тег &lt;title&gt;</b></p>
												<p id="meta_title"><? echo $meta_title_ex; ?></p>
												<p><b class="btn btn-large disabled">Мета-тег description</b></p>
												<p id="meta_desc"><? echo $meta_descr_ex; ?></p>
												<p><b class="btn btn-large disabled">Мета-тег keywords</b></p>
												<p id="meta_keys"><? echo $meta_keyw_ex; ?></p>
											</div>
											<div class="modal-footer">
												<a href="#" class="btn" data-dismiss="modal">Закрыть</a>
											</div>
										</div>

									</td>
									<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
								</tr>
								<tr>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
									<td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
									<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
								</tr>
							</table>              
						</div>
					</div>
				</div></td>
		</tr>

		<?
		if (ifEnabled_user($f[flag], "social"))
		{
			echo '
      <tr>
        <td>&nbsp;</td>
      </tr>
        ';
		}
		else
		{
			echo '
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div class="alert alert-error">
' . $def_social_not_memberships . '
        </div></td>
      </tr>
';
		}
		?>

		<tr>
	        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
					<div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
					<div class="CollapsiblePanelContent">
	<? echo $help_seo; ?>
					</div>
				</div></td>
		</tr>
		<tr>
	        <td>&nbsp;</td>
		</tr>
		<tr>
	        <td>&nbsp;</td>
		</tr>
	</table>

	<script type="text/javascript">
		function checkDomen()
		{
			if (!$('#domen').length)
			{
				return false;
			}

			var check_value = $('#domen').val();
			if (check_value == '')
			{
				return false;
			}

			$('#domen_list').hide();
			$('#domen_loader').css('visibility', 'visible');
			$.post(
			'/users/user.php?REQ=authorize&mod=seo',
			{
				do_check: 'domen',
				check: check_value
			},
			function(data){
				$('#domen_loader').css('visibility', 'hidden');
				$('#domen_list').html(data).slideDown();
			}
			);

			return true;
		}

		var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
		var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
		
		$(function(){
			$('#fill_meta').click(fillMeta);
			$('#clean_meta').hide().click(cleanMeta);
		});
		
		var metaList = ['title', 'desc', 'keys'];
		function fillMeta()
		{
			$(metaList).each(function(k, id){
				$('#meta_' + id + '_content').val($('#meta_' + id).text());
			});
			$('#clean_meta').show();
		}
		
		function cleanMeta()
		{
			$(metaList).each(function(k, id){
				$('#meta_' + id + '_content').val('');
			});
			$('#clean_meta').hide();
		}
	</script>

	<?php
}
?>