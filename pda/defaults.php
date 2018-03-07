<?php

/*
=====================================================
 Created by D.Madi
-----------------------------------------------------
 Внедрение и модификация I-Soft
=====================================================
 Назначение: Подключение файлов
=====================================================
*/

session_start();

@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

if ($_SESSION['no_mobile']=='YES') unset($_SESSION['no_mobile']);

define ( 'ISB', true );
$url_full_version = 'index.php?mobile=no';

srand ((double) microtime() * 10000000);

if (!isset($_GET[page])) $_GET[page] = "0";
if ($_GET[page] == "") $_GET[page] = "0";

if (isset($_REQUEST['page'])) $kPage = intval($_GET[page]);
if (isset($_REQUEST['category']))    { $categorymains = intval($_GET['category']); $cat = intval($_GET['category']); }
if (isset($_REQUEST['cat']))    $cat = intval($_GET['cat']); 
if (isset($_REQUEST['subcat']))    $subcat = intval($_GET['subcat']); 
if (isset($_REQUEST['subsubcat']))    $subsubcat = intval($_GET['subsubcat']);
if (isset($_REQUEST['id']))    $id = intval($_GET['id']);

// Including configuration file
include ( ".././conf/config.php" );

 // URL путь до скрипта
 $def_mainlocation_pda = $def_mainlocation.'/'.$def_pda;

// Including configuration file
include ( "./conf/config.php" );

// Including memberships
include ( ".././conf/memberships.php" );

// Including functions
include ( ".././includes/functions.php" );

// Including mysql class
include ( ".././includes/$def_dbtype.php" );

// Connecting to the database
include ( ".././connect.php" );

// Including functions
include ( ".././includes/sqlfunctions.php" );

$lang = $def_language;

// Including language pack
include ( "../lang/language.$lang.php" );

if ($_GET['city']=='del') { unset($_SESSION[where_city], $_SESSION[smycityloc], $_SESSION['smycity']); }

if (isset ($_REQUEST['Smycity'])) {

    if ($def_country_allow=='NO') {

         if (empty($_SESSION['smycity']) or ($_SESSION['smycity']=='') or (safeHTML($_REQUEST['Smycity'])!=$_SESSION['smycity'])) $kPage=0;

         $rct = $db->query  ( "SELECT location, locationselector  FROM $db_location" );
         $results_city = mysql_num_rows ( $rct );
                $_SESSION[smycity]='';
                for ( $ijc=0; $ijc < $results_city; $ijc++ ) {
                    $def_city_all =  $db->fetcharray( $rct );
                    if ($def_city_all['location']==safeHTML($_REQUEST['Smycity'])) { $_SESSION[smycityloc]=$def_city_all['locationselector']; $_SESSION[smycity]=safeHTML($_REQUEST['Smycity']); }
                }
    }

    else { if (empty($_SESSION['smycity']) or ($_SESSION['smycity']=='') or (safeHTML($_REQUEST['Smycity'])!=$_SESSION['smycity'])) { $_SESSION[smycity] = safeHTML($_REQUEST['Smycity']); $kPage=0; } else $_SESSION['smycity'] = safeHTML($_REQUEST['Smycity']); }
}

if (isset($_SESSION['smycity']) and $_SESSION['smycity']!='') {

    if ($def_country_allow=='NO') $_SESSION['where_city']=" and location='$_SESSION[smycityloc]' "; else $_SESSION[where_city]=" and city='$_SESSION[smycity]' ";

} else unset($_SESSION['where_city'], $_SESSION['smycityloc'], $_SESSION['smycity']);

$results_amount_city=0;

if (isset ($_REQUEST['Smycity']) and isset($_SESSION['where_city'])) {

    $r_count_city = $db->query ( "SELECT COUNT(*) FROM $db_users WHERE firmstate = 'on' $_SESSION[where_city] " );

    $results_amount_city=mysql_result ( $r_count_city,0,0 );

    if ($results_amount_city==0) { unset($_SESSION['where_city'], $_SESSION['smycityloc'], $_SESSION['smycity']); $class_alert="alert alert-error"; $alert_info = $def_nothing_found_cyti2; }
    else { $class_alert="alert alert-info"; $alert_info = $def_nothing_found_cyti4.$results_amount_city.'. <a href="'.$def_mainlocation_pda.'/company_city.php">'.$def_nothing_found_cyti5.'</a>'; }

}

?>