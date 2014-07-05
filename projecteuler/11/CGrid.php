<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Contains a specification of a 2D grid as given in projecteuler
 * problem 11.
 * 
 * The extent of the 2D grid is specified to the constructor
 * by using $x_max and $y_max.  The number of values used in the
 * product is given by collection_size.
 *
 * @author raymond
 */
class CGrid {
    private $m_x_max=null;
    private $m_y_max=null;
    private $m_collection_size=null;
    private $m_gdata=null;
    private $POSSIBLE_CANDIDATE=0;
    private $NOT_A_CANDIDATE=1;
    /**
     *
     * @var array Contains the horizontal collections.  Each collection
     * is of m_collection_size.
     */
    private $m_collections=null;
    public function __construct($x_max, $y_max, $collection_size)
    {
        $this->m_x_max = $x_max;
        $this->m_y_max = $y_max;
        $this->m_collection_size = $collection_size;
        $this->m_collections = array_fill(0, $this->m_y_max, array_fill(0, $this->m_x_max,$this->POSSIBLE_CANDIDATE));
    }
    /**
     * 
     * @param array $gdata
     * @throws Exception
     */
    public function loadGrid($gdata)
    {
        if (is_array($gdata == FALSE))
        {
            throw Exception('gdata is not an array');
        }
        $this->m_gdata = $gdata;
        
    }
    public function getGrid()
    {
        return $this->m_gdata;
    }
    
    public function eliminateHalf()
    {
        // proceed along each row
        for ($y=0; $y<$this->m_y_max; $y++)
        {
            // process columns in 1 row
            for ($x=0; $x<($this->m_x_max-$this->m_collection_size); $x++)
            {
                $first = $this->m_gdata[$y][$x];
                $second = $this->m_gdata[$y][$x+4];
                if ($first > $second)
                {
                    $this->m_collections[$y][$x+4] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_collections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                }
                
            }
        }
    }
    /**
     * Given a row position, largest computes the largest product
     * value in that row, and returns the starting position of that
     * collection (used to compute the product) along with its value.
     * @param int $row
     * @param int $r_max_pos
     * @param int $r_max_value
     * @return int
     * @todo check on type of float or real, for r_max_value.
     */
    public function largest($row, &$r_max_pos, &$r_max_value)
    {
        // The x position for the start of the collection containing
        // the current max.
        $max_pos=null;
        $max_value=null;
        for ($x=0; $x<=($this->m_x_max-$this->m_collection_size); $x++)
        {
            $candidate_pos = $this->m_collections[$row][$x];
            if ($candidate_pos == $this->NOT_A_CANDIDATE())
            {
                continue;
            }
            $current_value = $this->m_gdata[$row][$x] * $this->m_gdata[$row][$x+1] * $this->m_gdata[$row][$x+2] * $this->m_gdata[$row][$x+3];
            if ($max_value == null)
            {
                $max_pos = $x;
                $max_value = $current_value;
            }
            else
            {
                if ($current_value>$max_value)
                {
                    $max_pos = $x;
                    $max_value = $current_value;
                }
            }
        }
        $r_max_pos = $max_pos;
        $r_max_value = $max_value;
        return 0; // Success
    }
    /**
     * Computes the largest value considering only the complete
     * set of horizontal rows.
     */
    public function largestHorizontal()
    {
        $y_max=null;
        $x_max=null;
        $largest=null;
        for ($y=0; $y<$this->m_y_max; $y++)
        {
            $max_value = null;
            $max_pos = null;
            $ret_l = largest($y, $max_pos, $max_value);
            if ($y == 0)
            {
                $y_max = 0;
                $x_max = $max_pos;
                $largest = $max_value;
            }
            else
            {
                if ($max_value > $largest)
                {
                    $largest = $max_value;
                    $y_max = $y;
                    $x_max = $max_pos;
                }
            }
        }
    }
    public function getCollections()
    {
        return $this->m_collections;
    }
    public function POSSIBLE_CANDIDATE()
    {
        return $this->POSSIBLE_CANDIDATE;
    }
      public function NOT_A_CANDIDATE()
    {
        return $this->NOT_A_CANDIDATE;
    }
    
}
