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
        for ($y=0; $y<$this->m_y_max; $y++)
        {
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
