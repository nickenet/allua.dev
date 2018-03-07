<? /*

Шаблон - авторизация компании

*/ ?>

<br />
<form name="login" action="users/user.php?REQ=authorize" method="post">
<table cellpadding="5" cellspacing="1" border="0" width="100%">
     <tr>
        <td bgColor="*bgcolor*" align="right">*user*: <input type="text" name="login" style="width:150px;" maxlength="100"></td>
    </tr>
    <tr>
        <td bgColor="*bgcolor*" align="right">*password*: <input type="password" name="pass" style="width:150px;" maxlength="100"></td>
    </tr>
    <tr>
        <td bgColor="*bgcolor*" align="right">*security*<input type="text" name="security" style="width:150px;" maxlength="100"></td>
    </tr>
    <tr>
        <td align="right" bgColor="*bgcolor*"><input type="submit" value="*enter*" name="inbut"></td>
    </tr>
    <tr>
        <td align="center"><br><a href="remind.php"><u>*reminder*</u></a></td>
    </tr>
</table>
</form>

