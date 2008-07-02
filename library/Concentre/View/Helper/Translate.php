<?php

class Concentre_View_Helper_Translate_ {

    private $_view = null;
    private $_translate = null;

	public function __construct() {
		$this->_translate = new Zend_Translate('tmx', '../application/languages/blog/es.tnx');
	}

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }


    public function Translate($messagei=null) 
    {
		
		$options = func_get_args();
        array_shift($options);

        $count   = count($options);
        $locale  = null;
        if ($count > 0) {
            if (Zend_Locale::isLocale($options[$count - 1])) {
                $locale = array_pop($options);
            }
        }
        if ((count($options) == 1) and (is_array($options[0]))) {
            $options = $options[0];
        }
        $message = $this->translate->translate($messageid, $locale);
        return vsprintf($message, $options);
        
		return $this->_translate->_($key);
    }

}

?>
