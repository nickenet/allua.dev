<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D.Madi & Ilya.K
=====================================================
 Файл: review.php
-----------------------------------------------------
 Назначение: Управление авторизацией
=====================================================
*/

require_once 'includes/loginza/API.class.php';
require_once 'includes/loginza/UserProfile.class.php';

$LoginzaAPI = new LoginzaAPI();

if (!empty($_POST['token']))
{
	$UserProfile = $LoginzaAPI->getAuthInfo($_POST['token']);

	if (!empty($UserProfile->error_type))
	{
		#echo $UserProfile->error_type . ": " . $UserProfile->error_message;
	}
	elseif (empty($UserProfile))
	{
		echo 'Temporary auth error.';
	}
	else
	{
		// запоминаем профиль пользователя в сессию
		$_SESSION['loginza']['is_auth'] = 1;
		$_SESSION['loginza']['profile'] = $UserProfile;
	}
}
elseif (isset($_REQUEST['loginza_quit']))
{
	unset($_SESSION['loginza']);
}

if (!empty($_SESSION['loginza']['is_auth']))
{
	$LoginzaProfile = new LoginzaUserProfile($_SESSION['loginza']['profile']);

	$userName = $LoginzaProfile->genDisplayName();
	$userName = iconv('utf-8', 'windows-1251', $userName);

	/* данныe полученныe через LoginzaUserProfile
	echo "Ник: " . $LoginzaProfile->genNickname() . "<br/>";
	echo "Отображать как: " . $LoginzaProfile->genDisplayName() . "<br/>";
	echo "Полное имя: " . $LoginzaProfile->genFullName() . "<br/>";
	echo "Сайт: " . $LoginzaProfile->genUserSite() . "<br/>";
	*/
	if (!empty($_SESSION['loginza']['profile']->photo))
	{
		$avatar = $_SESSION['loginza']['profile']->photo;
	}
}

?>