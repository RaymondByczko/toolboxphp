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
 * @change_history 2014-07-11 July 11; RByczko; Added eliminateVerticals.
 * Fixed eliminateHorizontals.
 * @change_history 2014-07-11 July 11; RByczko; Enhanced *collections
 * array extents due to the fact they are less in 1 or both dimensions
 * depending on what version of eliminate* is called.  Also added tests
 * in loadGrid method since mistakes can occur here easily.
 * @change_history 2014-07-14 July 14; RByczko; Changed name of
 * largestOneDiagonal to largestOneDiagonal2_4.
 * @change_history 2014-07-14 July 14; RByczko; Changed name of m_dcollections
 * to m_2_4_dcollections.
 * @change_history 2014-07-14 July 14; RByczko; Added documentation for
 * some variables.  Adjusted allocation for: m_2_4_dcollections.
 * Added methods: largestDiagonal2_4, getD2_4Collections. Fixed:
 * eliminateDiagonals2_4.
 */
class CGrid {
    /**
     *
     * @var int Size of grid along x.  Values of x run from 0 to (m_x_max-1).  
     */
    private $m_x_max=null;
    /**
     *
     * @var int Size of grid along y.  Value of y run from 0 to (m_y_max-1). 
     */
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
     * @note The *collections arrays are for storing candidacy information.
     * Its extent will be less in one (horizontal or vertical) or both
     * dimensions (diagonals) than the original data grid (via gdata in
     * loadGrid).
     */
    private $m_hcollections=null;
    private $m_vcollections=null;
    private $m_2_4_dcollections=null;
    private $m_3_1_dcollections=null;
    public function __construct($x_max, $y_max, $collection_size)
    {
        $this->m_x_max = $x_max;
        $this->m_y_max = $y_max;
        $this->m_collection_size = $collection_size;
        // Horizontal
        // @note nvc stands for 'number of valid collections'
        $nvc_h_x = $this->m_x_max - $collection_size + 1;
        $nvc_h_y = $this->m_y_max;
        if (($nvc_h_x>0) && ($nvc_h_y > 0))
        {
            $this->m_hcollections = array_fill(0, $nvc_h_y, array_fill(0, $nvc_h_x,$this->POSSIBLE_CANDIDATE));
        }
        // Vertical
        $nvc_v_x = $this->m_x_max;
        $nvc_v_y = $this->m_y_max - $collection_size + 1;
        if (($nvc_v_x>0) && ($nvc_v_y > 0))
        {       
            $this->m_vcollections = array_fill(0, $nvc_v_y, array_fill(0, $nvc_v_x,$this->POSSIBLE_CANDIDATE));
        }
        // Diagonal
        if ( ($this->m_y_max > $this->m_collection_size) &&
    ($this->m_x_max > $this->m_collection_size) )
        {
            $this->m_2_4_dcollections = array_fill(0, $this->m_y_max-$this->m_collection_size+1, array_fill(0, $this->m_x_max-$this->m_collection_size+1,$this->POSSIBLE_CANDIDATE));
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
            throw new Exception('gdata is not an array');
        }
        // The dimensions of gdata must line up with what is specified in CGrid
        // constructor.
        $y_size = count($gdata);
        if ($y_size != $this->m_y_max)
        {
            throw new Exception('gdata is not correct in y; y_size='.$y_size.', m_y_max='.$this->m_y_max);
        }
        foreach ($gdata as $key=>$egdata)
        {
            $egdata_size = count($egdata);
            if ($egdata_size != $this->m_x_max)
            {
                throw new Exception('gdata is not correct in x; egdata_size='.$egdata_size.', m_x_max='.$this->m_x_max.', key='.$key);
            }
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
                    // Properly id seconds as $x+1.
                    $this->m_hcollections[$y][$x+1] = $this->NOT_A_CANDIDATE;
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
     * Considers all columns 'vertically' positioned.
     * (column is determined by $x in code.)
     */
    public function eliminateVerticals()
    {
        // proceed along each column - I visualize this as proceeding
        // horizontally.
        for ($x=0; $x<$this->m_x_max; $x++)
        {
            // process columns in 1 row - I visualize this as proceeding
            // vertically.
            $numCollections = $this->m_y_max-$this->m_collection_size;
            for ($y=0; $y<$numCollections; $y++)
            {
                $first = $this->m_gdata[$y][$x];
                $second = $this->m_gdata[$y+$this->m_collection_size][$x];
                if ($first > $second)
                {
                    $this->m_vcollections[$y+1][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_vcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                    // or...
                    // Declare the first one as NOT A CANDIDATE.
                    $this->m_vcollections[$y][$x] = $this->NOT_A_CANDIDATE;
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
        $y_limit = $this->m_y_max - $cs -1;
        $x_limit = $this->m_x_max - $cs -1;
        for ($y=0; $y<=$y_limit; $y++)
        {
            for ($x=0; $x<=$x_limit; $x++)
            {
                $first = $this->m_gdata[$y][$x];
                $second = $this->m_gdata[$y+$cs][$x+$cs];    
                if ($first > $second)
                {
                    $this->m_2_4_dcollections[$y+1][$x+1] = $this->NOT_A_CANDIDATE;
                }
                if ($first < $second)
                {
                    $this->m_2_4_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
                }
                if ($first == $second)
                {
                    // Keep them both as possible candidate if already
                    // set as such.  Otherwise, also do nothing.
                    // or...
                    // Declare first as NOT A CANDIDATE
                    $this->m_2_4_dcollections[$y][$x] = $this->NOT_A_CANDIDATE;
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
    public function largestOneDiagonal2_4($y_d, $x_d, &$y_max, &$x_max, &$max_value)
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
            $candidate_pos = $this->m_2_4_dcollections[$y][$x];
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
    
    /**
     * Finds the largest product among the entire set of 2,4 diagonals.
     *
     * @param int $y 0 based index of y-coordinate of start of largest product.
     * @param int $x 0 based index of x-coordinate of start of largest product.
     * @param int(float) $value The value of that largest product.
     * @note $y is the first dimension.  It can be seen as running vertical.
     * @note $x is the second dimension.  It can be seen as running horizontal.
     * @note @todo possible 'fix' this convention.  Make sure to state it in
     * some central area.
     * @note The largest product is specified by the following operands:
     * ($y,$x), ($y+1,$x+1), ($y+2,$x+2), ($y+3,$x+3)
     */
    public function largestDiagonal2_4(&$y, &$x, &$value)
    {
        $y_largest = null;
        $x_largest = null;
        $largest = null;
        
        $x_limit = $this->m_x_max - $this->m_collection_size;
        $y_limit = $this->m_y_max - $this->m_collection_size;
        // Initialize largest to first product encountered
        if ( ($x_limit>=0)&&($y_limit>=0) )
        {
            $y_largest=0;
            $x_largest=0;
            $largest=$current_value = $this->m_gdata[0][0] * $this->m_gdata[1][1] * $this->m_gdata[2][2] * $this->m_gdata[3][3];
        }
        // Along 'side' with x constant as 0, and y varies.
        $x=0;
        for ($y=0; $y <= $y_limit; $y++)
        {
            $y_max = null;
            $x_max = null;
            $max_value = null;
            echo 'x='.$x.'; y='.$y."\n";
            $this->largestOneDiagonal2_4($y, $x, $y_max, $x_max, $max_value);
            if ($max_value > $largest)
            {
                $y_largest = $y_max;
                $x_largest = $x_max;
                $largest = $max_value;
            }

        }
        
        // Along 'top' with y constant and x varies.
        $y=0;
        for ($x=1; $x <= $x_limit; $x++)
        {
            $y_max = null;
            $x_max = null;
            $max_value = null;
            echo 'x='.$x.'; y='.$y."\n";
            $this->largestOneDiagonal2_4($y, $x, $y_max, $x_max, $max_value);
            if ($max_value > $largest)
            {
                $y_largest = $y_max;
                $x_largest = $x_max;
                $largest = $max_value;
            }

        }        
        $y = $y_largest;
        $x = $x_largest;
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
    public function getD2_4Collections()
    {
        return $this->m_2_4_dcollections;
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
