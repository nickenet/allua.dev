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
<title>*company* - версия для печати</title>

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
.id_f {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
	color: #FF0000;
	border: 2px solid #FF0000;
	padding: 2px;
	margin: 2px;
}
.id_a {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
	color: #0000FF;
	border: 2px solid #0000FF;
	padding: 2px;
	margin: 2px;
}
.id_b {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
	color: #006600;
	border: 2px solid #009900;
	padding: 2px;
	margin: 2px;
}
hr {
	border: 1px dotted #CCCCCC;
}
    .main_list {
	border: 1px solid #A6B2D5;
	border-collapse: collapse;
	margin-top: 20px;
	}
    .main_list td {
        padding: 5px;
	border: 1px solid #A6B2D5;
	}
-->
</style>

</head>

<body>
<br>*logo*<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1>*company*</h1></td>
    <td width="100" align="center" class="id_f">Id=*id_print*</td>
  </tr>
    <tr>
    <td colspan="2" style="padding-left:20px;">*description*</td>
  </tr>
</table>
<hr>    
<table width="100%" border="0" class="main_list">
  <tr>
    <td width="220" align="right">Контактное лицо:</td>
    <td align="left"><b>*contact*</b></td>
  </tr>
  <tr>
    <td align="right">Индекс:</td>
    <td align="left"><b>*zip*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">Страна:</td>
    <td align="left"><b>*country*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">Область:</td>
    <td align="left"><b>*state*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">Город:</td>
    <td align="left"><b>*city*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">Адрес:</td>
    <td align="left"><b>*address*</b></td>
  </tr>
  <tr>
    <td align="right">Телефон:</td>
    <td align="left"><b>*phone*</b></td>
  </tr>
  <tr>
    <td align="right">Мобильный:</td>
    <td align="left"><b>*mobile*</b></td>
  </tr>
  <tr>
    <td align="right">Факс:</td>
    <td align="left"><b>*fax*</b></td>
  </tr>
  <tr>
    <td align="right">www:</td>
    <td align="left"><b>*www*</b></td>
  </tr>
  <tr>
    <td align="right">ICQ:</td>
    <td align="left"><b>*icq*</b></td>
  </tr>
  <tr>
    <td align="right">Социальные аккаунты:</td>
    <td align="left">*twitter_print* *facebook_print* *vkontakte_print* *odnoklassniki_print*</td>
  </tr>
  <tr>
    <td align="center">*qr_print*<br>*social_link*</td>
    <td align="left">*Yandex_map_wym380_hym210*<br>*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*</td>
  </tr>
</table>

<br><div style="padding:5px; text-align: right;"><img src = "*path_to_images*/print.gif" border="0"> <a href="#" onclick="window.print()">Напечатать</a></div><br>
<div style="padding:7px; text-align: right;">*directory_url*</div>
 </body>
</html>