<?php

class Concentre_Controller_Action_Crud_Json extends Concentre_Controller_Action_Crud {

	protected $_model;	
	
	public function init() {
		parent::init();
	   	$this->_helper->viewRenderer->setNoRender(true);
	   	$this->_helper->layout->disableLayout(true);
	   	
		$this->getResponse()->setHeader('Content-Type', 'text/javascript;charset=utf-8');
		
	}
	
	
	public function deleteAction() {
    	try {
 	 	  	$_id = $this->_getParam('id');
 	 	  		
 	 	  	$this->_model->delete($_id,'id');
    		$this->getResponse()->setBody(sprintf("{'classname':'done','message':'%s'}", "")); 
    	} catch (Exception $e) {
    		$this->getResponse()->setBody(sprintf("{'classname':'error','message':'%s'}", $e->getMessage()));
    	}
    }
    
    public function createAction() {
    	try {
 	 	  	$_id = $this->_getParam('id');

 	 	  	if ($this->getRequest()->isPost()) {
 	 	  		$_data = $this->getRequest()->getPost();
 		 	  	//$this->_postmodel->insert($_data);
 		 	  	
 		 	  	$this->getResponse()->setBody(sprintf("{'classname':'done','message':'%s'}", ""));
 	 	  	}
 	 	  			 
	    	} catch (Exception $e) {
 		 	  	$this->getResponse()->setBody(sprintf("{'classname':'error','message':'%s'}", $e->getMessage()));
    	 	}
    }

    public function updateAction() {
    	try {
 	 	  	$_id = $this->_getParam('id');

	 	  	if ($this->getRequest()->isPost()) {
	 	  		$_data = $this->getRequest()->getPost();
 	  		
	 	  		
	 	  		//$this->_postmodel->update($_data, $_id);
	 	  		
	 	  		$this->getResponse()->setBody(sprintf("{'classname':'done','message':'%s'}", ""));
 		 	  	
 	 	  	}

    	} catch (Exception $e) {
    		$this->getResponse()->setBody(sprintf("{'classname':'error','message':'%s'}", $e->getMessage()));
    	}    	
    }
}

?>