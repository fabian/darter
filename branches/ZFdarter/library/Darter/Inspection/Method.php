<?php


class Darter_Inspection_Method extends ReflectionMethod {



	private $description;

	private $annotations;

	public function __construct($class, $name) {
		parent::__construct($class, $name);



		$this->description = Darter_Inspection::parseDescription($this->getDocComment());

		$this->annotations = Darter_Inspection::parseAnnotations($this->getDocComment());
	}



	public function getDeclaringClass() {

		return new Darter_Inspection_Class(parent::getDeclaringClass()->getName());

	}



	public function getDescription() {

		return $this->description;

	}

	public function getAnnotations() {

		return $this->annotations;
	}



	public function getVisibility() {

		if($this->isPrivate()) {

			return 'private';

		} elseif($this->isProtected()) {

			return 'protected';

		} else {

			return 'public';

		}

	}



	public function getDeclaration() {

		$declaration = $this->getVisibility();

		if($this->isFinal()) {

			$declaration .= ' final';

		}

		if($this->isAbstract()) {

			$declaration .= ' abstract';

		}

		return $declaration;

	}
}

?>