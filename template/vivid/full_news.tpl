<? /*

Шаблон полной версии новости

*/ ?>

<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td align="left" bgcolor="*color*"><strong>*title*</strong></td>
  </tr>
  <tr>
    <td align="left">*date*&nbsp;|&nbsp;*keywords*</td>
  </tr>
  <tr>
    <td align="left" bgcolor="*color*">*fullstory*</td>
  </tr>
  <tr>
    <td align="right">*rating*</td>
  </tr>
  <tr>
    <td align="right">*related*</td>
  </tr>
  <tr>
    <td align="right">*blog* &raquo;</td>
  </tr>
  <tr>
    <td align="right">Категория: <b>*category*</b> | Просмотров *hits* | <noindex><a href="*link_print*" rel="nofollow">Версия для печати &raquo;</a></noindex></td>
  </tr>
  <tr>
    <td align="right">*qr*</td>
  </tr>
</table>

	<script>
	$(function() {
                $.fx.speeds._default = 1000;
		$( "#myblog_isb" ).dialog({
			autoOpen: false,
			resizable: false,
			modal: true,
                        width: 450,
                        height: 450,
                        show: "blind",
			hide: "explode"
		});

		$( "#open_isb" ).click(function() {
			$( "#myblog_isb" ).dialog( "open" );
			return false;
		});

	});
	</script>





