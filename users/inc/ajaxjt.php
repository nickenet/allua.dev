<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya.K
  =====================================================
  Файл: ajaxjt.php
  -----------------------------------------------------
  Назначение: Ajax действия по изменению цены
  =====================================================
 */

header("Content-type: text/plain; charset=windows-1251");

if (empty($_POST['id'])) echo die(); else {

// Including configuration file
include ( "../../conf/config.php" );

// Including mysql class
include ( "../../includes/$def_dbtype.php" );

// Connecting to the database
include ( "../../connect.php" );

// Including functions
include ( "../../includes/sqlfunctions.php" );

$new_cena=htmlspecialchars($_POST['value']);
$new_cena = iconv('CP1251', 'UTF-8', $new_cena);
$id_num=intval($_POST['id']);

$db->query  ( "UPDATE $db_offers SET price='$new_cena' WHERE num='$id_num'" );

echo $new_cena;

}

?>