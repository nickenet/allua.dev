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
<title>Заявка -  *title*</title>

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
h2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 20px;
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1>*title*</h1></td>
    <td width="200" align="center" class="id_f">Заявка №*number* от *data*</td>
  </tr>
  <tr>
    <td colspan="2" style="padding-left:20px;">*shortstory*</td>
  </tr>
</table>
<hr>    
<table width="100%" border="0" class="main_list">
  <tr>
    <td width="220" align="right">Тип:</td>
    <td align="left"><b>*type*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">*txt_price*</td>
    <td align="left"><b>*price*</b></td>
  </tr>
  <tr>
    <td align="center">*qr_req*</td>
    <td align="left"><b><u>*link_req*</u></b></td>
  </tr>
</table>
<br>*img*<br>
<hr>
<table width="100%" border="0" class="main_list">
  <tr>
    <td colspan="2" style="padding-left:20px;"><h2>*company*</h2></td>
  </tr>
  <tr>
    <td width="220" align="right">Адрес:</td>
    <td align="left"><b>*address*</b></td>
  </tr>
  <tr>
    <td width="220" align="right">Телефон:</td>
    <td align="left"><b>*phone*</b></td>
  </tr>
  <tr>
    <td align="right">Мобильный:</td>
    <td align="left"><b>*mobile*</b></td>
  </tr>
  <tr>
    <td align="center">*qr_firm*<br><b><u>*link_firm*</u></b></td>
    <td align="left">*Yandex_map_wym380_hym210*<br>*koordinata* *shirota_text**shirota* *dolgota_text**dolgota*</td>
  </tr>
</table>

<br><div style="padding:5px; text-align: right;"><img src = "*path_to_images*/print.gif" border="0"> <a href="#" onclick="window.print()">Напечатать</a></div><br>
<div style="padding:7px; text-align: right;">*directory_url*</div>
 </body>
</html>