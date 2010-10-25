<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */
// $Id$

require_once 'PEAR/PackageFileManager2.php';
require_once 'PEAR/PackageFileManager/Cvs.php';

$pkg = new PEAR_PackageFileManager2;

$options = array(
    'simpleoutput'      => true,
    'baseinstalldir'    => '/',
    'packagedirectory'  => dirname(__FILE__),
    'pathtopackagefile' => basename(__FILE__),
    'filelistgenerator' => 'Cvs',
    'dir_roles'         => array(
        'tests'         => 'test',
        'docs'          => 'doc',
        'data'          => 'data'
    ),
    'ignore'            => array(
        'package.xml',
        'package2.xml',
        '*.tgz',
        basename(__FILE__)
    )
);

$pkg->setOptions($options);

$summary = <<<EOT
Numerical Root-Finding methods package in PHP
EOT;

$desc = <<<EOT
Math_Numerical_RootFinding is the package provide various number of Numerical
Root-Finding Methods functions implemented in PHP.
Supported methods:
1. Bisection/Binary Chopping/Interval Halving/Bolzano
2. False Position/Regula Falsi
3. Fixed Point
4. Netwon-Raphson
5. Netwon-Raphson 2
6. Ralston-Rabinowitz
7. Secant
EOT;

$notes = <<<EOT
* Request #2897: added new parameter \$guess to validateEqFunction()
* Added unit tests
* Examples files renamed to lower case
EOT;

// Some hard-coded stuffs.
$pkg->setPackage('Math_Numerical_RootFinding');
$pkg->setSummary($summary);
$pkg->setDescription($desc);
$pkg->setChannel('pear.php.net');
$pkg->setAPIVersion('1.0');
$pkg->setReleaseVersion('1.1.0a1');
$pkg->setReleaseStability('alpha');
$pkg->setAPIStability('alpha');
$pkg->setNotes($notes);
$pkg->setPackageType('php');
$pkg->setLicense('BSD License', 'http://www.opensource.org/licenses/bsd-license.php');

// Add maintainers.
$pkg->addMaintainer('lead', 'firman', 'Firman Wandayandi', 'firman@php.net', 'yes');
$pkg->addMaintainer('lead', 'mfonda', 'Matthew Fonda', 'mfonda@php.net', 'yes');

// Core dependencies.
$pkg->setPhpDep('4.3.0');
$pkg->setPearinstallerDep('1.4.0');

// Add some replacements.
$pkg->addGlobalReplacement('package-info', '@package_version@', 'version');

// Generate file contents.
$pkg->generateContents();

// Writes a package.xml.
$e = $pkg->writePackageFile();

// Some errors occurs.
if (PEAR::isError($e)) {
    throw new Exception('Unable to write package file. Got message: ' . $e->getMessage());
}

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>