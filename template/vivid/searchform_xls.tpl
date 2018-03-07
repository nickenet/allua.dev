<? /*

Шаблон формы поиска по прайс-листам

*/ ?>

<table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
   <td align="center" valign="middle" width="100%" bgcolor="*bgcolor*" background="*path_to_images*/bg_searchform.gif">

<form action="*file_find*" method=post>
	<table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td width="150" align="center" class="searchik">*text_find*&nbsp;</td>
            <td><input type="text" name="skey" id="autocomplete" value="*rezult*" maxlength="60" style="width:100%;"></td>
            <td width="60" align="center">&nbsp;<input type="submit" value="*button_search*"></td>
          </tr>
        </table>
</form>

  </td>
 </tr>
</table>