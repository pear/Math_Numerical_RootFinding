<?php
require_once('PEAR/PackageFileManager.php');

$pkg = new PEAR_PackageFileManager;

$packagedir = dirname(__FILE__);
$self = basename(__FILE__);
$category = 'Image';

$packagedesc = "This package provide various numerical analysis methods for find root\n" .
               "Available Methods:\n" .
               "- Bisection\n" .
               "- False Position\n" .
               "- Fixed Point\n" .
               "- Newton-Raphson\n" .
               "- Secant\n";

$packagenotes = "- Initial release of Math_Numerical_RootFinding\n" .
                "- Divergency testing only available for first 3 rows\n";

$options = array(
    'doctype'           => 'D:\Net\www\htdocs\PEAR\PEAR\data\PEAR\package.dtd',
    'package'           => 'Math_Numerical_RootFinding',
    'baseinstalldir'    => '',
    'version'           => '0.1.0',
    'packagedirectory'  => $packagedir,
    'pathtopackagefile' => $packagedir,
    'state'             => 'alpha',
    'filelistgenerator' => 'file',
    'notes'             => $packagenotes,
    'summary'           => 'Numerical analysis root finding methods package',
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

$pkg->addMaintainer('firman', 'lead', 'Firman Wandayandi', 'fwd@vfemail.net');

$e = $pkg->writePackageFile();
if (PEAR::isError($e)) {
    echo $e->getMessage();
}
?>
