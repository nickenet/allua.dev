<?

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: component.php
-----------------------------------------------------
 Назначение: Подключение дополнительных компонентов
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$component_help;

$link_edit='';
if (isset($_GET['edit'])) {
    $name_edit=htmlspecialchars(strip_tags($_GET['edit']));
    $link_edit=' | <a href="component.php?edit='.$name_edit.'">Редактирование компонента '.$name_edit.'</a>';
}

$title_cp = 'Компоненты и модули - ';
$speedbar = ' | <a href="component.php">Компоненты и модули</a>'.$link_edit;

check_login_cp('0_0','component.php');

require_once 'template/header.php';

table_item_top ('Компоненты','components.png');

// Редактирование компонента

if (isset($_GET['edit'])) {

    $type = explode('.', $name_edit);
    $type = end($type);

    $name_edit_code=file_get_contents('../requery/'.$name_edit);
    
    $content = htmlspecialchars($name_edit_code,ENT_QUOTES,$def_charset);

    table_fdata_top ($def_item_form_data);
    
?>

<link media="screen" href="../includes/codemirror/filetree.css" type="text/css" rel="stylesheet" />
<link media="screen" href="../includes/codemirror/css/codemirror.css" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="../includes/codemirror/filetree.js"></script>
<script type="text/javascript" src="../includes/codemirror/js/codemirror.js"></script>



<?

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

echo $script.'<textarea style="width:600px;height:300px;" name="file_text" id="file_text">' . $content . '</textarea>';

table_fdata_bottom();

} else {

// Загрузка файла

if ($_POST['file']=='true') {

    $fileExt = array('php', 'js', 'htm', 'html');
    if (isset($_FILES[file_sys]) && is_uploaded_file($_FILES[file_sys]['tmp_name'])) {

        $name=$_FILES[file_sys]['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);

        if (!in_array($ext, $fileExt))
				$error_submit.='<b>Ошибка! Файл для шапки не был загружен!</b><br>К загрузке допускаются файлы с расширениями: php, js, html, htm.<br>';
			else
			{

				$name = '../requery/' . $_FILES[file_sys]['name'];

				@unlink($name);

				if (move_uploaded_file($_FILES[file_sys]['tmp_name'], $name))
                                    { $def_admin_message_error='Успешно!'; $error_submit.='Файл успешно был загружен!'; }
				else
					$error_submit.='<b>Ошибка! Файл не был загружен!</b><br>Сервер не смог принять данный файл.<br>';
			}
    }
}

// Настройка подключений файлов компонентов

$components=array("view"=>array("file"=>"view.php", "descr"=>"Подключение файлов к информационной странице компании"));

$file_import = file ('../system/components.dat');
$file_name_comp = '../system/components.dat';

// Удаление файла

if (isset($_GET['del_file'])) {

    $name_del=htmlspecialchars(strip_tags($_GET['del_file']));
    @unlink('../requery/'.$name_del);
    $def_admin_message_error='Успешно!'; $error_submit.='Файл <b>'.$name_del.'</b> успешно удален!';

    $content_file='';
    foreach ($file_import as $value) {
        $pos=stripos($value,$name_del);
        if ($pos!==0) $content_file.=$value;
        $content_file_del.=$value;
    }

    if ($content_file_del!=$content_file) {
    	$f = fopen($file_name_comp, 'w+');
	fwrite($f, $content_file);
	fclose($f);
    }
}

$files_c = glob('../requery/{*.php,*.htm,*.js,*.html}', GLOB_BRACE);

if ($error_submit != '')
{
        msg_text('80%',$def_admin_message_error,$error_submit);
}

?>

<style type="text/css">
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	}
    .main_list td {
        padding: 5px;
        text-align: center;
	border: 1px solid #A6B2D5;
	}
    .main_list th {
        background-image: url(images/table_files_bg.gif);
	height: 25px;
	padding-top: 2px;
	padding-left: 5px;
	text-align: center;
	border: 1px solid #A6B2D5;
        }
    hr {
	border: 1px dotted #CCCCCC;
        }
</style>

<table width="1000" align="center" class="main_list">
  <tr>
    <th width="30"><div align="center"></div></th>
    <th width="300"><div align="center">Файл</div></th>
    <th width="110"><div align="center">Дата</div></th>
    <th><div align="center">Подключение</div></th>
  </tr>
  
<? 

$ik=0;
while ($ik<count($files_c)) {
    echo '<tr class="selecttr">';
    
        echo '  <td width="30"><a href="?del_file='.basename($files_c[$ik]).'" title="Удалить"><img src="images/delete.gif" widht="16" height="16" border="0"></a></td>';
        echo '  <td width="300" class="slink"><a href="?edit='.basename($files_c[$ik]).'">'.basename($files_c[$ik]).'</a></td>';
        echo '  <td width="110">'.date('d.m.Y', filemtime('../requery/'.basename($files_c[$ik]))).'</td>';  
        echo '  <td>';
    for ($ig=0; $ig<count($file_import); $ig++ ) {
       
        $sys_true=explode(":", $file_import[$ig]);
             
    if (basename($files_c[$ik])==$sys_true[0]) { echo 'Подключен к '.$sys_true[1].'.php<br>'; }  

}
       echo '</td>';
       $ik++;
   echo '</tr>';
}

?>
  <tr>
    <td colspan="5">
        <div style="text-align:right;">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="file_sys"> <input type="submit" name="save" value="<? echo $def_upload; ?>">
                <input type="hidden" name="file" value="true" />
            </form>
        </div>
    </td>
  </tr>
</table>

<?

}

require_once 'template/footer.php';

?>