<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
    }

    public function indexAction() {
 		$this->view->pageTitle = "Concentr� XForms";
 		$this->_helper->layout()->setLayout('comingsoon'); 
    }
    
    public function call($m, $a) {
 		$this->view->pageTitle = "Concentr� XForms";
 		
    }
    
		
}

?>
