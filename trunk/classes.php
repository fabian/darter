<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

$classesView = new Darter_View('classes');
$classesView->index = Darter::getIndexedClasses();
$classesView->display();

?>