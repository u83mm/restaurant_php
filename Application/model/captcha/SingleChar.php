<?php
declare(strict_types=1);

namespace model\captcha;

use Attribute;
use model\captcha\Strategy\ {PlainText,PlainFill};

#[SingleChar]

class SingleChar
{
    const MARGIN     = 3;
    const DEFAULT_FG = [0x00, 0x00, 0x00];
    const DEFAULT_BG = [0xFF, 0xFF, 0xFF];
    const DEFAULT_TX_X = 25;
    const DEFAULT_TX_Y = 75;
    const DEFAULT_TX_SIZE  = 60;
    const DEFAULT_TX_ANGLE = 0;
    const DEFAULT_WIDTH = 100;
    const DEFAULT_HEIGHT = 100;
    public $image    = NULL;
    public $fgColor  = NULL;
    public $bgColor  = NULL;

   
    public function __construct(
        public string $text,
        public string $fontFile,
        public int    $width    = self::DEFAULT_WIDTH,
        public int    $height   = self::DEFAULT_HEIGHT,
        public int    $size     = self::DEFAULT_TX_SIZE,
        public float  $angle    = self::DEFAULT_TX_ANGLE,
        public int    $textX    = self::DEFAULT_TX_X,
        public int    $textY    = self::DEFAULT_TX_Y)
    {
        $this->image    = \imagecreate($width, $height);
        $this->fgColor  = $this->colorAlloc(self::DEFAULT_FG);
        $this->bgColor  = $this->colorAlloc(self::DEFAULT_BG);
    }

    
    public function colorAlloc(int|array $r, int $g = 0, int $b = 0)
    {
        if (is_array($r)) {
                [$r, $g, $b] = $r;
        }
        return \imagecolorallocate($this->image, $r, $g, $b);
    }

    
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->fgColor);
        PlainFill::writeFill($this, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
    }

    
    public function writeText()
    {
        return PlainText::writeText(
                $this, $this->size, $this->angle, $this->textX,
                $this->textY, $this->fgColor, $this->fontFile, $this->text);
    }
    
    
    public function save(string $fn)
    {
        return \imagepng($this->image, $fn);
    }
}
