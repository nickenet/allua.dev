<? /*

Шаблон полной версии видеоролика

*/ ?>
<div itemprop="video" itemscope itemtype="http://schema.org/VideoObject">
<h1 itemprop="name">*title*</h1>
<hr>
<div align="center">*video_wvr500_hvr281*</div>
<span itemprop="description">*fullstory*</span>
<div class="block_vote">
    <div>Добавлено: <b>*date*</b></div>
    <div>Просмотров *hits*</div>
    <div>*rating*</div>
    <div style="float:right;">*blog**qr*</div>
</div>
</div>

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




