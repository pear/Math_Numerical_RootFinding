<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */
// {{{ Header
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// }}}
// $Id$

/**
 * Fixed Point method usage example.
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
 */
function gx($x)
{
    return pow(M_E, -$x);
}

// Create new instance of Math_Numerical_RootFinding_Fixedpoint.
$mroot = Math_Numerical_RootFinding::factory('fixedpoint');
if (PEAR::isError($mroot)) {
    die($mroot->toString());
}

// Calculate the root using Fixed Point's method.
$root = $mroot->compute('gx', 0);
if (PEAR::isError($root)) {
    die($root->toString());
}

print "<h1>Root Finding::Fixed Point Method</h1>\n";
$mroot->infoCompute();

print "<h2>Case</h2>\n";
print "f(x) = e<sup>-x</sup> - x<br />\n";
print "g(x) = e<sup>-x</sup><br />\n";

print "<h3>Parameters</h3>\n";
print "<b>Initial guest</b> = 0<br />\n";
print "<b>True root</b> = 0.56714329<br />\n";

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
