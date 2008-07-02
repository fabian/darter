<?php

class Concentre_Controller_Action_Abstract extends Zend_Controller_Action implements Concentre_Controller_Action_Interface {

	protected $_modulePath;
	protected $_localesPath;
	
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
		parent::__construct($request, $response, $invokeArgs);

		$this->_modulePath = MODULES_DIR.DIRECTORY_SEPARATOR.$this->getModuleName();
		$this->_localesPath = $this->_modulePath.DIRECTORY_SEPARATOR.'locales'.DIRECTORY_SEPARATOR.$this->getControllerName().DIRECTORY_SEPARATOR;

		//$this->view->translate = new Zend_Translate('xliff',  $this->_localesPath . 'es.xliff', 'es');

		set_include_path(
         		$this->_modulePath.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR.PATH_SEPARATOR.
        		get_include_path()
        );
	}

	public function getModuleName() {
		return $this->_request->getModuleName();
	}

    public function getControllerName() {
        return $this->_request->getControllerName();
    }

	public function getModulePath() {
		return $this->_modulePath;
	}
}

?>