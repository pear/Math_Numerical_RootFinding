<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2004 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 3.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.php.net/license/3_0.txt.                                  |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Firman Wandayandi <fwd@vfemail.net>                         |
// +----------------------------------------------------------------------+
//
// $Id$

/**
 * File contains RootFinding class
 *
 * @author Firman Wandayandi <fwd@vfemail.net>
 * @package Math_Numerical_RootFinding
 * @category math
 * @license http://www.php.net/license/3_0.txt The PHP License, version 3.0
 */

/**
 * Class for handling error
 */
require_once 'PEAR.php';

/**
 * This class provide common numerical analysis root finding methods calculation.
 *
 * @author Firman Wandayandi <fwd@vfemail.net>
 * @package Math_Numerical_RootFinding
 * @example docs/examples/example1.php
 * @example docs/examples/example2.php
 * @example docs/examples/example3.php
 * @example docs/examples/example4.php
 * @example docs/examples/example5.php
 * @example docs/examples/example6.php
 * @example docs/examples/comparison.php
 */
class Math_Numerical_RootFinding {
    // {{{ properties
    /**
     * Options for this object
     *
     * @var array
     * @access public
     */
    var $options = array(
            'maxIteration'    => 30,
            'stopOnDivergent' => true,
            'tolerance'       => 1E-005
    );

    /**
     * Roots collection during iteration
     *
     * @var array
     * @access private
     */
    var $_rootList = array();
    
    /**
     * Iteration count
     *
     * @var int
     * @access private
     */
    var $_iterationCount = 0;
    
    /**
     * Root value
     *
     * @var float
     * @access private
     */
    var $_root = null;

    // }}}
    // {{{ Math_Numerical_RootFinding()

    /**
     * Constructor
     *
     * @param array $options optional Options
     * known options:
     * <pre>
     *      maxIteration    int    Number of maximum iteration
     *      stopOnDivergen  bool   Flag to tell the whether to stop iteration if
     *                             divergent row detected
     *      tolerance       float  Error tolerance
     * </pre>
     *
     * @access public
     */
    function Math_Numerical_RootFinding($options = null) {
        if ($options !== null && is_array($options)) {
            $this->options = array_merge($this->options, $options);
        }
    }

    // }}}
    // {{{ set()

    /**
     * Set the option(s)
     *
     * Set a single or multiple options
     *
     * @param mixed $option A single option name or the options array
     * @param mixed $value Option value if $option is string
     *
     * @return bool|PEAR_Error TRUE on success, PEAR_Error on failure
     * @access public
     */
    function set($option, $value = null) {
        if (is_array($option)) {
            foreach ($option as $key => $value) {
                if (isset($this->options[$key])) {
                    $this->options[$key] = $value;
                }
            }
        } elseif (is_string($option) && isset($this->options[$option])) {
            if ($value == null) {
                return PEAR::raiseError('null value given');
            }
            $this->options[$option] = $value;
        }
    }
    
    // }}}
    // {{{ bisection()

