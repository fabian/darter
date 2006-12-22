<?php
require_once 'lib/packages.package.php';
Darter_Package::load('lib');
Darter_Inspection::load();

class Darter_ClassTree {
	private $classes = array();
	private $root;

	public function __construct(Darter_TreeItemContainer $root) {
		$this->root = $root;
	}

	public function getClasses() {
		return $this->classes;
	}

	public function add(Darter_InspectionClass $inspection) {
		if(!key_exists($inspection->getName(), $this->classes)) {
			$this->classes[$inspection->getName()] = new Darter_TreeItem($inspection->getName(), $inspection);
		}
		if($inspection->getParentClass() != null) {
			if(!key_exists($inspection->getParentClass()->getName(), $this->classes)) {
				$this->add($inspection->getParentClass());
			}
			$this->classes[$inspection->getParentClass()->getName()]->add($this->classes[$inspection->getName()]);
		} else {
			$this->root->add($this->classes[$inspection->getName()]);
		}
	}
}

$tree = new Darter_TreeItemContainer();
$classTree = new Darter_ClassTree($tree);

foreach(get_declared_classes() as $class) {
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined() && $inspection->isNotDarterClass()) {
		$classTree->add($inspection);
	}
}

$overview = new Darter_View('overview');
$overview->interfaces = Darter::getInterfaces();
$overview->classes = $tree;
$overview->display();

?>