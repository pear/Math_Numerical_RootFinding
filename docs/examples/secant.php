<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */

// $Id$

/**
 * Secant method usage example.
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
    return pow(M_E, -$x) - $x;
}

// Create new instance of Math_Numerical_RootFinding_Secant.
$mroot = Math_Numerical_RootFinding::factory('Secant');
if (PEAR::isError($mroot)) {
    die($mroot->toString());
}

// Calculate the root using Secant's method.
$root = $mroot->compute('fx', 0, 1);
if (PEAR::isError($root)) {
    die($root->toString());
}

print "<h1>Root Finding::Secant Method</h1>\n";
$mroot->infoCompute();

print "<h2>Case</h2>\n";
print "<b>Case:</b><br />\n";
print "f(x) = e<sup>-x</sup> - x<br />\n";

print "<h3>Parameters</h3>\n";
print "<b>First initial guest</b> = 0<br />\n";
print "<b>Second initial guest</b> = 1<br />\n";
print "<b>True root</b> = 0,56714329...<br />\n";

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
