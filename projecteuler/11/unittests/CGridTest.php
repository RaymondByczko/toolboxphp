<?php
/**
 * @compay self
 * @author Raymond Byczko
 * @filesource CGridTest.php
 * @file CGridTest.php
 * @start_date 2014-07-02 July 2
 */

require_once '../CGrid.php';
/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-07-02 at 21:14:13.
 */
class CGridTest extends PHPUnit_Framework_TestCase {

    /**
     * @var CGrid
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new CGrid(6,2,4);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        
    }

    /**
     * @covers CGrid::loadGrid
     * @todo   Implement testLoadGrid().
     */
    public function testLoadGrid() {
        $gdata = array(
                    0=>array(1,2,2,2,3,5),
                    1=>array(4,9,9,1,3,8)
                 );
        $this->object->loadGrid($gdata);
        $grid = $this->object->getGrid();
        $this->assertEquals($grid[0][5],5);
        $this->assertEquals($grid[1][5],8);
        
    }

    /**
     * @covers CGrid::eliminateHalf
     * @todo   Implement testEliminateHalf().
     */
    public function testEliminateHalf() {
        // Remove the following lines when you implement this test.
        /// $this->markTestIncomplete(
        ///         'This test has not been implemented yet.'
        /// );
        $gdata = array(
                    0=>array(1,2,2,2,3,5),
                    1=>array(4,9,9,1,3,8)
                 );
        $this->object->loadGrid($gdata);
        $this->object->eliminateHalf();
        $collections = $this->object->getCollections();
        $this->assertEquals($collections[0][0],$this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[0][1],$this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[0][2],$this->object->POSSIBLE_CANDIDATE());
    }

}
