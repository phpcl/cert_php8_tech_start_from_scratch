<?php
namespace Phpcl\Image\Strategy;
use Phpcl\Image\ImageInterface;
#[description("Draws a face")]
class Face
{
    const SIZE_FACE  = 0.90;    // 90% of X
    const SIZE_EYES  = 0.20;    // 20% of X
    const SIZE_NOSE  = 0.10;    // 10% of X
    const SIZE_SMILE = 0.50;    // 50% of X
    #[description("Draws a face onto canvas")]
    #[ImageInterface("blank box : passed by reference")]
    #[string("smile : smile|frown|neutral")]
    #[int("color")]
    #[returns("void")]
    public static function write(ImageInterface $canvas, string $smile, int $color) : void
    {
        $img = $canvas->image;
        $x = imagesx($img);
        $y = imagesy($img);
        $centerX = (int) ($x / 2);
        $centerY = (int) ($y / 2);
        $face = [
            'face' => [
                // center of the image
                'x' => $centerX,
                'y' => $centerY,
                // minus the margin
                'w' => (int) ($x * self::SIZE_FACE),
                'h' => (int) ($y * self::SIZE_FACE),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'eye_left' => [
                // 33% down 33% in
                'x' => (int) ($x * 0.33),
                'y' => (int) ($y * 0.33),
                'w' => (int) ($x * self::SIZE_EYES),
                'h' => (int) ($y * self::SIZE_EYES),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            // 33% down 66% in
            'eye_right' => [
                'x' => (int) ($x * 0.66),
                'y' => (int) ($y * 0.33),
                'w' => (int) ($x * self::SIZE_EYES),
                'h' => (int) ($y * self::SIZE_EYES),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'nose' => [
                // 50% down, 50% in
                'x' => $centerX,
                'y' => $centerY,
                'w' => (int) ($x * self::SIZE_NOSE),
                'h' => (int) ($y * self::SIZE_NOSE),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'mouth' => [
                // 66% down, 50% in
                'x' => (int) $centerX,
                'y' => (int) ($y * 0.66),
                'w' => (int) ($x * self::SIZE_SMILE),
                'h' => (int) ($x * self::SIZE_SMILE * 0.5),
            ],
        ];
        $start_end = match ($smile) {
            'smile' => ['s' => 20, 'e' => 160],
            'frown' => ['y' => (int) ($y * 0.75), 's' => 205, 'e' => 350],
            default => ['y' => (int) ($y * 0.70), 'h' => 1, 's' => 0, 'e' => 0],
        };
        $face['mouth'] = array_merge($face['mouth'], $start_end);
        foreach ($face as $key => $p)
            // draw arcs into canvas
            \imagearc($img, $p['x'], $p['y'], $p['w'], $p['h'], $p['s'], $p['e'], $color);
    }
}
