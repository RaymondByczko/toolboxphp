<?php

/* 
 * @company self
 * @author Raymond Byczko
 * @file 19/countingsundays/main.php
 * @subject project euler 19
 * @note Two slightly different ways of calculating answer
 * are presented in this main.php.  The second shows
 * generalized code in a method, derived from first.
 */

require_once 'CYear.php';

$yearObj = new CYear();

// One way to calculate answer for project euler 19.
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

// Second way where code is generalized further.
$numSundays2 = $yearObj->numberSundays(1, 1901, 12, 2000);

echo 'numSundays='.$numSundays."\n";
echo 'numSundays2='.$numSundays2."\n";
echo 'main-end'."\n";
