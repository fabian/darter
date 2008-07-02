<?php

class Darter_Tree {

	private $classes = array();

	private $root;



	public function __construct() {

		$this->root = new Darter_Tree_Item_Container();

	}



	public function getRoot() {

		return $this->root;

	}



	public function getClasses() {

		return $this->classes;

	}



	public function add(Darter_Inspection_Class $inspection) {

		if(!key_exists($inspection->getName(), $this->classes)) {

			$this->classes[$inspection->getName()] = new Darter_Tree_Item($inspection->getName(), $inspection);

			if($inspection->getParentClass() != null) {

				$this->add($inspection->getParentClass()); // make sure parent class is in list

				$this->classes[$inspection->getParentClass()->getName()]->add($this->classes[$inspection->getName()]);

			} else {

				$this->root->add($this->classes[$inspection->getName()]);

			}
		}

	}

}

?>