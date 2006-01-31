<?php
require_once('PEAR/PackageFileManager.php');
require_once 'PEAR/Config.php';

$pkg = new PEAR_PackageFileManager;
$config = new PEAR_Config;

$packagedir = dirname(__FILE__);

$desc = <<<EOT
Math_Numerical_RootFinding is the package
provide various Numerical Methods Root-Finding
functions implemented in PHP, e.g Bisection .
Newton-Raphson, Fixed Point, Secant etc
EOT;

$notes = <<<EOT
* Fixed method name capitol bug in Math_Numerical_RootFinding::factory(), thanks to Keith Palmer Jr.
* Now all method driver names are using insensitive-case alias
* Converted all header comment block into current coding standard
* Added Matthew Fonda as package co-lead
* This is first stable version release
EOT;

$options = array(
    'simpleoutput'      => true,
    'doctype'           => $config->get('data_dir') . '/PEAR/package.dtd',
    'package'           => 'Math_Numerical_RootFinding',
    'license'           => 'BSD License',
    'baseinstalldir'    => '',
    'version'           => '1.0.0',
    'packagedirectory'  => $packagedir,
    'pathtopackagefile' => $packagedir,
    'state'             => 'stable',
    'filelistgenerator' => 'cvs',
    'notes'             => $notes,
    'summary'           => 'Numerical Methods Root-Finding collection package',
    'description'       => $desc,
    'dir_roles'         => array(
        'docs'      => 'doc',
        'data'      => 'data'
    ),
    'ignore'            => array(
        'package.xml',
        '*.tgz',
        basename(__FILE__)
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
$pkg->addRole('txt', 'doc');
$pkg->addRole('sh', 'script');

$pkg->addMaintainer('firman', 'lead', 'Firman Wandayandi', 'firman@php.net');
$pkg->addMaintainer('mfonda', 'lead', 'Matthew Fonda', 'mfonda@php.net');

$pkg->addDependency('php', '4.2.0', 'ge', 'php');

$e = $pkg->addGlobalReplacement('package-info', '@package_version@', 'version');

$e = $pkg->writePackageFile();
if (PEAR::isError($e)) {
    echo $e->getMessage();
}
?>
