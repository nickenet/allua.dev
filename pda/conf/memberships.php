<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: memberships.php
-----------------------------------------------------
 Назначение: Настройка тарифных планов
=====================================================
*/


 // Метод оплаты перевода аккаунта на платный тарифный план
 // 5 - форма заявки

 $def_gateway = "5";

 // За сколько дней сообщать клиенту об окончании пребывания
 // в платном тарифном плане на е-майл
 $def_paypal_expiration_warning = "5";

 // Использовать платную регистрацию
 // НЕ ВКЛЮЧАТЬ!!!
 $def_onlypaid = "NO";  // YES or NO (upper case, please)


 /*

 Настройки тарифных планов
 D - бесплатный тариф
 C,B,A - платные тарифы

 Используйте только заглавные буквы - YES

 Перед редактированием тарифных планов, рекомендуем ознакомиться
 с документацией по настройке тарифных планов

 */

 // ********************************************************
 // D - бесплатный

 // Использовать в системе данный тариф
 $def_D_enable = "YES"; // YES or NO (upper case, please)

 // Название тарифного плана
 $def_D = "Бесплатный";

 // Стоимость нахождения в тарифе
 $def_D_price = "Бесплатно";

 // Период пребывания в тарифе - в днях
 $def_D_expiration = "всегда"; // Days, "0" - Never Expire

 // Показывать описание компании
 $def_D_description = "YES"; // YES or NO (upper case, please)

 // Показывать почтовый адрес
 $def_D_address = "YES"; // YES or NO (upper case, please)

 // Показывать индекс
 $def_D_zip = "YES"; // YES or NO (upper case, please)

 // Показывать телефон
 $def_D_phone = "YES"; // YES or NO (upper case, please)

 // Показывать факс
 $def_D_fax = "YES"; // YES or NO (upper case, please)

 // Показывать мобильный телефон
 $def_D_mobile = "YES"; // YES or NO (upper case, please)

 // Показывать номер ICQ
 $def_D_icq = "YES"; // YES or NO (upper case, please)

 // Показывать контактное лицо
 $def_D_manager = "YES"; // YES or NO (upper case, please)

 // Разрешить использование e-mail формы
 $def_D_email = "YES"; // YES or NO (upper case, please)

 // Показывать официальный сайт компании WWW
 $def_D_www = "YES"; // YES or NO (upper case, please)

 // Показывать карту
 $def_D_map = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку логотипа
 $def_D_logo = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку графической схемы проезда
 $def_D_sxema = "YES"; // YES or NO (upper case, please)

 // Показывать положение фирмы на карте
 $def_D_maps = "YES"; // YES or NO (upper case, please)

 // Разрешить добавление филиалов
 $def_D_filial = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку большого верхнего баннера TOP
 $def_D_banner = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку маленьких боковых баннеров
 $def_D_banner2 = "YES"; // YES or NO (upper case, please)

 // Разрешить одобрение/удаление комментариев
 $def_D_review = "YES"; // YES or NO (upper case, please)

 // Использовать расширенную статистику
 $def_D_stat = "YES"; // YES or NO (upper case, please)

 // Разрешить продукцию
 $def_D_products = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать продукции или услуг
 $def_D_setproducts = "20";

 // Разрешить загрузку картинок к продукции и услугам
 $def_D_offerIM = "YES"; // YES or NO (upper case, please)

 // Разрешить показ картинок к продукции и услугам
 $def_D_offer_thumbnail = "YES"; // YES or NO (upper case, please)

 // Разрешить использовать галерею изображений
 $def_D_images = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать в галерею изображений
 $def_D_setimages = "20";

 // Разрешить использовать прайсы
 $def_D_exel = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать прайсов
 $def_D_setexel = "20";

 // Разрешить использовать видеоролики
 $def_D_video = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать видеороликов
 $def_D_setvideo = "2";

 // Разрешить использовать информационный блок
 $def_D_infoblock = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать публикаций
 $def_D_setinfo = "2";

 // Разрешить использование в каталоге подключение социальной странички
 $def_D_social = "YES"; // YES or NO (upper case, please)

 // use new tarif D

 // ********************************************************
 // C - платный тарифный план

 // Использовать в системе данный тариф
 $def_C_enable = "YES"; // YES or NO (upper case, please)

 // Название тарифного плана
 $def_C = "Старт";

 // Стоимость нахождения в тарифе
 $def_C_price = "200";

 // Период пребывания в тарифе - в днях
 $def_C_expiration = "0"; // Days, "0" - Never Expire

 // Показывать описание компании
 $def_C_description = "YES"; // YES or NO (upper case, please)

 // Показывать почтовый адрес
 $def_C_address = "YES"; // YES or NO (upper case, please)

 // Показывать индекс
 $def_C_zip = "YES"; // YES or NO (upper case, please)

 // Показывать телефон
 $def_C_phone = "YES"; // YES or NO (upper case, please)

 // Показывать факс
 $def_C_fax = "YES"; // YES or NO (upper case, please)

 // Показывать мобильный телефон
 $def_C_mobile = "YES"; // YES or NO (upper case, please)

 // Показывать номер ICQ
 $def_C_icq = "YES"; // YES or NO (upper case, please)

 // Показывать контактное лицо
 $def_C_manager = "YES"; // YES or NO (upper case, please)

 // Разрешить использование e-mail формы
 $def_C_email = "YES"; // YES or NO (upper case, please)

 // Показывать официальный сайт компании WWW
 $def_C_www = "YES"; // YES or NO (upper case, please)

 // Показывать карту
 $def_C_map = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку логотипа
 $def_C_logo = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку графической схемы проезда
 $def_C_sxema = "YES"; // YES or NO (upper case, please)

 // Показывать положение фирмы на карте
 $def_C_maps = "YES"; // YES or NO (upper case, please)

 // Разрешить добавление филиалов
 $def_C_filial = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку большого верхнего баннера TOP
 $def_C_banner = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку маленьких боковых баннеров
 $def_C_banner2 = "YES"; // YES or NO (upper case, please)

 // Разрешить одобрение/удаление комментариев
 $def_C_review = "YES"; // YES or NO (upper case, please)

 // Использовать расширенную статистику
 $def_C_stat = "YES"; // YES or NO (upper case, please)

 // Разрешить продукцию
 $def_C_products = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать продукции или услуг
 $def_C_setproducts = "10";

 // Разрешить загрузку картинок к продукции и услугам
 $def_C_offerIM = "YES"; // YES or NO (upper case, please)

 // Разрешить показ картинок к продукции и услугам
 $def_C_offer_thumbnail = "YES"; // YES or NO (upper case, please)

 // Разрешить использовать галерею изображений
 $def_C_images = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать в галерею изображений
 $def_C_setimages = "10";

 // Разрешить использовать прайсы
 $def_C_exel = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать прайсов
 $def_C_setexel = "10";

 // Разрешить использовать видеоролики
 $def_C_video = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать видеороликов
 $def_C_setvideo = "7";

 // Разрешить использовать информационный блок
 $def_C_infoblock = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать публикаций
 $def_C_setinfo = "15";

 // Разрешить использование в каталоге подключение социальной странички
 $def_C_social = "YES"; // YES or NO (upper case, please)

 // use new tarif C

 // ********************************************************
 // B - платный тарифный план

 // Использовать в системе данный тариф
 $def_B_enable = "YES"; // YES or NO (upper case, please)

 // Название тарифного плана
 $def_B = "Бизнес";

 // Стоимость нахождения в тарифе
 $def_B_price = "300";

 // Период пребывания в тарифе - в днях
 $def_B_expiration = "0"; // Days, "0" - Never Expire

 // Показывать описание компании
 $def_B_description = "YES"; // YES or NO (upper case, please)

 // Показывать почтовый адрес
 $def_B_address = "YES"; // YES or NO (upper case, please)

 // Показывать индекс
 $def_B_zip = "YES"; // YES or NO (upper case, please)

 // Показывать телефон
 $def_B_phone = "YES"; // YES or NO (upper case, please)

 // Показывать факс
 $def_B_fax = "YES"; // YES or NO (upper case, please)

 // Показывать мобильный телефон
 $def_B_mobile = "YES"; // YES or NO (upper case, please)

 // Показывать номер ICQ
 $def_B_icq = "YES"; // YES or NO (upper case, please)

 // Показывать контактное лицо
 $def_B_manager = "YES"; // YES or NO (upper case, please)

 // Разрешить использование e-mail формы
 $def_B_email = "YES"; // YES or NO (upper case, please)

 // Показывать официальный сайт компании WWW
 $def_B_www = "YES"; // YES or NO (upper case, please)

 // Показывать карту
 $def_B_map = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку логотипа
 $def_B_logo = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку графической схемы проезда
 $def_B_sxema = "YES"; // YES or NO (upper case, please)

 // Показывать положение фирмы на карте
 $def_B_maps = "YES"; // YES or NO (upper case, please)

 // Разрешить добавление филиалов
 $def_B_filial = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку большого верхнего баннера TOP
 $def_B_banner = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку маленьких боковых баннеров
 $def_B_banner2 = "YES"; // YES or NO (upper case, please)

 // Разрешить одобрение/удаление комментариев
 $def_B_review = "YES"; // YES or NO (upper case, please)

 // Использовать расширенную статистику
 $def_B_stat = "YES"; // YES or NO (upper case, please)

 // Разрешить продукцию
 $def_B_products = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать продукции или услуг
 $def_B_setproducts = "50";

 // Разрешить загрузку картинок к продукции и услугам
 $def_B_offerIM = "YES"; // YES or NO (upper case, please)

 // Разрешить показ картинок к продукции и услугам
 $def_B_offer_thumbnail = "YES"; // YES or NO (upper case, please)

 // Разрешить использовать галерею изображений
 $def_B_images = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать в галерею изображений
 $def_B_setimages = "50";

 // Разрешить использовать прайсы
 $def_B_exel = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать прайсов
 $def_B_setexel = "20";

 // Разрешить использовать видеоролики
 $def_B_video = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать видеороликов
 $def_B_setvideo = "10";

 // Разрешить использовать информационный блок
 $def_B_infoblock = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать публикаций
 $def_B_setinfo = "30";

 // Разрешить использование в каталоге подключение социальной странички
 $def_B_social = "YES"; // YES or NO (upper case, please)

 // use new tarif B

 // ********************************************************
 // A - платный тарифный план

 // Использовать в системе данный тариф
 $def_A_enable = "YES"; // YES or NO (upper case, please)

 // Название тарифного плана
 $def_A = "Премиум";

 // Стоимость нахождения в тарифе
 $def_A_price = "500";

 // Период пребывания в тарифе - в днях
 $def_A_expiration = "0"; // Days, "0" - Never Expire

 // Показывать описание компании
 $def_A_description = "YES"; // YES or NO (upper case, please)

 // Показывать почтовый адрес
 $def_A_address = "YES"; // YES or NO (upper case, please)

 // Показывать индекс
 $def_A_zip = "YES"; // YES or NO (upper case, please)

 // Показывать телефон
 $def_A_phone = "YES"; // YES or NO (upper case, please)

 // Показывать факс
 $def_A_fax = "YES"; // YES or NO (upper case, please)

 // Показывать мобильный телефон
 $def_A_mobile = "YES"; // YES or NO (upper case, please)

 // Показывать номер ICQ
 $def_A_icq = "YES"; // YES or NO (upper case, please)

 // Показывать контактное лицо
 $def_A_manager = "YES"; // YES or NO (upper case, please)

 // Разрешить использование e-mail формы
 $def_A_email = "YES"; // YES or NO (upper case, please)

 // Показывать официальный сайт компании WWW
 $def_A_www = "YES"; // YES or NO (upper case, please)

 // Показывать карту
 $def_A_map = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку логотипа
 $def_A_logo = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку графической схемы проезда
 $def_A_sxema = "YES"; // YES or NO (upper case, please)

 // Показывать положение фирмы на карте
 $def_A_maps = "YES"; // YES or NO (upper case, please)

 // Разрешить добавление филиалов
 $def_A_filial = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку большого верхнего баннера TOP
 $def_A_banner = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку маленьких боковых баннеров
 $def_A_banner2 = "YES"; // YES or NO (upper case, please)

 // Разрешить продукцию
 $def_A_products = "YES"; // YES or NO (upper case, please)

 // Разрешить загрузку картинок к продукции и услугам
 $def_A_offerIM = "YES"; // YES or NO (upper case, please)

 // Разрешить одобрение/удаление комментариев
 $def_A_review = "YES"; // YES or NO (upper case, please)

 // Использовать расширенную статистику
 $def_A_stat = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать продукции или услуг
 $def_A_setproducts = "100";

 // Разрешить показ картинок к продукции и услугам
 $def_A_offer_thumbnail = "YES"; // YES or NO (upper case, please)

 // Разрешить использовать галерею изображений
 $def_A_images = "YES"; // YES or NO (upper case, please)

  // Сколько можно загружать в галерею изображений
 $def_A_setimages = "100";

 // Разрешить использовать прайсы
 $def_A_exel = "YES"; // YES or NO (upper case, please)

 // Сколько можно загружать прайсов
 $def_A_setexel = "50";

 // Разрешить использовать видеоролики
 $def_A_video = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать видеороликов
 $def_A_setvideo = "15";

 // Разрешить использовать информационный блок
 $def_A_infoblock = "YES"; // YES or NO (upper case, please)

 // Сколько можно использовать публикаций
 $def_A_setinfo = "50";

 // Разрешить использование в каталоге подключение социальной странички
 $def_A_social = "YES"; // YES or NO (upper case, please)

 // use new tarif A

?>