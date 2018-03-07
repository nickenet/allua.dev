<? /*

Шаблон вывода поисковой формы, по первой букве, новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

	if ($def_allow_index == "YES") include ("./searchform.inc.php"); // Форма поиска

	include ("./includes/alpha_view.php"); // Поиск по первой букве

        if ($def_news_module == "YES") include ( "./template/$def_template/show_news.php" ); // Новости

?>