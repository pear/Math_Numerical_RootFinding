<?php
/**
 * Fixed point method examples
 *
 * @author Firman Wandayandi <fwd@vfemail.net>
 * @package Math_Numerical_RootFinding
 * @category math
 * @license http://www.php.net/license/3_0.txt The PHP License, version 3.0
 */

/**
 * Math_Numerical_RootFinding class
 */
require_once 'Math/Numerical/RootFinding.php';

function gx($x) {
    return (pow($x, 2) - 1) / 3;
}

$mroot = new Math_Numerical_RootFinding();
$root = $mroot->fixedPoint('gx', -0.5);
if (PEAR::isError($root)) {
    print $root->toString();
    die;
}

print '<b>Root Finding::Fixed Point</b><br /><br />';
print '<b>Case:</b><br />';
print 'f(x) = x<sup>2</sup> - 3x + 1 => g(x) = (x<sup>2</sup> - 1) / 3<br />';
print 'x<sub>0</sub> = -0.5<br /><br />';
print '<b>Iteration Count</b> = ' . $mroot->getIterationCount() . '<br />';
print '<b>Root</b> = ' . $root;
?>
