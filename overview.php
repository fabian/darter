<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

$classes = array();
$tree = new Darter_TreeItemContainer();

foreach(get_declared_classes() as $class) {
	
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined() && $inspection->isNotDarterClass()) {
		$classes[$class] = new Darter_TreeItem($class);
		if($inspection->getParentClass() != null) {
			if(key_exists($inspection->getParentClass()->getName(), $classes)) {
				$classes[$inspection->getParentClass()->getName()]->add($classes[$class]);
				continue;
			}
		}
		$tree->add($classes[$class]);
	}
}

$overview = new Darter_View('overview');
$overview->classes = $tree;
$overview->display();

?>