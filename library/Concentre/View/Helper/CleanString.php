<?php

class Concentre_View_Helper_CleanString  {

    protected $_view = null;
	public function setView($view) {
		$this->_view = $view;
    }

	function CleanString($str ) {
		return htmlspecialchars($str);
	}
}

?>
