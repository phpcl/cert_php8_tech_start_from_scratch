<?php
namespace Phpcl\Image;
use Phpcl\Image\Strategy\ {PlainText,PlainFill};
#[description("Creates a single image, by default black on white")]
class SingleChar extends Base
{
    const MARGIN     = 3;
    const DEFAULT_TX_X = 25;
    const DEFAULT_TX_Y = 75;
    const DEFAULT_TX_SIZE  = 60;
    const DEFAULT_TX_ANGLE = 0;
    const DEFAULT_WIDTH = 100;
    const DEFAULT_HEIGHT = 100;
    #[description("Builds an image based on config specs")]
    #[
        string("text"),
        string("fontFile"),
        int("width"),
        int("height"),
        int("size"),
        float("angle"),
        int("textX"),
        int("textY")
    ]
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
    #[description("Fills image background")]
    #[description("see: https://www.php.net/manual/en/function.imagettftext.php")]
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width, $this->height, $this->fgColor);
        PlainFill::writeFill($this, 1, 1, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
    }
    #[description("Writes text onto image")]
    #[description("See: https://www.php.net/manual/en/function.imagettftext.php")]
    #[string("text")]
    public function writeText()
    {
        return PlainText::writeText(
                $this, $this->size, $this->angle, $this->textX,
                $this->textY, $this->fgColor, $this->fontFile, $this->text);
    }
}
