<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: shablon_ajax.php
-----------------------------------------------------
 Назначение: Управление шаблонами
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

header('Content-type: text/html; charset=windows-1251');

$allowedExtensions = array('tpl', 'css', 'js', 'php');


function clear_url_dir($var)
{

global $def_charset;

	if (is_array($var))
	{
		return '';
	}

	$var = trim(strip_tags($var));
	$var = str_replace('\\', '/', $var);
	$var = preg_replace('#[^a-z0-9\/\_\-]+#mi', '', $var);
	
	return $var;
}


$root = '../' . $_SESSION['part_template'] . '/' . $_SESSION['template'] . '/';
if ($_REQUEST['ajax_action'] == 'save')
{
	$_POST['file'] = trim(str_replace('..', '', urldecode($_POST['file'])));

	if (!$_POST['file'])
	{
		exit('error in filename');
	}

	$url = @parse_url($_POST['file']);

	$file_path = dirname(clear_url_dir($url['path']));
	$file_name = pathinfo($url['path']);
	$file_name = $file_name['basename'];

	$type = explode('.', $file_name);
	$type = end($type);

	if (!in_array($type, $allowedExtensions))
	{
		exit('error in file extension');
	}

	$file = $root . $file_path . '/' . $file_name;
	if (!file_exists($file))
	{
		exit('error in file');
	}

	if (!is_writable($file))
	{
		echo ' <font color="red">Установите права записи для директории или файла!</font>';
		exit;
	}

	$_POST['content'] = iconv('cp1251', 'utf-8', $_POST['content']);

	if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
	{
		$_POST['content'] = stripslashes($_POST['content']);
	}

	$handle = fopen($file, 'w');
	fwrite($handle, $_POST['content']);
	fclose($handle);

	echo 'ok';
}
elseif ($_REQUEST['ajax_action'] == 'load')
{
	$_POST['file'] = trim(str_replace('..', '', urldecode($_POST['file'])));

	if (!$_POST['file'])
	{
		exit('error in filename');
	}

	$url = @parse_url($_POST['file']);

	$file_path = dirname(clear_url_dir($url['path']));
	$file_name = pathinfo($url['path']);
	$file_name = $file_name['basename'];

	$type = explode('.', $file_name);
	$type = end($type);

	$file = $file_path . '/' .$file_name;
	if (!in_array($type, $allowedExtensions))
	{
		exit('error in fileextension');
	}

	if (!file_exists($root . $file))
	{
		exit('error in file');
	}

	$content = file_get_contents($root . $file);
	$content = @htmlspecialchars(file_get_contents($root . $file), ENT_QUOTES,$def_charset);

	echo 'Редактирование ' . $file;

	if (!is_writable($root . $file))
	{
		echo ' <font color="red">Установите права записи для директории или файла!</font>';
	}

	$script = '<script type="text/javascript">
		var editor = CodeMirror.fromTextArea("file_text", {
			height: "440px",
			textWrapping: false,
			path: "../includes/codemirror/js/",
			';

	switch ($type)
	{
		default:
		case 'tpl':
			$script .= '
				parserfile: ["parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", "parsehtmlmixed.js"],
				stylesheet: [	"../includes/codemirror/css/xmlcolors.css", 
								"../includes/codemirror/css/jscolors.css", 
								"../includes/codemirror/css/csscolors.css"]';
			break;
		
		case 'css':
			$script .= '
				parserfile: "parsecss.js",
				stylesheet: "../includes/codemirror/css/csscolors.css"';
			break;
		
		case 'js':
			$script .= '
				parserfile: ["tokenizejavascript.js", "parsejavascript.js"],
				stylesheet: "../includes/codemirror/css/jscolors.css"';
			break;
		
		case 'php':
			$script .= '
				parserfile: [	"parsexml.js", "parsecss.js", "tokenizejavascript.js", "parsejavascript.js", 
								"tokenizephp.js", "parsephp.js", "parsephphtmlmixed.js"],
				stylesheet: [	"../includes/codemirror/css/xmlcolors.css",
								"../includes/codemirror/css/jscolors.css",
								"../includes/codemirror/css/csscolors.css",
								"../includes/codemirror/css/phpcolors.css"]';
			break;
	}

	$script .= '});</script>';
	
	echo '<br /><br />
		<div style="border: solid 1px #BBB;width:99%;height:440px;">
			<textarea style="width:100%;height:440px;" name="file_text" id="file_text" wrap="off">' . $content . '</textarea>
		</div>
		<br /><input onClick="savefile(\'' . $file . '\')" type="button" class="buttons" value="Сохранить" style="width:100px;">',
		$script;
}
elseif ($_REQUEST['ajax_action'] == 'init')
{
	$_POST['dir'] = clear_url_dir(urldecode($_POST['dir']));
	
	if (file_exists($root . $_POST['dir']))
	{
		$files = scandir($root . $_POST['dir']);
		natcasesort($files);
		
		if (count($files) > 2)
		{
			echo '<ul class="jqueryFileTree" style="display: none;">';
			# Сначала покажу директории
			foreach ($files as $file)
			{
				if (file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($root . $_POST['dir'] . $file))
				{
					echo '<li class="directory collapsed">',
							'<a href="#" rel="' . htmlentities($_POST['dir'] . $file) . '/">' . htmlentities($file) . '</a></li>';
				}
			}
			# Теперь и файлы
			foreach ($files as $file)
			{
				if (file_exists($root . $_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($root . $_POST['dir'] . $file))
				{
					$serverfile_arr = explode('.', $file);
					$ext = end($serverfile_arr);

					if (in_array($ext, $allowedExtensions))
					{
						echo '<li class="file ext_' . $ext . '"><a href="#" rel="' . htmlentities($_POST['dir'] . $file) . '">',
								htmlentities($file) . '</a></li>';
					}
				}
			}
			
			echo '</ul>';
		}
	}
}
?>