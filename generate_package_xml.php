<?php
require_once('PEAR/PackageFileManager.php');

$pkg = new PEAR_PackageFileManager;

$packagedir = dirname(__FILE__);
$self = basename(__FILE__);
$category = 'Math';

$packagedesc =
'Math_Numerical_RootFinding is the package' . "\n" .
'provide various Numerical Methods Root-Finding' . "\n" .
'functions implemented in PHP, e.g Bisection,' . "\n" .
'Newton-Raphson, Fixed Point, Secant etc.' . "\n";

$packagenotes =
'- changed license into BSD License' . "\n" .
'- removed file \'Bracketing.php\'' . "\n" .
'- removed file \'Open.php\'' . "\n" .
'- introduce new abstract class' . "\n" .
'  Math_Numerical_RootFinding_Common' . "\n" .
'- renamed all method filenames to uppercase' . "\n" .
'  first letter' . "\n" .
'- fixed Bug #2897: Capitalization type in' . "\n" .
'  falseposition.php' . "\n" .
'- renamed all compute function names from' . "\n" .
'  method name e.g bisection() into compute()' . "\n" .
'- added new function infoCompute() to provide' . "\n" .
'  information about compute function arguments' . "\n" .
'- applied divergent testing into all methods' . "\n";

$options = array(
    'doctype'           => 'D:\Net\www\htdocs\PEAR\PEAR\data\PEAR\package.dtd',
    'package'           => 'Math_Numerical_RootFinding',
    'license'           => 'BSD License',
    'baseinstalldir'    => '',
    'version'           => '0.3.0',
    'packagedirectory'  => $packagedir,
    'pathtopackagefile' => $packagedir,
    'state'             => 'alpha',
    'filelistgenerator' => 'file',
    'notes'             => $packagenotes,
    'summary'           => 'Numerical Methods Root-Finding functions package',
    'description'       => $packagedesc,
    'ignore'            => array(
                            'package.xml',
                            '*.tgz',
                            $self
                           )
);

$e = $pkg->setOptions($options);
if (PEAR::isError($e)) {
    echo $e->getMessage();
    die;
}

// hack until they get their shit in line with docroot role
$pkg->addRole('tpl', 'php');
$pkg->addRole('png', 'php');
$pkg->addRole('gif', 'php');
$pkg->addRole('jpg', 'php');
$pkg->addRole('css', 'php');
$pkg->addRole('js', 'php');
$pkg->addRole('ini', 'php');
$pkg->addRole('inc', 'php');
$pkg->addRole('afm', 'php');
$pkg->addRole('pkg', 'doc');
$pkg->addRole('cls', 'doc');
$pkg->addRole('proc', 'doc');
$pkg->addRole('sh', 'script');
$pkg->addRole('txt', 'doc');

$pkg->addDependency('php', '4.2.0', 'ge', 'php');
$pkg->addMaintainer('firman', 'lead', 'Firman Wandayandi', 'firman@php.net');

$e = $pkg->writePackageFile();
if (PEAR::isError($e)) {
    echo $e->getMessage();
}
?>
