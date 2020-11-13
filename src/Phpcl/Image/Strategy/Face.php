<?php
namespace Phpcl\Image\Strategy;
use Php8\Image\Canvas;
#[description("Draws a face")]
class Face
{
    const SIZE_FACE  = 0.90;    // 90% of X
    const SIZE_EYES  = 0.10;    // 10% of X
    const SIZE_NOSE  = 0.075;   // 7.5% of X
    const SIZE_SMILE = 0.20;    // 20% of X
    #[description("Draws a face onto canvas")]
    #[Canvas("blank box" : "passed by reference")]
    #[string("smile" : "smile|frown|neutral")]
    #[int("color")]
    #[returns("void")]
    public static function write(Canvas $canvas, string $smile, int $color) : void
    {
        $img = $canvas->image;
        $x = imagesx($img);
        $y = imagesy($img);
        $face = [
            'face' => [
                // center of the image
                'x' => (int) ($x / 2),
                'y' => (int) ($y / 2),
                // minus the margin
                'w' => (int) ($x * self::SIZE_FACE),
                'h' => (int) ($y * self::SIZE_FACE),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'eye_left' => [
                // 25% down 25% in
                'x' => (int) ($x * 0.25),
                'y' => (int) ($y * 0.25),
                'w' => (int) ($x * self::SIZE_EYES),
                'h' => (int) ($y * self::SIZE_EYES),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            // 25% down 75% in
            'eye_right' => [
                'x' => (int) ($x * 0.75),
                'y' => (int) ($y * 0.25),
                'w' => (int) ($x * self::SIZE_EYES),
                'h' => (int) ($y * self::SIZE_EYES),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'nose' => [
                // 50% down, 50% in
                'x' => (int) ($x * 0.5),
                'y' => (int) ($y * 0.5),
                'w' => (int) ($x * self::SIZE_NOSE),
                'h' => (int) ($y * self::SIZE_NOSE),
                's' => 0,   // start of arc
                'e' => 360, // end of arc
            ],
            'mouth' => [
                // 75% down, 50% in
                'x' => (int) ($x * 0.5),
                'y' => (int) ($y * 0.75),
                'w' => (int) ($x * self::SIZE_SMILE),
                'h' => (int) ($x * self::SIZE_SMILE * 0.5),
            ],
        ];
        $start_end = match ($smile) {
            'smile' => ['s' => 25, 'e' => 155],
            'frown' => ['s' => 205, 'e' => 350],
            default => ['h' => 1, 's' => 0, 'e' => 0],
        };
        $face['mouth'] = array_merge($face['mouth'], $start_end);
        foreach ($face as $key => $p)
            // draw arcs into canvas
            \imagearc($img, $p['x'], $p['y'], $p['w'], $p['h'], $p['s'], $p['e'], $color);
    }
}
