<?php
namespace Phpcl\Image;
#[description("Tells is this class has an image or not")]
interface ImageInterface
{
    public function hasImage() : bool;
}
