<?php
// library.php: creates easy-to-use functions for "Start from Scratch" bundle
declare(strict_types=1);


// ************ HOUSEKEEPING ***************************//
define('PROJECT_ROOT', realpath(__DIR__ . '/../..'));
define('PROJECT_SRC', PROJECT_ROOT . '/src');
define('IMAGES_URL', '/images');
define('IMAGES_DIR', PROJECT_ROOT . IMAGES_URL);

// autoloads background classes
spl_autoload_register(
    function ($class) {
        $fn = str_replace('\\', '/', $class);
        $fn = PROJECT_SRC . '/' . $fn . '.php';
        $fn = str_replace('//', '/', $fn);
        require $fn;
    }
);
use Phpcl\Image\Canvas;
use Phpcl\Image\Strategy\Face;
$canvas = new Canvas();

// cleans up any images > 24 hours old
$iter = new \RecursiveDirectoryIterator(IMAGES_DIR);
$now = time();
$yesterday = $now - (60 * 60 * 24);
foreach ($iter as $name => $obj) {
    // find files older than 24 hours
    if ($obj->isFile() && $obj->getCTime() < $yesterday) {
        unlink($name);
    }
}


// ************ FUNCTION LIBRARY ***************************//
#[description("Returns an int representing an RGB color")]
#[int("r")]
#[int("g")]
#[int("b")]
#[returns("int")]
function make_a_color(int $r, int $g, int $b)
{
    global $canvas;
    $color = $canvas->colorAlloc($r, $g, $b);
    if ($color === FALSE) {
        echo Canvas::ERR_COLOR . "<br>\n";
        $color = 0;
    }
    return $color;
}

function get_rand_image_fn($base = '')
{
    return IMAGES_DIR . '/' . $base . '_' . date('YmdHis') . rand(100,999) . '.png';
}
#[description("Returns HTML img tag that displays an image")]
#[string("smile : smile|frown|neutral")]
#[int("color")]
#[returns("string : HTML img tag")]
function make_a_face(string $smile, int $color)
{
    global $canvas;
    Face::write($canvas, $smile, $color);
    $fn = get_rand_image_fn(__FUNCTION__);
    $canvas->save($fn);
    $html = '<img src="' . IMAGES_URL . '/' . basename($fn) . '" />';
    return $html;
}
