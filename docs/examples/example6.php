<?php
/**
 * Newton-Raphson method examples
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

function fx($x) {
	return pow($x, 4) - 3 * pow($x,2) - 7;
}

// f(x) derivation level 1
function dfx($x) {
    return 4 * pow($x, 3) - 6 * $x;
}


$mroot = new Math_Numerical_RootFinding();

$root = $mroot->newtonRaphson('fx', 'dfx', 3);
if (PEAR::isError($root)) {
    print $root->toString();
    die;
}

print '<b>Root Finding::Newton-Rapshon Method</b><br /><br />';
print '<b>Case:</b><br />';
print 'f(x) = x<sup>4</sup> - 3 x<sup>2</sup> - 7<br />';
print 'f\'(x) = 4x<sup>3</sup> - 6x</b><br />';
print 'x0 = 3<br /><br />';
print '<b>Iteration Count</b> = ' . $mroot->getIterationCount() . '<br />';
print '<b>Root</b> = ' . $root;
?>
