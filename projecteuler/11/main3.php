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
 * @change_history
 */
?>
<?php
require_once './CGrid.php';
require_once './CDiagonalDirection.php';
echo 'projecteuler/11/main3.php: start'."\n";

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
$objCGrid8_8 = new CGrid(8,8,4);
$objCGrid8_8->loadGrid($gdata8_8);
$collections = $objCGrid8_8->getD3_1Collections();
print_r($collections);
$objCGrid8_8->eliminateDiagonals3_1(); 
$collections = $objCGrid8_8->getD3_1Collections();
print_r($collections);
/*
$this->assertEquals($collections[7][0], $objCGrid8_8->POSSIBLE_CANDIDATE());
$this->assertEquals($collections[6][1], $objCGrid8_8->NOT_A_CANDIDATE());
$this->assertEquals($collections[5][2], $objCGrid8_8->NOT_A_CANDIDATE_CANDIDATE());
$this->assertEquals($collections[4][3], $objCGrid8_8->NOT_A_CANDIDATE_CANDIDATE());
*/
echo 'projecteuler/11/main3.php: end'."\n";