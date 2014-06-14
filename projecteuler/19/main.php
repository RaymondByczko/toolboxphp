<?php

/* 
 * @company self
 * @author Raymond Byczko
 * @file 19/countingsundays/main.php
 */

require_once 'CYear.php';

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

$yearObj = new CYear();
$numDays = $yearObj->daysToDate(4, 1, 1900);

$numSundays = 0;
for ($y=1901; $y<=2000; $y++)
{
    for ($m=1; $m<=12; $m++)
    {
        $numDays = $yearObj->days1900ToDate($m, 1, $y);
        if ($numDays%7 == 0)
        {
            // Falls on Sunday
            echo 'year='.$y.'; month='.$m."\n";
            echo 'numDays='.$numDays."\n";
            $numSundays++;
            
        }
    }
}
echo 'numSundays='.$numSundays."\n";
echo 'main-end'."\n";
