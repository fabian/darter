<?php

class Darter_Annotation_Author implements Darter_Annotation_Interface {
	
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

?>