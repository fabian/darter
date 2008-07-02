<?php

abstract class Concentre_Ecommerce_Shipment_Abstract {

	protected $_data = array();

	function __construct($weight) {
		$this->_weight = $weight;
	}
	
	private function __set($key, $value) {
		$this->_data[$key] = $value;
	}
	
	private function __get($key) {
		return $this->_data[$key];
	}
}

?>
