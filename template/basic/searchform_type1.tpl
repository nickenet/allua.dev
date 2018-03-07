<? /*

Шаблон формы поиска тип 1

*/ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
 <tr>
  <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

 <form name="search" action="*file_find_company*" method="post">
 <table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tr>
   <td align="right" valign="middle" width="20%" class="searchik">*text_find_company*:</td>
   <td valign="middle" align="left" width="30%"><input type="text" name="skey" id="autocomplete" size="20" maxlength="64">
<script type="text/javascript"><!--
document.search.skey.focus();
//--></script>
   </td>
   </td>
    <td valign="middle" align="left" width="30%"><select name="location" style="width: 135px;">*select_location*</select></td>
    <td valign="middle" width="20%" align="left"><input type="submit" name="submit" value="*button_search*"></td>
  </tr>
 </table>
 </form>

<form action="*file_find_product*" method="post">
<table width="100%" cellspacing="0" cellpadding="5" border="0">
 <tr>
  <td align="right" valign="middle" width="20%" class="searchik">*text_find_product*:</td>
  <td valign="middle" width="30%" align="left"><input type="text" name="pkey" size="20" maxlength="64"></td>
  <td valign="middle" align="left" width="30%"><select name="type" style="width: 135px;">*offers_type*</select></td>
  <td valign="middle" align="left" width="20%"><input type="submit" name="submit" value="*button_search*"><br></td>
 </tr>
</table>
</form>

<form action="*file_find_images*" method="post">
 <table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tr>
   <td align="right" valign="middle" width="20%" class="searchik">*text_find_images*:</td>
   <td valign="middle" width="30%" align="left"><input type="text" name="pkey" size="20" maxlength="64"></td>
    <td valign="middle" align="left" width="30%"></td>
    <td valign="middle" align="left" width="20%"><input type="submit" name="submit" value="*button_search*"><br></td>
  </tr>
</table>
</form>

  </td>
 </tr>
</table>