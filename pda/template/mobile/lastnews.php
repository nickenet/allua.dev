<? /*

Шаблон вывода новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1 class="post-title">Последние новости</h1>

<?

$header_set_limit=15;
$header_set_chars_limit=100;
$header_set_main="YES";

include("./includes/show_news.php"); // Новости

?>

