<?php
/**
 * All test suite
 *
 * PHP Version 5
 *
 * @package    Math_Numerical_RootFinding
 * @subpackage UnitTests
 * @link	   http://pear.php.net/package/Math_Numerical_RootFinding
 * @version    CVS: $Id$
 * @since      File available since Release 1.1.0a1
 */
if (!defined('PHPUnit_MAIN_METHOD')) {
	define('PHPUnit_MAIN_METHOD', 'PEAR_Size_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

require_once 'GeneralTest.php';
require_once 'Method/BisectionTest.php';
require_once 'Method/FalsePositionTest.php';
require_once 'Method/FixedPointTest.php';
require_once 'Method/NewtonRaphsonTest.php';
require_once 'Method/NewtonRaphson2Test.php';
require_once 'Method/RalstonRabinowitzTest.php';
require_once 'Method/SecantTest.php';

class Math_Numerical_RootFinding_AllTests
{
	public static function main()
	{
		PHPUnit_TextUI_TestRunner::run(self::suite());
	}

	public static function suite()
	{
		$suite = new PHPUnit_Framework_TestSuite('Math_Numerical_RootFinding All Tests');
		$suite->addTestSuite('Math_Numerical_RootFinding_GeneralTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_BisectionTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_FalsePositionTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_FixedPointTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_NewtonRaphsonTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_NewtonRaphson2Test');
		$suite->addTestSuite('Math_Numerical_RootFinding_RalstonRabinowitzTest');
		$suite->addTestSuite('Math_Numerical_RootFinding_SecantTest');

		return $suite;
	}
}

if (PHPUnit_MAIN_METHOD == 'Math_Numerical_RootFinding_AllTests::main') {
	Math_Numerical_RootFinding_AllTests::main();
}