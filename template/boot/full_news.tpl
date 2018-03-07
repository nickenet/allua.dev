<? /*

Шаблон полной версии новости

*/ ?>

<h1>*title*</h1>
<div class="panel panel-default">
  <div class="panel-body">
    *date*&nbsp;|&nbsp;*keywords*
  </div>
</div>
<p>*fullstory* *rating*</p>
<br>
<div class="block_vote">*related*</div>
<div class="panel panel-default">
  <div class="panel-body">
      <div align="right">Категория: <b>*category*</b> | Просмотров *hits* | *blog* | <noindex><a href="*link_print*" rel="nofollow">Версия для печати &raquo;</a></noindex></div>
  </div>
</div>
<div>*qr*</div>

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






