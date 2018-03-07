<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D.Madi
  =====================================================
  Файл: shablon.php
  -----------------------------------------------------
  Назначение: Управление шаблонами
  =====================================================
 */

session_start();

require_once './defaults.php';

if (empty($_SESSION['part_template']))
{
	$_SESSION['part_template'] = 'template';
}

if (empty($_SESSION['template']))
{
	$_SESSION['template'] = $def_template;
}

if (isset($_POST['part_template']))
{
	$dir = '../' . $_POST['part_template'];
	if (is_dir($dir))
	{
		$_SESSION['part_template'] = $_POST['part_template'];
	}
	
	$dir = '../' . $_SESSION['part_template'] . '/' . $_POST['template'];
	if (is_dir($dir))
	{
		$_SESSION['template'] = $_POST['template'];
	}
}

if (!empty($_REQUEST['ajax_action']))
{
	require dirname(__FILE__) . '/inc/shablon_ajax.php';
	
	exit;
}

$help_section = (string) $shablon_help;

$title_cp = 'Редактирование шаблонов - ';
$speedbar = ' | <a href="shablon.php">Редактирование шаблонов</a>';

check_login_cp('4_6','shablon.php');

require_once 'template/header.php';
?>
<link media="screen" href="../includes/codemirror/filetree.css" type="text/css" rel="stylesheet" />
<link media="screen" href="../includes/codemirror/css/codemirror.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../includes/codemirror/filetree.js"></script>
<script type="text/javascript" src="../includes/codemirror/js/codemirror.js"></script>
<table width="100%" border="0">
	<tr>
		<td>
			<img src="images/shablon.png" width="32" height="32" align="absmiddle" /> 
			<span class="maincat">Редактирование шаблонов</span>
		</td>
	</tr>
	<tr>
		<td height="1" bgcolor="#D7D7D7"></td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="3"><img src="images/button-l.gif" width="3" height="34" /></td>
					<td style="background: url(images/button-b.gif) repeat-x top;">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
								<td width="580" class="vclass">
									<form name="form_template" method="post" action="shablon.php">
										Папка шаблонов&nbsp;<input name="part_template" type="text" value="<? echo $_SESSION['part_template']; ?>" />
										&nbsp;Шаблон&nbsp;
										<select name="template">
											<?
											$dir = '../' . $_SESSION['part_template'];
											$list = glob($dir . '/*', GLOB_ONLYDIR);

											foreach ($list as $path)
											{
												$file = basename($path);
												if ($_SESSION['template'] == $file)
												{
													$selected = ' selected="selected"';
												}
												else
												{
													$selected = '';
												}
													
												echo '<option value="' . $file . '"' . $selected . '>' . $file . '</option>';
											}
											?>
										</select>
										&nbsp;<input type="submit" name="edit_template" value="выбрать" />
									</form>
								</td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
					<td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
				</tr>
			</table>
			
			<table width="100%">
				<tr>
					<td width="220">
						<div id="filetree" class="filetree"></div>
					</td>
					<td valign="top">
						<div id="fileedit" style="border: solid 1px #BBB;height: 510px; padding:5px;"></div>
					</td>
				</tr>
			</table>
			<script type="text/javascript">
				$(document).ready( function() {

					$('#filetree').fileTree(	{
													root: '',
													script: 'shablon.php?ajax_action=init', 
													folderEvent: 'click', 
													expandSpeed: 750, 
													collapseSpeed: 750, 
													multiFolder: false
												}, 
												function (file)
												{ 
													$.post(	'shablon.php', 
															{ ajax_action: 'load', file: file }, 
															function(data){
																RunAjaxJS('fileedit', data);
															});
												}
					);
				});

				function savefile( file )
				{
					var content = editor.getCode();

					$.post(	'shablon.php', 
							{ ajax_action: 'save', file: file, content: content }, 
							function(data)
							{
								var message;
								if ( data == 'ok' ) 
								{
									message = 'Файл успешно сохранён.';
								} 
								else 
								{
									message = 'Ошибка сохранения файла.';
								}

								alert(message);
							}
					);
				};
			</script>

		
		</td>
	</tr>
</table>

<?
require_once 'template/footer.php';
?>