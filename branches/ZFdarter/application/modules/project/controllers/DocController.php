<?php

class Project_DocController extends Zend_Controller_Action {

  
    public function init() {
		
		$project = $this->_getParam('project','xforms');

		$configpath = MODULES_DIR . '/' . $this->getRequest()->getModuleName() . '/config.xml'; 
		$config = new Zend_Config_Xml($configpath, 'projects');

		$this->_config = $config->$project->doc;
		Darter_Inspection::load($this->_config);

    }
    
    public function overviewAction() {
 		$this->view->pageTitle = "Documentation Overview";
 		$this->view->description = $this->_config->description; 
		
		$this->view->packages = Darter_Documentator::getPackages();
		$this->view->interfaces = Darter_Documentator::getInterfaces();
		
		
		$this->view->classes = Darter_Documentator::getClassTree();
		$this->view->functions = Darter_Documentator::getFunctions();
		

    }

    public function packagesAction() {
 		$this->view->pageTitle = "Documentation Packages";

	
		$this->view->elements = Darter_Documentator::getElementsWithoutPackage();
		$this->view->packages = Darter_Documentator::getPackages();
    }


    public function allAction() {
 		$this->view->pageTitle = "Documentation Index";
 		
 		$this->view->index = Darter_Documentator::getIndex();
    }
  
    public function detailAction() {
 		$this->view->pageTitle = "Detail";
 		
		$class = $this->_getParam('class','');
		$function = $this->_getParam('function','');
		
		if($class != '') {
			$this->view->class = new Darter_Inspection_Class($class);
		} elseif($function != '') {
			$this->view->function = new Darter_Inspection_Function($function);
		} else {
			throw new Zend_Exception('no parameter given');
		}
		
 		
    }  

    public function menuAction() {
		$this->_helper->layout->disableLayout();

    }		
}

?>
