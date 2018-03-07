<? /*

Шаблон обработки вывода номера страницы

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

$page_news=str_replace('[', '', $page_news);
$page_news=str_replace(']', '', $page_news);

?>