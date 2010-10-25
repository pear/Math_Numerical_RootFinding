<?php
/**
 * Driver file contains Math_Numerical_RootFinding_Bisection class to provide False
 * Position/Regula Falsi method root finding calculation.
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
 * @link       http://pear.php.net/package/Math_Numerical_RootFinding
 * @version    CVS: $Id$
 */

/**
 * Math_Numerical_RootFinding_Common
 */
require_once 'Math/Numerical/RootFinding/Common.php';

/**
 * False Position/Regula Falsi method class.
 *
 * @category   Math
 * @package    Math_Numerical_RootFinding
 * @subpackage Methods
 * @author     Firman Wandayandi <firman@php.net>
 * @copyright  2004-2008 Firman Wandayandi
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @link       http://pear.php.net/package/Math_Numerical_RootFinding
 * @version    Release: @package_version@
 */
class Math_Numerical_RootFinding_FalsePosition
extends Math_Numerical_RootFinding_Common
{
    // {{{ Constructor

    /**
     * Constructor.
     *
     * @param array $options (optional) Options.
     *
     * @access public
     * @see Math_Numerical_RootFinding_Common::Math_Numerical_RootFinding_Common()
     */
    function Math_Numerical_RootFinding_FalsePosition($options = null)
    {
        parent::Math_Numerical_RootFinding_Common($options);
    }

    // }}}
    // {{{ infoCompute()

    /**
     * Print out parameters description for compute() function.
     *
     * @access public
     * @return void
     */
    function infoCompute()
    {
        print "<h2>False Position::compute()</h2>\n" .

              "<em>float</em> | <em>PEAR_Error</em> ".
              "<strong>compute</strong>(<u>\$fxFunction</u>, <u>\$xL</u>, ".
              "<u>\$xU</u>)<br />\n" .

              "<h3>Description</h3>\n".

              "<em>callback</em> <u>\$fxFunction</u> Callback f(x) equation ".
              "function or object/method tuple.<br>\n" .

              "<em>float</em> <u>\$xL</u> Lower guess.<br>\n" .

              "<em>float</em> <u>\$xU</u> Upper guess.<br>\n";
    }

    // }}}
    // {{{ compute()

    /**
     * False Position/Regula Falsi method.
     *
     * @param callback $fxFunction Callback f(x) equation function or
     *                             object/method tuple.
     * @param float    $xL         Lower guess.
     * @param float    $xU         Upper guess.
     *
     * @return float|PEAR_Error Root value on success or PEAR_Error on failure.
     * @access public
     * @see Math_Numerical_RootFinding_Common::validateEqFunction()
     * @see Math_Numerical_RootFinding_Common::getEqResult()
     * @see Math_Numerical_RootFinding_Bisection::compute()
     */
    function compute($fxFunction, $xL, $xU)
    {
        // Validate f(x) equation function.
        $err = Math_Numerical_RootFinding_Common::validateEqFunction(
                 $fxFunction, $xL
               );
        if (PEAR::isError($err)) {
            return $err;
        }

        // Sets maximum iteration and tolerance from options.
        $maxIteration = $this->options['max_iteration'];
        $errTolerance = $this->options['err_tolerance'];

        // Calculate first approximation $xR (False Position's formula).
        $fxL = Math_Numerical_RootFinding_Common::getEqResult($fxFunction, $xL);
        $fxU = Math_Numerical_RootFinding_Common::getEqResult($fxFunction, $xU);
        if ($fxL - $fxU == 0) {
            return PEAR::raiseError('Iteration skipped, division by zero');
        }
        $xR = $xU - (($fxU * ($xL - $xU)) / ($fxL - $fxU));

        // Sets variable for saving errors during iteration, for divergent
        // detection.
        $epsErrors = array();

        for ($i = 0; $i < $maxIteration; $i++) {
            // Calculate f(xr), where: xr = $xR
            $fxR = Math_Numerical_RootFinding_Common::getEqResult($fxFunction, $xR);

            if ($fxL * $fxR < 0) { // Root is at first subinterval.
                $xU = $xR;
            } elseif ($fxL * $fxR > 0) { // Root is at second subinterval.
                $xL = $xR;
            } elseif ($fxL * $fxR == 0) { // $xR is the exact root.
                $this->root = $xR;
                break;
            }

            // Avoid division by zero.
            if ($fxL - $fxU == 0) {
                return PEAR::raiseError('Iteration skipped, division by zero');
            }

            // Compute new approximation.
            $xN = $xU - (($fxU * ($xL - $xU)) / ($fxL - $fxU));

            // Compute approximation error.
            $this->epsError = abs(($xN - $xR) / $xN);
            $epsErrors[]    = $this->epsError;

            // Detect for divergent rows.
            if ($this->isDivergentRows($epsErrors) &&
                $this->options['divergent_skip']) {
                return PEAR::raiseError(
                         'Iteration skipped, divergent rows detected'
                       );
                break;
            }

            // Check for error tolerance, if lower than or equal with
            // $errTolerance it is the root.
            if ($this->epsError <= $errTolerance) {
                $this->root = $xN;
                break;
            }

            // Calculate f(xl), where xl = $xL.
            $fxL = Math_Numerical_RootFinding_Common::getEqResult($fxFunction, $xL);
            // Calculate f(xu), where xu = $xU.
            $fxU = Math_Numerical_RootFinding_Common::getEqResult($fxFunction, $xU);

            // Switch xn -> xr, where xn = $xN and xr = $xR.
            $xR = $xN;
        }
        $this->iterationCount = $i;
        return $this->root;
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
