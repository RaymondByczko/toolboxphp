<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// require_once './CDiagonalDirection.php';
/**
 * Contains a specification of a 2D grid as given in projecteuler
 * problem 11.
 * 
 * The extent of the 2D grid is specified to the constructor
 * by using $x_max and $y_max.  The number of values used in the
 * product is given by collection_size.
 *
 * @note Each set of numbers used to form a product is known in this
 * class as a collection.  To specify one exact collection, two pieces
 * of information are needed:
 * 
 * a) an 'origin' of the collection
 * b) the direction of the collection
 * c) the size of the collection
 * 
 * Sounds like a vector to me!
 * origin and direction are related.  A collection can be specified by
 * one end, a origin and its direction.  Likewise, the same collection
 * can be specifed with the other end, and the opposite direction.
 * 
 * origin is just a pair in our grid (say $x, y).
 * direction specifies something related to origin.  e.g. $x+1,$y+1.
 * This indicates a diagonal advancing in increasing x and y.
 * Another example would be $x+1,$y, which is a horizontal row (constant
 * y)
 * @author raymond
 * @change_history 2014-07-10 July 10; RByczko; Adjusted behavior
 * when first and second are equal, making first NOT A CANDIDATE.
 * @change_history 2014-07-10 July 10; RByczko; Adjusted name of m_collections
 * to m_hcollections to better reflect its horizontal context.
 * @change_history 2014-07-10 July 10; RByczko; Changed name of getCollections
 * to getHCollections.  Introduced getVCollections and supporting vars. Minor
 * fix - should refer to m_vcollections when context is vertical.
 * @change_history 2014-07-10 July 10; RByczko; Changed name of eliminateHalf
 * to eliminateHorizontals.
 */
