<? /*

Шаблон вывода новостей

*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

?>

<h1 class="post-title">Новости каталога</h1>

<?

$header_set_limit=3;
$header_set_chars_limit=100;
$header_set_main="YES";

include("./includes/show_news.php"); // Новости

?>

<h2 class="post-title">Популярные категори</h2>

<? if ((!$showallcat) and (!$letterss)) include ("./template/$def_template/topcats.php"); ?>

