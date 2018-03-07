<? /*

Шаблон вывода последних новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td style="padding-left:10px;"><table width="242" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="151" height="22" bgcolor=<? echo $def_kurs_background; ?>>&nbsp;<img src="<? echo $def_mainlocation; ?>/template/<? echo $def_template; ?>/images/news.gif" width="16" height="16" align="absmiddle"><font color="#FFFFFF">&nbsp;Новости одной строкой</font></td>
            <td width="80" align="right" bgcolor="#FFFFFF"><a href="<? echo $def_mainlocation; ?>/news/">Все новости &raquo;</a></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="border">
          <tr>
            <td style="padding-left:10px; padding-right:10px; padding-top:5px; padding-bottom:5px;">

<? 

include("./includes/show_news.php");

?>

	   </td>
          </tr>
        </table></td>
      </tr>
</table>