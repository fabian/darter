<?php

class Concentre_View_Helper_Traducir {

    private $_view = null;
    private $_translate = null;

	public function __construct() {
	
		$ctrl = Zend_Controller_Front::getInstance();
		$request = $ctrl->getRequest();
	
		$_fname = sprintf(LANG_PATH.'%s/%s.tmx',$request->getModuleName(),'es');

		if (is_readable($_fname)) {
			$this->_translate = new Zend_Translate('tmx', $_fname ,'es');
			$this->_translate->addTranslation(LANG_PATH.'layout/es.tmx','es');
		} else {
			$this->_translate = new Zend_Translate('array', array() ,'es');
		}

		//echo $this->_view->layout()->getLayout();

		//$messageids = $this->_translate->getMessageIds();
		//print_r($messageids);
	}

    public function setView(Zend_View_Interface $view)
    {
        $this->_view = $view;
    }


    public function Traducir($messageid=null) 
    {

		//echo $this->_view->layout()->getLayout();
		
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
        
        
        $message = $this->_translate->_($messageid, $locale);
        return vsprintf($message, $options);

    }

}

?>
