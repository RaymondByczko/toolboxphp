<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CYear
 *
 * @author raymond
 */
class CYear {
    /**
     *
     * @staticvar array m_daysPerMonthReg number of days per
     * month in a regular year (non-leap, non divisible by 400).
     * 
     */
    static private $m_daysPerMonthReg = array(
        1=>31,
        2=>28,
        3=>31,
        4=>30,
        5=>31,
        6=>30,
        7=>31,
        8=>31,
        9=>30,
        10=>31,
        11=>30,
        12=>31
    );
    static private $m_daysUpToMonthReg = array
    (
        
    );
    /**
     * @
     */
    static private $m_daysPerMonthLY = array(
        1=>31,
        2=>29,
        3=>31,
        4=>30,
        5=>31,
        6=>30,
        7=>31,
        8=>31,
        9=>30,
        10=>31,
        11=>30,
        12=>31
    );   
    /**
     * Determines if a certain year is a leap year.
     * @param int $y represents a year
     * @return boolean
     */
    static public function isLeapYear($y)
    {
        $leapYear = null;
        if ($y%4 == 1)
        {
            if ($y%400 == 0)
            {
                $leapYear = false;
            }
            else
            {
                $leapYear = true;
            }
        }
        else
        {
            $leapYear = true;
        }
        return $leapYear;
    }
    /**
     * Calculates number of days from Jan 1 of a certain year to any day in that year.
     * @param int $m representing months 1 - 12 inclusive
     * @param int $d representing days (adjusted per month and leap year)
     * @param int $y representing the year (1900 and after)
     * @return int number of days from Jan 1 to data specified, inclusive.
     * @throws Exception
     */
     public function daysToDate($m, $d, $y)
     {
         $leapYear = self::isLeapYear($y);
         $daysPerMonth = null;
         if ($leapYear)
         {
             $daysPerMonth = self::$m_daysPerMonthLY;
         }
         else 
         {
             $daysPerMonth = self::$m_daysPerMonthReg;
         }
         if (($m<1) || ($m>12))
         {
             throw Exception('m is not a valid month;m='.$m);
         }
         if (($d<0)||($d>$daysPerMonth[$m]))
         {
             throw Exception('d is not a valid day for that month; d='.$d.', m='.$m);
         }
         $sumDays = 0;
         for ($i=1; $i< $m; $i++)
         {
             $sumDays += $daysPerMonth[$i];
         }
         $sumDays += $d;
         return $sumDays;
     }
     public function days1900ToDate($m, $d, $y)
     {
         $sumDays = 0;
         for ($i=1900; $i<$y; $i++)
         {
             if (self::isLeapYear($i))
             {
                 $sumDays += 366;
             }
             else
             {
                 $sumDays += 365;
             }
         }
         $lastYearsDays = $this->daysToDate($m, $d, $y);
         $sumDays += $lastYearsDays;
         return $sumDays;
     }
    
}
?>
