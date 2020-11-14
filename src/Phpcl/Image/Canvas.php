<?php
namespace Phpcl\Image;
use Phpcl\Image\Strategy\PlainFill;
#[description("Creates a single image with a white background (by default)")]
class Canvas extends Base
{
    const ERR_COLOR      = 'SORRY! Colors can be three numbers between 0 and 255 only.';
    const DEFAULT_WIDTH  = 100;
    const DEFAULT_HEIGHT = 100;
    const DEFAULT_MARGIN = 0.1;
    const DEFAULT_FG     = [0x00, 0x00, 0x00];
    const DEFAULT_BG     = [0xFF, 0xFF, 0xFF];
    #[description("Builds an image based on config specs")]
    #[
        int("width"),
        int("height")
    ]
    public function __construct(
        public int $width  = self::DEFAULT_WIDTH,
        public int $height = self::DEFAULT_HEIGHT)
    {
        $this->image    = \imagecreate($width, $height);
        $this->fgColor  = $this->colorAlloc(self::DEFAULT_FG);
        $this->bgColor  = $this->colorAlloc(self::DEFAULT_BG);
        $this->writeFill();
    }
    #[description("Fills image background")]
    #[description("see: https://www.php.net/manual/en/function.imagettftext.php")]
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->bgColor);
    }
}
