<? /*

Шаблон - регистрация в каталоге

*/ ?>

<style type="text/css">
   OPTGROUP.catXR {
    background: #000000; /* Цвет фона */
    color: #FFFFFF; /* Цвет текста */
   }
   OPTGROUP.subXR {
    background: #CCCCCC; /* Цвет фона */
    color: #000000; /* Цвет текста */
   }
   OPTION {
    color:  #000; /* Цвет текста */
    background: #fff; /* Цвет фона */
   }
   OPTION.mainXR {
    background: #E8E8E8; /* Цвет фона */
    color: #000000; /* Цвет текста */
   }
   .hh {
	display: none;
   }
</style>

<h1>Регистрация в каталоге</h1>
<hr>

<form action="reg.php" name="regform" id="regform" method="post">
<div class="form-horizontal" role="form">
        <div class="form-group has-warning">
            *category*
           <select name="category[]" multiple style="height: 250px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 14px; background: #fff;" class="form-control">
                *cat_view*
            </select>* *sel_ctrl*
        </div>
</div>
    <hr>
    <div class="form-inline" role="form">
        <div class="form-group has-warning">
            <label class="control-label">*company*</label>
            <input type="text" name="firmname" id="firmname" style="width:400px;" size="50" maxlength="100" value="*rezult_company*"  class="form-control">&nbsp;<input type="button" onclick="checkFirm()" value="Проверить" class="btn btn-default">
                <img id="firm_loader" src="images/go.gif" alt="loading" style="visibility:hidden">                   
                <div id="firm_list" class="label label-info"></div>
        </div>
    </div>
    <hr>
<div class="form-horizontal" role="form">
        <div class="form-group has-warning">
            *description*
            <textarea name="business" id="business" cols="20" rows="5" style="height: 250px;" class="form-control">*rezult_description*</textarea>
        </div>
        <div class="form-group has-default">
            *keywords*
            <input type="text" name="keywords" maxlength="100" value="*rezult_keywords*" class="form-control">
        </div>
        <div class="form-group has-warning">
            *location*
            <select name="location" class="form-control">*location_view*</select>
        </div>
        <div class="form-group has-warning">
            *state*
            <select name="state" class="form-control">*state_view*</select>
        </div>
        <div class="form-group has-warning">
            *city*
            <input type="text" name="city" value="*rezult_city*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *address*
            <input type="text" name="address" value="*rezult_address*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *zip*
            <input type="text" name="zip" style="width:300px;" value="*rezult_zip*" maxlength="15" class="form-control">
        </div>
        <div class="form-group has-default">
            *phone*
            <input type="text" name="phone" value="*rezult_phone*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *fax*
            <input type="text" name="fax" value="*rezult_fax*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *mobile*
            <input type="text" name="mobile" value="*rezult_mobile*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            *icq*
            <input type="text" name="icq" value="*rezult_icq*" maxlength="100" class="form-control">
        </div>
        <div class="form-group has-default">
            &nbsp;<img src="*path_to_images*/user.png" alt="user" align="absmiddle">&nbsp;*manager*
            <input type="text" name="manager" value="*rezult_manager*" maxlength="100" class="form-control">
        </div>
    <div style="text-align:right;">
    <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *www*
            <input type="text" name="www" style="width:300px;" value="*rezult_www*" maxlength="100" class="form-control" placeholder="http://">&nbsp;<img src="*path_to_images*/www.png" alt="www" align="absmiddle">&nbsp;
        </div>
    </div>
     <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *twitter*
            <input type="text" name="twitter" style="width:300px;" value="*rezult_twitter*" maxlength="100" class="form-control" placeholder="имя">&nbsp;<img src="*path_to_images*/twitter.png" alt="twitter" align="absmiddle">&nbsp;
        </div>
     </div>
     <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *facebook*
            <input type="text" name="facebook" style="width:300px;" value="*rezult_facebook*" maxlength="100" class="form-control" placeholder="имя">&nbsp;<img src="*path_to_images*/facebook.png" alt="twitter" align="absmiddle">&nbsp;
        </div>
     </div>
     <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *vk*
            <input type="text" name="vk" style="width:300px;" value="*rezult_vk*" maxlength="100" class="form-control" placeholder="имя">&nbsp;<img src="*path_to_images*/vkontakte.png" alt="vk" align="absmiddle">&nbsp;
        </div>
     </div>
     <div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *odnoklassniki*
            <input type="text" name="odnoklassniki" style="width:300px;" value="*rezult_odnoklassniki*" maxlength="100" class="form-control" placeholder="имя">&nbsp;<img src="*path_to_images*/odnoklassniki.png" alt="odnoklassniki" align="absmiddle">&nbsp;
        </div>
     </div>
    </div>

