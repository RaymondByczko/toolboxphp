<?php

/**
 * @compay self
 * @author Raymond Byczko
 * @filesource CGridTest.php
 * @file CGridTest.php
 * @start_date 2014-07-02 July 2
 * @change_history 2014-07-10 July 10; RByczko; Adjusted a test  case
 * to account for equality in first,second comparison (see CGrid.php).
 * The first will be declared as NOT_A_CANDIDATE.
 * @change_history 2014-07-10 July 10; RByczko; Adjusted name of
 * getCollections to getHCollections.
 * @change_history 2014-07-10 July 10; RByczko; Changed name of eliminateHalf
 * to eliminateHorizontals.
 * @change_history 2014-07-11 July 11; RByczko; Made adjustment to test
 * based on more accurate concept of what consistitutes first and second
 * in eliminateHorizontals (and eliminateVerticals too). first is at one
 * pair of $x,$y.  second is right next to it - just increase $x,$y or both by 1.
 * (And not by m_collection_size).
 * @change_history 2014-07-11 July 11; RByczko; Added testEliminateVerticals.
 * @change_history 2014-07-14 July 14; RByczko; Changed name of
 * largestOneDiagonal to largestOneDiagonal2_4.
 * @change_history 2014-07-14 July 14; RByczko; Added testLargestDiagonal2_4.
 * * @todo - test remaining columns in testEliminateVerticals.
 */
require_once '../CGrid.php';
require_once '../CDiagonalDirection.php';

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-07-02 at 21:14:13.
 */
class CGridTest extends PHPUnit_Framework_TestCase {

