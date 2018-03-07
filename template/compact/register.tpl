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

<form action="reg.php" name="regform" id="regform" method="post">
    <table cellpadding="5" cellspacing="1" border="0" width="100%">
        <tr>
            <td bgColor="*bgcolor*" align="center"><b>*category*</b>:<font color="red">*</font><br />
            <select name="category[]" multiple style="width: 400px; height: 250px; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; background: #fff;">
                *cat_view*
            </select><br>* *sel_ctrl*
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*company*</b>:&nbsp;<font color="red">*</font>&nbsp;<input type="text" name="firmname" id="firmname" style="width:300px;" size="50" maxlength="100" value="*rezult_company*" ><br />
                <img id="firm_loader" src="images/go.gif" alt="loading" style="visibility:hidden">
                <input type="button" onclick="checkFirm()" value="Проверить">
                <div id="firm_list"></div>
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right" valign="middle"><b>*description*</b>:&nbsp;<font color="red">*</font><br>
                <textarea name="business" id="business" cols="20" rows="5" style="width:400px; height: 250px;">*rezult_description*</textarea><br>
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*keywords*:&nbsp;<input type="text" name="keywords" style="width:300px;" maxlength="100" value="*rezult_keywords*"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*location*</b>:&nbsp;<font color="red">*</font>&nbsp;<select name="location" style="width:300px;">*location_view*</select></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*state*</b>:<font color="red">*</font>&nbsp;<select name="state" style="width:300px;">*state_view*</select></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*city*</b>:<font color="red">*</font>&nbsp;<input type="text" name="city" style="width:300px;" value="*rezult_city*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*address*:&nbsp;<input type="text" name="address" style="width:300px;" value="*rezult_address*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*zip*:&nbsp;<input type="text" name="zip" style="width:300px;" value="*rezult_zip*" maxlength="15"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*phone*:&nbsp;<input type="text" name="phone" style="width:300px;" value="*rezult_phone*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*fax*:&nbsp;<input type="text" name="fax" style="width:300px;" value="*rezult_fax*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*mobile*:&nbsp;<input type="text" name="mobile" style="width:300px;" value="*rezult_mobile*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*icq*:&nbsp;<input type="text" name="icq" style="width:300px;" value="*rezult_icq*" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*manager*:&nbsp;<input type="text" name="manager" style="width:300px;" value="*rezult_manager*" maxlength="100">&nbsp;<img src="*path_to_images*/user.png" alt="user" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*www*:&nbsp;<input type="text" name="www" style="width:300px;" value="*rezult_www*" maxlength="100">&nbsp;<img src="*path_to_images*/www.png" alt="www" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*twitter*&nbsp;<input type="text" name="twitter" style="width:300px;" value="*rezult_twitter*" maxlength="100">&nbsp;<img src="*path_to_images*/twitter.png" alt="twitter" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*facebook*&nbsp;<input type="text" name="facebook" style="width:300px;" value="*rezult_facebook*" maxlength="100">&nbsp;<img src="*path_to_images*/facebook.png" alt="twitter" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*vk*&nbsp;<input type="text" name="vk" style="width:300px;" value="*rezult_vk*" maxlength="100">&nbsp;<img src="*path_to_images*/vkontakte.png" alt="vk" align="absmiddle">&nbsp;</td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*odnoklassniki*&nbsp;<input type="text" name="odnoklassniki" style="width:300px;" value="*rezult_odnoklassniki*" maxlength="100">&nbsp;<img src="*path_to_images*/odnoklassniki.png" alt="odnoklassniki" align="absmiddle">&nbsp;</td>
        </tr>

<!-- Дополнительная переменная 1
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_1*&nbsp;<input type="text" name="reserved_1" style="width:300px;" value="*rezult_reserved_1*" maxlength="100"></td>
        </tr>
-->

<!-- Дополнительная переменная 2
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_2*&nbsp;<input type="text" name="reserved_2" style="width:300px;" value="*rezult_reserved_2*" maxlength="100"></td>
        </tr>
-->

<!-- Дополнительная переменная 3
        <tr>
            <td bgColor="*bgcolor*" align="right">*reserved_3*&nbsp;<input type="text" name="reserved_3" style="width:300px;" value="*rezult_reserved_3*" maxlength="100"></td>
        </tr>
-->
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*security*</b>:&nbsp;<font color="red">*</font>&nbsp;*security_img*&nbsp;<input type="text" name="security" style="width:150px;" size="50" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*mail*</b>:&nbsp;<font color="red">*</font>&nbsp;<input type="text" name="mail" value="*rezult_mail*" style="width:300px;" size="50" maxlength="100"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right">*domen* *dir_to_main*/&nbsp;<input type="text" name="domen" id="domen" maxlength="100" value="*rezult_domen*" style="width:300px;"><br />
                <img id="domen_loader" src="images/go.gif" alt="loading" style="visibility:hidden">
                <input type="button" onclick="checkDomen()" value="Проверить">
                <div id="domen_list"></div>
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*login*</b>: <font color="red">*</font>&nbsp;<input type="text" name="login" id="login" maxlength="100" value="*rezult_login*" style="width:300px;"><br />
                <img id="login_loader" src="images/go.gif" alt="loading" style="visibility:hidden">
                <input type="button" onclick="checkLogin()" value="Проверить">
                <div id="login_list"></div>
            </td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*pass*</b>: <font color="red">*</font>&nbsp;<input type="password" maxlength="100" name="pass" id="pass" style="width:300px;"></td>
        </tr>
        <tr>
            <td bgColor="*bgcolor*" align="right"><b>*pass_repeat*</b>: <font color="red">*</font>&nbsp;<input type="password" maxlength="100" name="pass2" style="width:300px;"></td>
        </tr>
        <tr>
            <td align="right" bgColor="*bgcolor*">
                Я принимаю <a id="help_link" href="javascript:;"><b>правила</b></a> каталога
                <input type="checkbox" name="pravila" id="pravila" value="on">
                <input type="submit" id="regbut" disabled="true" value="*reg_buttion*">
                <input type="hidden" name="regbut" value="*reg_buttion*">
                <br />

		<div id="help_content" class="hh" style="background-color:#fefdea; border: 1px solid #d7d6ba; padding:10px; text-align:left;">
			<a id="help_close" href="javascript:;" style="float: right" class="closed">Прочитано мною. Закрыть [X]</a>
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

            </td>
        </tr>
    </table>
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