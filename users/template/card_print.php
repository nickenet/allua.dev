<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<title>Печать визитной карточки</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
.txt {
	font-family: Tahoma;
	font-size: 11px;
	color: #666666;
}
#uprava {
	padding: 2px;
	border: 1px solid #000000;
}
-->
</style>
</head>

<body>
<br>
<?php

function q_tag($text) {

    $fastquotes = array ("&lt;", "&gt;");
    $htmlquotes = array ("<", ">");
    $text = str_replace ( $fastquotes, $htmlquotes, $text );

    return $text;

}

$res_print = (int)$_POST['select']/2;
$card_type = (int)$_POST['type_card'];

$cPhone=htmlspecialchars ( $_POST['phone'], ENT_QUOTES );
$cFax=htmlspecialchars ( $_POST['fax'], ENT_QUOTES );
$cMail=htmlspecialchars ( $_POST['mail'], ENT_QUOTES );
$cAddress=htmlspecialchars ( $_POST['address'], ENT_QUOTES );
$cFirmname=htmlspecialchars ( $_POST['firmname'], ENT_QUOTES );
$cID=intval($_POST['cid']);
$def_mainlocation_name=htmlspecialchars ( $_POST['cdef_mainlocation'], ENT_QUOTES );



if (!isset($cFirmname)) die( "Hacking attempt!" );

for ( $i=0;$i<$res_print;$i++ )

{
?>

<table width="510" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="255" align="center">
    <table width="255" border="0" cellspacing="0" cellpadding="0" id="uprava">
      <tr>
        <td width="218" height="142" valign="top" bgcolor="#FFFFFF"><table width="218" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left" style="padding-left:3px; padding-right:3px;"><div align="center"><strong><? echo $cFirmname; ?></strong></div>
                  <br>
<?php
echo q_tag($cPhone).' '.q_tag($cFax).' '.q_tag($cMail).' '.q_tag($cAddress);
?>
	      </td>
            </tr>
            <tr>
              <td height="22" align="center" class="txt"><? echo $def_mainlocation_name; ?></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
        </table></td>
        <td width="37"><img src="<? echo $def_mainlocation; ?>/users/template/card/<? echo $card_type; ?>.gif" width="37" height="142"></td>
      </tr>
    </table>
    </td>
    <td width="255" align="center">
<table width="255" border="0" cellspacing="0" cellpadding="0" id="uprava">
      <tr>
        <td width="218" height="142" valign="top" bgcolor="#FFFFFF"><table width="218" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td align="left" style="padding-left:3px; padding-right:3px;"><div align="center"><strong><? echo "$cFirmname"; ?></strong></div>
                  <br>
<?php
echo q_tag($cPhone).' '.q_tag($cFax).' '.q_tag($cMail).' '.q_tag($cAddress);
?>
	      </td>
            </tr>
            <tr>
              <td height="22" align="center" class="txt"><? echo $def_mainlocation_name; ?></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
        </table></td>
        <td width="37"><img src="<? echo $def_mainlocation; ?>/users/template/card/<? echo $card_type; ?>.gif" width="37" height="142"></td>
      </tr>
    </table>    
    </td>
  </tr>
</table><br>

<?php
}
?>
</body>
</html>