<?php

/*
  =====================================================
  I-Soft Bizness - внедрение и модификация I-Soft
  -----------------------------------------------------
  http://vkaragande.info/
  -----------------------------------------------------
  Created by D. Madi & Ilya.K
  =====================================================
  Файл: ajaxjtv.php
  -----------------------------------------------------
  Назначение: Ajax действия по изменению названия ролика
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

$new_item = str_replace("\n", "<br>", $_POST['value']);
$new_item=htmlspecialchars($new_item,ENT_QUOTES,$def_charset);
$new_item = iconv('CP1251', 'UTF-8', $new_item);


$id_num=intval($_POST['id']);

$db->query  ( "UPDATE $db_video SET item='$new_item' WHERE num='$id_num'" );

echo $new_item;

}

?>