<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi & Ilya.K
=====================================================
 Файл: informer.php
-----------------------------------------------------
 Назначение: Информеры
=====================================================
*/


include ( "./defaults.php" );

$titleinfor="Информеры";

if (empty($_POST['type_informer'])) $incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | $titleinfor";
else {

$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <a href=\"$def_mainlocation/informer.php\"><font color=\"$def_status_font_color\"><u>$titleinfor</u></font></a> | ";
if ($_POST['type_informer']==1) $incomingline .="Трансляция компаний";
if ($_POST['type_informer']==2) $incomingline .="Трансляция публикаций";
if ($_POST['type_informer']==3) $incomingline .="Трансляция случайной продукции или услуги";
if ($_POST['type_informer']==3) $incomingline .="Трансляция баннеров контрагентов";
}

$incomingline_firm=$titleinfor;

$help_section = "$informer_help";

include "./template/$def_template/header.php";

if (empty($_POST['type_informer']))

{
?>
<p><strong>Информеры</strong> - это автоматически обновляющийся информационный  блок, который размещается на сайте для предоставления посетителям  дополнительной информации с нашего каталога.</p>
<p>Владельцы сайтов могут разместить данные информеры на своем  ресурсе: это повысит его информативность и сделает более привлекательным для  посетителей.</p>
<p>Мы предлагаем следующие типы информеров: трансляция компаний,  трансляция публикаций, трансляция случайной продукции или услуги, трансляция  баннеров контрагентов.</p>
<p>Для размещения информера Вам нужно лишь скопировать код и  добавить его на страницу Вашего сайта. Наш информеры имеет гибкую систему  настроек, благодаря чему Вы легко сможете привести его в соответствие со стилем  и дизайном своего сайта.</p>
<?php
}

main_table_top  ($titleinfor);

?>

<style type="text/css">
.informer-block {
	text-align: left;
	float: left;
	clear: left;
}
</style>

