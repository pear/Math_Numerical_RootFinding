<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */
// {{{ Header
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// }}}
// $Id$

/**
 * Ralston and Rabinowitz method usage example.
 *
 * @author Firman Wandayandi <firman@php.net>
 * @package Math_Numerical_RootFinding
 * @subpackage Examples
 */

/**
 * Math_Numerical_RootFinding class
 */
require_once 'Math/Numerical/RootFinding.php';

/**
 * f(x) callback function
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
 * @ignore
 */
function dx($x)
{
    return 3 * pow($x, 2) - (10 * $x) + 7;
}

// Create new instance of Math_Numerical_RootFinding_Ralstonrabinowitz.
$mroot = Math_Numerical_RootFinding::factory('RalstonRabinowitz');
if (PEAR::isError($mroot)) {
    die($mroot->toString());
}

// Calculate the root using Ralston and Rabinowitz's method.
$root = $mroot->compute('fx', 'dx', 0, 4);
if (PEAR::isError($root)) {
    die($root->toString());
}

print "<h1>Root Finding::Ralston and Rabinowitz Method</h1><br />\n";
$mroot->infoCompute();

print "<h2>Case</h2>\n";
print "f(x) = x<sup>3</sup> - 5x<sup>2</sup> + 7x - 3<br />\n";
print "f'(x) = 3x<sup>2</sup> - 10x + 7<br />\n";

print "<h3>Parameters</h3>\n";
print "<b>First initial guest</b> (<u>\$xR0</u>) = 0<br />\n";
print "<b>Second initial guest</b> (<u>\$xR1</u>) = 4<br />\n";
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
