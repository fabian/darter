<?php

class Concentre_Ecommerce_Product_Virtual extends Concentre_Ecommerce_Product_Abstract {

	function __construct($id,$name, $price) {
		parent::__construct($id, $name);
		
		$this->_price = $price;
	}
	
	public function toString() {
		return '[ Object Product Virtual ]';
	}
	
	
}

?>