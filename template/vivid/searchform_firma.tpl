<? /*

Шаблон формы поиска по фирмам

*/ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
   <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

 <form name="search" action="*file_find*" method="post">
 <table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tr>
   <td align="right" valign="middle" width="20%" class="searchik">*text_find*:</td>
   <td valign="middle" align="left" width="30%"><input type="text" id="autocomplete" name="skey" size="20" maxlength="64" value="*rezult*"></td>
   <td valign="middle" align="left" width="30%"><select name="location" style="width: 135px;">*select_location*</select>
   <td valign="middle" width="20%" align="left"><input type="submit" name="submit" value="*button_search*"></td>
  </tr>
 </table>
 </form>

</td>
</tr>
</table>