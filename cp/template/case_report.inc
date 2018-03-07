<!DOCTYPE HTML>
<html lang="ru-RU" id="case">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<title>Отчет по компании <? echo $firmname; ?></title>

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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><h1><? echo $firmname; ?></h1></td>
    <td width="100" align="center" class="id_f">Id=<? echo $selector; ?></td>
    <td width="100" align="center" class="id_a"><? echo $alpha; ?></td>
  </tr>
    <tr>
    <td style="padding-left:20px;"><? echo $def_bin_rnn; ?>: <b style="color:#006600; font-size:16px;"><? echo $bin; ?></b></td>
    <td colspan="2" align="center" class="id_b"><? echo $tarif; ?></td>
  </tr>
</table>
<hr>    
<table width="100%" border="0" class="main_list">
  <tr>
    <td width="220" align="right">Контактное лицо:</td>
    <td align="left"><b><? echo $manager; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Сопроводительная информация:</td>
    <td align="left"><b><? echo $info; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Заметки по компании:</td>
    <td align="left"><b><? echo $notes; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Банковские реквизиты:</td>
    <td align="left"><b><? echo $banking; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Контактные данные:</td>
    <td align="left"><b><? echo $contact; ?></b></td>
  </tr>
  <tr>
    <td colspan="2" align="right"><hr></td>
  </tr>
  <tr>
    <td align="right">Индекс:</td>
    <td align="left"><b><? echo $zip; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Страна:</td>
    <td align="left"><b><? echo $location; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Область:</td>
    <td align="left"><b><? echo $state; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Город:</td>
    <td align="left"><b><? echo $city; ?></b></td>
  </tr>
  <tr>
    <td width="220" align="right">Адрес:</td>
    <td align="left"><b><? echo $address; ?></b></td>
  </tr>
  <tr>
    <td align="right">E-mail:</td>
    <td align="left"><b><? echo $mail; ?></b></td>
  </tr>
  <tr>
    <td align="right">Телефон:</td>
    <td align="left"><b><? echo $phone; ?></b></td>
  </tr>
  <tr>
    <td align="right">Мобильный:</td>
    <td align="left"><b><? echo $mobile; ?></b></td>
  </tr>
  <tr>
    <td align="right">Факс:</td>
    <td align="left"><b><? echo $fax; ?></b></td>
  </tr>
  <tr>
    <td align="right">www:</td>
    <td align="left"><b><? echo $www; ?></b></td>
  </tr>
  <tr>
    <td align="right">ICQ:</td>
    <td align="left"><b><? echo $icq; ?></b></td>
  </tr>
  <tr>
    <td align="right">Социальные аккаунты:</td>
    <td align="left"><? echo $twitter; ?><? echo $facebook; ?><? echo $vkontakte; ?><? echo $odnoklassniki; ?></td>
  </tr>
  <tr>
    <td align="center"><? echo $qr_code; ?><br><? echo $view; ?><br><br><? echo $view_domen; ?></td>
    <td align="left"><? echo $ymap; ?></td>
  </tr>
</table>

</body>
</html>