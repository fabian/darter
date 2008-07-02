<?php

class Concentre_Controller_Plugin_Auth extends  Zend_Controller_Plugin_Abstract {

	private $_auth;
	private $_acl;

	public function __construct($auth, $acl)
    	{
        	$this->_auth = $auth;
      		$this->_acl = $acl;
    	}


	public function preDispatch($request)
	{
		$role = 'guest';
		$controller = $request->controller;
		$action = $request->action;
		$module = $request->module;
		$resource = $module.'+'.$controller;

		
		
        if ($this->_auth->hasIdentity()) {
             $role = $this->_auth->getIdentity()->role;
        }
		
	  	if (!$this->_acl->has($resource)) {
			$resource = $module;
    	}
    	
        if (!$this->_acl->isAllowed($role, $resource, $action)) {
			
			if (!$this->_auth->hasIdentity()) {		
				//$request->setModuleName('default');
				$request->setControllerName('auth');
				$request->setActionName('login');
				
				$redirectNS = new Zend_Session_Namespace('redirect');
				$redirectNS->fromURL = $_SERVER['REQUEST_URI'];	
			} else {

				$request->setControllerName('auth');
                $request->setActionName('forbidden');
			}
		} 
		
	}
}





?>
