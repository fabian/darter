<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
    }

    public function indexAction() {
 		$this->view->pageTitle = "ConcentrŽ XForms";
 		$this->_helper->layout()->setLayout('comingsoon'); 
    }
    
    public function call($m, $a) {
 		$this->view->pageTitle = "ConcentrŽ XForms";
 		
    }
    
		
}

?>
