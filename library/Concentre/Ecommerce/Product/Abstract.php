<?php

abstract class Concentre_Ecommerce_Product_Abstract {

	protected $_data = array();

	public function __construct($id, $name) {
		$this->_id = $id;
		$this->_name = $name;
		$this->_quantity = 1;
	}
	
	public function __call($method, $args) {
	
		if (preg_match('/^get([A-Z]{1}[a-z0-9]+)$/',$method, $matches)) {
			return $this->_data[ strtolower('_'.$matches[1]) ];
		}
	
		throw new Exception('Unknown method');
		return false;	
	}
	
	private function __set($key, $value) {
		$this->_data[$key] = $value;
	}
	
	private function __get($key) {
		return $this->_data[$key];
	}

	abstract public function toString();
	
	public function toJson() {
		return Zend_Json::encode($this->_data);
	}

	public function toArray() {
		return $this->_data;
	}
	
	public function add() {
			$this->_quantity++;
	}

	public function delete() {
		if ($this->_quantiy>0) {
			$this->_quantity--;
		}
	}
	
}

?>