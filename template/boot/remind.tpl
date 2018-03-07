<? /*

Шаблон - восстановление пароля

*/ ?>

<div class="form-horizontal" role="form">
    <form action="remind.php" method="post">
        <div class="form-group has-warning">
            *mail*:
            <input type="text" name="mail" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-warning">
            *security*:
            <input type="text" name="security" maxlength="50" class="form-control">
        </div>
        <div class="form-group has-default">
            <input type="submit" name="inbut" value="*reminder*" class="btn btn-primary">
        </div>
    </form>
</div>