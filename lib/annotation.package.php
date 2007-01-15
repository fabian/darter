<?php

interface Darter_Annotation {
	
	public static function getSignature();	
	public function __construct($match);	
	public function getTitle();	
	public function getBody();
}

class Darter_AuthorAnnotation implements Darter_Annotation {
	
	private $author;
	
	public static function getSignature() {
		return '/@author ([$A-Za-z ]*)/';
	}
	
	public function __construct($match) {
		$this->author = $match[0];
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
	
	public static function getSignature() {
		return '/@package ([$A-Za-z ]*)/';
	}
	
	public function __construct($match) {
		$this->package = $match[0];
	}
	
	public function getTitle() {
		return 'Package';
	}
	
	public function getBody() {
		return $this->package;
	}
}

class Darter_CopyrightAnnotation implements Darter_Annotation {
	
	private $copyright;
	
	public static function getSignature() {
		return '/@copyright ([$A-Za-z ]*)/';
	}
	
	public function __construct($match) {
		$this->copyright = $match[0];
	}
	
	public function getTitle() {
		return 'Copyright';
	}
	
	public function getBody() {
		return $this->copyright;
	}
}

?>