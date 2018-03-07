<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: reklama.php
-----------------------------------------------------
 Назначение: Отображение рекламного материала
=====================================================
*/

if( ! defined( 'ISB' ) and empty($_GET['redir'])) {
	die( "Hacking attempt!" );
}

require_once './includes/reklama_classes.php';

reklamAdmin::loadData();

if ( isset($_GET['redir']) )
{
	$url	= reklamAdmin::indexUrl;
	$id		= (int)$_GET['redir'];
	foreach (reklamAdmin::$list as $place)
	{
		if ( !empty($place->subs[$id]) )
		{
			$cont = $place->subs[$id];
			$url = $cont->url;
			
			# Проверка и сохранение последнего обратившего IP
			if ($cont->lastClickIp != $_SERVER['REMOTE_ADDR'])
			{
				$cont->numClick++;
				$cont->lastClickIp = $_SERVER['REMOTE_ADDR'];
			}

			if ($cont->maxClickOn && $cont->numClick >= $cont->maxClick)
			{
				$cont->active = false;
			}

			reklamAdmin::flushData();
		}
	}

	header('Location: ' . $url, TRUE, '302');
	
	exit;
}


if ( empty($reklama) )
{
	return;
}

foreach (reklamAdmin::$list as $place)
{
	if ( strcmp($reklama, $place->title) != 0)
	{
		continue;
	}

	do
	{
		$list = $place->subs;
		if ( empty($list) )
		{
			break;
		}

		$list = array_filter($list, array('reklamAdmin', 'filterActive'));
		if ( empty($list) )
		{
			break;
		}

		usort($list, array('reklamAdmin', 'sortShow'));

		$cont = array_shift($list);
		$cont->numShow++;
		if ($cont->maxShowOn && $cont->numShow >= $cont->maxShow)
		{
			$cont->active = false;
		}

		reklamAdmin::flushData();
		$cont->doShow();
	}
	while (0);
}
?>

<?php chdir(".."); ?>