<? if (isset($_POST['type_informer']) && $_POST['type_informer'] < 4) { ?>
<link rel="stylesheet" href="includes/construktor/app.css" type="text/css" media="all" />
<script type="text/javascript" src="includes/construktor/jquery-ui.min.js"></script>
<script type="text/javascript" src="includes/construktor/app.js"></script>

<div id="themeRoller" style="float: right; width: 300px; border: 1px solid black">
	<br /><br /><strong>Конструктор стиля</strong><br /><br />
	<form method="get" action="/" id="themeConfig">
	<fieldset class="clearfix">

		<div class="theme-group clearfix" id="global-config">
			<div class="theme-group-header state-default">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<a href="#">Общее</a>
			</div><!-- /theme group header -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					<label for="bW">Ширина блока:</label>
					<input type="text" value="220px" name="bW" id="bW" class="bW" size="7" />
				</div>
			</div><!-- /theme group content -->
		</div><!-- /theme group -->
	
		<div class="theme-group clearfix" id="Header">
			<div class="theme-group-header state-default">

				<span class="icon icon-triangle-1-e">Collapse</span>
				<div class="state-preview corner-all isb_header">abc</div>
				<a href="#">Заголовок</a>
			</div><!-- /theme group header -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					<!-- hFf = header font family -->
					<label for="hFf">Шрифт</label>
					<select name="hFf" class="hFf" id="hFf">
						<option>Verdana</option>
						<option selected="selected">Tahoma</option>
						<option>Arial</option>
						<option>Times New Roman</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="hFs">Размер</label>
					<select name="hFs" class="hFs" id="hFs">
						<option>10px</option>
						<option selected="selected">11px</option>
						<option>12px</option>
						<option>14px</option>
						<option>16px</option>
						<option>20px</option>
					</select>
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="hFw">Жирно</label>
					<select name="hFw" class="hFw" id="hFw">
						<option value="normal">нет</option>
						<option value="bold" selected="selected">да</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="hCr">Радиус рамки:</label>
					<input type="text" value="4px" name="hCr" id="hCr" class="hCr" size="5" />
				</div>
				
				<div class="field-group field-group-clear clearfix">
					<label for="hFc">Текст</label>
					<input type="text" name="hFc" id="hFc" class="hex" value="#000000" size="6" />
				</div>
				<div class="field-group field-group-background clearfix">
					<label for="hBg" class="background">Фон</label>
					<input type="text" name="hBg" id="hBg" class="hex" value="#FFCC00" />
				</div>
				<div class="field-group field-group-border clearfix">
					<label for="hBr">Рамка</label>
					<input type="text" name="hBr" id="hBr" class="hex" value="#999999" size="6" />
				</div>
			</div><!-- /theme group content -->

		</div><!-- /theme group -->			
		
		<div class="theme-group clearfix" id="ContentArea">
			<div class="theme-group-header state-default">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<div class="state-preview corner-all isb_content">abc</div>
				<a href="#">Контент</a>
			</div><!-- /theme group Content -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					<!-- cFf = content font family -->
					<label for="cFf">Шрифт</label>
					<select name="cFf" class="cFf" id="cFf">
						<option>Verdana</option>
						<option selected="selected">Tahoma</option>
						<option>Arial</option>
						<option>Times New Roman</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="cFs">Размер</label>
					<select name="cFs" class="cFs" id="cFs">
						<option>10px</option>
						<option selected="selected">11px</option>
						<option>12px</option>
						<option>14px</option>
						<option>16px</option>
						<option>20px</option>
					</select>
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="cFw">Жирно</label>
					<select name="cFw" class="cFw" id="cFw">
						<option value="normal">нет</option>
						<option value="bold" selected="selected">да</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="cCr">Радиус рамки:</label>
					<input type="text" value="4px" name="cCr" id="cCr" class="cCr" size="5" />
				</div>
				
				<div class="field-group field-group-clear clearfix">
					<label for="cFc">Текст</label>
					<input type="text" name="cFc" id="cFc" class="hex" value="#000000" size="6" />
				</div>
				<div class="field-group field-group-background clearfix">
					<label for="cBg" class="background">Фон</label>
					<input type="text" name="cBg" id="cBg" class="hex" value="#FFFFCC" />
				</div>
				<div class="field-group field-group-border clearfix">
					<label for="cBr">Рамка</label>
					<input type="text" name="cBr" id="cBr" class="hex" value="#999999" size="6" />
				</div>
			</div><!-- /theme group content -->

		</div><!-- /theme group -->		

		<div class="theme-group clearfix" id="Default">
			<div class="theme-group-header state-default">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<a href="#">Ссылки</a>
				
			</div><!-- /theme group Default -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					Обычные
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="lNd">Подчёркнуто</label>
					<select name="lNd" class="lNd" id="lNd">
						<option value="underline">да</option>
						<option value="none" selected="selected">нет</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="lNc">Цвет</label>
					<input type="text" name="lNc" id="lNc" class="hex" value="#0066FF" />
				</div>
				<div class="field-group clearfix">
					<label for="lNw">Жирно</label>
					<select name="lNw" class="lNw" id="lNw">
						<option value="normal">нет</option>
						<option value="bold" selected="selected">да</option>
					</select>
				</div>
				
				<div class="field-group field-group-clear clearfix">
					Активные
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="lAd">Подчёркнуто</label>
					<select name="lAd" class="lAd" id="lAd">
						<option value="underline" selected="selected">да</option>
						<option value="none">нет</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="lAc">Цвет</label>
					<input type="text" name="lAc" id="lAc" class="hex" value="#FF9900" />
				</div>
				<div class="field-group clearfix">
					<label for="lAw">Жирно</label>
					<select name="lAw" class="lAw" id="lAw">
						<option value="normal">нет</option>
						<option value="bold" selected="selected">да</option>
					</select>
				</div>
			</div><!-- /theme group content -->

		</div><!-- /theme group -->	
	
		<div class="theme-group clearfix" id="ContentArea">
			<div class="theme-group-header state-default">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<div class="state-preview corner-all isb_boxdescr">abc</div>
				<a href="#">Описание фирмы</a>
			</div><!-- /theme group Content -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					<!-- dFf = description font family -->
					<label for="dFf">Шрифт</label>
					<select name="dFf" class="dFf" id="dFf">
						<option>Verdana</option>
						<option selected="selected">Tahoma</option>
						<option>Arial</option>
						<option>Times New Roman</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="dFs">Размер</label>
					<select name="dFs" class="dFs" id="dFs">
						<option selected="selected">10px</option>
						<option>11px</option>
						<option>12px</option>
						<option>14px</option>
						<option>16px</option>
						<option>20px</option>
					</select>
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="dFw">Жирно</label>
					<select name="dFw" class="dFw" id="dFw">
						<option value="normal" selected="selected">нет</option>
						<option value="bold">да</option>
					</select>
				</div>
				
				<div class="field-group clearfix">
					<label for="dFc">Текст</label>
					<input type="text" name="dFc" id="dFc" class="hex" value="#333333" size="6" />
				</div>
			</div><!-- /theme group content -->

		</div><!-- /theme group -->		

		<div class="theme-group clearfix" id="ContentArea">
			<div class="theme-group-header state-default">
				<span class="icon icon-triangle-1-e">Collapse</span>
				<div class="state-preview corner-all isb_sideboxtext">abc</div>
				<a href="#">Дата и просмотры</a>
			</div><!-- /theme group Content -->
			<div class="theme-group-content corner-bottom clearfix">
				<div class="field-group clearfix">
					<!-- sFf = sidebox font family -->
					<label for="sFf">Шрифт</label>
					<select name="sFf" class="sFf" id="sFf">
						<option>Verdana</option>
						<option selected="selected">Tahoma</option>
						<option>Arial</option>
						<option>Times New Roman</option>
					</select>
				</div>
				<div class="field-group clearfix">
					<label for="sFs">Размер</label>
					<select name="sFs" class="sFs" id="sFs">
						<option selected="selected">9px</option>
						<option>10px</option>
						<option>11px</option>
						<option>12px</option>
						<option>14px</option>
						<option>16px</option>
						<option>20px</option>
					</select>
				</div>
				<div class="field-group field-group-clear clearfix">
					<label for="sFw">Жирно</label>
					<select name="sFw" class="sFw" id="sFw">
						<option value="normal" selected="selected">нет</option>
						<option value="bold">да</option>
					</select>
				</div>
				
				<div class="field-group clearfix">
					<label for="sFc">Текст</label>
					<input type="text" name="sFc" id="sFc" class="hex" value="#999999" size="6" />
				</div>
			</div><!-- /theme group content -->

		</div><!-- /theme group -->		
		
		<button type="submit" name="submit" id="submitBtn">Preview Changes</button>		
	</fieldset>
</form>

</div>
<? } ?>

