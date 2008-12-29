<?php
/**
 * File contains abstract class Math_Numerical_RootFinding_Common for all method
 * classes.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 * Copyright (c) 2008 Firman Wandayandi <firman@php.net>
 *
 * This source file is subject to the BSD License license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/bsd-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to pear-dev@list.php.net so we can send you a copy immediately.
 *
 * @category   Math
 * @package    Math_Numerical_RootFinding
 * @subpackage Methods
 * @author     Firman Wandayandi <firman@php.net>
 * @copyright  2004-2008 Firman Wandayandi
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    CVS: $Id$
 */

/**
 * PEAR
 */
require_once 'PEAR.php';

/**
 * Abstract class contains common properties and methods for specified method
 * classes.
 *
 * @category   Math
 * @package    Math_Numerical_RootFinding
 * @subpackage Methods
 * @author     Firman Wandayandi <firman@php.net>
 * @copyright  2004-2008 Firman Wandayandi
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: @package_version@
 * @abstract
 */
class Math_Numerical_RootFinding_Common
{
    // {{{ Properties

    /**
     * Options.
     * Available options:
     * <pre>
     *  max_iteration  int   Maximum iteration count.
     *  err_tolerance  float Error tolerance.
     *  divergent_skip bool  Flag whether to skip the current iteration if divergent
     *                       rows detected or not.
     * </pre>
     *
     * @var array
     * @access protected
     */
    var $options = array(
        'max_iteration'  => 30,
        'err_tolerance'  => 0.00001, // Equals to 1.0E-5
        'divergent_skip' => true
    );

    /**
     * Iteration count.
     *
     * @var int
     * @access protected
     */
    var $iterationCount = 0;

    /**
     * Epsilon error.
     *
     * @var float
     * @access protected
     */
    var $epsError = 0;

    /**
     * Root value.
     *
     * @var float
     * @access protected
     */
    var $root = null;

    // }}}
    // {{{ Constructor

    /**
     * Constructor.
     *
     * @param array $options (optional) Options.
     *
     * @access public
     * @see    set()
     */
    function Math_Numerical_RootFinding_Common($options = null)
    {
        if ($options !== null) {
            $this->set($options);
        }
    }

    // }}}
    // {{{ set()

    /**
     * Set the option(s).
     *
     * Set a single option or multiple options.
     *
     * @param mixed $option           A string with option name as value for  single
     *                                option or an associative array contains
     *                                options. array('<option>' => <value>) for
     *                                multiple options.
     * @param mixed $value (optional) Option value. Require when $option is string
     *                                (single option mode).
     *
     * @return bool|PEAR_Error TRUE on success or PEAR_Error on failure.
     * @access public
     */
    function set($option, $value = null)
    {
        if (!is_array($option) && !is_string($option)) {
            return PEAR::raiseError('Type mismatch for $option argument');
        }

        if (is_array($option)) {
            foreach ($option as $key => $val) {
                $err = $this->set($key, $val);
                if (PEAR::isError($err)) {
                    return $err;
                }
            }
        } elseif (is_string($option)) {
            if (isset($this->options[$option])) {
                if (!isset($value)) {
                    return PEAR::raiseError('No value given for option ' .
                                            '\'' . $option . '\'');
                }

                // Attempt to casting variable type.
                settype($value, gettype($this->options[$option]));
                $this->options[$option] = $value;
            } else {
                return PEAR::raiseError('Unknown option \'' . $option . '\'');
            }
        }
    }

    // }}}
    // {{{ get()

    /**
     * Get the option value.
     *
     * @param $option Option name.
     *
     * @return mixed Value of the option or PEAR_Error on failure.
     * @since Method available since Release 1.1.0a1
     */
    function get($option)
    {
        if (!array_key_exists($option, $this->options)) {
            return PEAR::raiseError('Unknown option \'' . $option . '\'');
        }

        return $this->options[$option];
    }

    // }}}
    // {{{ compute()

    /**
     * Compute the root.
     *
     * This method implemented in the extend class of this class.
     * Please Note: DIFFERENT METHOD, DIFFERENT PARAMETERS.
     *              See the function parameter carefully or error will be
     *              throwed. For information about parameter just call
     *              infoCompute().
     *
     * @abstract()
     */
    function compute()
    {
        return PEAR::raiseError('This function not implemented');
    }

    // }}}
    // {{{ getRoot()

    /**
     * Get root value.
     *
     * @return float Root value.
     * @access public
     */
    function getRoot()
    {
        return $this->root;
    }

    // }}}
    // {{{ getIterationCount()

    /**
     * Get iteration count.
     *
     * @return int Iteration count.
     * @access public
     */
    function getIterationCount()
    {
        return $this->iterationCount;
    }

    // }}}
    // {{{ getEpsError()

    /**
     * Get epsilon error.
     *
     * @return float Epsilon error.
     * @access public
     */
    function getEpsError()
    {
        return $this->epsError;
    }

    // }}}
    // {{{ isDivergentRows()

    /**
     * Detect for divergent rows.
     *
     * Compare 3 rows of last epsilon errors, if no.3 bigger than no.2 and no.2
     * bigger than no.1, rows are divergent.
     *
     * @param array $epsilonErrors Epsilon errors collection
     *
     * @return bool TRUE if divergent, otherwise FALSE
     * @access public
     */
    function isDivergentRows($epsErrors)
    {
        $n = count($epsErrors);
        if ($n >= 3) {
            if ($epsErrors[$n - 1] > $epsErrors[$n - 2] &&
                $epsErrors[$n - 2] > $epsErrors[$n - 3])
            {
                return true;
            }
        }
        return false;
    }

    // }}}
    // {{{ reset()

    /**
     * Reset all values.
     *
     * This method allow you to use same object with different parameter.
     *
     * @access public
     */
    function reset()
    {
        $this->iterationCount = 0;
        $this->epsError = 0;
        $this->root = null;
    }

    // }}}
    // {{{ validateEqFunction()

    /**
     * Validate equation function or object/method.
     *
     * Simple function to know the whether equation function or object/method
     * callback is working.
     *
     * @param string $eqFunction       Equation function name or object method tuple.
     * @param float  $guess (optional) Initial guess value, default is 1.
     *
     * @return bool|PEAR_Error TRUE on success or PEAR_Error on failure.
     * @access public
     * @see getEqResult()
     * @static
     */
    function validateEqFunction($eqFunction, $guess = 1)
    {
        $err = Math_Numerical_RootFinding_Common::getEqResult($eqFunction, $guess);
        if(PEAR::isError($err)) {
            return $err;
        }
        return true;
    }

    // }}}
    // {{{ getEqResult()

    /**
     * Compute a value using given equation function or object/method.
     *
     * @param callback $eqFunction Equation function name or object method tuple.
     * @param float    $varValue   Variable value.
     *
     * @return float|PEAR_Error result value on success, PEAR_Error on failure.
     * @access public
     * @static
     */
    function getEqResult($eqFunction, $varValue)
    {
        if (is_callable($eqFunction, false, $callable_name)) {
            return call_user_func($eqFunction, $varValue);
        }

        return PEAR::raiseError('Unable call equation function or method ' .
                                '\'' . $callable_name . '()\'');
    }

    // }}}
}

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
