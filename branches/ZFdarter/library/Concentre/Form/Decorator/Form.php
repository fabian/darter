<?php
class Concentre_Form_Decorator_Form extends Zend_Form_Decorator_Form 
{
    public function getOptions()
    {
        $this->setOption('onsubmit','return false;');
 
        $baseUrl = Zend_Controller_Front::getInstance()->getBaseUrl();
        $this->getElement()->getView()->headScript()->appendFile($baseUrl . '/share/js/Validator.js');
 
        return parent::getOptions();
    }
}


?>