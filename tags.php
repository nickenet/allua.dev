<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: tags.php
-----------------------------------------------------
 Назначение: Облако тегов
=====================================================
*/


$file = 'system/tags.dat';

if ( !file_exists($file) )
{
	echo 'No file';
	
	return;
}


function sorti($a, $b)
{
	$a = $a->num;
	$b = $b->num;
	if ($a == $b)
	{
		return 0;
	}
	
	return $a > $b ? 1 : -1;
}


$data = file_get_contents($file);
$data = unserialize($data);
foreach ($data as $k => $row)
{
	if ($row->state == 'off')
	{
		unset($data[$k]);
	}
}

usort($data, 'sorti');
$title_tags="Облака тегов";
table_top  ($title_tags);
?>
	<div style="padding: 5px">
	<?php foreach ($data as $k => $row) : ?>
		<a style="font-size: <?php echo $row->size; ?>px; color: <?php echo $row->color; ?>"
			href="<?php echo $row->url; ?>"><?php echo $row->name; ?></a><?php echo $k != count($data) - 1 ? ', ' : ''; ?>
	<?php endforeach; ?>
	</div>
<?php table_bottom(); ?>