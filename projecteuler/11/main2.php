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
 * @file main2.php
 * @filesource main2.php
 * @purpose To utilize debugger for a certain test, that focuses on
 * CDiagonalDirection::V().  Otherwise, this file is not used as the
 * main of the application.
 * @start_date 2014-07-07 July 7
 * @change_history RByczko; 2014-07-07 July 7; Started this file.
 */
?>
<?php
require_once './CGrid.php';
require_once './CDiagonalDirection.php';
echo 'projecteuler/11/main2.php: start'."\n";
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
$objCGrid16_3->eliminateHalf();
$x_max_pos=null;
$x_max_value=null;
$objCGrid16_3->largest(CDiagonalDirection::V(), 0, $x_max_pos, $x_max_value);
echo 'projecteuler/11/main2.php: end'."\n";