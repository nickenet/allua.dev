<? /*

Шаблон - авторизация компании

*/ ?>


<form name="login" action="users/user.php?REQ=authorize" method="post" role="form">
    <h2 class="form-signin-heading">Вход в личный кабинет клиента</h2>
*user*: <input class="form-control"  type="text" name="login" style="width:350px;" maxlength="100">
*password*: <input class="form-control" type="password" name="pass" style="width:350px;" maxlength="100">
*security* <input type="text" class="form-control" name="security" style="width:350px;" maxlength="100"><br>
<input class="btn btn-lg btn-primary" type="submit" value="*enter*" name="inbut"> <br><br><a href="remind.php"><u>*reminder*</u></a>
</form>

