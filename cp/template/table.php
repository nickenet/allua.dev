<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: table.php
-----------------------------------------------------
 Назначение: Функции отображения таблиц
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

function table_fdata_top ($item)

{

?>

<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="4"><img src="images/table_sys_01.gif" width="4" height="26" /></td>
    <td background="images/table_sys_02.gif"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="16" align="center"><img src="images/table_sys_vdv.gif" width="8" height="20" /></td>
        <td><?echo $item; ?></td>
        <td width="16" align="right"><img src="images/table_sys_zn.gif" width="16" height="16" border="0" /></td>
      </tr>
    </table></td>
    <td width="5"><img src="images/table_sys_03.gif" width="5" height="26" /></td>
  </tr>
  <tr>
    <td width="4" background="images/table_sys_04.gif">&nbsp;</td>
    <td bgcolor="#FFFFFF" align="center"><br />

<?

}

function table_fdata_bottom ()

{

?>

</td>
    <td width="5" background="images/table_sys_06.gif">&nbsp;</td>
  </tr>
  <tr>
    <td width="4"><img src="images/table_sys_07.gif" width="4" height="5" /></td>
    <td background="images/table_sys_08.gif"><img src="images/table_sys_08.gif" width="4" height="5" /></td>
    <td width="5"><img src="images/table_sys_09.gif" width="4" height="5" /></td>
  </tr>
</table>

<?

}

function table_item_top ($item_m,$pic)

{

?>

<table width="100%" border="0">
  <tr>
      <td><img src="images/<? echo $pic; ?>" width="32" height="32" align="absmiddle" /><span class="maincat">&nbsp;<? echo $item_m; ?></span></td>
  </tr>
  <tr>
    <td height="1" bgcolor="#D7D7D7"></td>
  </tr>
</table><br />

<?

}

?>