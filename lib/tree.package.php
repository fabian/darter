<?php

class Darter_TreeItem extends Darter_TreeItemContainer  {
	private $id;

	public function __construct($id) {
		$this->id = $id;
	}

	public function __toString() {
		return $this->id;
	}
}

class Darter_TreeItemContainer {
	private $children = array();

	public function getChildren() {
		return $this->children;
	}

	public function add(Darter_TreeItem $child) {
		$this->children[] = $child;
	}
}

?>