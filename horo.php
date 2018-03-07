<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by Ilya.K
=====================================================
 Файл: horo.php
-----------------------------------------------------
 Назначение: Гороскоп от Ignio.com
=====================================================
*/


class Horos
{
	private $file  = 'system/horo.dat';
	private $today = 0;
	
	public $data      = array();
	public $sign      = - 1;
	public $type      = - 1;
	public $show_week = false;
	public $cur_sign  = array();
	
	public $list = array(
		array('name' => 'Общий',            'url' => 'http://img.ignio.com/r/export/utf/xml/daily/com.xml'),
		array('name' => 'Бизнес',           'url' => 'http://img.ignio.com/r/export/utf/xml/daily/bus.xml'),
		array('name' => 'Здоровья',         'url' => 'http://img.ignio.com/r/export/utf/xml/daily/hea.xml'),
		array('name' => 'Гастрономический', 'url' => 'http://img.ignio.com/r/export/utf/xml/daily/cook.xml'),
		array('name' => 'Любовный',         'url' => 'http://img.ignio.com/r/export/utf/xml/daily/lov.xml'),
		array('name' => 'Мобильный',        'url' => 'http://img.ignio.com/r/export/utf/xml/daily/mob.xml')
		);
	
	public $signs = array(
		array('name' => 'aries',       'title' => 'Овен'),
		array('name' => 'taurus',      'title' => 'Телец'),
		array('name' => 'gemini',      'title' => 'Близнецы'),
		array('name' => 'cancer',      'title' => 'Рак'),
		array('name' => 'leo',         'title' => 'Лев'),
		array('name' => 'virgo',       'title' => 'Дева'),
		array('name' => 'libra',       'title' => 'Весы'),
		array('name' => 'scorpio',     'title' => 'Скорпион'),
		array('name' => 'sagittarius', 'title' => 'Стрелец'),
		array('name' => 'capricorn',   'title' => 'Козерог'),
		array('name' => 'aquarius',    'title' => 'Водолей'),
		array('name' => 'pisces',      'title' => 'Рыбы')
		);
		
	public $week = array(
		'prev' => array('type' => 0, 'url' => 'http://img.ignio.com/r/export/utf/xml/weekly/prev.xml'),
		'this' => array('type' => 0, 'url' => 'http://img.ignio.com/r/export/utf/xml/weekly/cur.xml')
		);	
		
	public $week_types = array(
		'common'   => 'Общий',
		'business' => 'Бизнес-гороскоп',
		'love'     => 'Гороскоп "Семья, любовь"',
		'car'      => 'Автомобильный гороскоп',
		'health'   => 'Гороскоп здоровья',
		'shop'     => 'Шоппинг-гороскоп',
		'beauty'   => 'Гороскоп красоты',
	);	
		
	function __construct()
	{
		foreach (array('type', 'sign') as $v)
		{
			if ( isset($_GET[$v]) )
			{
				$this->$v = (int)$_GET[$v];
			}
		}
		
		if ( $this->type < 0 || $this->type >= count($this->list) + 2 )
		{
			$this->type = 1;
		}
		
		if ( !array_key_exists($this->sign, $this->signs) )
		{
			$this->sign = 0;
		}
		
		$this->week['prev']['type'] = count($this->list);
		$this->week['this']['type'] = count($this->list) + 1;
		
		$this->today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		
		$update = $this->today + (13 - 3) * 3600 + date('Z');
		if ( !file_exists($this->file) 
			|| (time() > $update && filemtime($this->file) < $update) )
		{
			foreach ($this->list as $k => $v)
			{
				$tmp = file_get_contents($v['url']);
				$tmp = simplexml_load_string($tmp);
				
				$parse = new stdClass();
				foreach ($tmp as $sign => $days)
				{
					$parse->$sign = new stdClass();
					foreach ($days as $day => $text)
					{
						$parse->$sign->$day = iconv('UTF-8', 'WINDOWS-1251', (string)$text);
					}
				}
				
				$this->data[$k] = $parse;
			}

			foreach ($this->week as $w)
			{
				$tmp = file_get_contents($w['url']);
				$tmp = simplexml_load_string($tmp);
				
				$parse = new stdClass();
				foreach ($tmp as $sign => $v)
				{
					$parse->$sign = new stdClass();
					foreach ($v as $type => $text)
					{
						$parse->$sign->$type = iconv('UTF-8', 'WINDOWS-1251', (string)$text);
					}
				}
				
				$this->data[ $w['type'] ] = $parse;
			}
			
			file_put_contents( $this->file, serialize($this->data) );
		}
		else
		{
			$this->data = file_get_contents($this->file);
			$this->data = unserialize($this->data);
		}
		
		$this->data = $this->data[ $this->type ];
		
		if ( $this->type >= count($this->list) )
		{
			$this->show_week = true;
			$this->cur_sign  = $this->signs[ $this->sign ];
			$this->data      = $this->data->{$this->cur_sign['name']};
		}
	}
	
	
	function getDay($k = 0)
	{
		return $this->today + ($k - 1) * 24 * 3600;
	}
}

$horo = new Horos();

include ( "./defaults.php" );

$title_horo="Гороскоп";
$incomingline_firm = $title_horo;
$incomingline = "<a href=\"index.php\"><font color=\"$def_status_font_color\"><u>$def_catalogue</u></font></a> | <font color=\"$def_status_font_color\">$title_horo</font>";
$help_section = "$horo_help";
	
