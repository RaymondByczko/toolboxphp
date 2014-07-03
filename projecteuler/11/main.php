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

require_once './CGrid.php';
echo 'projecteuler/11/main.php: start'."\n";
$objGrid = new CGrid(6,2,4);
$gdata = array(
    0=>array(1,2,2,2,3,5),
    1=>array(4,9,9,1,3,8)
);
$objGrid->loadGrid($gdata);
$grid = $objGrid->getGrid();
$objGrid->eliminateHalf();
$collections = $objGrid->getCollections();
echo 'projecteuler/11/main.php: end'."\n";
?>