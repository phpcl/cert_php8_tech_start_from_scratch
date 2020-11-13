<?php
// constants
define('COLS', 3);
define('SPACER', '<td>&nbsp;&nbsp;&nbsp;</td>');
// init vars
$flag = TRUE;
$iter = NULL;
$filt = NULL;
$phpMyAdmin = TRUE;
$bundles = ['start_from_scratch'];
$col_class = 'col-md-'
           . (string) ((int) (12 / COLS));
// output file list
if (empty($message)) $message = '';
if (empty($output)) {
    $output = '';
    $dirIter = new RecursiveDirectoryIterator(__DIR__);
    $iterIter = new RecursiveIteratorIterator($dirIter);
    // create filter by category
    $filt = new class ($iterIter) extends FilterIterator {
        public $path = '';
        public function accept() : bool
        {
            $fn = parent::current();
            return (strpos($fn, $this->path) && $fn->isFile());
        }
    };
    //echo __FILE__ . ':' . var_export(iterator_to_array($filt), TRUE); exit;
}
include __DIR__ . '/home.phtml';
