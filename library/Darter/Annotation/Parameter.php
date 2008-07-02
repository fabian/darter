<?php

class Darter_Annotation_Parameter implements Darter_Annotation_Interface {
	
	private $type;
	
	private $name;
	
	public static function getName() {
		return 'param';
	}
	
	public function __construct($match) {
		$this->type = $match;
		$this->name = $match;
	}
	
	public function getTitle() {
		return 'Parameter';
	}
	
	public function getBody() {
		return $this->type;
	}
}

?>