<script type="text/javascript">
function trans_instrum()
{
    var elm = document.getElementById('instrum_link');
    var show = (elm.style.display == 'none' ? 'none' : '');
    elm.style.display = (show ? '' : 'none');
    $('#instrum_link_hide').css('display', show);
    $('#instrum_mod').css('display', show);
}

$(function(){
	$('.informer_form').submit(function(){
		if (!$('#informer_code').length)
		{
			return true;
		}
		
		var formAction = 'informer_load.php?' + $('#themeRoller form').serialize();
		$(this).attr('target', 'informer_content').attr('action', formAction);
		
		$('#form_loader').css('visibility', 'visible');
		$.post(
			formAction, 
			$(this).serialize() + '&code_only=1', 
			function(data){
				$('#form_loader').css('visibility', 'hidden');
				$('#informer_code').html(data);
			}
		);
	});
	
	if ($('#informer_code').length)
	{
		$('.informer_form:first').submit();
	}
});

</script>

<?php if (($_POST['type_informer']==1) or (!isset($_POST['type_informer']))) { ?>

<div class="informer-block">
	<form class="informer_form" action="" method="POST">
<table width="400" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" align="right"><br /><br /><strong>Трансляция компаний</strong><br /><br /></td></tr>
  <tr>
    <td width="306" align="right">Показывать компании</td>
    <td width="194"><select name="type" style="width: 160px;">
      <option value="1" selected="selected"><? echo $def_last10; ?></option>
      <option value="2"><? echo $def_top10; ?></option>
      <option value="3"><? echo $def_lastmod; ?></option>
      <option value="4"><? echo $def_featured; ?></option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right">Количество компаний</td>
    <td><select name="number" style="width: 160px;">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5" selected="selected">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="30">30</option>
      <option value="50">50</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right">Транслировать логотип</td>
    <td><select name="logo" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right">Показывать краткое описание компании</td>
    <td><select name="desc" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Показывать Город</td>
    <td><select name="country" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Показывать область</td>
    <td><select name="states" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сформировать код информера" /></td>
    <td><input name="type_informer" type="hidden" value="1" /></td>
  </tr>
</table>
</form>
</div>

<? } ?>

