<?php

$string1 = "The quick brown fox jumps over the lazy dog.";
$string2 = "The quick brown albino fox jumps the groovy dog.";

$string1 = explode(" ", $string1);
$string2 = explode(" ", $string2);

$diff = array_intersect($string2, $string1);

$tmp = array();
foreach ($string2 as $k => $w) {
    if ($diff[$k]==$w) {
        $tmp[$k] = $w;
    }
    else {
        $tmp[$k] = "<b>$w</b>";
    }
}
$diff = array_diff($string1, $tmp);

foreach ($diff as $k => $w) {
    $tmp[$k] .= " [<strike>$w</strike>]";
}

echo join (' ', $tmp);