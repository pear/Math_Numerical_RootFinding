<?php
/**
 * Root Finding Method Comparison
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

// f(x) function
function fx($x) {
	return pow($x, 3) + $x - 1;
}

// g(x) function
function gx($x) {
    return 1 - pow($x, 3);
}

// df(x) function
function dfx($x) {
    return 3 * pow($x, 2) + 1;
}

// print result
function printResult($mtd, $eq, $itr, $root) {
    print "<b>Root Finding::$mtd</b><br />\n";
    print "<b>Case:</b><br />";
    print "$eq<br />\n";
    print "Iteration Count = $itr<br />\n";
    print "Root = $root<br /><br />\n";
}

$equations = array(
    // f(x) = x^3 + x - 1
    'Fx' => 'f(x) = x<sup>3</sup> + x - 1',
    // g(x) = 1 - x^3
    'Gx' => 'g(x) = 1 - x<sup>3</sup>',
    // df(x) = 3x^2 + 1
    'DFx' => 'f\'(x) = 3x<sup>2</sup> + 1'
);

$mroot = new Math_Numerical_RootFinding();

// Bisection Method
$err = $mroot->bisection('fx', 1, 0.5);
if (PEAR::isError($err)) {
    print $err->toString();
    die;
}

printResult('Bisection', $equations['Fx'], $mroot->getIterationCount(),
            $mroot->getRoot());

// False Position Method
$err = $mroot->falsePosition('fx', 1, 2);
if (PEAR::isError($err)) {
    print $err->toString();
    die;
}

printResult('False Position', $equations['Fx'], $mroot->getIterationCount(),
            $mroot->getRoot());

// Fixed Point Method
$err = $mroot->fixedPoint('gx', 1);
if (PEAR::isError($err)) {
    print $err->toString();
    die;
}

printResult('Fixed Point', $equations['Gx'], $mroot->getIterationCount(),
            $mroot->getRoot());


// Netwon-Raphson Method
$err = $mroot->newtonRaphson('fx', 'dfx', 1);
if (PEAR::isError($err)) {
    print $err->toString();
    die;
}

printResult('Newton-Raphson', $equations['Fx'] . ', ' .$equations['DFx'],
            $mroot->getIterationCount(), $mroot->getRoot());

// Secant Method
$err = $mroot->secant('fx', 1, 2);
if (PEAR::isError($err)) {
    print $err->toString();
    die;
}

printResult('Secant', $equations['Fx'], $mroot->getIterationCount(),
            $mroot->getRoot());

?>
