<? /*

Шаблон вывода последних публикаций

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>




<table width="100%" border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td colspan="2"><?php if ($def_lastshow_news == "YES") { $last_type=1; include ("./lastinfo.php"); } ?><br></td>
  </tr>
  <tr>
    <td width="50%" valign="top"><?php if ($def_lastshow_tender == "YES") { $last_type=2; include ("./lastinfo.php"); } ?><br><?php if ($def_lastshow_board == "YES") { $last_type=3; include ("./lastinfo.php"); } ?></td>
    <td width="50%" valign="top"><?php if ($def_lastshow_job == "YES") { $last_type=4; include ("./lastinfo.php"); } ?><br><?php if ($def_lastshow_pressrel == "YES") { $last_type=5; include ("./lastinfo.php"); } ?></td>
  </tr>
</table>