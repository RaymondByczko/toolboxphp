<?php
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
/**
 * @company self
 * @author RByczko
 * @file
 * @filesource
 * @purpose
 * @start_date
 * @change_history 2014-07-10 July 10; RByczko; Changed name of getCollections
 * to getHCollections.
 * @change_history 2014-07-10 July 10; RByczko; Changed name of eliminateHalf
 * to eliminateHorizontals.
 * @change_history 2014-07-14 July 14; RByczko; Changed name of
 * largestOneDiagonal to largestOneDiagonal2_4.
 */

require_once './CGrid.php';
require_once './CDiagonalDirection.php';
echo 'projecteuler/11/main.php: start'."\n";
$objGrid = new CGrid(6,2,4);
$gdata = array(
    0=>array(1,2,2,2,3,5),
    1=>array(4,9,9,1,3,8)
);
$objGrid->loadGrid($gdata);
$grid = $objGrid->getGrid();
$objGrid->eliminateHorizontals();
$collections = $objGrid->getHCollections();
$l_max_pos=null;
$l_max_value=null;
$ret_largest = $objGrid->largest(CDiagonalDirection::H(),0,$l_max_pos, $l_max_value);

$objGrid2 = new CGrid(6,2,4);
$gdata2 = array(
            0 => array(1, 1, 1, 2, 2, 5),
            1 => array(1, 9, 9, 1, 1, 1)
        );
$objGrid2->loadGrid($gdata2);
$objGrid2->eliminateHorizontals();
$l_max_pos=null;
$l_max_value=null;
$objGrid2->largest(new CDiagonalDirection(),1, $l_max_pos, $l_max_value);

$object8_8 = new CGrid(8,8,4);
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
$object8_8->loadGrid($gdata8_8);
$object8_8->eliminateDiagonals2_4();   
$y_max = null;
$x_max = null;
$max_value = null;
$object8_8->largestOneDiagonal2_4(0, 0, $y_max, $x_max, $max_value);

echo 'projecteuler/11/main.php: end'."\n";
?>