    /**
     * Bisection method
     *
     * @param string $fx_func f(x) equation function or object/method tuple
     * @param float $a First initial guest
     * @param float $b Second initial guest
     *
     * @return float|PEAR_Error root value on success, PEAR_Error on failure
     * @access public
     */
    function bisection($fx_func, $a, $b) {
        // evaluate equation function before begin anything
        $eval = $this->_evalEquationFunc($fx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        // inilitialize some variables
        $maxIteration = $this->options['maxIteration'];
        $tolerance = $this->options['tolerance'];
        $i =& $this->_iterationCount;
        $approx = ($a + $b) / 2;

        for ($i = 1; $i <= $maxIteration; $i++) {
            // calculate f(x), which x = a, x = b and x = approx
            $fa = $this->_getEquationResult($fx_func, $a);
            $fb = $this->_getEquationResult($fx_func, $b);
            $fi = $this->_getEquationResult($fx_func, $approx);
            
            if ($fa * $fi > 0) { // root is at first sub-interval
                $a = $approx;
            } else { // root is at second sub-interval
                $b = $approx;
            }
            
            // save approximation for compute error later
            $approxPrev = $approx;
            
            // compute new approximation
            $approx = ($a + $b) / 2;
            
            // compute epsilons error
            $eps = abs(($approxPrev - $approx) / $approx);

            if ($eps <= $tolerance || $fi == 0) {   // compute pi
                $this->_root = $approx;
                break;
            }
        }

        return $this->_root;
    }

    // }}}
    // {{{ falsePosition()

    /**
     * False Position method
     *
     * @param string $fx_func f(x) equation function or object/method tuple
     * @param float $a First initial guest
     * @param float $b Second initial guest
     *
     * @return float|PEAR_Error root value on success, PEAR_Error on failure
     * @access public
     */
    function falsePosition($fx_func, $a, $b) {
        // evaluate equation function before begin anything
        $eval = $this->_evalEquationFunc($fx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        $maxIteration = $this->options['maxIteration'];
        $tolerance = $this->options['tolerance'];
        $i =& $this->_iterationCount;

        // calculate f(x), which x = a and x = b, for first approximation
        $fa = $this->_getEquationResult($fx_func, $a);
        $fb = $this->_getEquationResult($fx_func, $b);

        if ($fb - $fa == 0) {
            return PEAR::raiseError('iteration skipped, division by zero');
        }

        $approx = $approx = (($a * $fb) - ($b * $fa)) / $fb - $fa;

        for ($i = 1; $i <= $maxIteration; $i++) {
            // calculate f(x), which x = a and x = b
            $fa = $this->_getEquationResult($fx_func, $a);
            $fb = $this->_getEquationResult($fx_func, $b);
            $fi = $this->_getEquationResult($fx_func, $approx);

            $c = $fb - $fa;

            // avoid division by zero
            if ($c == 0) {
                return PEAR::raiseError('iteration skipped, division by zero');
            }

            if ($fa * $fi > 0) { // root is at first sub-interval
                $a = $approx;
            } else { // root is at second sub-interval
                $b = $approx;
            }

            // save approximation for compute error later
            $approxPrev = $approx;

            // compute current approximation
            $approx = (($a * $fb) - ($b * $fa)) / $c;

            // compute epsilons error
            $eps = abs(($approxPrev - $approx) / $approx);

            if ($eps <= $tolerance || $fi == 0) {   // compute pi
                $this->_root = $approx;
                break;
            }
        }

        return $this->_root;
    }

    // }}}
    // {{{ fixedPoint()

    /**
     * Fixed Point method.
     *
     * @param string $gx_func g(x) equation function or object/method tuple,
     *                        which g(x)=x
     * @param float $x0 Initial guess
     *
     * @return float|PEAR_Error root value on success, PEAR_Error on failure
     * @access public
     */
    function fixedPoint($gx_func, $x0) {
        // evaluate equation function before begin anything
        $eval = $this->_evalEquationFunc($gx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        $maxIteration = $this->options['maxIteration'];
        $tolerance = $this->options['tolerance'];
        $i =& $this->_iterationCount;

        $epsilonErrors = array();
        $this->_rootList[0] = $x0;

        for($i = 1; $i <= $maxIteration; $i++) {
            $gi = $this->_getEquationResult($gx_func, $this->_rootList[$i-1]);
            
            if ($gi == 0) {
                return $this->_rootList[$i - 1];
            }

            $this->_rootList[$i] = $gi;

            // compute error
            $epsilonErrors[$i] = abs($this->_rootList[$i] - $this->_rootList[$i - 1]);

            if ($i == 3) {
                // detect for divergent rows
                if (Math_Numerical_RootFinding::isDivergentRow($epsilonErrors) &&
                    $this->options['stopOnDivergent'])
                {
                    return PEAR::raiseError('iteration skipped, divergent rows detected');
                    break;
                } elseif ($epsilonErrors[$i] <= $tolerance) {
                    $this->_root = $this->_rootList[$i];
                    break;
                }
            } elseif ($epsilonErrors[$i] <= $tolerance) {
                $this->_root = $this->_rootList[$i];
                break;
            }
        }

        return $this->_root;
    }

    // }}}
    // {{{ newtonRaphson()
        
    /**
     * Netwon-Raphson method
     *
     * @param string $fx_func f(x) equation function or object/method tuple
     * @param string $dfx_func f'(x) equation function or object/method tuple
     * @param float $x0 Initial guess
     *
     * @return float|PEAR_Error root value on success, PEAR_Error on failure
     * @access public
     */
    function newtonRaphson($fx_func, $dfx_func, $x0) {
        // evaluate f(x) equation function before begin anything
        $eval = $this->_evalEquationFunc($fx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        // evaluate df(x) equation function before begin anything
        $eval = $this->_evalEquationFunc($dfx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        $maxIteration = $this->options['maxIteration'];
        $tolerance = $this->options['tolerance'];
        $i =& $this->_iterationCount;

        $epsilonErrors = array();
        $this->_rootList[0] = $x0;

        for ($i = 1; $i < $maxIteration; $i++) {
            $fi = $this->_getEquationResult($fx_func, $this->_rootList[$i - 1]);
            $di = $this->_getEquationResult($dfx_func, $this->_rootList[$i - 1]);

            // avoid division by zero
            if ($di == 0) {
                return PEAR::raiseError('iteration skipped, division by zero');
            }

            // newton-raphson's formula
            $this->_rootList[$i] = $this->_rootList[$i - 1] - ($fi / $di);

            // compute error
            $epsilonErrors[$i] = abs($this->_rootList[$i] - $this->_rootList[$i - 1]);

            if ($i == 3) {
                // detect for divergent rows
                if (Math_Numerical_RootFinding::isDivergentRow($epsilonErrors) &&
                    $this->options['stopOnDivergent'])
                {
                    return PEAR::raiseError('iteration skipped, divergent rows detected');
                    break;
                } elseif ($epsilonErrors[$i] <= $tolerance) {
                    $this->_root = $this->_rootList[$i];
                    break;
                }
            } elseif ($epsilonErrors[$i] <= $tolerance) {
                $this->_root = $this->_rootList[$i];
                break;
            }
        }

        return $this->_root;
    }

    // }}}
    // {{{ secant()

    /**
     * Secant method
     *
     * @param string $fx_func f(x) equation function or object/method tuple
     * @param float $x0 First initial guest
     * @param float $x1 Second initial guest
     *
     * @return float|PEAR_Error root value on success, PEAR_Error on failure
     * @access public
     */
    function secant($fx_func, $x0, $x1) {
         // evaluate equation function before begin anything
        $eval = $this->_evalEquationFunc($fx_func);
        if (PEAR::isError($eval)) {
            return $eval;
        }

        // initialize some variables
        $maxIteration = $this->options['maxIteration'];
        $tolerance = $this->options['tolerance'];
        $i =& $this->_iterationCount;
        $epsilonErrors = array();
        $x = array();
        $x[0] = $x0;
        $x[1] = $x1;

        for($i = 1; $i <= $maxIteration; $i++) {
            $fx = $this->_getEquationResult($fx_func, $x[$i]);
            $fx_ = $this->_getEquationResult($fx_func, $x[$i - 1]);

            if ($fx - $fx_ == 0) {
                return PEAR::raiseError('iteration skipped division by zero');
            }

            // secant's formula
            $x[$i + 1] = $x[$i] - (($x[$i] - $x[$i - 1]) / ($fx - $fx_)) * $fx;

            $epsilonErrors[$i] = abs($x[$i] - $x[$i - 1]);

            if ($i == 3) {
                // detect for divergent rows
                if (Math_Numerical_RootFinding::isDivergentRow($epsilonErrors) &&
                    $this->options['stopOnDivergent'])
                {
                    return PEAR::raiseError('iteration skipped, divergent row sdetected');
                    break;
                } elseif ($epsilonErrors[$i] <= $tolerance) {
                    $this->_root = $x[$i];
                    break;
                }
            } elseif ($epsilonErrors[$i] <= $tolerance) {
                $this->_root = $x[$i];
                break;
            }
        }

        return $this->_root;
    }

    // }}}
    // {{{ isDivergentRow()

    /**
     * Detect for divergent row
     *
     * @param array $epsilonErrors Epsilon errors collection
     *
     * @return bool TRUE if divergent, otherwise FALSE
     * @access public
     */
    function isDivergentRow($epsilonErrors) {
        if (count($epsilonErrors) >= 3 &&
            ($epsilonErrors[3] > $epsilonErrors[2]) &&
            ($epsilonErrors[2] > $epsilonErrors[1]))
        {
            return true;
        }
        return false;
    }

    // }}}
    // {{{ getIterationCount()

    /**
     * Get iteration count number
     *
     * @return int Iteration count number
     * @access public
     */
    function getIterationCount() {
        return $this->_iterationCount;
    }

    // }}}
    // {{{ getRoot()

    /**
     * Get root value
     *
     * Alias of root finding method functions
     *
     * @return float Root value
     * @access public
     */
    function getRoot() {
        return $this->_root;
    }

    // }}}
    // {{{ getRootList()

    /**
     * Get all roots found during iteration
     *
     * @return array Root iteration
     * @access public
     */
    function getRootList() {
        return $this->_rootList;
    }

    // }}}
    // {{{ _evalEquationFunc()

    /**
     * Evalute equation function or object/method
     *
     * Simple function to know the whether equation function or object/method
     * is working
     *
     * @param string $eqfunction Equation functio6n name or object method tuple
     *
     * @return bool|PEAR_Error TRUE on success, PEAR_Error on failure
     * @access private
     */
    function _evalEquationFunc($eq_func) {
        $err = $this->_getEquationResult($eq_func, 1);
        if(PEAR::isError($err)) {
            return $err;
        }
        return true;
    }

    // }}}
    // {{{ _getEquationResult()

    /**
     * Compute a value using given equation function or object/method
     *
     * @param float $eq_func Equation function name or object method tuple
     * @param float $x Variable value
     *
     * @return float|PEAR_Error result value on success, PEAR_Error on failure
     * @access private
     */
    function _getEquationResult($eq_func, $x) {
        if (is_string($eq_func) && strlen($eq_func) && function_exists($eq_func)) {
            return call_user_func($eq_func, $x);
        } elseif (is_array($eq_func) &&
                  count($eq_func) == 2 &&
                  is_object($eq_func[0]) &&
                  is_string($eq_func[1]) &&
                  strlen($eq_func[1]) && 
                  method_exists($eq_func[0], $eq_func[1]))
        {
            return call_user_func($eq_func, $x);
        }

        return PEAR::raiseError('unable call equation function or method');
    }

    // }}}
}

?>
