<? /*

Шаблон - восстановление пароля

*/ ?>

<br />
<form action="remind.php" method="post">
 <table cellpadding="5" cellspacing="1" border="0" width="100%">
  <tr>
   <td bgColor="*bgcolor*" align="right" width="100%">*mail*:&nbsp;<input type="text" name="mail" maxlength="100" style="width:150px;"></td>
  </tr>
  <tr>
   <td bgColor="*bgcolor*" align="right" width="100%">*security*&nbsp;<input type="text" name="security" maxlength="50" style="width:150px;"></td>
  </tr>
  <tr>
   <td align="right" bgColor="*bgcolor*" colspan="2"><input type="submit" name="inbut" value="*reminder*" border="0"></td>
  </tr>
 </table>
</form>