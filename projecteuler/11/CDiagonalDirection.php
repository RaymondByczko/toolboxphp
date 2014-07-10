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
 * @change_history
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
    
}
?>