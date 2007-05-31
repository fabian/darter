<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

$overview = new Darter_View('overview');
$overview->description = Darter_Properties::get('project.description');
$overview->packages = Darter::getPackages();
$overview->interfaces = Darter::getInterfaces();
$overview->classes = Darter::getClassTree();
$overview->display();

?>