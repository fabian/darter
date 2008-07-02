<?php

class Concentre_Pattern_Collection {
	
	protected $_data;
	
	public function __construct(Array $data=array()) {
		$this->_data = $data;
	}
	
	public function __set($key, $value) {
		$this->_data[$key] = $value;
	}

	public function __get($key) {
		return $this->_data[$key];
		
	}
	
	public function toArray() {
		return $this->_data;
		
	}
	
}


?>