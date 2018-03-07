<? /*

Шаблон вывода первых букв

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1 class="post-title">Поиск по первой букве</h1>
<p>Выберите букву</p>
<div style="text-align:center;">
<form>
    <input type="hidden" name="select value">
		<select name="sel" size="1" class="input-search" OnChange="top.location.href = this.options[this.selectedIndex].value;">
			<?php
				$letters = explode("#", $def_index_search);
				for ($a=0;$a<count($letters);$a++)
				{
				echo "<option value=\"$def_mainlocation_pda/index.php?letter=$letters[$a]\">$letters[$a]</option>";
				}
			?>
		</select>
</form>
</div>

