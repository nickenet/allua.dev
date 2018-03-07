<?php

// Read & Save BMP files

function imagebmp(&$img, $filename = false)
{
	$wid = imagesx($img);
	$hei = imagesy($img);
	$wid_pad = str_pad('', $wid % 4, "\0");

	$size = 54 + ($wid + $wid_pad) * $hei;

	//prepare & save header
	$header['identifier'] = 'BM';
	$header['file_size'] = dword($size);
	$header['reserved'] = dword(0);
	$header['bitmap_data'] = dword(54);
	$header['header_size'] = dword(40);
	$header['width'] = dword($wid);
	$header['height'] = dword($hei);
	$header['planes'] = word(1);
	$header['bits_per_pixel'] = word(24);
	$header['compression'] = dword(0);
	$header['data_size'] = dword(0);
	$header['h_resolution'] = dword(0);
	$header['v_resolution'] = dword(0);
	$header['colors'] = dword(0);
	$header['important_colors'] = dword(0);

	if ($filename)
	{
		$f = fopen($filename, "wb");
		foreach ($header AS $h)
		{
			fwrite($f, $h);
		}

		//save pixels
		for ($y = $hei - 1; $y >= 0; $y--)
		{
			for ($x = 0; $x < $wid; $x++)
			{
				$rgb = imagecolorat($img, $x, $y);
				fwrite($f, byte3($rgb));
			}
			fwrite($f, $wid_pad);
		}
		
		fclose($f);
	}
	else
	{
		foreach ($header AS $h)
		{
			echo $h;
		}

		//save pixels
		for ($y = $hei - 1; $y >= 0; $y--)
		{
			for ($x = 0; $x < $wid; $x++)
			{
				$rgb = imagecolorat($img, $x, $y);
				echo byte3($rgb);
			}
			echo $wid_pad;
		}
	}
}

function imagecreatefrombmp($p_sFile)
{
	$file = fopen($p_sFile, "rb");
	$read = fread($file, 10);
	while (!feof($file) && ($read <> ""))
		$read .= fread($file, 1024);
	$temp = unpack("H*", $read);
	$hex = $temp[1];
	$header = substr($hex, 0, 108);
	if (substr($header, 0, 4) == "424d")
	{
		$header_parts = str_split($header, 2);
		$width = hexdec($header_parts[19] . $header_parts[18]);
		$height = hexdec($header_parts[23] . $header_parts[22]);
		unset($header_parts);
	}
	$x = 0;
	$y = 1;
	$image = imagecreatetruecolor($width, $height);
	$body = substr($hex, 108);
	$body_size = (strlen($body) / 2);
	$header_size = ($width * $height);
	$usePadding = ($body_size > ($header_size * 3) + 4);
	for ($i = 0; $i < $body_size; $i+=3)
	{
		if ($x >= $width)
		{
			if ($usePadding)
				$i += $width % 4;
			$x = 0;
			$y++;
			if ($y > $height)
				break;
		}
		$i_pos = $i * 2;
		$r = hexdec($body[$i_pos + 4] . $body[$i_pos + 5]);
		$g = hexdec($body[$i_pos + 2] . $body[$i_pos + 3]);
		$b = hexdec($body[$i_pos] . $body[$i_pos + 1]);
		$color = imagecolorallocate($image, $r, $g, $b);
		imagesetpixel($image, $x, $height - $y, $color);
		$x++;
	}
	unset($body);
	return $image;
}

function dwordize($str)
{
	$a = ord($str[0]);
	$b = ord($str[1]);
	$c = ord($str[2]);
	return $c * 256 * 256 + $b * 256 + $a;
}

function byte3($n)
{
	return chr($n & 255) . chr(($n >> 8) & 255) . chr(($n >> 16) & 255);
}

function dword($n)
{
	return pack("V", $n);
}

function word($n)
{
	return pack("v", $n);
}