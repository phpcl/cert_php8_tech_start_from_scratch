<?php
namespace Phpcl\Image;
use Phpcl\Image\Strategy\PlainFill;
#[description("Creates a single image with a white background (by default)")]
class Base implements ImageInterface
{
    public $image = NULL;
    #[description("Determines whether or not an image exists")]
    #[returns("bool")]
    public function hasImage() : bool
    {
        return empty($this->image);
    }
    #[description("Allocates a color resource")]
    #[param("int|array r")]
    #[int("g")]
    #[int("b")]
    #[returns("int | bool FALSE")]
    public function colorAlloc(int|array $r, int $g = 0, int $b = 0)
    {
        if (is_array($r)) {
            [$r, $g, $b] = $r;
        }
        $expected = 3;
        $actual   = 0;
        $actual += ($r >= 0 && $r <= 255);
        $actual += ($g >= 0 && $g <= 255);
        $actual += ($b >= 0 && $b <= 255);
        if ($actual !== $expected) return FALSE;
        return \imagecolorallocate($this->image, $r, $g, $b);
    }
    #[description("Renders image as PNG")]
    #[string("fn : filename where to write image")]
    #[returns("bool")]
    public function save(string $fn)
    {
        return \imagepng($this->image, $fn);
    }
}
