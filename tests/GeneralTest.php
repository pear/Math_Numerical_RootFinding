<?php
/**
 * General test case
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
	define('PHPUnit_MAIN_METHOD', 'Math_Numerical_RootFinding_GeneralTest::main');
}

require_once 'PHPUnit/Framework/TestCase.php';
require_once 'PHPUnit/Framework/TestSuite.php';

require_once 'Math/Numerical/RootFinding.php';

class Math_Numerical_RootFinding_GeneralTest extends PHPUnit_Framework_TestCase
{
    /**
     * Runs the test methods of this class.
     *
     * @return void
     */
    public static function main()
    {
        include_once "PHPUnit/TextUI/TestRunner.php";

        $suite = new PHPUnit_Framework_TestSuite('Math_Numerical_RootFinding General Test');
        PHPUnit_TextUI_TestRunner::run($suite);
    }

    public function testFactory()
    {
        $i = Math_Numerical_RootFinding::factory('Bisection');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_Bisection);

        $i = Math_Numerical_RootFinding::factory('FalsePosition');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_FalsePosition);

        $i = Math_Numerical_RootFinding::factory('FixedPoint');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_FixedPoint);

        $i = Math_Numerical_RootFinding::factory('NewtonRaphson');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_NewtonRaphson);

        $i = Math_Numerical_RootFinding::factory('NewtonRaphson2');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_NewtonRaphson2);

        $i = Math_Numerical_RootFinding::factory('RalstonRabinowitz');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_RalstonRabinowitz);

        $i = Math_Numerical_RootFinding::factory('Secant');
        $this->assertTrue($i instanceof Math_Numerical_RootFinding_Secant);
    }

    public function testSetOptions()
    {
        $options = array(
            'max_iteration'  => 20,
            'divergent_skip' => false
        );

        $o = Math_Numerical_RootFinding::factory('Bisection', $options);
        $this->assertTrue($o instanceof Math_Numerical_RootFinding_Bisection);
        
        $this->assertEquals($o->get('max_iteration'), $options['max_iteration']);
        $this->assertFalse($o->get('divergent_skip'));
    }
}
?>
