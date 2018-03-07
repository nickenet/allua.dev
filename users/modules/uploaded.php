<?php

/*
=====================================================
 I-Soft Bizness - внедрение и модификация I-Soft
-----------------------------------------------------
 http://vkaragande.info/
-----------------------------------------------------
 Created by D. Madi
=====================================================
 Файл: uploader.php
-----------------------------------------------------
 Назначение: Обновление или загрузка графики
=====================================================
*/

if( ! defined( 'ISB' )) {
	die( "Hacking attempt!" );
}

			if ( $_POST["do"] == "uploaded" )

			{

				if ( $_POST["mode"] == "logo" )

				{

					$picdir = "logo";

				}

				if ( $_POST["mode"] == "sxema" )

				{

					$picdir = "sxema";

				}


				if ( $_POST["mode"] == "banner" )

				{

					$picdir = "banner";

				}

				if ( $_POST["mode"] == "banner2" )

				{

					$picdir = "banner2";

				}

				if ( $_POST[Submit] == "$def_upload")

				{

					if ( $_FILES['img1']['tmp_name'] )

					{

						chmod ( $_FILES['img1']['tmp_name'], 0755 ) or $uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";
						$size = Getimagesize ( $_FILES['img1']['tmp_name'] );
						$filesize = filesize ( $_FILES['img1']['tmp_name'] );

						if ( $_POST["mode"] == "logo" )

						{

							$max_width_ls = $def_logo_width;

							$max_width = 10000;
							$max_height = 10000;
							$max_size = $def_logo_size;

						}

						if ( $_POST["mode"] == "sxema" )

						{

							$max_width_ls = $def_sxema_width;

							$max_width = 10000;
							$max_height = 10000;
							$max_size = $def_sxema_size;

						}

						if ( $_POST["mode"] == "banner" )

						{

							$max_width = $def_banner_width;
							$max_height = $def_banner_height;
							$max_size = $def_banner_size;

						}

						if ( $_POST["mode"] == "banner2" )

						{

							$max_width = $def_banner2_width;
							$max_height = $def_banner2_height;
							$max_size = $def_banner2_size;

						}

						if ( ( ( $size[0] <= $max_width ) and ( $size[1] <= $max_height ) and ( $filesize < $max_size ) and ( $size[2] <> 4 ) ) and ( ( $size[2] == 1 ) or ( $size[2] == 2 ) or ( $size[2] == 3 ) or ( $size[2] == 6 ) ) )

						{

							if ( $size[2]==1 ) $type = "gif";
							if ( $size[2]==2 ) $type = "jpg";
							if ( $size[2]==3 ) $type = "png";
							if ( $size[2]==6 ) $type = "bmp";

							@unlink ( ".././$picdir/$f[selector].gif" );
							@unlink ( ".././$picdir/$f[selector].bmp" );
							@unlink ( ".././$picdir/$f[selector].jpg" );
							@unlink ( ".././$picdir/$f[selector].png" );

							copy ( $_FILES['img1']['tmp_name'], ".././$picdir/$f[selector].$type" ) or $uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";

							chmod ( ".././$picdir/$f[selector].$type", 0755 ) or $uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";

							if ((( $_POST["mode"] == "logo" ) or ( $_POST["mode"] == "sxema" )) and ($size[0] > $max_width_ls))

							{
							
								switch ($type) 
								{
									case 'jpg':
									$out = 'imagejpeg';
									$q = 100;
									break;
					
									case 'png':
									$out = 'imagepng';
									$q = 0;
									break;
					
									case 'gif':
									$out = 'imagegif';
									break;

									case 'bmp':
									$out = 'imagebmp';
									break;
								}
											
								$img = imagecreatefromstring( file_get_contents('../'.$picdir.'/'.$f[selector].'.'.$type) );
								$w = imagesx($img);
								$h = imagesy($img);
								$k = $max_width_ls / $w;
								$img2 = imagecreatetruecolor($w * $k, $h * $k);
								imagecopyresampled($img2, $img, 0, 0, 0, 0, $w * $k, $h * $k, $w, $h);
								$out($img2, '../'.$picdir.'/'.$f[selector].'.'.$type, $q);
							
							}

							$uploaded = "<font color=\"red\">$def_banner_ok</font><br><span class=\"txt\"> (Размер: $size[0]x$size[1] пикселей, Тип: $type)</span><br>";

						}

						else

						{

							if ( $_POST["mode"] == "logo" ) $uploaded = "<font color=\"red\">$def_banner_error $def_logo_size Bytes</font><br>";
							if ( $_POST["mode"] == "sxema" ) $uploaded = "<font color=\"red\">$def_banner_error $def_sxema_size Bytes</font><br>";
							if ( $_POST["mode"] == "banner" ) $uploaded = "<font color=red>$def_banner_error ($def_banner_width x $def_banner_height) @ $def_banner_size Bytes</font><br>";
							if ( $_POST["mode"] == "banner2" ) $uploaded = "<font color=red>$def_banner_error ($def_banner2_width x $def_banner2_height) @ $def_banner2_size Bytes</font><br>";

						}


					}

					else

					{

						$uploaded = "<font color=red>Файл нельзя загрузить на сервер!<br> Он превышает лимит по размеру файла принимаемым нашим сервером!<br> Оптимизируйте его.</font><br>";

					}

				}

				if ($_POST[Submit] == "$def_remove")

				{


					@unlink ( ".././$picdir/$f[selector].gif" );
					@unlink ( ".././$picdir/$f[selector].bmp" );
					@unlink ( ".././$picdir/$f[selector].jpg" );
					@unlink ( ".././$picdir/$f[selector].png" );

					$uploaded = "<font color=red>$def_image_removed</font><br>";

				}

			}

?>