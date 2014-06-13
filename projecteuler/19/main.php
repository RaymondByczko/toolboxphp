<?php

/* 
 * @company self
 * @author Raymond Byczko
 * @file 19/countingsundays/main.php
 */


// EXPLANATION FOR FOLLOWING CODE FRAGMENT...
// JUST MAKING SURE I CAN DEBUG INTO THIS WITH NETBEANS.
// SOMETIMES IT DOESN'T COOPERATE AND NEED TO LOOK AT XDEBUG
// AND OTHER MATTERS
// @todo remove this
//
function add_this($a, $b)
{
    $res = $a + $b;
    return $res;
}

$x = 4;
$y = 5;

$sumxy = add_this($x, $y);
echo 'sumxy='.$sumxy."\n";
