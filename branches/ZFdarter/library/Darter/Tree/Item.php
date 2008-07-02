<?php


class Darter_Tree_Item extends Darter_Tree_Item_Container  {

	private $id;
	private $data;



	public function __construct($id, $data = null) {

		$this->id = $id;
		$this->data = $data;

	}
	
	public function getData() {
		return $this->data;
	}



	public function __toString() {

		return $this->id;

	}

}



?>