<!-- Дополнительная переменная 1
        <div class="form-group has-default">
            *reserved_1*
            <input type="text" name="reserved_1" style="width:300px;" value="*rezult_reserved_1*" maxlength="100" class="form-control">
        </div>
-->

<!-- Дополнительная переменная 2
        <div class="form-group has-default">
            *reserved_2*
            <input type="text" name="reserved_2" style="width:300px;" value="*rezult_reserved_2*" maxlength="100" class="form-control">
        </div>
-->

<!-- Дополнительная переменная 3
        <div class="form-group has-default">
            *reserved_3*
            <input type="text" name="reserved_3" style="width:300px;" value="*rezult_reserved_3*" maxlength="100" class="form-control">
        </div>
-->
        <div class="form-group has-warning">
            *security* *security_img*
            <input type="text" name="security" style="width:250px;" size="50" maxlength="100" class="form-control" type="number">
        </div>
        <div class="form-group has-warning">
            *mail*
            <input type="text" name="mail" value="*rezult_mail*" size="50" maxlength="100" class="form-control" type="email">
        </div>
<div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-default">
            *domen* <b>*dir_to_main*/</b>
            <input type="text" name="domen" id="domen" maxlength="100" value="*rezult_domen*" style="width:300px;" class="form-control" placeholder="имя_фирмы_в_латинице">
                <input type="button" onclick="checkDomen()" value="Проверить" class="btn btn-default">
                <img id="domen_loader" src="images/go.gif" alt="loading" style="visibility:hidden"><div id="domen_list" class="label label-info"></div>
        </div>
</div>
<div class="form-inline" role="form" style="padding: 10px;">
        <div class="form-group has-warning">
            *login*
            <input type="text" name="login" id="login" maxlength="100" value="*rezult_login*" style="width:300px;" class="form-control">
                <input type="button" onclick="checkLogin()" value="Проверить" class="btn btn-default">
                <img id="login_loader" src="images/go.gif" alt="loading" style="visibility:hidden"><div id="login_list" class="label label-info"></div>
        </div>
</div>
        <div class="form-group has-warning">
            *pass*
            <input type="password" maxlength="100" name="pass" id="pass" style="width:300px;" class="form-control">
        </div>
        <div class="form-group has-warning">
            *pass_repeat*
            <input type="password" maxlength="100" name="pass2" style="width:300px;" class="form-control">
        </div>
        <div class="form-group has-warning">
            Я принимаю <a id="help_link" href="javascript:;"><b>правила</b></a> каталога
                <input type="checkbox" name="pravila" id="pravila" value="on">
                <input type="submit" id="regbut" disabled="true" value="*reg_buttion*" class="btn btn-primary">
                <input type="hidden" name="regbut" value="*reg_buttion*">
                <br />
        </div>

		<div id="help_content" class="hh alert alert-warning">
			<a id="help_close" href="javascript:;" style="float: right" class="label label-success">Прочитано мною. Закрыть [X]</a>
<p><strong>*catalog*</strong> предоставляет услуги, позволяющие  пользователям регистрироваться и создавать в каталоге учетные записи. После  регистрации на <strong>*catalog*</strong> пользователь получает доступ к  разделу каталога «<strong>Личный кабинет</strong>», в котором он может опубликовать информацию о  представляемой им компании: контактную информацию; информацию о товарах и  услугах, предлагаемых компанией; прочую информацию о компании.<br>
<br>
  При регистрации Вы обязаны предоставить правдивую, точную и  полную информацию о компании и поддерживать эту информацию в актуальном  состоянии. В случае предоставления неверной информации, <strong>*catalog*</strong> имеет  право приостановить либо отменить Вашу регистрацию и прекратить предоставление  услуг.<br>
  <br>
  <strong>Правила  размещения информации в каталоге</strong><br>
  <br>
  <strong style="color:#FF0000;">В каталоге  разрешается:</strong><br>
  - загрузить логотип, схему проезда,  указать контактные данные и филиалы; <br>
  - предоставить подробное описание  деятельности компании;<br>
  - размещать товары и услуги;<br>
  - размещать галерею товаров и услуг;<br>
  - размещать прайс-листы;<br>
  - размещать публикации (новости, тендеры, объявления, вакансии, пресс-релизы);<br>
  - размещать видеоролики;<br>
  - проводить рекламные компании;<br>
  - отвечать на отзывы и комментарии к  компании;<br>
  - вести переписку с посетителями  каталога.<br>
  <br>
  Количество позиций регулируется  тарифными планами каталога. <br>
  <br>
  <strong style="color:#FF0000;">В каталоге  запрещается:</strong><strong> </strong><br>
  - размещать организацию, содержание  которой не соответствует теме выбранного раздела;<br>
  - вставлять в описания позиций мета-теги, всевозможный код, непонятные символы  и рисунки;<br>
  - подача регистрации без указания данных для обратной связи (адрес, телефон, e-mail и др.);<br>
  - размещать информацию о товарах и услугах, запрещённую к распространению  действующим законодательством;<br>
  - информацию, нарушающую авторские  права третей стороны, патентное право, коммерческую тайну, копии сайтов или  отдельно взятые страницы, изображения и тексты, размещенные в интернете, если  копирование запрещено владельцами оригинала;<br>
  - информацию о компаниях или юридических  лицах, которые уже представлены в каталоге; <br>
  - информацию, связанную с  распространением любого вида порнографии, информацию об услугах сексуального  характера или другую подобную информацию, носящую сексуальный характер;<br>
  - спам, вредоносные программы, предназначенные  для нарушения нормального функционирования или уничтожения других программ,  серийные номера к коммерческим программным продуктам и программы для их  генерации, средства для получения несанкционированного доступа к платным  ресурсам в интернете, а также ссылки на подобную информацию<br>
  - информацию, связанную с пропагандой  насилия, ненависти, расовой вражды, клеветой или оскорблением третьих лиц или  организаций.<br>
  <br>
  В случае нарушения правил, Ваш аккаунт будет удален, а также Вам будет  закрыт доступ для дальнейшей работы с каталогом.<br>
  <br>
