<?php

class Darter_Annotation_Copyright implements Darter_Annotation_Interface {
	
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