<?php if (($_POST['type_informer']==2) or (!isset($_POST['type_informer']))) { ?>

<div class="informer-block">
<form class="informer_form" action="" method="POST">
<table width="400" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" align="right"><br /><br /><strong>Трансляция публикаций</strong><br /><br /></td></tr>
  <tr>
    <td width="306" align="right">Показывать публикации</td>
    <td width="194"><select name="type" style="width: 160px;">
      <option value="5" selected="selected"><? echo $def_info_news; ?></option>
      <option value="6"><? echo $def_info_tender; ?></option>
      <option value="7"><? echo $def_info_board; ?></option>
      <option value="8"><? echo $def_info_job; ?></option>
      <option value="9"><? echo $def_info_pressrel; ?></option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right">Количество публикаций</td>
    <td><select name="number" style="width: 160px;">
      <option value="1">1</option>
      <option value="2">2</option>
      <option value="3">3</option>
      <option value="4">4</option>
      <option value="5" selected="selected">5</option>
      <option value="10">10</option>
      <option value="15">15</option>
      <option value="20">20</option>
      <option value="30">30</option>
      <option value="50">50</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right">Показывать краткое описание</td>
    <td><select name="desc" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сформировать код информера" /></td>
    <td><input name="type_informer" type="hidden" value="2" /></td>
  </tr>
</table>
</form>
</div>

<? } ?>

<?php if (($_POST['type_informer']==3) or (!isset($_POST['type_informer']))) { ?>

<div class="informer-block">
<form class="informer_form" action="" method="POST">
<table width="400" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" align="right"><br /><br /><strong>Трансляция случайной продукции или услуги</strong><br /><br /></td></tr>
  <tr>
    <td align="right" width="306" >Показывать краткое описание</td>
    <td width="194"><select name="desc" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Показывать цену</td>
    <td><select name="price" style="width: 160px;">
      <option value="1" selected="selected">Да</option>
      <option value="0">Нет</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сформировать код информера" /></td>
    <td><input name="type_informer" type="hidden" value="3" /></td>
  </tr>
</table>
</form>
</div>

<? } ?>

<?php if (($_POST['type_informer']==4) or (!isset($_POST['type_informer']))) { ?>

<div class="informer-block">
<form class="informer_form" action="" method="POST">
<table width="400" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" align="right"><br /><br /><strong>Трансляция баннеров контрагентов</strong><br /><br /></td></tr>
  <tr>
    <td align="right" width="306" >Транслировать баннеры</td>
    <td width="194"><select name="type" style="width: 160px;">
      <option value="11" selected="selected">TOP</option>
      <option value="12">SIDE</option>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сформировать код информера" /></td>
    <td><input name="type_informer" type="hidden" value="4" /></td>
  </tr>
</table>
</form>
</div>

<? } ?>

<?php if (isset($_POST['type_informer'])) { ?>
<div style="clear:both"> </div>
<img id="form_loader" src="images/go.gif" alt="loading" style="visibility:hidden">
<div id="informer_code"></div>
<iframe name="informer_content" frameBorder="0" style="width: 100%; border: none; height: 800px"></iframe>
<?php } ?>

<?php
main_table_bottom();
include ( "./template/$def_template/footer.php" );
?>