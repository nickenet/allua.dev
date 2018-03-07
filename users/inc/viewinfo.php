<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: vewinfo.php
-----------------------------------------------------
 Назначение: Показ изображений или видеоролика
=====================================================
*/

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Просмотр</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>

<body>

<table width="100%" border="0" cellspacing="1" cellpadding="4">

<?php

if (isset($_GET['img']))

{

if (!is_numeric ($_GET['img'])) die( "Hacking attempt!" );

require('../../conf/config.php');

$img_view=intval($_GET['img']);

	$handle_logo = opendir('../../info');

	$count_logo=0;
	while (false != ($file_logo = readdir($handle_logo))) {
		if ($file_logo != "." && $file_logo != "..") {
			$logo_block[$count_logo]="$file_logo";
			$count_logo++;
		}
	}
	closedir($handle_logo);

		for ($xxl = 0; $xxl < count($logo_block); $xxl++)
		{
			$rlogo_block = explode(".", $logo_block[$xxl]);
			if ($rlogo_block[0] == $img_view) 
			{
				$view_img = $logo_block[$xxl];
				$view_img_file = $rlogo_block[0];
				$view_img_type = $rlogo_block[1];
				$view_img_ok=true;
			}
		}

if (!$view_img_ok) die( "Hacking attempt!" );

?>
  <tr>
    <td align="center">Уменьшенное изображение</td>
  </tr>
  <tr>
    <td align="center">
<?php

echo "<img src=\"$def_mainlocation/info/$img_view-small.$view_img_type\">";

?>
   </td>
  </tr>
  <tr>
    <td align="center">Изображение</td>
  </tr>
  <tr>
    <td align="center">

<?php

echo "<img src=\"$def_mainlocation/info/$img_view.$view_img_type\">";

?>
    </td>
  </tr>


<?php

unset ($view_img, $view_img_file, $view_img_type, $logo_block[$xxl], $handle_logo);

}

if (isset($_GET['video']))

{

if (!is_numeric ($_GET['video'])) die( "Hacking attempt!" );

// Including configuration file
include ( "../../conf/config.php" );

// Including mysql class
include ( "../../includes/$def_dbtype.php" );

// Connecting to the database
include ( "../../connect.php" );

// Including functions
include ( "../../includes/sqlfunctions.php" );

$img_video=intval($_GET['video']);

	$sql_video = $db->query("SELECT video FROM $db_info WHERE num = '$img_video'");
	$b_video = $db->fetcharray($sql_video);

	@$results_amount = mysql_num_rows ( $sql_video );

	if ($results_amount==0) die( "Hacking attempt!" );

		$url = urldecode( $b_video[video] );
		$url = str_replace("&amp;","&", $url );
		
		$source = parse_url ( $url );

		$source['host'] = str_replace( "www.", "", strtolower($source['host']) );

		$error_video="";

		if ($source['host'] != "youtube.com" AND $source['host'] != "rutube.ru") $error_video="<font color=red>Ошибка ссылки!</font>";

		$a = explode('&', $source['query']);
		$j = 0;

		while ($j < count($a)) {
		    $b = explode('=', $a[$j]);
		    if ($b[0] == "v") $video_link = $b[1];
		    $j++;
		}

		if ($error_video=="") {

		echo "<tr><td align=\"center\">Просмотр видеоролика</td></tr>";

		if ($source['host'] == "youtube.com")

			echo "<tr><td align=\"center\"><object width=\"425\" height=\"344\"><param name=\"movie\" value=\"http://www.youtube.com/v/$video_link&hl=ru&fs=1\"></param><param name=\"wmode\" value=\"transparent\" /><param name=\"allowFullScreen\" value=\"true\"></param><param name=\"allowscriptaccess\" value=\"always\"></param><embed src=\"http://www.youtube.com/v/$video_link&hl=ru&fs=1\" type=\"application/x-shockwave-flash\" allowscriptaccess=\"always\" allowfullscreen=\"true\" wmode=\"transparent\" width=\"425\" height=\"344\"></embed></object></td></tr>";
		else
			echo "<tr><td align=\"center\"><OBJECT width=\"425\" height=\"344\"><PARAM name=\"movie\" value=\"http://video.rutube.ru/$video_link\"></PARAM><param name=\"wmode\" value=\"transparent\" /></PARAM><PARAM name=\"allowFullScreen\" value=\"true\"></PARAM><EMBED src=\"http://video.rutube.ru/$video_link\" type=\"application/x-shockwave-flash\" wmode=\"transparent\" width=\"425\" height=\"344\" allowFullScreen=\"true\" ></EMBED></OBJECT></td></tr>";

		}

		else

		{

		echo "<tr><td align=\"center\">Не верно указана ссылка видеоролика!</td></tr>";		

		}
}

?>
</table>

</body>
</html>