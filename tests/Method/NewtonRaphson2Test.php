<?php
/**
 * Newton-Raphson 2 test case
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
	define('PHPUnit_MAIN_METHOD', 'Math_Numerical_RootFinding_NewtonRaphson2Test::main');
}

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'Math/Numerical/RootFinding.php';

class Math_Numerical_RootFinding_NewtonRaphson2Test extends PHPUnit_Framework_TestCase
{
	/**
	 * Runs the test methods of this class.
	 *
	 * @return void
	 */
	public static function main()
	{
		include_once 'PHPUnit/TextUI/TestRunner.php';

		$suite = new PHPUnit_Framework_TestSuite('Math_Numerical_RootFinding NewtonRaphson2 Test');
		PHPUnit_TextUI_TestRunner::run($suite);
	}


	public function testCompute()
	{
		$o = Math_Numerical_RootFinding::factory('NewtonRaphson2');
		$res = $o->compute(array(get_class($this), 'Fx'), array(get_class($this), 'D1x'), array(get_class($this), 'D2x'), 0);
		if (PEAR::isError($res)) {
			$this->fail('Error has returned from compute(): ' . $res->getMessage());
		}

		$exact_root = 1;

		$this->assertLessThanOrEqual($o->get('max_iteration'), $o->getIterationCount(), 'Invalid iteration count');
		$this->assertLessThanOrEqual($o->get('err_tolerance'), $o->getEpsError());
		$this->assertGreaterThanOrEqual($exact_root - $o->get('err_tolerance'), $o->getRoot());
		$this->assertLessThanOrEqual($exact_root + $o->get('err_tolerance'), $o->getRoot());
	}

	public static function Fx($x)
	{
		return pow($x, 3) - (5 * pow($x,2)) + (7 * $x) - 3;
	}

	public static function D1x($x)
	{
		return 3 * pow($x, 2) - (10 * $x) + 7;
	}

	public static function D2x($x)
	{
		return 6 * $x - 10;
	}
}
?>
