<? /*

Шаблон вывода разделов подкатегорий

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

    echo "&raquo;&nbsp;<a href=\"index.php?cat=$cat&amp;subcat=$f[catsubsel]&amp;subsubcat=$f[catsubsubsel]\">$f[subsubcategory]</a>&nbsp;<br>";

?>


