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
        if ($y%4 == 0)
        {
            $isCentury = ($y%100 == 0);
            if ($isCentury)
            {
                echo 'century: '.$y."\n";
            }
            if (($isCentury))
            {
                if ($y%400 == 0)
                {
                    $leapYear = true;
                }
                else 
                {
                    $leapYear = false;
                }
            }
            else
            {
                $leapYear = true;
                echo $y.' is a leap year'."\n";
            }
        }
        else
        {
            $leapYear = false;
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
     /**
      * Calculates number of days since Jan 1, 1900 to
      * $m,$d,$y.
      * @param int $m month 1-12
      * @param int $d day, per specific month
      * @param int $y year
      * @return int
      */
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
     
     /**
      * Calculates the number of Sundays found between
      * two different month dates.
      * @param int $m1 Month of first date (1-12).
      * @param int $y1 Year of first date.
      * @param int $m2 Month of second date (1-12).
      * @param int $y2 Year of second date.
      * @throws Exception
      */
     public function numberSundays($m1,$y1,$m2,$y2)
     {
        if ($y2 < $y1)
        {
            throw new Exception('Years out of order; y1='.$y1."; y2=".$y2);        
        }
        
        $numSundays = 0;
        for ($y=$y1; $y<=$y2; $y++)
        {
            if ($y1==$y2)
            {
                $m_min = $m1;
                $m_max = $m2;   
            }
            if (($y2 > $y1) && ($y==$y1))
            {
                $m_min = $m1;
                $m_max = 12;
            }
            if (($y2 > $y1) && ($y > $y1) && ($y < $y2))
            {
                $m_min = 1;
                $m_max = 12;
            }
            if (($y2 > $y1) && ($y == $y2))
            {
                $m_min = 1;
                $m_max = $m2;
            }        
            for ($m=$m_min; $m<=$m_max; $m++)
            {
                $numDays = $this->days1900ToDate($m, 1, $y);
                if ($numDays%7 == 0)
                {
                    // Falls on Sunday
                    echo 'year='.$y.'; month='.$m."\n";
                    echo 'numDays='.$numDays."\n";
                    $numSundays++;
            
                }
            }
        }
        return $numSundays;
     }
    
}
?>
