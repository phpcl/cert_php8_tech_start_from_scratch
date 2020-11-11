<?php
namespace Phpcl\Image\Strategy;
use Imagick;
#[description("Writes an array of files into single GIF")]
class Animate
{
    #[description("Writes image files into single GIF")]
    #[array("image filenames")]
    #[string("target filename: must be GIF")]
    #[returns("bool: TRUE if operation succeeded; FALSE otherwise")]
    public static function writeGif(array $files, string $dest) : bool
    {
        $gif = new Imagick();
        foreach( $files as $fn)
        {
            $magick = new Imagick();
            $magick->readImage($fn);
            $gif->addImage($magick);
        }
        return $gif->writeImages($dest, TRUE);
    }
}
