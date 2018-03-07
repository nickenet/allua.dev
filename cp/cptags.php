<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by K.Ilya
=====================================================
 Файл: cptags.php
-----------------------------------------------------
 Назначение: Облако тегов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$tags_help;

$title_cp = 'Облако тегов - ';
$speedbar = ' | <a href="cptags.php">Облако тегов</a>';

check_login_cp('3_4','cptags.php');

require_once 'template/header.php';

table_item_top ('Облако тегов','tags.png');

$file = '../system/tags.dat';

$data = array();
if ( !empty($_POST['name']) )
{
	foreach ($_POST['name'] as $k => $name)
	{
		if ( !empty($_POST['del'][$k]) )
		{
			continue;
		}
		
		$row = new stdClass();
		foreach (array('state', 'num', 'field', 'name', 'url', 'color', 'size', 'value') as $val)
		{
			$row->$val = $_POST[$val][$k];
		}
		
		if ( get_magic_quotes_gpc() )
		{
			$row->name = stripslashes($row->name);
		}
	
		$data[] = $row;
	}
	
	$fp = fopen($file, 'w');
	fwrite($fp, serialize($data));
	fclose($fp);
}

if ( file_exists($file) )
{
	$data = file_get_contents($file);
	$data = unserialize($data);
}

$sizes = array(8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28);

?>
<style type="text/css">
* {
	margin: 0px;
	padding: 0px
}

table.main {
	border-collapse: collapse;
	width: 95%;
	margin: auto
}

table.main th {
	background-color: #ffd1d1;
}

.main td, .main th {
	padding: 1px;
}

.hide, #new {
	display: none
}

.bg {
	background-color: #FFF;
	border: solid 1px #999;
	width: 15px;
	float: left;
	margin-right: 2px;
}

div.bg {
	cursor: pointer;
}

.cancel {
	background-color: #cccccc
}

.but {
	padding: 2px 5px
}
</style>
<script src="inc/color_picker.js" type="text/javascript"></script>
<script type="text/javascript">
var maxLen = <? echo count($data); ?>;
function add()
{
	var elm = document.getElementById('new').cloneNode(1);
	maxLen++;
	elm.id = 'tr_' + maxLen;
	var tmp = elm.getElementsByTagName('div')[0];
	tmp.style.display = 'block';
	tmp.id = tmp.id.replace('__', '_' + maxLen);
	  
	tmp = tmp.nextSibling;
	if (tmp.nodeType != 1)
	{
		tmp = tmp.nextSibling;
	}
		
	tmp.id = tmp.id.replace('__', '_' + maxLen);
	document.getElementById('place').appendChild(elm);
}


function del(elm)
{
	elm = elm.parentNode.parentNode;
	elm.parentNode.removeChild(elm);
}


function edit(n, elm)
{
	var list = document.getElementById('tr' + n).getElementsByTagName('span');
	for (i = 0; i < list.length; i++)
	{
		list[i].style.display = 'none';
	}
	
	list = document.getElementById('tr' + n).getElementsByTagName('div');
	for (i = 0; i < list.length; i++)
	{
		list[i].style.display = 'block';
	}
	
	elm.style.display = 'none';
}


function preSubmit()
{
	var elm = document.getElementById('new');
	elm.parentNode.removeChild(elm);
}


function preColor(elm)
{
	var tmp = elm.id;
	tmp = tmp.replace('bg_', '');
	showColorGrid2('bg_code_' + tmp, 'bg_' + tmp);
}
</script>

<div id="colorpicker201" class="colorpicker201"></div>
<form action="" method="post" onsubmit="preSubmit()">
<table border="0" class="main">
  <col span="4" align="center">
  <col span="4">
  <col span="1" align="right">
  <tbody id="place">
  <tr>
    <td width="60" id="table_files_b"><b>Удалить</b></td>
    <td width="30" id="table_files_bc"></td>
    <td width="55" id="table_files_b"><b>Статус</b></td>
    <td width="30" id="table_files_bc"><b>№</b></td>
    <td width="40" id="table_files_b"><b>tag</b></td>
    <td width="180" id="table_files_bc"><b>Тег</b></td>
    <td id="table_files_b"><b>URL ссылки тега</b></td>
    <td width="90" id="table_files_bc"><b>Цвет</b></td>
    <td width="60" id="table_files_b"><b>Размер</b></td>
    <td width="130" id="table_files_br"><b>Список ID компаний</b></td>
  </tr>
