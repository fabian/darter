<?php

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
		
		$annotationClasses = array();
		foreach(get_declared_classes() as $class) {
			$reflection = new ReflectionClass($class);
			if($reflection->implementsInterface('Darter_Annotation')) {
				$annotationClasses[] = $reflection;
			}
		}
		
		$array = explode( "\n" , $comment );

		$sentence = '';
		foreach($array as $line) {
			foreach($annotationClasses as $reflection) {
				if (preg_match('/\* @' . call_user_func(array($reflection->getName(), 'getName')) . ' ([^\/?]*)/', $line, $matches)) {
					$class = $reflection->getName();
					$annotations[] = new $class($matches[1]);
				}
			}
		}


		return $annotations;
	}

	public static function parseDescription($comment) {
		$array = explode( "\n" , $comment );

		$sentence = '';
		foreach($array as $line) {
			if (preg_match("/\* ([^@].*)/", $line, $matches)) {
				$sentence .= trim($matches[1]) . ' ';
			}
		}

		return trim($sentence);
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
	
	public function getAnnotationsByClass($class) {
		$annotations = array();
		foreach($this->annotations as $annotation) {
			if($annotation instanceof  $class) {
				$annotations[] = $annotation;
			}
		}
		
		return $annotations;
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

	public function isNotExcluded() {
		$excludes = Darter_Properties::get('darter.exclude');
		foreach(explode(',', $excludes) as $exclude) {
			if(substr($exclude, 0, 1) == '*') {
				$exclude = substr($exclude, 1);
				if (substr($this->getName(), -strlen($exclude)) == $exclude) {
					return false;
				}
			} elseif (substr($exclude, -1) == '*') {
				$exclude = substr($exclude, 0, -1);
				if (substr($this->getName(), 0, strlen($exclude)) == $exclude) {
					return false;
				}
			} else {
				if ($this->getName() == $exclude) {
					return false;
				}
			}
		}
		return true;
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

	public function getAnnotations() {
		return $this->annotations;
	}

}

?>
