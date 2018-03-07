<script type="text/javascript">
$(function() {
	$("#send").click(function(){
		var author = $("#author").val();
		var message = $("#message").val();
                var security = $("#security").val();
		$.ajax({
			type: "POST",
			url: "sendmessage.php",
			data: {"author": author, "message": message, "security": security, "id_firm": *id*},
			cache: false,						
			success: function(response){
				var messageResp = new Array('Ваше сообщение отправлено!','Сообщение не отправлено!','Нельзя отправлять пустые сообщения!','Код безопасности не соответствует отображённому!');
				var resultStat = messageResp[Number(response)];
				if(response == 0){
					$("#author").val("");
					$("#message").val("");
                                        $("#security").val("");
				}
				$("#resp").text(resultStat).show().delay(1500).fadeIn(800);
				$("#form_mess").hide("slow");
				
			}
		});
		return false;
				
	});
});
</script>
<h1>Отправить сообщение для "*company*"</h1>
<div id="form_mess">
<form action="sendmessage.php" method="post" name="form">
	<p>Ваш e-mail:<br><input name="author" type="email" pattern="[^ @]*@[^ @]*" id="author" class="input-search" /></p>
	<p>Текст сообщения:<br><textarea name="message" rows="5" id="message" class="input-search"></textarea></p>
	<p>*security_img*<input name="security" type="number" pattern="\d*" id="security" class="input-search" /></p>
	<input name="js" type="hidden" value="no" id="js" />
	<p><input name="button" type="submit" value="Отправить" id="send" class="btn btn-info" /></p>
</form>
</div>
<span id="resp"></span>