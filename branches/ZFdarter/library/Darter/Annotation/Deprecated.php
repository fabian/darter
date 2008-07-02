<?php


class Darter_Annotation_Deprecated implements Darter_Annotation_Interface {
	

	private $deprecated;
	

	
	public static function getName() {

		return 'deprecated';
	
	}
	
	
	
	public function __construct($match) {
		
		$this->deprecated = $match;
	
	}
	
	
	
	public function getTitle() {
	
		return '<span class="important">' . 'Deprecated' . '</span>';
	
	}
	
	

	public function getBody() {

		return $this->deprecated;
	}

}




?>