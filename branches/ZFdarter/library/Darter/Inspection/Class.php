<?php

class Darter_Inspection_Class extends ReflectionClass {

	private $description;



	private $annotations;



	public function __construct($class) {

		parent::__construct($class);



		$this->darter_className = $class;

		$this->description = Darter_Inspection::parseDescription($this->getDocComment());

		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());


	}

	public function getDescription() {
		return $this->description;
	}



	public function getAnnotations() {

		return $this->annotations;

	}

	public function getAnnotationsByName($name) {
		if(isset($this->annotations[$name])) {
			return $this->annotations[$name];
		} else {
			return array();
		}
	}



	public function getMethods() {

		$methods = array();

		foreach(parent::getMethods() as $method) {

			$methods[$method->getName()] = new Darter_Inspection_Method($this->getName(), $method->getName());

		}

		ksort($methods);

		return $methods;

	}

	public function getProperties() {
		$properties = array();
		foreach(parent::getProperties() as $property) {
			$properties[$property->getName()] = new Darter_Inspection_Property($this->getName(), $property->getName());
		}

		ksort($properties);
		return $properties;
	}



	public function isNotExcluded() {
		return Darter_Inspection::isNotExcluded($this->getName());
	}

	public function getDarterFileName() {
		return substr($this->getFileName(), strlen(substr(dirname(__FILE__), 0 ,-4) . '/' . Darter_Inspection::$source . '/'));
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
			return new Darter_Inspection_Class(parent::getParentClass()->getName());
		} else {
			return null;
		}
	}



}

?>
