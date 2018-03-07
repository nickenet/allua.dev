<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi
=====================================================
 Файл: security.php
-----------------------------------------------------
 Назначение: Секретный код
=====================================================
*/

session_start();

function security ($number)

{

	include ("./conf/config.php");

	$image = ImageCreateFromJPEG("./template/$def_template/images/security.jpg") or die ("error");

	$text_color = ImageColorAllocate($image, 20, 20, 20);

	Header("Content-Type: image/jpeg");

	if (function_exists('imagettftext'))

	Imagettftext ($image, 15, 1, 5, 17, $text_color, "./fonts/font.ttf", $number) or die ("error");

	else

	ImageString ($image, 5, 7, 2, $number, $text_color);
	ImageJPEG($image, NULL, 75);
	ImageDestroy($image);

}

$random = $_SESSION['random'];

security($random);

?>