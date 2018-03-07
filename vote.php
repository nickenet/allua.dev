<?php
header("Content-type: text/plain; charset=windows-1251");

require 'votetop.php';

$num = empty($_GET['num']) ? 0 : (int)$_GET['num'];
if ($num < 0)
{
	echo 'no '.$num;
	return;
}

$data = file_exists($cur_file) ? file_get_contents($cur_file) : '';
$data = unserialize($data);

if ( empty($_COOKIE['poll_'.$data['id']]) && key_exists($num, $data['list']) )
{
	$data['list'][$num]['num']++;
	$data['total']++;
	file_put_contents($cur_file, serialize($data));

	setcookie('poll_'.$data['id'], 'now', time() + 24 * 3600);
}

echo 'ok';
print_results($data);
?>