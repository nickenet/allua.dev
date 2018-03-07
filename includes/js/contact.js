<script type="text/javascript" src="includes/jquery.validate.min.js"></script>

<script type="text/javascript">
function markDiv()
{
	var list = ['adm', 'finan', 'reklama']; //Список id от div, в порядке, который есть в select
	var num  = document.getElementById('admin').selectedIndex;

	for (var i in list)
	{
		document.getElementById(list[i]).className = (i == num ? 'activ' : 'normal');
	}
}

document.getElementById('admin').onchange = markDiv;
markDiv();

    $(document).ready(function() {
    $('#send_form').click(function() {
	
        var admin = $("#admin").val();
        var name = $("#name").val();
        var tel = $("#tel").val();
        var mail = $("#mail").val();
		var text = $("#text").val();
        var security = $("#security").val();
	
		if(mail == "" || text == "" || security == "")
		{
			console.log("sdf");
			var arra = Array();
			if(mail == "") arra.push("\"E-mail\"");
			if(text == "") arra.push("\"Ваше сообщение\"");
			if(security == "") arra.push("\"Код безопасности\"");
			$("#ok_send").html("<div class=\"error_captcha\">Не заполнено поле: "+arra.join(", ")+"</div>");
			
		}
		else
		{
			$.ajax({
				type: "POST",
				dataType: "script",
				url: 'includes/ajax/send_contact.php',
				data: { "name": name, "mail": mail, "tel": tel, "text": text, "security": security, "admin": admin  },
				cache: false,
				beforeSend: function() { $('#ok_send').html('<img src="images/go.gif">'); },
				success: function(html) { eval(html); }
			});
		}
        
     });
});
</script>