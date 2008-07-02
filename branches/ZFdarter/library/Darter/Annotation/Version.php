<?php


class Darter_Annotation_Version implements Darter_Annotation_Interface {

	private $version;
	
	
	
	public static function getName() {
	
		return 'version';
	}
	
	public function __construct($match) {
		$this->version = $match;
	
	}
	
	
	
	public function getTitle() {

		return 'Version';
	
	}
	
	
	
	public function getBody() {
		return $this->version;

	}
}

?>