<? foreach ($data as $k => $row) : ?>  
  <tr id="tr<? echo $k; ?>" <? echo $row->state == 'off' ? 'class="cancel"' : ''; ?>>
    <td id="table_files_ib">
    	<input name="del[<? echo $k; ?>]" value="1" type="checkbox">
    </td>
    <td class="slink" id="table_files_ib_c">
    	<a href="javascript:;" onclick="edit(<? echo $k; ?>, this)" title="Редактировать">ред</a>
    </td>
    <td id="table_files_ib">
    	<span><? echo $row->state == 'on' ? 'вкл.' : 'выкл.'; ?></span>
    	<div class="hide">
	    	<select name="state[]" style="width: 55px">
	    		<option value="on"<? echo $row->state == 'on' ? ' selected="selected"' : ''; ?>>вкл.</option>
	    		<option value="off"<? echo $row->state == 'off' ? ' selected="selected"' : ''; ?>>выкл.</option>
	    	</select>
	    </div>		
    </td>
    <td id="table_files_ib_c">
    	<span><? echo $row->num; ?></span>
    	<div class="hide">
    		<input name="num[]" value="<? echo $row->num; ?>" type="text" style="width: 30px">
    	</div>	
    </td>
    <td id="table_files_ib">
    	<span><? echo $row->field; ?></span>
    	<div class="hide">
    		<input name="field[]" value="<? echo $row->field; ?>" type="text" style="width: 150px">
     	</div>	
    </td>
    <td id="table_files_ib_c">
    	<span style="font-size: <? echo $row->size; ?>px; color: <? echo $row->color; ?>">
    		<? echo $row->name; ?></span>
    	<div class="hide">
    		<input name="name[]" value="<? echo htmlspecialchars($row->name,ENT_QUOTES,$def_charset); ?>" type="text" 
    			style="width: 180px">
    	</div>	
    </td>
    <td id="table_files_ib">
    	<span><? echo htmlspecialchars($row->url,ENT_QUOTES,$def_charset); ?></span>
    	<div class="hide">
    		<input name="url[]" value="<? echo htmlspecialchars($row->url,ENT_QUOTES,$def_charset); ?>" type="text"
    			style="width: 100%">
    	</div>	
    </td>
    <td id="table_files_ib_c">
    	<span class="bg" style="background-color: <? echo $row->color; ?>">&nbsp;</span>
    	<span><? echo $row->color; ?></span>
    	<div class="hide">
    		<div id="bg_<? echo $k; ?>" class="bg" style="background-color: <? echo $row->color; ?>" 
    			onclick="preColor(this)">&nbsp;</div>
    		<input name="color[]" value="<? echo $row->color; ?>" type="text" id="bg_code_<? echo $k; ?>"
    			 style="width: 65px">
    	</div>
    </td>
    <td id="table_files_ib">
    	<span><? echo $row->size; ?>px</span>
    	<div class="hide">
	    	<select name="size[]" style="width: 60px">
	    	<? foreach ($sizes as $s) : ?>
	    		<option value="<? echo $s; ?>"<? echo $row->size == $s ? ' selected="selected"' : ''; ?>
	    			><? echo $s; ?>px</option>
	    	<? endforeach; ?>		
	    	</select>
	    </div>		
    </td>
    <td id="table_files_i_r">
    	<span><? echo $row->value; ?></span>
    	<div class="hide">
    		<input name="value[]" value="<? echo $row->value; ?>" type="text" style="width: 130px">
    	</div>	
    </td>
  </tr>
<? endforeach; ?> 
  <tr>
    <td colspan="10" align="center"><br />
    	<input value="Сохранить" type="submit" class="but">
    	<input value="Добавить" type="button" onclick="add()" class="but"><br /><br />
    </td>
  </tr>   
  <tr id="new">
    <td colspan="2" class="slink"><a href="javascript:;" onclick="del(this)">удалить</a></td>
    <td>
    	<select name="state[]" style="width: 55px">
    		<option value="on">вкл.</option>
    		<option value="off">выкл.</option>
    	</select>
    </td>
    <td>
   		<input name="num[]" value="" type="text" style="width: 30px">
    </td>
    <td>
   		<input name="field[]" value="" type="text" style="width: 150px">
    </td>
    <td>
   		<input name="name[]" value="" type="text" style="width: 180px">
    </td>
    <td>
   		<input name="url[]" value="" type="text" style="width: 100%">
    </td>
    <td>
   		<div id="bg__" class="bg" onclick="preColor(this)">&nbsp;</div>
   		<input name="color[]" value="" type="text" id="bg_code__" style="width: 65px">
    </td>
    <td>
    	<select name="size[]" style="width: 60px">
    	<? foreach ($sizes as $s) : ?>
    		<option value="<? echo $s; ?>"
    			><? echo $s; ?>px</option>
    	<? endforeach; ?>		
    	</select>
    </td>
    <td>
   		<input name="value[]" value="" type="text" style="width: 130px">
    </td>
  </tr>
  </tbody>
</table>
</form>

<?

require_once 'template/footer.php';

?>