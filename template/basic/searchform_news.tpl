<? /*

Шаблон формы поиска по новостям

*/ ?>


<table width="100%" cellspacing="0" cellpadding="0" border="0">
 <tr>
  <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

 <form name="search" action="*file_find*" method="post">
 <table width="100%" cellspacing="0" cellpadding="5" border="0">
  <tr>
   <td align="right" valign="middle" class="searchik">*text_find*</td>
   <td valign="middle" align="left" ><input type="text" id="autocomplete" name="skey" size="20" maxlength="64" value="*rezult*" style="width: 100%">
   </td>
    <td valign="middle" align="left" width="235">
	<select name="category" style="width: 235px;">
            *select_razdel*
        </select>
   <td valign="middle" align="left"><input type="submit" name="submit" value="*button_search*"></td>
  </tr>
 </table>
 </form>

  </td>
 </tr>
</table>