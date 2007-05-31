<?php

interface Darter_Annotation {
	
	public static function getName();	
	public function __construct($match);	
	public function getTitle();	
	public function getBody();
}

class Darter_ParameterAnnotation implements Darter_Annotation {
	
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

class Darter_AuthorAnnotation implements Darter_Annotation {
	
	private $author;
	
	public static function getName() {
		return 'author';
	}
	
	public function __construct($match) {
		$this->author = $match;
	}
	
	public function getTitle() {
		return 'Author';
	}
	
	public function getBody() {
		return $this->author;
	}
}

class Darter_PackageAnnotation implements Darter_Annotation {
	
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

class Darter_CopyrightAnnotation implements Darter_Annotation {
	
	private $copyright;
	
	public static function getName() {
		return 'copyright';
	}
	
	public function __construct($match) {
		$this->copyright = $match;
	}
	
	public function getTitle() {
		return 'Copyright';
	}
	
	public function getBody() {
		return $this->copyright;
	}
}

?>