Администрация сайта никоим образом не несёт ответственность за услуги или  товар, предложение которых находится на данном каталоге, а также оставляет за  собой право удалять любые регистрации без объяснения причин.</p>
		</div>

</div>
</form>

<style type="text/css">
label.error {
	display: block;
	color: red;
}
</style>

<script type="text/javascript">

// Принимаю правила каталога
function showBut()
{
	if (!$('#pravila').length || !$('#regbut').length)
	{
		return;
	}

	if ($('#pravila:checked').val() == 'on')
	{
		$('#regbut').attr('disabled', false);
	}
	else
	{
		$('#regbut').attr('disabled', true);
	}
}


function checkFirm()
{
	if (!$('#firmname').length || !window.formValid.element('#firmname'))
	{
		return false;
	}

	var check_value = $('#firmname').val();
	if (check_value == '')
	{
		return false;
	}

	$('#firm_list').hide();
	$('#form_loader').css('visibility', 'visible');
	$.post(
		'reg.php',
		{
		  do_check: 'firm',
		  check: check_value
		},
		function(data){
			$('#form_loader').css('visibility', 'hidden');
			$('#firm_list').html(data).slideDown();
		}
	);

	return true;
}


function checkLogin()
{
	if (!$('#login').length || !window.formValid.element('#login'))
	{
		return false;
	}

	var check_value = $('#login').val();
	if (check_value == '')
	{
		return false;
	}

	$('#login_list').hide();
	$('#login_loader').css('visibility', 'visible');
	$.post(
		'reg.php',
		{
		  do_check: 'login',
		  check: check_value
		},
		function(data){
			$('#login_loader').css('visibility', 'hidden');
			$('#login_list').html(data).slideDown();
		}
	);

	return true;
}

function checkDomen()
{
	if (!$('#domen').length || !window.formValid.element('#domen'))
	{
		return false;
	}

	var check_value = $('#domen').val();
	if (check_value == '')
	{
		return false;
	}

	$('#domen_list').hide();
	$('#domen_loader').css('visibility', 'visible');
	$.post(
		'reg.php',
		{
		  do_check: 'domen',
		  check: check_value
		},
		function(data){
			$('#domen_loader').css('visibility', 'hidden');
			$('#domen_list').html(data).slideDown();
		}
	);

	return true;
}


$(function() {

	window.formValid = $('#regform').validate({
		rules: {
				'category[]': 'required',
				firmname: 'required',
				business: 'required',
				location: 'required',
				state: 'required',
				city: 'required',
				mail: 'required email',
				security: 'required',
				login: 'required',
				pass: 'required',
				pass2: {
					required: true,
					equalTo: "#pass"
				},
				pravila: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			form.submit();
		}
	});

	showBut();
	$('#pravila').click(showBut);

        $('#help_close').click(function(){
	$('#help_content').slideUp();
	});
	$('#help_link').click(function(){
		$('#help_content').css('paddingBottom', '10px');
		$('#help_content').slideDown(700);
		$('#help_content').animate({paddingBottom:'0'}, 300);
	});

});
</script>
<br>