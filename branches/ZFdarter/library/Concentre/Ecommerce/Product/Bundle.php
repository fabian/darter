<?php

class Concentre_Ecommerce_Product_Bundle extends Concentre_Ecommerce_Product_Abstract {

	function __construct($id,$name, $price, $products) {
		parent::__construct($id, $name);
		
		$this->_price = $price;	
		$this->_products = $products;
	}
	
	public function toString() {
		return '[ Object Product Bundle ]';
	}
	
	
}

?>