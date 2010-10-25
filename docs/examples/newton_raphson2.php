<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */

// $Id$

/**
 * Newton-Raphson 2 method usage example.
 *
 * @author Firman Wandayandi <firman@php.net>
 * @package Math_Numerical_RootFinding
 * @subpackage Examples
 */

/**
 * Math_Numerical_RootFinding class.
 */
require_once 'Math/Numerical/RootFinding.php';

/**
 * f(x) callback function.
 *
 * @param float $x Variable value.
 *
 * @return float
 * @ignore
 */
function fx($x)
{
    return pow($x, 3) - (5 * pow($x,2)) + (7 * $x) - 3;
}

/**
 * f'(x) callback function.
 *
 * @param float $x Variable value.
 *
 * @return float
 */
function d1x($x)
{
    return 3 * pow($x, 2) - (10 * $x) + 7;
}

/**
 * f''(x) callback function.
 *
 * @param float $x Variable value.
 *
 * @return float
 */
function d2x($x)
{
    return 6 * $x - 10;
}

// Create new instance of Math_Numerical_RootFinding_Newtonraphson2.
$mroot = Math_Numerical_RootFinding::factory('NewtonRaphson2');
if (PEAR::isError($mroot)) {
    die($mroot->toString());
}

// Calculate the root using Newton-Raphson 2 method.
$root = $mroot->compute('fx', 'd1x', 'd2x', 0);
if (PEAR::isError($root)) {
    die($root->toString());
}

print "<h1>Root Finding::Newton-Raphson 2 Method</h1>\n";
$mroot->infoCompute();

print "<h2>Case</h2>\n";
print "f(x) = x<sup>3</sup> - 5x<sup>2</sup> + 7x - 3<br />\n";
print "f'(x) = 3x<sup>2</sup> - 10x + 7<br />\n";
print "f''(x) = 6x - 10<br />\n";

print "<h3>Parameters</h3>\n";
print "<b>Initial guest</b> = 0<br />\n";
print "<b>True root</b> = 1<br />\n";

print "<h3>Result</h3>\n";
print sprintf("<b>Iteration count</b> = %d<br />\n", $mroot->getIterationCount());
print sprintf("<b>Root value</b> = %f<br />\n", $mroot->getRoot());
print sprintf("<b>Estimate error</b> = %f<br />\n", $mroot->getEpsError());

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
