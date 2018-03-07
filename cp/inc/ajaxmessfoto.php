<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya.K
  =====================================================
  Файл: ajaxmessfoto.php
  -----------------------------------------------------
  Назначение: Ajax действия по изменению описания фото
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

$new_message=htmlspecialchars($_POST['value']);
$new_message = iconv('CP1251', 'UTF-8', $new_message);
$id_num=intval($_POST['id']);

$db->query  ( "UPDATE $db_foto SET message='$new_message' WHERE num='$id_num'" );

echo $new_message;

}

?>