<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

$classes = array();

foreach(get_declared_classes() as $class) {
	
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined() && $inspection->isNotDarterClass()) {
		$classes[] = $class;
	}
}

$overview = new Darter_View('overview');
$overview->classes = $classes;
$overview->display();

?>