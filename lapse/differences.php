<?php
// include the Diff class

require_once dirname(__FILE__).'/php-diff/lib/Diff.php';
$file = fopen("differences.html","w");

// Include two sample files for comparison
$a = explode("\n", file_get_contents(dirname(__FILE__).'/a.txt'));
$b = explode("\n", file_get_contents(dirname(__FILE__).'/b.txt'));