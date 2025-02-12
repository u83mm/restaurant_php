<?php
namespace Application\model\captcha\Strategy;

use Application\model\captcha\SingleChar;

class PlainText
{
	
	public static function writeText(
		SingleChar $char,
		float $size,
		float $angle,
		int $x,
		int $y,
		int $color,
		string $fontFile,
		string $text) : array
	{
		return \imagettftext($char->image, $size, $angle, $x, $y, $color, $fontFile , $text); 
	}
}
