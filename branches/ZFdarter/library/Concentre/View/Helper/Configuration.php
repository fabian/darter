<?php

class Concentre_View_Helper_Configuration  {

        protected $_view = null;
	public function setView($view) {
		$this->_view = $view;
        }

	function Configuration() {
		return Zend_Registry::get('config');
	}
}

?>
