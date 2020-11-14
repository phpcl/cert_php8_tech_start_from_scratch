<?php
// start_from_scratch/dealing_with_data.php
// make sure you add this command before you create the rest of the PHP program
include 'lib/library.php';

/**
 * PHP categorizes information into four basic "data types":
 * "int" (integer) is for whole numbers (including negative)
 * "float" is for large numbers, or numbers with a decimal
 * "string" is for characters (e.g. words, sentences, or a mix of letters and numbers, etc.)
 * "bool" (boolean) is used to represent TRUE or FALSE
 */

// In our first example, we want to draw a face on the screen
// in order to do that we need to create a "color" that consists of a mixture of red, green and blue
// each value can be an "int" with a value from 0 to 255
// Here is an example of drawing a blue face
$red   = 0;
$green = 0;
$blue  = 255;
$color = make_a_color($red, $green, $blue);

// now we need to tell PHP whether or not to make the face smile or frown
// to do that we need to give it a "string" value that contains either the word "smile" or "frown"
$smile = 'smile';
echo make_a_face($smile, $color);
