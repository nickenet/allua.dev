<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: review_form_news.php
-----------------------------------------------------
 Назначение: Форма для добавления комментария к новости
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/jquery.validate.min.js"></script>
<script type="text/javascript" src="<? echo $def_mainlocation; ?>/includes/messages_ru.js"></script>

<script src="http://loginza.ru/js/widget.js" type="text/javascript"></script>

<br /><br />
<? echo $def_review_msg_text; ?>
<br /><br />
<table cellpadding="5" cellspacing="1" border="0" width="100%">
	<tr>
		<td align="right" colspan="2">
			<?

			$pageUrl="http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];

			if (!empty($_SESSION['loginza']['is_auth']))
			{
				# пользователь уже прошел авторизацию
				$avatarImage = '';
				if (!empty($avatar))
				{
					$avatar = strip_tags($avatar);
					$avatarImage = '<img width="50" src="' . $avatar . '" alt="" />';
				}
				
				echo $def_review_loginza_hellow . ':<br/>',
					$userName . '<br/>',
					$avatarImage . '<br/>',
					'<form method="post" action="' . $pageUrl . '">
					<input type="hidden" name="loginza_quit" value="now" />
					<input type="submit" value="выход" />
					</form>';
			}
			else
			{
				?>
				<? echo $def_review_loginza_enter; ?>:
                                <noindex><a rel="nofollow" href="https://loginza.ru/api/widget?token_url=<? echo urlencode($pageUrl); ?>" class="loginza">
					<img src="https://loginza.ru/img/providers/yandex.png" alt="Yandex" title="Yandex">
					<img src="https://loginza.ru/img/providers/google.png" alt="Google" title="Google Accounts">
					<img src="https://loginza.ru/img/providers/vkontakte.png" alt="Вконтакте" title="Вконтакте">
					<img src="https://loginza.ru/img/providers/mailru.png" alt="Mail.ru" title="Mail.ru">
					<img src="https://loginza.ru/img/providers/twitter.png" alt="Twitter" title="Twitter">
					<img src="https://loginza.ru/img/providers/loginza.png" alt="Loginza" title="Loginza">
					<img src="https://loginza.ru/img/providers/myopenid.png" alt="MyOpenID" title="MyOpenID">
					<img src="https://loginza.ru/img/providers/openid.png" alt="OpenID" title="OpenID">
					<img src="https://loginza.ru/img/providers/webmoney.png" alt="WebMoney" title="WebMoney">
				</a></noindex>
				<?
			}
			?>
		</td>
	</tr>
</table>

<form action="" ENCTYPE="multipart/form-data" method="post" id="comment_form">
	<table cellpadding="5" cellspacing="1" border="0" width="100%">
	
		<tr>
			<td align="right">
				<? echo $def_your_name; ?>:
				<font color="red">*</font>
			</td>
			<td align="left">
				<input type="hidden" name="hiddenbut" value="go">
				&nbsp;<input type="text" name="user_name" maxlength="50" size="50" value="<?php echo $userName; ?>"
					<? if (!empty($_SESSION['loginza']['is_auth'])) echo 'readonly="readonly"'; ?>>
			</td>
		</tr>

		<tr>
			<td align="right">
				<? echo $def_your_email; ?>: &nbsp;&nbsp;
			</td>
			<td align="left">
				&nbsp;<input type="text" name="email" maxlength="50" size="50" value="<?php echo $email; ?>">
			</td>
		</tr>

		<tr>
			<td align="right" valign=top>
				<? echo $def_review; ?>: <font color="red">*</font>
			</td>
			<td align="left">
				&nbsp;<textarea name="texty" id="texty" cols="10" rows="5" 
								onKeyUp="textCounter('texty', 'remLen', <?php echo $def_review_size; ?>);"
								style="width:316px;"><? echo $texty; ?></textarea>
				<br>&nbsp;<input readonly type="text" name="remLen" id="remLen" size="4" maxlength="4" 
								 value="<? echo $def_review_size; ?>"> <?php echo $def_characters_left; ?>
			</td>
		</tr>

		<tr>
			<td align="right" colspan="2">
				Код безопасности: <font color="red">*</font>
				<img src="<? echo $def_mainlocation; ?>/security.php?<? echo $rand; ?>" alt="">&nbsp;<input type="text" name="security" maxlength="100"
                                                                                                                            value="<? echo htmlspecialchars($_POST['security']); ?>"
														style="width:<? echo $def_subm_form_size - 80; ?>;">
			</td>
		</tr>

		<tr>
			<td align="right" colspan="2">
				<input type="submit" name="inbut" value="<?php echo $def_sendmessage_button; ?>">
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
function textCounter (field, countField, maxLimit)
{
	maxLimit = parseInt(maxLimit);
	field = $('#' + field);
	countField = $('#' + countField);
	if (!field.length || !countField.length)
	{
		return;
	} 

	var text = field.val(); 
	
	if (text.length > maxLimit)
	{
		field.val(text.substr(0, maxLimit));
	}
	
	countField.val(maxLimit - text.length);
}


$(function() {
	
	$('#comment_form').validate({
		rules: { 
				user_name: 'required',
				email: 'email',
				texty: 'required',
				security: 'required'
			},
		submitHandler: function(form) {
			$(form).find('input[type="submit"]').attr('disabled', true);
			form.submit();
		}
	});		
	
	$('#texty').keyup();
});
</script>
		