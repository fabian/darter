<?php

class Concentre_View_Helper_Importe {

    private $_view = null;

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }

    public function Importe($value)
    {
    	if (is_numeric($value)) {
    		$_currency = Zend_Registry::get('currency');
			echo $_currency->toCurrency($value);
			
    	}	
    }

}

?>