include ( "./template/$def_template/header.php" );

if ($horo->show_week) : ?>

<table>	
	<tr>
		<td>
			<img src="images/horo/<?php echo $horo->sign; ?>.png" 
				alt="<?php echo $horo->cur_sign['title']; ?>" hspace="2" vspace="2" align="left"><font size="+1" color=red><b><?php echo $horo->cur_sign['title']; ?></b></font><br>
			<?php 
			if ($horo->type == $horo->week['prev']['type']) 
			{
				echo '<a href="?type='.$horo->week['this']['type']
					.'&sign='.$horo->sign.'">смотреть на текущую неделю</a>';
			}
			else
			{
				echo '<a href="?type='.$horo->week['prev']['type']
					.'&sign='.$horo->sign.'">смотреть на предыдущую неделю</a>';
			}
			?>
		</td>
	</tr>	
	<tr>
		<td><br></td>
	</tr>	
	<?php foreach ($horo->week_types as $k => $v) : ?>	
	<tr>
		<td>
			<b><?php echo $v; ?></b><br>
			<div><?php echo $horo->data->$k; ?></div>
		</td>
	</tr>	
	<tr>
		<td><br></td>
	</tr>	
	<?php endforeach; ?>
</table>		

<?php else : ?>



<style type="text/css">
<!--
.menu td {
	border-left: 1px solid black;
	padding: 1px 10px;
	text-align: center;
}

.menu {
	margin: auto;
}

#dateList td {
	visibility: hidden;
	border: none;
}

#dayl_1, #dayList span, .text_0, .text_2, .text_3 {
	display: none;
}

.text_1 {
	display: block;
}
-->
</style>
<table class="menu">
	<tr>
<?php
foreach ($horo->list as $k => $v)
{
	echo ($k == 0 ? '<td style="border-left: none">' : '<td>')
		.($horo->type == $k 
			? $v['name'] 
			: '<a href="?type='.$k.'" title="'.$v['name'].' гороскоп">'.$v['name'].'</a>')
		.'</td>';
}
?>		
	</tr>
</table>
<script type="text/javascript">
<!--
function chDay(num)
{
	var elms, see;
	
	for (i = 0; i <= 3; i++)
	{
		if (i == num)
		{	
			$('#dayl_' + i).css('display', 'none');
			$('#date_' + i).css('visibility', 'visible');
			see = 'block';
		}
		else
		{
			
			$('#dayl_' + i).css('display', 'block');
			$('#date_' + i).css('visibility', 'hidden');
			see = 'none';
		}
		
		$('#day_'  + i).css('display', see);
		
		$('#text_list div').each(function(j, elm) {
			if ($(elm).hasClass('text_' + i))
			{
				$(elm).css('display', see);
			}	
		});
	}
}
//-->
</script>
<table class="menu" id="dayList">
	<tr>
		<td style="border-left: none">
			<a id="dayl_0" href="javascript:chDay(0)" title="">Вчера</a>
			<span id="day_0">Вчера</span>
		</td>
		<td>
			<a id="dayl_1" href="javascript:chDay(1)" title="">Сегодня</a>
			<span id="day_1" style="display: block">Сегодня</span>
		</td>
		<td>
			<a id="dayl_2" href="javascript:chDay(2)" title="">Завтра</a>
			<span id="day_2">Завтра</span>
		</td>
		<td>
			<a id="dayl_3" href="javascript:chDay(3)" title="">Послезавтра</a>
			<span id="day_3">Послезавтра</span>
		</td>
	</tr>
	<tr id="dateList">
		<td id="date_0">
			<?php echo date('d.m', $horo->getDay(0)); ?>
		</td>
		<td id="date_1" style="visibility: visible">
			<?php echo date('d.m', $horo->getDay(1)); ?>
		</td>
		<td id="date_2">
			<?php echo date('d.m', $horo->getDay(2)); ?>
		</td>
		<td id="date_3">
			<?php echo date('d.m', $horo->getDay(3)); ?>
		</td>
	</tr>	
</table>		
<table id="text_list">	
	<?php foreach ($horo->signs as $k => $v) : ?>	
	<tr>
		<td>
			<img src="images/horo/<?php echo $k; ?>.png" alt="<?php echo $v['title']; ?>" hspace="2" vspace="2" align="left"><font size="+1"><b><?php echo $v['title']; ?></b></font><br>
			<a href="?type=<?php echo $horo->week['this']['type']; ?>&sign=<?php echo $k; ?>">
				смотреть на текущую неделю</a>
			<div class="text_0"><?php echo $horo->data->$v['name']->yesterday; ?></div>
			<div class="text_1"><?php echo $horo->data->$v['name']->today; ?></div>
			<div class="text_2"><?php echo $horo->data->$v['name']->tomorrow; ?></div>
			<div class="text_3"><?php echo $horo->data->$v['name']->tomorrow02; ?></div>
		</td>
	</tr>	
	<tr>
		<td><br></td>
	</tr>	
	<?php endforeach; ?>
</table>

<br><br><div align="right"><a href="http://ignio.com" target="_blank">www.ignio.com</a></div>
	
<?php endif; 
include ( "./template/$def_template/footer.php" ); ?>