class CGrid {
    private $m_x_max=null;
    private $m_y_max=null;
    /**
     *
     * @var integer The size of each collection.  Each collection is comprised
     * of a number of numbers which are multiplied to form a product.
     * e.g 3*3*2*2 .  Here the collection size is 4 and the product is 36.
     * e.g.1*7*2*2*3.  Here the collection size is 5 and the product is 84.
     */
    private $m_collection_size=null;
    private $m_gdata=null;
    private $POSSIBLE_CANDIDATE=0;
    private $NOT_A_CANDIDATE=1;
    /**
     *
     * @var array Contains the horizontal collections.  Each collection
     * is of m_collection_size.
     */
    private $m_hcollections=null;
    private $m_vcollections=null;
    private $m_dcollections=null;
    private $m_3_1_dcollections=null;
    public function __construct($x_max, $y_max, $collection_size)
    {
        $this->m_x_max = $x_max;
        $this->m_y_max = $y_max;
        $this->m_collection_size = $collection_size;
        // Horizontal
        $this->m_hcollections = array_fill(0, $this->m_y_max, array_fill(0, $this->m_x_max,$this->POSSIBLE_CANDIDATE));
        // Vertical
        $this->m_vcollections = array_fill(0, $this->m_y_max, array_fill(0, $this->m_x_max,$this->POSSIBLE_CANDIDATE));
        // Diagonal
        if ( ($this->m_y_max > $this->m_collection_size) &&
    ($this->m_x_max > $this->m_collection_size) )
        {
            $this->m_dcollections = array_fill(0, $this->m_y_max-$this->m_collection_size, array_fill(0, $this->m_x_max-$this->m_collection_size,$this->POSSIBLE_CANDIDATE));
            $this->m_3_1_dcollections = array_fill($this->m_collection_size-1, $this->m_y_max-$this->m_collection_size+1, array_fill(0, $this->m_x_max-$this->m_collection_size+1,$this->POSSIBLE_CANDIDATE));
            
        }
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
    
    /**
     * Considers all rows 'horizontally' positioned.
     * (row is determined by $y in code)
     */
    public function eliminateHorizontals()
    {
        // proceed along each row - I visualize this as proceeding
        // vertically.
        for ($y=0; $y<$this->m_y_max; $y++)
        {
            // process columns in 1 row - I visualize this as proceeding
            // horizontally.
            $numCollections = $this->m_x_max-$this->m_collection_size;
            for ($x=0; $x<$numCollections; $x++)
            {
                $first = $this->m_gdata[$y][$x];
                $second = $this->m_gdata[$y][$x+$this->m_collection_size];
                if ($first > $second)
                {
                    $this->m_hcollections[$y][$x+$this->m_collection_size] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_hcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                    // or...
                    // Declare the first one as NOT A CANDIDATE.
                    $this->m_hcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                
            }
        }
    }
    /**
     * Eliminates up to half of all candidates along a set of diagonals
     * running 'southeast'.  Essentially an element at $y,$x is compared
     * to an element at $y+$m_collection_size, $x+$m_collection_size.
     * This allows comparison of collections at $y,$x and $y+1,$x+1.
     * @note The '2_4' designation indicates a diagonal in quadrant 2 to
     * quadrant 4 in the 2-D cartesian plane.
     */
    public function eliminateDiagonals2_4()
    {
        $cs = $this->m_collection_size;
        for ($y=0; $y<$this->m_y_max-$cs; $y++)
        {
            for ($x=0; $x<($this->m_x_max-$cs); $x++)
            {
                $first = $this->m_gdata[$y][$x];
                $second = $this->m_gdata[$y+$cs][$x+$cs];    
                if ($first > $second)
                {
                    $this->m_dcollections[$y+1][$x+1] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                    // or...
                    // Declare first as NOT A CANDIDATE
                    $this->m_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
            }
        }
    }
   /**
     * Eliminates up to half of all candidates along a set of diagonals
     * running 'northeast'.  Essentially an element at $y,$x is compared
     * to an element at $y-$m_collection_size, $x-$m_collection_size.
     * This allows comparison of collections at $y,$x and $y-1,$x-1.
     * @note The '3_1' designation indicates a diagonal in quadrant 3 to
     * quadrant 1 in the 2-D cartesian plane.
     */    
    public function eliminateDiagonals3_1()
    {
        $cs = $this->m_collection_size;
        // start from bottom row..
        for ($y=$this->m_y_max-1; $y>=$cs; $y--)
        {
            // .. proceed across... then got up a row...
            for ($x=0; $x<=$this->m_x_max-$cs-1; $x++)
            {      
                $first = $this->m_gdata[$y][$x];
                $sy = $y - $cs;
                $sx = $x + $cs;
                $second = $this->m_gdata[$sy][$sx];
                if ($first > $second)
                {
                    $this->m_3_1_dcollections[$y-1][$x+1] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_3_1_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                    // or...
                    // pick the first as NOT A CANDIDATE
                    $this->m_3_1_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                    
                }
            }
        }
        return true; // success
    }
    /**
     * Given a row position, largest computes the largest product
     * value in that row, and returns the starting position of that
     * collection (used to compute the product) along with its value.
     * @param CDiagonalDirection specifies horizontal, vertical.
     * @param int $row
     * @param int $r_max_pos
     * @param int $r_max_value
     * @return int
     * @todo check on type of float or real, for r_max_value.
     * @note Call the appropriate eliminate* method before calling this method.
     */
    public function largest(CDiagonalDirection $dd, $row, &$r_max_pos, &$r_max_value)
    {
        // The x position for the start of the collection containing
        // the current max.
        $max_pos=null;
        $max_value=null;
        $limit=null;
        if ($dd->isHORIZONTAL())
        {
            $limit = $this->m_x_max-$this->m_collection_size;
        }
        if ($dd->isVERTICAL())
        {
            $limit = $this->m_y_max-$this->m_collection_size;
        }
        if ($dd->isHorizontal())
        {
            for ($x=0; $x<=$limit; $x++)
            {
                $candidate_pos = $this->m_hcollections[$row][$x];
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
        }
        if ($dd->isVERTICAL())
        {
            for ($y=0; $y<=$limit; $y++)
            {
                $candidate_pos = $this->m_vcollections[$y][$row];
                if ($candidate_pos == $this->NOT_A_CANDIDATE())
                {
                    continue;
                }
                $current_value = $this->m_gdata[$y][$row] * $this->m_gdata[$y+1][$row] * $this->m_gdata[$y+2][$row] * $this->m_gdata[$y+3][$row];
                if ($max_value == null)
                {
                    $max_pos = $y;
                    $max_value = $current_value;
                }
                else
                {
                    if ($current_value>$max_value)
                    {
                        $max_pos = $y;
                        $max_value = $current_value;
                    }
                }
            }           
        }
        $r_max_pos = $max_pos;
        $r_max_value = $max_value;
        return 1; // Success
    }
    /**
     * Find the largest collection in a single diagonal, whose orientation
     * is '\'.  If the size of the diagonal is less than m_collection_size,
     * then all reference parameters (read as OUT) will be set to null.
     * These include y_max, x_max, max_value.
     * @param int $y_d Between 0 and (m_y_max - m_collection_size).  It re-
     * presents the y value of the start of the diagonal.
     * @param int $x_d Between 0 and (m_x_max - m_collection_size).  It re-
     * presents the x value of the start of the diagonal.
     * @param int $y_max y (vertical) coordinate of diagonal collection
     * containing max value.
     * @param int $x_max x (horizontal) coordinate of diagonal collection
     * containing max value.
     * @param type $max_value @todo Is it float or real?
     * @throws Exception In the event of invalid $y, $x.
     */
    public function largestOneDiagonal($y_d, $x_d, &$y_max, &$x_max, &$max_value)
    {
        if (($x_d>0) && ($y_d != 0))
        {
            throw new Exception('Need to specify starting element on left-top');
        }
        if (($y_d>0) && ($x_d != 0))
        {
            throw new Exception('Need to specify starting element on left-top');
        }
        $max_ypos=null;
        $max_xpos=null;
        $current_max=null;
        for (
            $x=$x_d, $y = $y_d; 
            ($x<=($this->m_x_max-$this->m_collection_size)) &&
            ($y<=($this->m_y_max-$this->m_collection_size));
            $x++, $y++)
        {
            $candidate_pos = $this->m_dcollections[$y][$x];
            if ($candidate_pos == $this->NOT_A_CANDIDATE())
            {
                continue;
            }
            $current_value = $this->m_gdata[$y][$x] * $this->m_gdata[$y+1][$x+1] * $this->m_gdata[$y+2][$x+2] * $this->m_gdata[$y+3][$x+3];
            if ($max_value == null)
            {
                $max_ypos = $y;
                $max_xpos = $x;
                $current_max = $current_value;
            }
            else
            {
                if ($current_value>$current_max)
                {
                    $max_ypos = $y;
                    $max_xpos = $x;
                    $current_max = $current_value;
                }
            }
        }
        $y_max = $max_ypos;
        $x_max = $max_xpos;
        $max_value = $current_max;
    }
    /**
     * Computes the largest value considering only the complete
     * set of horizontal rows.
     */
    public function largestHorizontal(&$y, &$x, &$value)
    {
        $y_max=null;
        $x_max=null;
        $largest=null;
        for ($y=0; $y<$this->m_y_max; $y++)
        {
            $max_value = null;
            $max_pos = null;
            // $ddObj = new CDiagonalDirection();
            // $ddObj->HORIZONTAL();
            $ret_l = $this->largest(CDiagonalDirection::H(), $y, $max_pos, $max_value);
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
        $y = $y_max;
        $x = $x_max;
        $value = $largest;
        return 1; // success
    }
    
    /**
     * Computes the largest value considering only the complete
     * set of vertical rows.
     */
    public function largestVertical(&$y, &$x, &$value)
    {
        $y_max=null;
        $x_max=null;
        $largest=null;
        for ($x=0; $x<$this->m_x_max; $x++)
        {
            $max_value = null;
            $max_pos = null;
            $ret_l = $this->largest(CDiagonalDirection::V(), $x, $max_pos, $max_value);
            if ($x == 0)
            {
                $y_max = $max_pos;
                $x_max = 0;
                $largest = $max_value;
            }
            else
            {
                if ($max_value > $largest)
                {
                    $largest = $max_value;
                    $y_max = $max_pos;
                    $x_max = $x;
                }
            }
        }
        $y = $y_max;
        $x = $x_max;
        $value = $largest;
        return 1; // success        
    }
    
    public function getHCollections()
    {
        return $this->m_hcollections;
    }
    public function getVCollections()
    {
        return $this->m_vcollections;
    }
    public function getD3_1Collections()
    {
        return $this->m_3_1_dcollections;
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
