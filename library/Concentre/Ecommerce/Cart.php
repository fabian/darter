<?php 

class Concentre_Ecommerce_Cart implements Countable {

	protected $_data = array();
	protected $_content = array();

	private function __construct()
	{
	}

	private function __set($key, $value) {
		$this->_data[$key] = $value;
	}
	
	private function __get($key) {
		return $this->_data[$key];
	}
	
	public static function getInstance() {
		$_session = new Zend_Session_Namespace('Concentre_Ecommerce');
	
		if (!$_session->cart) {
			$_session->cart = new self();
		}
		
		return $_session->cart;
	}
	
	public function clear() 
	{
		$this->_content = array();
		$this->_recalculate();
	}

	public function delete($id)
	{
		$_pos = $this->getProductById($id);
		if ($pos == -1) {
			throw new Exception("Product #$id does not exists");
		}
		
		array_splice($this->_content,$_pos,1);
		$this->_recalculate();
	}
		
	
	public function count()
	{
		return count($this->cart);
	}
	
	
	public function add(Concentre_Ecommerce_Product_Abstract $product )
	{
		$_pos = $this->getProductById($product->getId());
	
		if ($_pos >= 0) {
			$this->_content[$_pos]->add();
		} else {
			$this->_content[] = $product;
		}
	
		$this->_recalculate();
	}

	function __call($method, $args)
	{
			switch($method) {
				case 'getTotal':
					$result = $this->_total;
					break;
				case 'getQuantityTotal':
					$result = $this->_quantity;
					break;
				case 'getProductById':
					$result = -1;
					foreach ($this->_content as $_key=>$_product) {
						
						if ($_product->getId() == $args[0]) {
							$result = $_key;
							break;
						}
					}
					
					
					break;
				default:
					throw new Exception('Unknown method');
			}

			return $result;
	}

	private function _recalculate()

	{
		$this->_total = 0;
		$this->_quantity = 0;
		foreach ($this->_content as $_product) {
			$this->_total += $_product->getPrice() * $_product->getQuantity();
			$this->_quantity += $_product->getQuantity();
		}
	}

	public function toString() {
		return '[ Object Cart ]';
	}	

	public function toJson() {
		return Zend_Json::encode($this->toArray());
	}	

	public function toArray() {
	
		$_content = array();
		
		foreach ($this->_content as $_product) {
			$_content[] = $_product->toArray();
		}
		
		return array('content' => $_content, 'total' => $this->_total, 'quantity' => $this->_quantity);
	}
	
}


?>