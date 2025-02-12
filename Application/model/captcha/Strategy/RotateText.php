<?php
namespace Application\model\captcha\Strategy;

use Application\model\captcha\SingleChar;


class RotateText
{
	const ADJ_FACTOR =  20;
	
	public static function writeText(SingleChar $char, float $angle = NULL) : void
	{
		$char->angle = rand(-20, 20);
		$char->angle = ($char->angle < 0) ? $char->angle + 360 : $char->angle;
	}
	
	public static function calcXYadjust(SingleChar $char, float $offset) : array
	{
		$x_factor = $char->width / self::ADJ_FACTOR;
		$y_factor = $char->height / self::ADJ_FACTOR;
		$x = $char->textX;
		$y = $char->textY;
		if ($offset > 0) {
			// tilts left
			$y += (int) ($offset / $y_factor);
			$x += (int) ($offset / $x_factor) * 3;
		} else {
			// tilts right
			$y += (int) ($offset / $y_factor) * 3;
			$x += (int) ($offset / $x_factor);
		}
		return [$x, $y];
	}
}
