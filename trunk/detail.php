<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

$class = isset($_GET['class']) ? $_GET['class'] : "";

if($class != "") {
	$detail = new Darter_View('detail');
	$detail->class = new Darter_InspectionClass($class);
	$detail->display();
}
else {
	echo "no parameter given";
}
 
?>
