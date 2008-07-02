<?php


class Darter_Tree_Item_Container {

	private $children = array();



	public function getChildren() {

		return $this->children;

	}



	public function add(Darter_Tree_Item $child) {

		$this->children[] = $child;

	}

}

?>