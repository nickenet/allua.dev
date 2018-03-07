<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: notepad.php
-----------------------------------------------------
 Назначение: Мой блокнот
=====================================================
*/


include ("./defaults.php");

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$help_section = "$notepad_help";
$incomingline_firm = $title_notepad;
$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_notepad</font>";

if ($_GET['clear']=='all') {

    if ($_GET['history']=='all') { setcookie('history', '', $cookie_time,"/"); $title_notepad="История"; } else { setcookie('notepad', '', $cookie_time,"/"); $title_notepad="Мой блокнот"; }

} else {

$print_history='';

if ($_GET['history']=='all') { $data = empty($_COOKIE['history']) ? 0 : $_COOKIE['history']; $print_history="&history=all"; $title_notepad="История"; }
else { $data = empty($_COOKIE['notepad']) ? 0 : $_COOKIE['notepad']; $title_notepad="Мой блокнот"; }

}

$data = explode(',', $data);

if ($data)
{
	foreach ($data as $k => $v)
	{
		$v = (int)trim($v);
		if ($v)
		{
			$data[$k] = $v;
		}
		else
		{
			unset($data[$k]);
		}
	}

	$data = array_unique($data);
	$data = array_values($data);
}

$help_section = "$notepad_help";
$incomingline_firm = $title_notepad;
$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_notepad</font>";


if ( empty($data) )
{
	if ($_GET['history']=='all') setcookie('history', '', $cookie_time,"/"); else setcookie('notepad', '', $cookie_time,"/");

include ( "./template/$def_template/header.php" );

	echo 'Записи отсутствуют.';

include ( "./template/$def_template/footer.php" );

	return;
}

$list=implode(',',$data);

$r = $db->query ( " SELECT * FROM $db_users WHERE selector IN ($list)");
@$results_amount = mysql_num_rows ( $r );

if (!$results_amount)
{

include ( "./template/$def_template/header.php" );

	if ($_GET['history']=='all') setcookie('history', '', $cookie_time,"/"); else setcookie('notepad', '', $cookie_time,"/");
	echo 'Записи отсутствуют.';

include ( "./template/$def_template/footer.php" );

	return;
}

$for_del = array();
if ( isset($_POST['del']) )
{
	$for_del = $_POST['ids'];
}

$data = array();
$output = '';


while ( count($data) <= $def_size_notepad
	&& $row = mysql_fetch_object($r) )
{
	if ( @in_array($row->selector, $for_del) )
	{
		continue;
	}
	
	$data[] = (int)$row->selector;
	$businessf = parseDescription("X", $row->business);

$output .= '<table width="100%" border="0" cellspacing="1" cellpadding="3">
  <tr>
    <td width="30" rowspan="2" align="center" bgcolor='.$def_form_back_color.'><input name=ids[] value="'.$row->selector.'" type="checkbox"></td>
    <td height="25" colspan="3" bgcolor='.$def_form_back_color.'><strong><a href="'.$def_mainlocation.'/view.php?id='.$row->selector.'">'.$row->firmname.'</a></strong></td>
    <td colspan="2" bgcolor='.$def_form_back_color.'>Адрес: <strong>'.$row->address.'</strong></td>
  </tr>
  <tr>
    <td colspan="3" valign="top" bgcolor='.$def_form_back_color.'>'.$businessf.'</td>
    <td width="200" valign="top" bgcolor='.$def_form_back_color.'>Тел.: <strong>'.$row->phone.'</strong><br>
      Факс: <strong>'.$row->fax.'</strong><br>
    Моб.: <strong>'.$row->mobile.'</strong></td>
    <td width="200" valign="top" bgcolor='.$def_form_back_color.'>www: <strong>'.$row->www.'</strong><br>
    e-mail: <strong>'.$row->mail.'</strong></td>
  </tr>
</table><br /><br />';

}

	

$data = join(',', $data);
if ($_GET['history']=='all') setcookie('history', $data, $cookie_time,"/"); else setcookie('notepad', $data, $cookie_time,"/");

if ( empty($data) )
{
include ( "./template/$def_template/header.php" );

	echo 'Записи устарели.';

include ( "./template/$def_template/footer.php" );
}
else
{

if ($_GET[view]=="print")
{

// версия для печати

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<? echo "<link rel=\"stylesheet\" href=\"$def_mainlocation/template/$def_template/css.css\">"; ?>
<title><? echo $title_notepad; ?></title>
</head>

<body>
<hr>
<h4><? echo "&nbsp;$def_title";?> &raquo; <? echo $title_notepad; ?><br></h4>
<hr>
<? echo $output; ?>
<hr>
<div align="center"><a href="http://vkaragande.info/" title="Скрипт фирм и организаций"><span class=sideboxtext>I-Soft Bizness &copy; 2011</span></a>
</div>
</body>
</html>

<?php

} else

{

include ( "./template/$def_template/header.php" );

main_table_top  ($title_notepad);

	?>
	<form action="" method="post">
	<input name="del" value="y" type="hidden">
	<? echo $output; ?>
	<br>
	<div align="left"><input value="Удалить выбранные" type="submit"></div>
	</form>
	<div align="right"><a href="<? echo $def_mainlocation; ?>/notepad.php?view=print<? echo $print_history; ?>" target="_blank">Версия для печати</a></div><br>
        <div align="right"><a href="<? echo $def_mainlocation; ?>/notepad.php?clear=all<? echo $print_history; ?>">Очистить</a></div>
	<?php

main_table_bottom();

include ( "./template/$def_template/footer.php" );

}
}


?>