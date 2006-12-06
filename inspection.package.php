<?php

class Darter_AuthorTag {
	
}

class Darter_Inspection {
	public static function parseAnnotations($comment) {
		$annotations = array();
		
		preg_match_all('/@([A-Za-z]*)( ([$A-Za-z ]*))?/', $comment, $matches);
		foreach($matches[1] as $key => $annotation) {			
			if(!isset($annotations[$annotation])) {
				$annotations[$annotation] = array();
			}
			
			$annotations[$annotation][] = $matches[3][$key];
		}
		
		return $annotations;
	}
}

class Darter_InspectionClass extends ReflectionClass {
	
	private $annotations;
	
	public function __construct($class) {
		parent::__construct($class);
		
		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());
	}
	
	public function getAnnotations($annotation) {
		return $this->annotations[$annotation];
	}
	
	public function getMethods() {
		$methods = array();
		foreach(parent::getMethods() as $method) {
			$methods[] = new Darter_InspectionMethod($this->getName(), $method->getName());
		}
		return $methods;
	}
}

class Darter_InspectionMethod extends ReflectionMethod {
	
	private $annotations;
	
	public function __construct($class, $name) {
		parent::__construct($class, $name);
		
		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());
	}
	
	public function getAnnotations($annotation) {
		return $this->annotations[$annotation];
	}
}

?>
