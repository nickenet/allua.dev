<? /*

Шаблон - страница жалоб (complaint.php)

*/ ?>

<h1>Пожаловаться на содержимое</h1>
<hr>

<div class="form-horizontal" role="form">
    <form action="complaint.php?REQ=send" method="post" id="complaint_form">
        <div class="form-group has-warning">
            Ваше имя:
            <input type="text" name="name"  value="*rezult_name*" maxlength="50" size="35" class="form-control">
        </div>
        <div class="form-group has-warning">
            E-mail:
            <input type="text" name="mail" maxlength="50"  value="*rezult_mail*" size="35" class="form-control">
        </div>
        <div class="form-group has-warning">
            Адрес страницы:
            <input type="text" name="url" maxlength="50"  value="*url*" size="35" class="form-control">
        </div>
        <div class="form-group has-warning">
            Нарушение:
<select name="category" size="14" class="form-control">
<option value="Фирма не существует">Фирма не существует</option>
<option value="Контактные данные не достоверны">Контактные данные не достоверны</option>
<option value="Дублирующая страница компании">Дублирующая страница компании</option>
<option value="Информация, нарушающая авторские права">Информация, нарушающая авторские права</option>
<option value="Информация о товарах и услугах, не соответствующих законодательству">Информация о товарах и услугах, не соответствующих законодательству</option>
<option value="Незаконно полученная частная и конфиденциальная информация">Незаконно полученная частная и конфиденциальная информация</option>
<option value="Информация с множеством грамматических ошибок">Информация с множеством грамматических ошибок</option>
<option value="Информация непристойного содержания">Информация непристойного содержания</option>
<option value="Содержание, связанное с насилием">Содержание, связанное с насилием</option>
<option value="Спам, вредоносные программы и вирусы (в том числе ссылки)">Спам, вредоносные программы и вирусы (в том числе ссылки)</option>
<option value="Информация о заработке в интернете">Информация о заработке в интернете</option>
<option value="Информация не носящая деловой характер">Информация не носящая деловой характер</option>
<option value="Информация оскорбляющая честь и достоинство третьих лиц">Информация оскорбляющая честь и достоинство третьих лиц</option>
<option value="Другие нарушения правил размещения информации">Другие нарушения правил размещения информации</option>
</select>
        </div>
        <div class="form-group has-warning">
            Текст комментария:
            <textarea name="text" cols="60" rows="10" class="form-control">*rezult_text*</textarea>
        </div>
        <div class="form-group has-warning">
            Код безопасности: *security*:
            <input type="text" name="security" maxlength="15" style="width:250px;" class="form-control">
        </div>
        <div class="form-group has-default">
            <input type="submit" name="inbut" value="Отправить" class="btn btn-primary"><input type="hidden" name="firma_id" value="*id_firma*">
        </div>
    </form>
</div>

<style type="text/css">
label.error {
	display: block;
	color: red;
}
</style>

<script type="text/javascript">
$(function() {
	
	$('#complaint_form').validate({
		rules: { 
				mail: 'required email',
				category: 'required',
				security: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			form.submit();
		}
	});		
});
</script>