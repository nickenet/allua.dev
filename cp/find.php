<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: find.php
-----------------------------------------------------
 Назначение: Быстрый поиск компании
=====================================================
*/

session_start();

require_once './defaults.php';

$help_section = (string)$find_help;

$title_cp = 'Быстрый поиск компании - ';
$speedbar = ' | <a href="find.php">Быстрый поиск компании</a>';

check_login_cp('1_1','find.php');

require_once 'template/header.php';

echo <<<HTML

<table width="100%" border="0">
  <tr>
    <td><img src="images/find.png" width="32" height="32" align="absmiddle" /><span class="maincat">$def_admin_find</span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="3"><img src="images/button-l.gif" width="3" height="34" /></td>
        <td background="images/button-b.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="13" align="center"><img src="images/vdv.gif" width="13" height="31" /></td>
            <td width="160" class="vclass"><img src="images/find.gif" width="31" height="31" align="absmiddle" /><a href="search.php?REQ=auth">$def_search</td>
            <td>&nbsp;</td>
            </tr>
        </table></td>
        <td width="3"><img src="images/button-r.gif" width="5" height="34" /></td>
      </tr>
    </table></td>
  </tr>
</table>
<form action="offers.php?REQ=auth" method="post">
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" id="table_files">$def_admin_uslovie</td>
        <td id="table_files_r">$def_admin_forma_find</td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_title:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idname" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_login_find:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idlogin" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_id_find:</td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idident" maxlength="100" size="40" /></td>
        </tr>
        <tr>
          <td width="250" id="table_files_i">$def_admin_comments: </td>
          <td class="blue_txt" id="table_files_i_r"><input type="text" name="idcomment" maxlength="100" size="40" /></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td id="table_files_i"><input type=submit name=inbut value="$def_admin_search_button" border="0" /></td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>

HTML;

require_once 'template/footer.php';

?>