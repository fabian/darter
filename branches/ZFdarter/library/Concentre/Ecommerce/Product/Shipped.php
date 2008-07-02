<?php

class Concentre_Ecommerce_Product_Shipped extends Concentre_Ecommerce_Product_Abstract {

	public function __construct($id,$name, $price, $weight) {
		parent::__construct($id, $name);
		
		$this->_price = $price;
		$this->_weight = $weight;
	}

	public function toString() {
		return '[ Object Product Shipped ]';
	}	

}

?>