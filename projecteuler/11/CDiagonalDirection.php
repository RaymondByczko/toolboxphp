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
 * @file CDiagonalDirection.php
 * @filesource CDiagonalDiretion.php
 * @purpose To specify a unique type for diagonal direction, to be used
 * with a) type-hinting b) private construction.
 * @start_date
 * @change_history 2014-07-16; RByczko; Added methods to account for
 * 2_4, 3_1 diaogonals. The numbers 2 and 4 (and 3 and 1) represent
 * quadrants in the 2-D cartesian plane.
 */
?>
<?php
class CDiagonalDirection
{
    private $direction;
    private function __construct()
    {
        
    }
    public function isVERTICAL()
    {
        if ($this->direction == 'V')
        {
            return true;
        }
        return false;
    }
    public function isHORIZONTAL()
    {
        if ($this->direction == 'H')
        {
            return true;
        }
        return false;
    }
    public function is2_4()
    {
        if ($this->direction == 'D2_4')
        {
            return true;
        }
        return false;
    }
    
    public function is3_1()
    {
        if ($this->direction == 'D3_1')
        {
            return true;
        }
        return false;
    }
    /*
    public function h()
    {
        $this->direction = 'H';
        return clone $this;
    }
    */
    static public function V()
    {
        $ddObj = new CDiagonalDirection();
        $ddObj->direction = 'V';
        return $ddObj;
    }
    static public function H()
    {
        $ddObj = new CDiagonalDirection();
        $ddObj->direction = 'H';
        return $ddObj;
    }
    static public function D2_4()
    {
        $ddObj = new CDiagonalDirection();
        $ddObj->direction = 'D2_4';
        return $ddObj;
    }
    static public function D3_1()
    {
        $ddObj = new CDiagonalDirection();
        $ddObj->direction = 'D3_1';
        return $ddObj;
    }
    
}
?>