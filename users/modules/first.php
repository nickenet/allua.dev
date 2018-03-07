<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: first.php
-----------------------------------------------------
 Назначение: Первое посещение скрипта
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

if ($_POST["changed"] == "true") {

    $off_mailer=intval($_POST[off_mailer]);
    $off_mail=intval($_POST[off_mail]);
    $off_rev=intval($_POST[off_rev]);
    $on_newrev=intval($_POST[on_newrev]);
    $off_friends=intval($_POST[off_friends]);
    $on_rating=intval($_POST[on_rating]);

    $db->query  ( "UPDATE $db_users SET off_mailer='$off_mailer', off_mail='$off_mail', off_rev='$off_rev', on_newrev='$on_newrev', off_friends='$off_friends', on_rating='$on_rating' WHERE login='$_SESSION[login]'" );
    unset ($f);
    $r = $db->query("SELECT * FROM $db_users WHERE login='$_SESSION[login]'");
    $f = $db->fetcharray($r);

    					if ( $_FILES['img1']['tmp_name'] )

					{
                                                $picdir='logo';
						$size = Getimagesize ( $_FILES['img1']['tmp_name'] );
						$filesize = filesize ( $_FILES['img1']['tmp_name'] );

							$max_width_ls = $def_logo_width;

							$max_width = 10000;
							$max_height = 10000;
							$max_size = $def_logo_size;

                                                if ( ( ( $size[0] <= $max_width ) and ( $size[1] <= $max_height ) and ( $filesize < $max_size ) and ( $size[2] <> 4 ) ) and ( ( $size[2] == 1 ) or ( $size[2] == 2 ) or ( $size[2] == 3 ) or ( $size[2] == 6 ) ) )

						{

							if ( $size[2]==1 ) $type = "gif";
							if ( $size[2]==2 ) $type = "jpg";
							if ( $size[2]==3 ) $type = "png";
							if ( $size[2]==6 ) $type = "bmp";

							@unlink ( ".././$picdir/$f[selector].gif" );
							@unlink ( ".././$picdir/$f[selector].bmp" );
							@unlink ( ".././$picdir/$f[selector].jpg" );
							@unlink ( ".././$picdir/$f[selector].png" );

							copy ( $_FILES['img1']['tmp_name'], ".././$picdir/$f[selector].$type" ) or $uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";

							chmod ( ".././$picdir/$f[selector].$type", 0755 ) or $uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";

							if ($size[0] > $max_width_ls)

							{
								switch ($type)
								{
									case 'jpg':
									$out = 'imagejpeg';
									$q = 100;
									break;

									case 'png':
									$out = 'imagepng';
									$q = 0;
									break;

									case 'gif':
									$out = 'imagegif';
									break;

									case 'bmp':
									$out = 'imagebmp';
									break;
								}

								$img = imagecreatefromstring( file_get_contents('../'.$picdir.'/'.$f[selector].'.'.$type) );
								$w = imagesx($img);
								$h = imagesy($img);
								$k = $max_width_ls / $w;
								$img2 = imagecreatetruecolor($w * $k, $h * $k);
								imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
								$out($img2, '../'.$picdir.'/'.$f[selector].'.'.$type, $q);

							}
						} else $uploaded = "<font color=\"red\">$def_banner_error $def_logo_size Bytes</font><br>";

                                        }
}

if ( isset ( $uploaded ) ) echo '<div class="alert alert-success">'.$uploaded.'</div>';

$logoList = glob('../logo/'.$f[selector].'.*');

?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><div id="TabbedPanels1" class="TabbedPanels">
          <ul class="TabbedPanelsTabGroup">
            <li class="TabbedPanelsTab" tabindex="0">Добро пожаловать</li>
            <li class="TabbedPanelsTab" tabindex="0">Новости для клиентов</li>
          </ul>
          <div class="TabbedPanelsContentGroup">
            <div class="TabbedPanelsContent">
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_r.gif" width="3" height="30"></td>
                  <td align="right" background="<? echo "$def_mainlocation"; ?>/users/template/images/center_r.gif"><table border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td bgcolor="#EEEEEE"><span class="btn-large btn-primary" style="widht: 200px;">Личный кабинет клиента каталога</span></td>
                        <td width="50">&nbsp;</td>
                      </tr>
                  </table></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/right_r.gif" width="3" height="30"></td>
                </tr>
                <tr>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                  <td class="tb_cont">

<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="460" align="left" valign="top"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/welcom.jpg" width="450" height="188"></td>
        <td align="left"><strong>Доброе время суток!</strong><br>
          <br>
Спасибо, что зарегистрировались в нашем каталоге <strong>"Каталог организаций нашего региона"</strong>.<br>
<br>
Если Вы находитесь на этой странице, значит, Ваш аккаунт  проверяется   администратором нашего каталога. В самое ближайшее время Вы  получите   полноценный доступ к личному кабинету клиента, если Ваш аккаунт    соответствует нашим правилам каталога. Вам будет отправлено сообщение на   Вашу электронную  почту, как только Ваш аккаунт будет активирован. </td>
      </tr>
</table>
<br>Пока сервис личного кабинета ограничен, но Вы сможете загрузить логотип Вашей компании и выполнить настройки личного кабинета:<br><br>
<div class="alert alert-info">
<form action="?REQ=authorize&mod=first" method="POST" enctype="multipart/form-data">

