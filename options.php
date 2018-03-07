<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: options.php
-----------------------------------------------------
 Назначение: Выбор языка и шаблона
=====================================================
*/

?>
<div align=center>

<?php if ($def_one_lang != "YES") { ?>

Язык: 
<form action=# method=POST>
<select name=lang onchange="this.form.submit();">

<?php

$handler = opendir ( "./lang");

while (false !== ($file = readdir($handler)))

{

	if ( strpos($file, 'language.') !== false )

	{

		$language = explode (".", $file);

		if ($lang == $language[1])

		echo "<option value=\"$language[1]\" SELECTED>$language[1]\n";

		else

		echo "<option value=\"$language[1]\">$language[1]\n";

	}

}

closedir ($handler);

?>

</select>
</form>

<?php } 
if ($def_one_template != "YES") { ?>

Шаблон: 
<form action=# method=POST>
<select name=template onchange="this.form.submit();">

<?php

$handler = opendir ( "./template");

while (false !== ($file = readdir($handler)))

{

	if ( $file != "." && $file != ".." && $file != "index.html" && $file != "_vti_cnf" )

	{

		if ($def_template == $file)

		echo "<option value=\"$file\" SELECTED>$file\n";

		else

		echo "<option value=\"$file\">$file\n";

	}

}

closedir ($handler);

?>

</select>
</form>

<?php 
}
?>

 <br />
<br />

</div>
