<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.MAdi
=====================================================
 Файл: informer.php
-----------------------------------------------------
 Назначение: Информеры
=====================================================
*/

include './defaults.php';

header('Content-Type: text/html; charset=windows-1251');

$style_css ='
.isb_header {
	font-family: ' . (!empty($_GET['hFf']) ? $_GET['hFf'] : 'Tahoma') . ';
	font-size: ' . (!empty($_GET['hFs']) ? $_GET['hFs'] : '11px') . ';
	font-weight: ' . (!empty($_GET['hFw']) ? $_GET['hFw'] : 'bold') . ';
	color: ' . (!empty($_GET['hFc']) ? $_GET['hFc'] : '#000000') . ';
	background-color: ' . (!empty($_GET['hBg']) ? $_GET['hBg'] : '#FFCC00') . ';
	border: 1px solid ' . (!empty($_GET['hBr']) ? $_GET['hBr'] : '#999999') . ';
	-moz-border-radius: ' . (!empty($_GET['hCr']) ? $_GET['hCr'] : '4px') . ';	
	-webkit-border-radius: ' . (!empty($_GET['hCr']) ? $_GET['hCr'] : '4px') . ';	
	border-radius: ' . (!empty($_GET['hCr']) ? $_GET['hCr'] : '4px') . ';	
	width: ' . (!empty($_GET['bW']) ? $_GET['bW'] : '220px') . ';
	text-align: center;
	padding: 2px;
}

.isb_content {
	font-family: ' . (!empty($_GET['cFf']) ? $_GET['cFf'] : 'Tahoma') . ';
	font-size: ' . (!empty($_GET['cFs']) ? $_GET['cFs'] : '11px') . ';
	font-weight: ' . (!empty($_GET['cFw']) ? $_GET['cFw'] : 'bold') . ';
	color: ' . (!empty($_GET['cFc']) ? $_GET['cFc'] : '#000000') . ';
	background-color: ' . (!empty($_GET['cBg']) ? $_GET['cBg'] : '#FFFFCC') . ';
	border: 1px solid ' . (!empty($_GET['cBr']) ? $_GET['cBr'] : '#999999') . ';
	-moz-border-radius: ' . (!empty($_GET['cCr']) ? $_GET['cCr'] : '4px') . ';	
	-webkit-border-radius: ' . (!empty($_GET['cCr']) ? $_GET['cCr'] : '4px') . ';	
	border-radius: ' . (!empty($_GET['cCr']) ? $_GET['cCr'] : '4px') . ';	
	width: ' . (!empty($_GET['bW']) ? $_GET['bW'] : '220px') . ';
	padding: 2px;
	margin-top: 2px;
}
.isb_content a:active, .isb_content a:visited, .isb_content a:link {
	color: ' . (!empty($_GET['lNc']) ? $_GET['lNc'] : '#0066FF') . ';
	text-decoration: ' . (!empty($_GET['lNd']) ? $_GET['lNd'] : 'none') . ';
	font-weight: ' . (!empty($_GET['lNw']) ? $_GET['lNw'] : 'bold') . ';
}
.isb_content a:hover {
	color: ' . (!empty($_GET['lAc']) ? $_GET['lAc'] : '#FF9900') . ';
	text-decoration: ' . (!empty($_GET['lAd']) ? $_GET['lAd'] : 'underline') . ';
	font-weight: ' . (!empty($_GET['lAw']) ? $_GET['lAw'] : 'bold') . ';
}
.isb_boxdescr {
	font-family: ' . (!empty($_GET['dFf']) ? $_GET['dFf'] : 'Tahoma') . ';
	font-size: ' . (!empty($_GET['dFs']) ? $_GET['dFs'] : '10px') . ';
	font-weight: ' . (!empty($_GET['dFw']) ? $_GET['dFw'] : 'normal') . ';
	color: ' . (!empty($_GET['dFc']) ? $_GET['dFc'] : '#333333') . ';
	' . (empty($_GET['css_only']) ? '' :
	'background-color: ' . (!empty($_GET['cBg']) ? $_GET['cBg'] : '#FFFFCC') . ';'
	) . '
	padding-top: 5px;
}
.isb_sideboxtext {
	font-family: ' . (!empty($_GET['sFf']) ? $_GET['sFf'] : 'Tahoma') . ';
	font-size: ' . (!empty($_GET['sFs']) ? $_GET['sFs'] : '9px') . ';
	font-weight: ' . (!empty($_GET['sFw']) ? $_GET['sFw'] : 'normal') . ';
	color: ' . (!empty($_GET['sFc']) ? $_GET['sFc'] : '#999999') . ';
	' . (empty($_GET['css_only']) ? '' :
	'background-color: ' . (!empty($_GET['cBg']) ? $_GET['cBg'] : '#FFFFCC') . ';'
	) . '
	padding-top: 5px;
}
';
	
$typeInformer = intval($_POST['type_informer']);
$type = intval($_POST['type']);
$number = intval($_POST['number']);
$logo = intval($_POST['logo']);
$desc = intval($_POST['desc']);
$states = intval($_POST['states']);
$country = intval($_POST['country']);
$pricevid = intval($_POST['price']);
        
$url = '';
switch ($typeInformer)
{
	case 1:
		$url	= 'type=' . $type
				. '&number=' . $number
				. '&logo=' . $logo
				. '&desc=' . $desc
				. '&states=' . $states
				. '&country=' . $country;
	break;

	case 2:
		$url	= 'type=' . $type
				. '&number=' . $number
				. '&desc=' . $desc;
	break;

	case 3:
		$url	= 'type=10'
				. '&desc=' . $desc
				. '&price=' . $pricevid;
	break;

	case 4:
		$url	= 'type=' . $type;
	break;

	default:
		break;
}

if ($url)
{
	$url = '<script type="text/javascript" src="' . $def_mainlocation . '/export.php?' . $url . '"></script>';
}

if (!empty($_GET['css_only']))
{
	header('Content-Type: text/css');
	
	echo $style_css;
	
	exit;
}

$style_css = '<style type="text/css">
<!--
' . $style_css . '
-->
</style>';

if (empty($_POST['code_only'])) 
{ 
	?>
	<div style="text-align: left;">
		<br /><br />
		<b>Предварительный просмотр информера</b>
		<br /><br />

		<? 
		if ($_POST['type_informer'] < 4) 
		{
			echo $style_css;
		}

		echo $url;
		?>
	</div>
	<? 
	exit;
} 
?>

<div style="text-align: left;">
	<br /><br />
	<a href="javascript:;" onclick="trans_instrum()" id="instrum_link"><b>Показать код информера &raquo;</b></a>
	<a href="javascript:;" onclick="trans_instrum()" id="instrum_link_hide" 
	   style="display: none">Скрыть код информера</a>

	<div id="instrum_mod" style="display: none;">
		<br />
		<b>Скопируйте данный код информера и разместите его на требуемой страницe Вашего сайта:</b>
		<br /><br />
		<div style="background: #FFFFCC; border: 1px solid #999999; padding: 5px; text-align:left;">
			<? 
			if ($typeInformer < 4) 
			{
			   echo nl2br(htmlspecialchars($style_css)); 
			}
			
			echo htmlspecialchars($url);
			?>
		</div>
	</div>
</div>