<table border="0" cellspacing="2" cellpadding="2">
  <tr>
      <td align="right">Загрузить логотип&nbsp;</td>
      <td>
          <?
          if ($logoList[0]!='') echo '<div class="thumbnail"><img src="'.$def_mainlocation.'/logo/'.basename($logoList[0]).'" alt="Логотип" /></div>';
          ?>
          <input type="file" name="img1" size="25">&nbsp;<input type="hidden" name="step" value="back"><input type="hidden" name="mode" value="logo"><input type="hidden" name="do" value="uploaded"></td>
  </tr>
  <tr>
    <td align="right">Получать рассылку от администрации&nbsp;</td>
    <td><select name="off_mailer">
<?php
if ($f[off_mailer]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select>
    </td>
  </tr>
  <tr>
    <td align="right">Разрешить отправку сообщений на Ваш электронный адрес&nbsp;</td>
    <td><select name="off_mail">
<?php
if ($f[off_mail]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Разрешить добавление комментариев&nbsp;</td>
    <td><select name="off_rev">
<?php
if ($f[off_rev]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Разрешить отправку сообщения друзьям с Вашего аккаунта&nbsp;</td>
    <td><select name="off_friends">
<?php
if ($f[off_friends]==0) {
?>
      <option value="0" selected>Да</option>
      <option value="1">Нет</option>
<?php }
else {
?>
      <option value="0">Да</option>
      <option value="1" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Сообщать на e-mail о поступивших комментариях&nbsp;</td>
    <td><select name="on_newrev">
<?php
if ($f[on_newrev]==1) {
?>
      <option value="1" selected>Да</option>
      <option value="0">Нет</option>
<?php }
else {
?>
      <option value="1">Да</option>
      <option value="0" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right">Сообщать на e-mail о поступивших оценках к компании&nbsp;</td>
    <td><select name="on_rating">
<?php
if ($f[on_rating]==1) {
?>
      <option value="1" selected>Да</option>
      <option value="0">Нет</option>
<?php }
else {
?>
      <option value="1">Да</option>
      <option value="0" selected>Нет</option>
<?php } ?>
    </select></td>
  </tr>
  <tr>
    <td align="right"><input type="submit" name="button" value="Сохранить" class="btn btn-warning"><input type="hidden" name="changed" value="true"></td>
    <td>&nbsp;</td>
  </tr>
</table>
</form>  

</div>
<p>После активации аккаунта, Вы сможете полноценно использовать  наш сервис, а именно:</p>
<table border="0" cellspacing="2" cellpadding="1">
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/maps.png"></td>
    <td><strong>Местоположение компании</strong><br><span class="mainmenu">Возможность загрузить схему проезда, а так же указать местоположение компании на интерактивной карте района.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/photo.png"></td>
    <td><strong>Изображения и фото</strong><br><span class="mainmenu">Загрузить фотографии и изображения товаров или услуг.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/shop.png"></td>
    <td><strong>Товары и услуги</strong><br><span class="mainmenu">Список товаров или услуг с описанием и стоимостью.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/excel.png"></td>
    <td><strong>Прайс-листы</strong><br><span class="mainmenu">Загрузить файлы прайс-листов.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/video.png"></td>
    <td><strong>Видеоролики</strong><br><span class="mainmenu">Транслировать видеоролики с видеобменников.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/news.png"></td>
    <td><strong>Информационный блок</strong><br><span class="mainmenu">Публиковать новости компании, объявления, вакансии,  тендеры и пресс-релизы.</span></td>
  </tr>
  <tr>
    <td width="48"><img width="48" height="48" src="<?=$def_mainlocation; ?>/users/template/images/social.png"></td>
    <td><strong>Социальная страница</strong><br><span class="mainmenu">Cоздать свою социальную страничку и поделится ей в социальных  сетях.</span></td>
  </tr>
</table>
<p>Хотим заметить, что чем больше информации Вы разместите в  нашем каталоге, тем быстрее и лучше Вас будут находить в каталоге потенциальные  клиенты. Каталог быстро индексируется в мировых поисковых системах, поэтому  находить вас смогут не только, через систему каталога, но и через поисковые  системы.<br><br>
Любые вопросы, связанные с работой в личном кабинете  клиента, Вы можете адресовать в службу поддержки.</p>
                  </td>
                  <td width="3" background="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/left_right_r.gif" width="3" height="1"></td>
                </tr>
                <tr>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_left_r.gif" width="3" height="1"></td>
                  <td background="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_center_r.gif" width="3" height="1"></td>
                  <td width="3"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/b_right_r.gif" width="3" height="1"></td>
                </tr>
              </table>
            </div>
            <div class="TabbedPanelsContent">
 		<? include ('doc/news.php'); ?>
            </div>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div id="CollapsiblePanel1" class="CollapsiblePanel">
          <div class="CollapsiblePanelTab" tabindex="0"><img src="<? echo "$def_mainlocation"; ?>/users/template/images/help.png" width="20" height="20" align="absmiddle">Помощь</div>
          <div class="CollapsiblePanelContent">
            <? echo "$help_main"; ?>
          </div>
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
<script type="text/javascript">
<!--
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("CollapsiblePanel1", {contentIsOpen:false});
//-->
$('#myModal').modal('show');
</script>
