<?php
namespace Phpcl\Image;
use Phpcl\Image\Strategy\PlainFill;
#[description("Creates a single image with a white background (by default)")]
class Canvas
{
    const DEFAULT_FG     = [0x00, 0x00, 0x00];
    const DEFAULT_BG     = [0xFF, 0xFF, 0xFF];
    const DEFAULT_WIDTH  = 100;
    const DEFAULT_HEIGHT = 100;
    public $image    = NULL;
    public $bgColor  = NULL;
    #[description("Builds an image based on config specs")]
    #[
        int("width"),
        int("height")
        array("bgColor" : [R,G,B],
        array("fgColor" : [R,G,B]),
    ]
    public function __construct(
        public int    $width    = self::DEFAULT_WIDTH,
        public int    $height   = self::DEFAULT_HEIGHT,
        public array  $fgColor  = self::DEFAULT_FG,
        public array  $bgColor  = self::DEFAULT_BG)
    {
        $this->image    = \imagecreate($width, $height);
        $this->fgColor  = $this->colorAlloc($fgColor);
        $this->bgColor  = $this->colorAlloc($bgColor);
        $this->writeFill();
    }
    #[description("Allocates a color resource")]
    #[param("int|array r")]
    #[int("g")]
    #[int("b")]
    #[returns("int")]
    public function colorAlloc(int|array $r, int $g = 0, int $b = 0)
    {
        if (is_array($r)) {
                [$r, $g, $b] = $r;
        }
        return \imagecolorallocate($this->image, $r, $g, $b);
    }
    #[description("Fills image background")]
    #[description("see: https://www.php.net/manual/en/function.imagettftext.php")]
    public function writeFill()
    {
        PlainFill::writeFill($this, 0, 0, $this->width - self::MARGIN, $this->height - self::MARGIN, $this->bgColor);
    }
    #[description("Renders image as PNG")]
    #[string("fn : filename where to write image")]
    #[returns("bool")]
    public function save(string $fn)
    {
        return \imagepng($this->image, $fn);
    }
}