    /**
     * @var CGrid
     */
    protected $object;
    protected $object2;
    protected $object5_15;
    protected $object8_8;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
        $this->object = new CGrid(6, 2, 4);
        $this->object2 = new CGrid(15, 2, 4);
        $this->object5_15 = new CGrid(15, 5, 4);
        $this->object8_8 = new CGrid(8, 8, 4);
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
            0 => array(1, 2, 2, 2, 3, 5),
            1 => array(4, 9, 9, 1, 3, 8)
        );
        $this->object->loadGrid($gdata);
        $grid = $this->object->getGrid();
        $this->assertEquals($grid[0][5], 5);
        $this->assertEquals($grid[1][5], 8);
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
            0 => array(1, 2, 2, 2, 3, 5),
            1 => array(4, 9, 9, 1, 3, 8)
        );
        $this->object->loadGrid($gdata);
        $this->object->eliminateHorizontals();
        $collections = $this->object->getHCollections();
        $this->assertEquals($collections[0][0], $this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[0][1], $this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[0][2], $this->object->POSSIBLE_CANDIDATE());

        $this->assertEquals($collections[1][0], $this->object->POSSIBLE_CANDIDATE());
        $this->assertEquals($collections[1][1], $this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[1][2], $this->object->NOT_A_CANDIDATE());
    }
    // @todo - make up test for eliminateHorizontals where its only 4 wide.
    // This is a boundary case.  If one dimension is less than or equal to
    // m_collection_size, then eliminate cannot work in that dimension.
    // This was discovered accidently in testEliminateVerticals.
    /*
     * 
     */
    public function testEliminateVerticals()
    {
       $gdata = array(
            0 => array(1, 1, 1, 8, 1),
            1 => array(1, 1, 1, 8, 1),
            2 => array(1, 7, 1, 8, 1),
            3 => array(3, 7, 1, 8, 1),
            4 => array(3, 7, 1, 1, 1),
            5 => array(3, 7, 1, 1, 1),
            6 => array(3, 1, 9, 1, 1),
            7 => array(1, 1, 9, 1, 1),
            8 => array(1, 1, 9, 1, 1),
            9 => array(1, 1, 9, 1, 1)
        );
        $objCGrid = new CGrid(5,10,4);
        $objCGrid->loadGrid($gdata);
        $objCGrid->eliminateVerticals();
        $collections = $objCGrid->getVCollections();
        $ak = array_keys($collections);
        $ak_min = min($ak);
        $this->assertEquals($ak_min, 0);
        $ak_max = max($ak);
        $this->assertEquals($ak_max, 6);
        $this->assertEquals($collections[0][0], $objCGrid->NOT_A_CANDIDATE());
        $this->assertEquals($collections[1][0], $objCGrid->NOT_A_CANDIDATE());
        $this->assertEquals($collections[2][0], $objCGrid->NOT_A_CANDIDATE());
        $this->assertEquals($collections[3][0], $objCGrid->POSSIBLE_CANDIDATE());
        $this->assertEquals($collections[4][0], $objCGrid->NOT_A_CANDIDATE());
        $this->assertEquals($collections[5][0], $objCGrid->NOT_A_CANDIDATE());
        $this->assertEquals($collections[6][0], $objCGrid->NOT_A_CANDIDATE());
        // @todo test other columns
    }
    
    public function testLargest()
    {
        $gdata = array(
            0 => array(1, 1, 1, 2, 2, 5),
            1 => array(1, 9, 9, 1, 1, 1)
        );
        $this->object->loadGrid($gdata);
        $this->object->eliminateHorizontals();
        $l_max_pos=null;
        $l_max_value=null;
        $this->object->largest(CDiagonalDirection::H(), 0, $l_max_pos, $l_max_value);
        $this->assertEquals(2, $l_max_pos);
        $this->assertEquals(20, $l_max_value);
        
        $l_max_pos=null;
        $l_max_value=null;
        $this->object->largest(CDiagonalDirection::H(), 1, $l_max_pos, $l_max_value);
        $this->assertEquals(1, $l_max_pos);
        $this->assertEquals(81, $l_max_value);
    }
    
    public function testLargest2()
    {
        $gdata = array(
            0 => array(1, 2, 3, 2, 2, 1, 1, 1, 4, 5, 6, 7, 1, 1, 1),
            1 => array(2, 3, 4, 2, 1, 1, 8, 8, 8, 8, 1, 1, 1, 1, 1)
        );
        $this->object2->loadGrid($gdata);
        $this->object2->eliminateHorizontals();
        $l_max_pos=null;
        $l_max_value=null;
        $this->object2->largest(CDiagonalDirection::H(), 0, $l_max_pos, $l_max_value);
        $this->assertEquals(8, $l_max_pos);
        $this->assertEquals(840, $l_max_value);
        
        $l_max_pos=null;
        $l_max_value=null;
        $this->object2->largest(CDiagonalDirection::H(), 1, $l_max_pos, $l_max_value);
        $this->assertEquals(6, $l_max_pos);
        $this->assertEquals(64*64, $l_max_value);
    }
    
    public function testLargest3()
    {
        $gdata = array(
            0=>array(1, 1, 9),
            1=>array(1, 1, 9),
            2=>array(1, 1, 9),
            3=>array(2, 1, 9),
            4=>array(2, 1, 1),
            5=>array(2, 1, 1),
            6=>array(2, 4, 1),
            7=>array(5, 4, 1),
            8=>array(5, 4, 1),         
            9=>array(5, 4, 1),
            10=>array(5, 1, 1),
            11=>array(1, 1, 1),
            12=>array(1, 1, 1),
            13=>array(1, 1, 1),
            14=>array(1, 1, 1),
            15=>array(1, 1, 1)
        );
        $objCGrid16_3 = new CGrid(3,16,4);
        $objCGrid16_3->loadGrid($gdata);
        $objCGrid16_3->eliminateHorizontals();
        $x_max_pos=null;
        $x_max_value=null;
        $objCGrid16_3->largest(CDiagonalDirection::V(), 0, $x_max_pos, $x_max_value);
        $this->assertEquals(7, $x_max_pos);
        $this->assertEquals(25*25,$x_max_value);
        $x_max_pos=null;
        $x_max_value=null;
        $objCGrid16_3->largest(CDiagonalDirection::V(), 1, $x_max_pos, $x_max_value);
        $this->assertEquals(6, $x_max_pos);
        $this->assertEquals(16*16,$x_max_value); 
        $x_max_pos=null;
        $x_max_value=null;
        $objCGrid16_3->largest(CDiagonalDirection::V(), 2, $x_max_pos, $x_max_value); 
        $this->assertEquals(0, $x_max_pos);
        $this->assertEquals(81*81,$x_max_value);     
    
    }
    
    public function testLargestHorizontal()
    {
        $gdata = array(
            0 => array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
            1 => array(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2),
            2 => array(1, 2, 3, 2, 2, 1, 1, 1, 4, 5, 6, 7, 1, 1, 1),
            3 => array(2, 3, 4, 2, 1, 1, 8, 8, 8, 8, 1, 1, 1, 1, 1),
            4 => array(3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3)
        );
        $this->object5_15->loadGrid($gdata);
        $this->object5_15->eliminateHorizontals();
        
        $max_y=null;
        $max_x=null;
        $max_value=null;
        $this->object5_15->largestHorizontal($max_y, $max_x, $max_value);
        $this->assertEquals(3, $max_y);
        $this->assertEquals(6, $max_x);
        $this->assertEquals(64*64, $max_value);    
    }
    
    public function testLargestHorizontal2()
    {
        $gdata = array(
            0 => array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
            1 => array(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2),
            2 => array(1, 2, 3, 2, 2, 1, 1, 1, 4, 5, 6, 7, 1, 1, 1),
            3 => array(2, 3, 4, 2, 1, 1, 8, 8, 8, 8, 1, 1, 1, 1, 1),
            4 => array(3, 3, 9, 9, 9, 9, 3, 3, 3, 3, 3, 3, 3, 3, 3)
        );
        $this->object5_15->loadGrid($gdata);
        $this->object5_15->eliminateHorizontals();
        
        $max_y=null;
        $max_x=null;
        $max_value=null;
        $this->object5_15->largestHorizontal($max_y, $max_x, $max_value);
        $this->assertEquals(4, $max_y);
        $this->assertEquals(2, $max_x);
        $this->assertEquals(81*81, $max_value);    
    }
    
    public function testLargestOneDiagonal()
    {
        $gdata8_8 = array(
            0 => array(1, 5, 1, 1, 1, 1, 1, 1 ),
            1 => array(1, 1, 5, 1, 1, 1, 1, 1 ),
            2 => array(1, 1, 9, 5, 1, 1, 1, 1 ),
            3 => array(1, 1, 1, 9, 5, 1, 1, 1 ),
            4 => array(2, 1, 1, 3, 9, 1, 1, 1 ),
            5 => array(1, 2, 1, 1, 3, 9, 1, 1 ),
            6 => array(1, 1, 2, 1, 1, 3, 1, 1 ),
            7 => array(1, 1, 1, 2, 1, 1, 3, 1 )               
        );
        $this->object8_8->loadGrid($gdata8_8);
        $this->object8_8->eliminateDiagonals2_4();   
        $y_max = null;
        $x_max = null;
        $max_value = null;
        $this->object8_8->largestOneDiagonal2_4(0, 0, $y_max, $x_max, $max_value);
        $this->assertEquals(81*81, $max_value);
        $this->assertEquals(2, $y_max);
        $this->assertEquals(2, $x_max);
        //
        $y_max = null;
        $x_max = null;
        $max_value = null;
        $this->object8_8->largestOneDiagonal2_4(0, 1, $y_max, $x_max, $max_value);
        $this->assertEquals(25*25, $max_value);
        $this->assertEquals(0, $y_max);
        $this->assertEquals(1, $x_max);
        //
        $y_max = null;
        $x_max = null;
        $max_value = null;
        $this->object8_8->largestOneDiagonal2_4(5, 0, $y_max, $x_max, $max_value);
        $this->assertEquals(null, $max_value);
        $this->assertEquals(null, $y_max);
        $this->assertEquals(null, $x_max);
    }
    
    public function testEliminateDiagonals3_1()
    {
        $gdata8_8 = array(
            0 => array(1, 1, 1, 1, 1, 1, 1, 1 ),
            1 => array(1, 1, 1, 1, 1, 1, 1, 1 ),
            2 => array(1, 1, 1, 1, 1, 1, 1, 1 ),
            3 => array(1, 1, 1, 1, 1, 1, 1, 4 ),
            4 => array(1, 1, 1, 2, 1, 1, 4, 1 ),
            5 => array(1, 1, 2, 1, 1, 4, 1, 1 ),
            6 => array(1, 2, 1, 1, 4, 1, 1, 1 ),
            7 => array(2, 1, 1, 1, 1, 1, 1, 1 )               
        );
        $this->object8_8->loadGrid($gdata8_8);
        $this->object8_8->eliminateDiagonals3_1(); 
        
        $collections = $this->object8_8->getD3_1Collections();
        $this->assertEquals($collections[7][0], $this->object->POSSIBLE_CANDIDATE());
        $this->assertEquals($collections[6][1], $this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[5][2], $this->object->NOT_A_CANDIDATE());
        $this->assertEquals($collections[4][3], $this->object->NOT_A_CANDIDATE());
    }
    
    public function testLargestDiagonal2_4()
    {
        $gdata8_8 = array(
                0 => array(2, 1, 1, 1, 1, 7, 1, 1 ),
                1 => array(1, 2, 1, 1, 1, 1, 7, 1 ),
                2 => array(1, 9, 2, 1, 1, 1, 1, 7 ),
                3 => array(1, 1, 9, 2, 1, 1, 1, 1 ),
                4 => array(1, 1, 1, 8, 3, 1, 1, 1 ),
                5 => array(1, 1, 1, 1, 9, 3, 1, 1 ),
                6 => array(1, 1, 1, 1, 1, 1, 1, 1 ),
                7 => array(1, 1, 1, 1, 1, 1, 1, 1 )               
            );
        $this->object8_8->loadGrid($gdata8_8);
        
        $c2_4 = $this->object8_8->getD2_4Collections();
        $keys2_4 = array_keys($c2_4);
        $min_keys2_4 = min($keys2_4);
        $max_keys2_4 = max($keys2_4);
        $this->assertEquals($min_keys2_4, 0);
        $this->assertEquals($max_keys2_4, 4);
        
        $this->object8_8->eliminateDiagonals2_4();
        
        $c2_4 = $this->object8_8->getD2_4Collections();
        $keys2_4 = array_keys($c2_4);
        $min_keys2_4 = min($keys2_4);
        $max_keys2_4 = max($keys2_4);
        $this->assertEquals($min_keys2_4, 0);
        $this->assertEquals($max_keys2_4, 4);
        
        $y_largest = null;
        $x_largest = null;
        $largest = null;
        $ret_l = $this->object8_8->largestDiagonal2_4($y_largest, $x_largest, $largest);
        $this->assertEquals($y_largest, 2);
        $this->assertEquals($x_largest, 1);
        $this->assertEquals($largest, 81*72);
    

    }
}