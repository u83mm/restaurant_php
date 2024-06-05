<?php
namespace model\captcha\Strategy;

use model\captcha\SingleChar;


class Shadow
{
	
	public static function writeText(SingleChar $char, int $offset, int|array $red = 0xCC, int $green = 0xCC, int $blue  = 0xCC) : array
	{
		$x = $char->textX + $offset;
		$y = $char->textY + $offset;

		if (is_array($red)) [$red, $green, $blue] = $red;

		$color = $char->colorAlloc($red, $green, $blue);
				
		return \imagettftext($char->image, $char->size, $char->angle, $x, $y, $color, $char->fontFile , $char->text); 
	}
}
