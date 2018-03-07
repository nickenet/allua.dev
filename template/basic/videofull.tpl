<? /*

Шаблон полной версии видеоролика

*/ ?>
<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
<table width="100%" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td align="left" bgcolor="*color*"><strong><span itemprop="name">*title*</span></strong></td>
  </tr>
  <tr>
    <td align="left">Добавлено: *date*</td>
  </tr>
  <tr>
    <td align="center" bgcolor="*color*">*video_wvr500_hvr281*</td>
  </tr>
  <tr>
    <td align="left" bgcolor="*color*"><span itemprop="description">*fullstory*</span></td>
  </tr>
  <tr>
    <td align="right">*rating*</td>
  </tr>
  <tr>
    <td align="right">*blog* &raquo;</td>
  </tr>
  <tr>
    <td align="right">Просмотров *hits*</td>
  </tr>
  <tr>
    <td align="right">*qr*</td>
  </tr>
</table>
</div>
<div align="left">*txt_recommend*</div>

	<script>
	$(function() {
                $.fx.speeds._default = 1000;
		$( "#myblog_isb" ).dialog({
			autoOpen: false,
			resizable: false,
			modal: true,
                        width: 400,
                        height: 400,
                        show: "blind",
			hide: "explode"
		});

		$( "#open_isb" ).click(function() {
			$( "#myblog_isb" ).dialog( "open" );
			return false;
		});

	});
	</script>




