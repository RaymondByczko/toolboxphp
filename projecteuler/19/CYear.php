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
         $sumDays = 0;
         for ($i=1; $i< $m; $i++)
         {
             $sumDays += $daysPerMonth[$i];
         }
         $sumDays += $d;
         return $sumDays;
     }
    
}
