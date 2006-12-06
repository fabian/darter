<?php
require_once 'inspection.package.php';

require_once 'testClass.php';

$className = isset($_GET['classname']) ? $_GET['classname'] : "";

if($className != "") {
	$inspectionClass = new Darter_InspectionClass($className);
	//var_dump($inspectionClass);
	require "templates/class.tpl.php";
}
else {
	echo "no parameter given";
}
 
?>
