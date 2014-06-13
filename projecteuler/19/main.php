<?php

/* 
 * @company self
 * @author Raymond Byczko
 * @file 19/countingsundays/main.php
 */

function add_this($a, $b)
{
    $res = $a + $b;
    return $res;
}

$x = 4;
$y = 5;

$sumxy = add_this($x, $y);
echo 'sumxy='.$sumxy."\n";
