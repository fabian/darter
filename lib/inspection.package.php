<?php

class Darter_AuthorTag {

}

class Darter_Inspection {

	public static function load() {
		$path = Darter_Properties::get('darter.source');
		$suffixLength = strlen(Darter_Properties::get('darter.suffix'));
		foreach (scandir($path) as $file) {
			if (substr($file, -$suffixLength) == Darter_Properties::get('darter.suffix')) {
				include_once $path . '/' . $file;
			}
		}
	}

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

class Darter_InspectionProperty extends ReflectionProperty {

	private $modifier;
	
	public function getModifier() {
		return $this->modifier;
	}

	public function __construct($class, $name) {
		parent::__construct($class, $name);

		$this->modifier = implode(' ', Reflection::getModifierNames($this->getModifiers()));
	}
}

class Darter_InspectionClass extends ReflectionClass {

	private $annotations;

	public function __construct($class) {
		parent::__construct($class);


		$this->darter_className = $class;

		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());
	}


	public function getAnnotations($annotation) {
		return $this->annotations[$annotation];
	}
	public function getAnnotation($annotation) {
		if(isset($this->annotations[$annotation][0])) {
			return $this->annotations[$annotation][0];
		}
		else {
			return "undefined";
		}
	}

	public function getMethods() {
		$methods = array();
		foreach(parent::getMethods() as $method) {
			$methods[] = new Darter_InspectionMethod($this->getName(), $method->getName());
		}
		return $methods;
	}

	public function getProperties() {
		$properties = array();
		foreach(parent::getProperties() as $property) {
			$properties[] = new Darter_InspectionProperty($this->getName(), $property->getName());
		}
		return $properties;
	}

	public function isNotDarterClass() {

		if (!strstr($this->getName(), 'Darter')) {
			return true;
		}
		else {
			return false;
		}

	}

	public function getType() {
		if($this->isInterface()) {
			return "Interface";
		}
		elseif ($this->isAbstract()) {
			return "Abstract Class";
		}
		else {
			return "Class";
		}
	}
	
	/**
	 * @return Darter_InspectionClass
	 */
	public function getParentClass() {
		if(parent::getParentClass() != null) {
			return new Darter_InspectionClass(parent::getParentClass()->getName());
		} else {
			return null;
		}
	}

}

class Darter_InspectionMethod extends ReflectionMethod {

	private $annotations;

	public function __construct($class, $name) {
		parent::__construct($class, $name);

		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());
	}

	public function getAnnotations($annotation) {
		if(isset($this->annotations[$annotation])) {
			return $this->annotations[$annotation];
		}
		else {
			return array(
			0 => "undefined"
			);
		}
	}

}

?>
