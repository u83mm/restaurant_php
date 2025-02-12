<?php
namespace Application\model\captcha\Strategy;

use Application\model\captcha\SingleChar;


class PlainFill
{	
	public static function writeFill(
		SingleChar $char,
		int $x1,
		int $y1,
		int $x2,
		int $y2,
		int $color) : bool
	{
		return \imagefilledrectangle($char->image, $x1, $y1, $x2, $y2, $color);
	}
}
?>