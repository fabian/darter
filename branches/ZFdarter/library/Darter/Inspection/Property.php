<?php

class Darter_Inspection_Property extends ReflectionProperty {

	private $modifier;

	private $description;

	private $type;

	public function getModifier() {
		return $this->modifier;
	}

	public function __construct($class, $name) {
		parent::__construct($class, $name);

		$this->modifier = implode(' ', Reflection::getModifierNames($this->getModifiers()));

		$this->description = Darter_Inspection::parseDescription($this->getDocComment());

		$this->type = Darter_Inspection::parseType($this->getDocComment());
	}

	public function getDescription() {
		return $this->description;
	}

	public function getType() {
		return $this->type;
	}
}

?>