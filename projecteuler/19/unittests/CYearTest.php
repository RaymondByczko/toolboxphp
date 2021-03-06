<?php
/**
 * @compay self
 * @author Raymond Byczko
 * @filesource CYearTest.php
 * @file CYearTest.php
 * @start_date 2014-06-13 June 13
 */

include_once '../CYear.php';
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-06-13 at 20:10:27.
 */
class CYearTest extends PHPUnit_Framework_TestCase {

    /**
     * @var CYear
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new CYear;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers CYear::isLeapYear
     * @todo
     */
    public function testIsLeapYear() {
        $result1900 = $this->object->isLeapYear(1900);
        $this->assertTrue($result1900 == false);
        $result1901 = $this->object->isLeapYear(1901);
        $this->assertTrue($result1901 == false);
        $result1902 = $this->object->isLeapYear(1902);
        $this->assertTrue($result1902 == false);
    }

    /**
     * @covers CYear::daysToDate
     * @todo   Implement testDaysToDate().
     */
    public function testDaysToDate() {
        $numDays1 = $this->object->daysToDate(1, 15, 1900);
        $this->assertTrue($numDays1 == 15);
        $numDays2 = $this->object->daysToDate(2, 1, 1900);
        $this->assertTrue($numDays2 == 32);
        $numDays3 = $this->object->daysToDate(3, 15, 1901);
        $this->assertTrue($numDays3 == 74);    
        $numDays4 = $this->object->daysToDate(12, 31, 1980);
        $this->assertTrue($numDays4 == 366);         
        $numDays5 = $this->object->daysToDate(12, 31, 1981);
        $this->assertTrue($numDays5 == 365);
        $numDays6 = $this->object->daysToDate(4, 1, 1900);
        $this->assertTrue($numDays6 == 91);   
        echo "numDays6".$numDays6;
        }

    /**
     * @covers CYear::days1900ToDate
     */
    public function testDays1900ToDate() {
        $numDays1 = $this->object->days1900ToDate(1, 10, 1900);
        $this->assertTrue($numDays1 == 10);
        $numDays2 = $this->object->days1900ToDate(1, 11, 1901);
        $this->assertTrue($numDays2 == 376);
        $numDays3 = $this->object->days1900ToDate(1, 18, 1902);
        $this->assertTrue($numDays3 == 748);
    }
  
    /**
     * @covers CYear::numberSundays -- See http://www.timeanddate.com/calendar/?year=1924&country=1
     * @link http://www.timeanddate.com/calendar/?year=1924&country=1 See this page for Calenders.
     */
    public function testNumberSundays()
    {
        $numSundays1 = $this->object->numberSundays(1, 1901, 12, 2000);
        $this->assertTrue($numSundays1 == 171);
        $numSundays2 = $this->object->numberSundays(1, 1905, 12, 1906);
        $this->assertTrue($numSundays2 == 4);
        $numSundays3 = $this->object->numberSundays(7, 1906, 9, 1906);
        $this->assertTrue($numSundays3 == 1);
        $numSundays4 = $this->object->numberSundays(10, 1911, 10, 1911);
        $this->assertTrue($numSundays4 == 1);
        $numSundays5 = $this->object->numberSundays(11, 1911, 11, 1911);
        $this->assertTrue($numSundays5 == 0);
        $numSundays6 = $this->object->numberSundays(1, 1919, 12, 1919);
        $this->assertTrue($numSundays6 == 1);
        $numSundays7 = $this->object->numberSundays(4, 1923, 7, 1924);
        $this->assertTrue($numSundays7 == 3);
    }

}
