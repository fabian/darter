<?php
require_once 'inspection.package.php';

require_once 'testClass.php';

$classes = array();

foreach(get_declared_classes() as $class) {
	
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined() && $inspection->isNotDarterClass()) {
		//var_dump($class);
		$classes[] = $class;
		
		/*foreach($inspection->getMethods() as $methodInspection) {
			if($methodInspection->isUserDefined()) {
				//var_dump($methodInspection->getName());
			}
		}*/
	}
}

require "templates/overview.tpl.php";

?>