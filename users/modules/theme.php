<?php
/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi
  =====================================================
  Файл: config.php
  -----------------------------------------------------
  Назначение: Выбор темы оформления социальной страницы
  =====================================================
 */

if (!defined('ISB'))
{
	die("Hacking attempt!");
}

$themeList = glob('../theme/*', GLOB_ONLYDIR);
foreach ($themeList as &$item)
{
	$item = basename($item);
}

unset($item);

$rstat1 = $db->query("select COUNT(*) from $db_offers where firmselector='$f[selector]'");
$rstat2 = $db->query("select COUNT(*) from $db_images where firmselector='$f[selector]'");
$rstat = mysql_result($rstat1, 0, 0) + mysql_result($rstat2, 0, 0);
$procent_g = round(($rstat / $def_min_pos_social) * 100);
if ($procent_g > 100)
	$procent_g = 100;

// Отключаем страницу

if ($_POST['disabl']==$def_sociall_turn_of) {
    $db->query("UPDATE $db_users SET theme='' WHERE login='$_SESSION[login]' and selector='$f[selector]'");
    $f['theme'] = '';
    $error_submit='<b>Успешно!</b><br>Ваша страница успешно отключена из каталога.<br>';
}

// Изменение темы оформления

if (($_POST['theme'] == "true") and ($_POST['disabl']!=$def_sociall_turn_of))
{

	// Картинки загружаем
	$img_v = explode(':', $f['design']);
	$imgExt = array('gif', 'png', 'bmp', 'jpg', 'jpeg', 'tif', 'tiff');
	$images_h = $img_v[0];
	$images_b = $img_v[1];
	$error_submit = '';
	if (isset($_FILES[key]) && is_uploaded_file($_FILES[key]['tmp_name']))
	{
		$fSize = filesize($_FILES[key]['tmp_name']);
		if ($fSize < $def_social_img_header)
		{

			$name = strtolower($_FILES[key]['name']);
			$ext = pathinfo($name, PATHINFO_EXTENSION);

			if (!in_array($ext, $imgExt))
				$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>К загрузке допускаются изображения с расширениями: gif, png, bmp, jpg, jpeg, tif, tiff.<br>';
			else
			{

				$name = '../design/header/' . $f['selector'] . '.' . $ext;
				$name_old = '../design/header/' . $f['selector'] . '.' . $images_h;

				@unlink($name_old);

				if (move_uploaded_file($_FILES[key]['tmp_name'], $name))
					$images_h = $ext;
				else
					$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>Превышение допустимого размера файла.<br>';
	}
	if (isset($_FILES[keyb]) && is_uploaded_file($_FILES[keyb]['tmp_name']))
	{
		$fSize = filesize($_FILES[keyb]['tmp_name']);
		if ($fSize < $def_social_img_header)
		{

			$name1 = strtolower($_FILES[keyb]['name']);
			$ext1 = pathinfo($name1, PATHINFO_EXTENSION);

			if (!in_array($ext1, $imgExt))
				$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>К загрузке допускаются изображения с расширениями: gif, png, bmp, jpg, jpeg, tif, tiff.<br>';
			else
			{

				$name1 = '../design/background/' . $f['selector'] . '.' . $ext1;
				$name_old1 = '../design/background/' . $f['selector'] . '.' . $images_b;

				@unlink($name_old1);

				if (move_uploaded_file($_FILES[keyb]['tmp_name'], $name1))
					$images_b = $ext1;
				else
					$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>Сервер не смог принять данный файл.<br>';
			}
		} else
			$error_submit.='<b>Ошибка! Файл фона не был загружен!</b><br>Превышение допустимого размера файла.<br>';
	}

	$images = $images_h . ':' . $images_b;
	$themeN = safeHTML($_POST['design']);
	$db->query("UPDATE $db_users SET theme='$themeN', design='$images' WHERE login='$_SESSION[login]' and selector='$f[selector]'");
	$f['theme'] = $themeN;
	$images_h = '';
	$images_b = '';
	$f['design'] = $images;
}

if ($error_submit != '')
{

	echo '<div class="alert alert-error">' . $error_submit . '</div>';
}



if ($f['domen'] == '')
	echo '<div class="alert alert-error">
		<b>Внимание!</b><br>
		У Вас не задано имя Вашей странички. Укажите имя в разделе "Имя страницы и SEO".
		</div>';

// Настройки социальной страницы

$form_set=explode(':', $f['setting_s']);

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
				<ul class="TabbedPanelsTabGroup">
					<li class="TabbedPanelsTab" tabindex="0">Дизайн и темы оформления</li>
                                        <li class="TabbedPanelsTab" tabindex="0">Настройки социальной страницы</li>
				</ul>
				<div class="TabbedPanelsContentGroup">
					<div class="TabbedPanelsContent">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
								<td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Оформление Вашей страницы</span></td>
											<td width="50">&nbsp;</td>
										</tr>
									</table></td>
								<td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
							</tr>
							<tr>
								<td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
								<td class="tb_cont">
									<div style="padding:5px;">
										<div>
											<span class="btn btn-large disabled">Ваша тема оформления</span>
											<div style="float:right;">
												<div style="padding-bottom: 5px;"  class="txt tooltip-main well"><a title="Отображает процент готовности подключения Вашей страницы к каталогу. У Вас должно быть загружено минимум <? echo $def_min_pos_social; ?> продукции(услуг) или изображений. После чего Вы можете выбрать тему и подключить к каталогу." rel="tooltip" href="#">Готовность подключения</a> <b><? echo $procent_g; ?>%</b></div>
												<div class="progress progress-info progress-striped" style="width:250px;">
													<div class="bar" style="width: <? echo $procent_g; ?>%;"></div>
												</div>
											</div>
										</div>
										<br>
										<form action="?REQ=authorize&mod=theme" method="post" enctype="multipart/form-data">
											<div style="widht:500px;">
												<ul class="thumbnails">
													<? foreach ($themeList as $theme) :?>
													<li class="span3">
														<label class="thumbnail">
															<input type="radio" name="design" value="<?=$theme?>" 
																<? if ($f['theme'] == $theme) echo 'checked' ?>>
															<img alt="" src="<? echo $def_mainlocation; ?>/theme/<?=$theme?>/images/face_theme.jpg"/>
														</label>
													</li>
													<? endforeach; ?>
												</ul>
											</div>
											<span class="btn btn-large disabled">Загрузите свои файлы</span><br><br>
											<ul class="thumbnails">
												<li class="span7">
													<span class="thumbnail">
														<span class="txt tooltip-main well">[<a title="К загрузке допускаются только изображения. Размер файла не должен превышать <? echo round(($def_social_img_header / 1024)); ?>KB." rel="tooltip" href="#">?</a>]</span> 
														Шапка: <input type="file" name="key" style="width:225px;" class="input-file">
														<input type="button" value="Удалить" class="btn" onclick="delImage('header')"><br>
														<span id="image_header">
														<? if (file_exists($header)) echo '<img alt="" src="' . $header . '" />'; ?>
														</span>
														</span>
												</li>
											</ul>
											<ul class="thumbnails">    
												<li class="span7">
													<span class="thumbnail"><span class="txt tooltip-main well">[<a title="К загрузке допускаются только изображения. Размер файла не должен превышать <? echo round(($def_social_img_bg / 1024)); ?>KB." rel="tooltip" href="#">?</a>]</span> Фон страницы: <input type="file" name="keyb" style="width:225px;" class="input-file">
														<input type="button" value="Удалить" class="btn" onclick="delImage('background')"><br>
														<span id="image_background">
															<? if (file_exists($background)) echo '<img alt="" src="' . $background . '" />'; ?>
															</span>
													</span>
												</li>
											</ul>
                                                                                        <? if (ifEnabled_user($f[flag], "social")) $txt_v='Выбрать тему и подключить страницу к каталогу'; else $txt_v='Выбрать тему';  ?>
                                                                                        <? if (($f['theme']=='') and  ($procent_g==100)) $text_page=$txt_v; ?>
                                                                                        <? if ($f['theme']!='') $text_page='Сохранить'; ?>
                                                                                        <? if ($procent_g<100) $text_page=''; ?>
											<? if ($text_page!='') {
                                                                                            echo '<input type="submit" name="button" class="btn btn-danger" value="'.$text_page.'"> ';
                                                                                            echo '<input type="submit" name="disabl" class="btn btn-warning" value="'.$def_sociall_turn_of.'">';
                                                                                        } else echo '<div class="alert alert-error">Для подключения социальной страницы, Вам нужно загрузить '.$def_min_pos_social.' позиций товаров, услуг или изображений. </div>'
                                                                                        
                                                                                        ?>
											<input type="hidden" name="theme" value="true">
                                                                                        
										</form>                                                                          
                                                                                <? if (ifEnabled_user($f[flag], "social")) echo ''; else echo '<br><br><div class="alert alert-error">' . $def_social_not_memberships . '</div>'; ?>

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
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Настройки социальной страницы</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont" align="right">
                      <div style="padding:5px;">
                      <form action="?REQ=authorize&mod=theme" method="post" id="page_settings">

                          <span class="btn btn-large disabled">Перевод сайта</span><br>
                            <input type="checkbox" name="translate" value="1" <? if ($form_set[0]==1) echo "checked"; ?>> Включить перевод сайта <span class="txt tooltip-main well" xmlns="http://www.w3.org/1999/xhtml">[<a title="Шапка страницы, это верхняя часть Вашей социальной страницы. По умолчанию выводится информация о названии фирмы. Если Вы хотите, чтобы информации не было, очистите данное поле." rel="tooltip" href="#">?</a>]</span>

                            <br><br><br><span class="btn btn-large disabled">Шапка страницы</span><br>
                            <script src="../includes/js/color_picker.js" type="text/javascript"></script>

<? if ($form_set[20]=='') $form_set[20]='#FFFFFF'; ?>
<style type="text/css">

#s2 {
	background-color: <?=$form_set[20]; ?>
}            
</style>

<?
if ($form_set[19]=='') $form_set[19]=$f['firmname'];
if ($form_set[19]=='notext') $form_set[19]='';
if ($form_set[21]=='') $form_set[21]=300;
if ($form_set[22]=='') $form_set[22]=40;
echo '
<table border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Заголовок в шапке страницы</td>
    <td align="left"><input name="set19" type="text" value="'.$form_set[19].'" style="width: 300px;"> <span class="txt tooltip-main well" xmlns="http://www.w3.org/1999/xhtml">[<a title="Шапка страницы, это верхняя часть Вашей социальной страницы. По умолчанию выводится информация о названии фирмы. Если Вы хотите, чтобы информации не было, очистите данное поле." rel="tooltip" href="#">?</a>]</span></td>
  </tr>
    <tr>
    <td align="right">Цвет текста заголовка</td>
    <td align="left">';
?>
 <input type='button' style='cursor:pointer;background-color:#F0F0F0;font-size:9px;padding-bottom:1px;' value='выберите цвет' onclick="showColorGrid2('s1','s2');" />&nbsp;
 <input class='sB' style='height:20px;text-align:center' type='text' size='10' id='s1' name="set20" value="<?=$form_set[20]; ?>" />&nbsp;
 <input class='sB' type='text' style='height:20px;text-align:center' size='2' id='s2' />
 <div ID='colorpicker201' class='colorpicker201'></div>

<?
echo '
    </td>
  </tr>
  <tr>
    <td align="right">Отступить слева</td>
    <td align="left"><input name="set21" type="text" value="'.$form_set[21].'" style="width: 100px;"> <span class="txt tooltip-main well" xmlns="http://www.w3.org/1999/xhtml">[<a title="Вы можете задать отступ текста заголовка с левой стороны шапки в пикселях." rel="tooltip" href="#">?</a>]</span></td>
  </tr>
  <tr>
    <td align="right">Отступить сверху</td>
    <td align="left"><input name="set22" type="text" value="'.$form_set[22].'" style="width: 100px;"> <span class="txt tooltip-main well" xmlns="http://www.w3.org/1999/xhtml">[<a title="Вы можете задать отступ текста заголовка с верхней части шапки в пикселях." rel="tooltip" href="#">?</a>]</span></td>
  </tr>
</table>
';
?>
                            <br><span class="btn btn-large disabled">Названия разделов меню страницы</span><br>

                            <? echo '
<table border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">'.$def_sociall_link_to_main.'</td>
    <td align="left"><input name="set1" type="text" value="'.$form_set[1].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_offers.'</td>
    <td align="left"><input name="set2" type="text" value="'.$form_set[2].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_images.'</td>
    <td align="left"><input name="set3" type="text" value="'.$form_set[3].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_exelp.'</td>
    <td align="left"><input name="set4" type="text" value="'.$form_set[4].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_video.'</td>
    <td align="left"><input name="set5" type="text" value="'.$form_set[5].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_info_news.'</td>
    <td align="left"><input name="set6" type="text" value="'.$form_set[6].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_info_tender.'</td>
    <td align="left"><input name="set7" type="text" value="'.$form_set[7].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_info_board.'</td>
    <td align="left"><input name="set8" type="text" value="'.$form_set[8].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_info_job.'</td>
    <td align="left"><input name="set9" type="text" value="'.$form_set[9].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_info_pressrel.'</td>
    <td align="left"><input name="set10" type="text" value="'.$form_set[10].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_friend.'</td>
    <td align="left"><input name="set11" type="text" value="'.$form_set[11].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_add_a_review.'</td>
    <td align="left"><input name="set12" type="text" value="'.$form_set[12].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_sendmessage.'</td>
    <td align="left"><input name="set13" type="text" value="'.$form_set[13].'" style="width: 300px;"></td>
  </tr>
  <tr>
    <td align="right">'.$def_filial.'</td>
    <td align="left"><input name="set18" type="text" value="'.$form_set[18].'" style="width: 300px;"></td>
  </tr>
</table>
';                           
?>
       <br><span class="btn btn-large disabled">Вывод информации</span><br>
<?

if ($form_set[14]!='') $def_social_publication=$form_set[14];
if ($form_set[15]!='') $def_social_offers=$form_set[15];
if ($form_set[16]!='') $def_social_images=$form_set[16];

echo '
<table border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td align="right">Сколько выводить публикаций</td>
    <td align="left"><input name="set14" type="text" value="'.$def_social_publication.'" style="width: 80px;"></td>
  </tr>
  <tr>
    <td align="right">Сколько выводить товаров или услуг</td>
    <td align="left"><input name="set15" type="text" value="'.$def_social_offers.'" style="width: 80px;"></td>
  </tr>
  <tr>
    <td align="right">Сколько выводить изображений</td>
    <td align="left"><input name="set16" type="text" value="'.$def_social_images.'" style="width: 80px;"></td>
  </tr>
</table>
';
?>
                            <br><span class="btn btn-large disabled">QR код</span><br>
                            <input type="checkbox" name="qr" value="1" <? if ($form_set[17]==1) echo "checked"; ?>> Включить QR код <span class="txt tooltip-main well" xmlns="http://www.w3.org/1999/xhtml">[<a title="Используя QR код, посетители каталога, с помощью мобильных устройств, смогут быстро занести ссылку Вашей социальной странички к себе в контакты." rel="tooltip" href="#">?</a>]</span>

                            <br><br>
							<img id="page_settings_loader" src="<? echo "$def_mainlocation"; ?>/images/go.gif" 
								 width="16" height="16" alt="loading" />
							<input type="submit" name="button" value="Сохранить" class="btn btn-danger">
							<div id="page_settings_answer"></div>
							<input type="hidden" name="setting" value="true">

                      </form>
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
	<tr>
        <td>&nbsp;</td>
	</tr>
	<tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
				<div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
				<div class="CollapsiblePanelContent">
<? echo "$help_theme"; ?>
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

	var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
	var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});

	function delImage(name)
	{
		$('#image_' + name).load('?REQ=authorize&mod=theme&del_image=' + name);
	}
	
	$(function(){
		$('#page_settings_loader').hide();
		$('#page_settings').submit(function(){
			$('#page_settings_loader').show();
			var postData = $(this).serialize();
			$.post('?REQ=authorize&mod=theme', postData, function(data) {
				if (data.indexOf('page_settings_updateok') != -1)
				{
					data = '<div class="alert alert-success">Настройки успешно изменены!</div>';
				}
				else
				{
					data = '<div class="alert alert-error">Ошибка обновления.</div>';
				}
				
				$('#page_settings_loader').delay(1000).hide();
				$('#page_settings_answer').html(data);
				$('#page_settings_answer .alert').delay(1500).fadeOut(1000);
			});
			
			return false;
		});
	});
</script>