<?php
/**
 * Newton-Raphson test case
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
	define('PHPUnit_MAIN_METHOD', 'Math_Numerical_RootFinding_NewtonRaphsonTest::main');
}

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'Math/Numerical/RootFinding.php';

class Math_Numerical_RootFinding_NewtonRaphsonTest extends PHPUnit_Framework_TestCase
{
	/**
	 * Runs the test methods of this class.
	 *
	 * @return void
	 */
	public static function main()
	{
		include_once 'PHPUnit/TextUI/TestRunner.php';

		$suite = new PHPUnit_Framework_TestSuite('Math_Numerical_RootFinding NewtonRaphson Test');
		PHPUnit_TextUI_TestRunner::run($suite);
	}


	public function testCompute()
	{
		$o = Math_Numerical_RootFinding::factory('NewtonRaphson');
		$res = $o->compute(array(get_class($this), 'Fx'), array(get_class($this), 'Dx'), 0);
		if (PEAR::isError($res)) {
			$this->fail('Error has returned from compute(): ' . $res->getMessage());
		}

		$exact_root = 0.56714329;

		$this->assertLessThanOrEqual($o->get('max_iteration'), $o->getIterationCount(), 'Invalid iteration count');
		$this->assertLessThanOrEqual($o->get('err_tolerance'), $o->getEpsError());
		$this->assertGreaterThanOrEqual($exact_root - $o->get('err_tolerance'), $o->getRoot());
		$this->assertLessThanOrEqual($exact_root + $o->get('err_tolerance'), $o->getRoot());
	}

	public static function Fx($x)
	{
		return pow(M_E, -$x) - $x;
	}
	
	public static function Dx($x)
	{
		return -pow(M_E, -$x) - 1;
	}
}
?>