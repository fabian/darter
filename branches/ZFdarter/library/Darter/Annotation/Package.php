<?php

class Darter_Annotation_Package implements Darter_Annotation_Interface {
	
	private $package;
	
	public static function getName() {
		return 'package';
	}
	
	public function __construct($match) {
		$this->package = $match;
	}
	
	public function getPackage() {
		return $this->package;
	}
	
	public function getTitle() {
		return 'Package';
	}
	
	public function getBody() {
		return '<a href="packages.php#package_' . $this->getPackage() . '">' . $this->getPackage() . '</a>';
	}
}


?>