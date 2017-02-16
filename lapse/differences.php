<?php
// include the Diff class
require_once './class.Diff.php';

// output the result of comparing two files as HTML
$file = fopen("differences.html","w");
echo fwrite($file, Diff::toHTML(Diff::compareFiles('commits/frame2.html', 'commits/frame3.html')));