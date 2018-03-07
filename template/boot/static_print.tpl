<?
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // always modified
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Pragma: no-cache"); // HTTP/1.0
?>

<!DOCTYPE HTML>
<html lang="ru-RU" id="case">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>*title* - версия для печати</title>

<style type="text/css">
<!--
body {
    	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	margin : 0;
        color: #333333;
        background-color: #ffffff;
}
h1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
	padding-left: 20px;
}
</style>

</head>

<body>

<div style="padding: 5px; text-align: left;">
<h1>*title*</h1>
<p style="text-align: justify;">*text*</p>
<p>*qr*</p>
</div>

<br><div style="padding:5px; text-align: right;"><img src = "*path_to_images*/print.gif" border="0"> <a href="#" onclick="window.print()">Напечатать</a></div><br>
 </body>
</html>