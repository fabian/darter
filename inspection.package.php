<?php

class DarterInspection {
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

class DarterInspectionClass extends ReflectionClass {
	
	private $annotations;
	
	public function __construct($class) {
		parent::__construct($class);
		
		$this->annotations = DarterInspection::parseAnnotations($this->getDocComment());
	}
	
	public function getAnnotations($annotation) {
		return $this->annotations[$annotation];
	}
}

class DarterInspectionMethod extends ReflectionMethod {
	
	private $annotations;
	
	public function __construct($class, $name) {
		parent::__construct($class, $name);
		
		$this->annotations = DarterInspection::parseAnnotations($this->getDocComment());
	}
	
	public function getAnnotations($annotation) {
		return $this->annotations[$annotation];
	}
}

?>
