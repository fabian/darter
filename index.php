<?php
require_once 'inspection.package.php';

require_once 'testClass.php';

$inspection = new Darter_InspectionClass('TestClass');
//var_dump($inspection->getAnnotations('author'));

$inspection = new Darter_InspectionMethod('TestClass', 'helloWorld');
//var_dump($inspection->getAnnotations('param'));
//var_dump($inspection->getAnnotations('return'));

$inspection = new Darter_InspectionMethod('TestClass', 'setFoo');
//var_dump($inspection->getAnnotations('param'));

//require "class.tpl.php";


$inspection = new Darter_InspectionClass('TestClass');
var_dump($inspection->getAnnotations('author'));
/*
$inspection = new Darter_InspectionMethod('TestClass', 'helloWorld');
var_dump($inspection->getAnnotations('param'));
var_dump($inspection->getAnnotations('return'));
*/
foreach(get_declared_classes() as $class) {
	$darterprefix = "Darter_";
	
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined()) {
		var_dump($class);
		foreach($inspection->getMethods() as $methodInspection) {
			if($methodInspection->isUserDefined()) {
				var_dump($methodInspection->getName());
			}
		}
	}
}

?>
<a href="overview.php">go to overview</a>