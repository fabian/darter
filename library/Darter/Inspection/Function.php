<?php

class Darter_Inspection_Function extends ReflectionFunction {

	private $description;

	private $annotations;

	public function __construct($name) {
		parent::__construct($name);

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

	public function getDarterFileName() {
		return substr($this->getFileName(), strlen(substr(dirname(__FILE__), 0 ,-4) . '/' . Darter_Inspection::source . '/'));
	}

	public function isNotExcluded() {
		return Darter_Inspection::isNotExcluded($this->getName());
	}
}

?>
