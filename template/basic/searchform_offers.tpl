<? /*

Шаблон формы поиска по продукции и услугам

*/ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
   <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

<form action="*file_find*" method=post>
   <table width="100%" cellspacing="0" cellpadding="5" border="0">
     <tr>
      <td align="right" valign="middle" width="20%" class="searchik">*text_find*</td>
      <td valign="middle" width="30%" align="left"><input type="text" id="autocomplete" name="pkey" value="*rezult*" size="20" maxlength="64"></td>
      <td valign="middle" align="left" width="30%"><select name="type" style="width:185px;">*offers_type*</select></td>
      <td valign="middle" align="left" width="20%"><input type="submit" name="submit" value="*button_search*"></td>
     </tr>
   </table>
</form>

   </td>
  </tr>
</table>