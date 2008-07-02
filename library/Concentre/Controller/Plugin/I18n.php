<?php
// Extendemos a Zend_Controller_Plugin_Abstract para crear nuestro plugin 
class Concentre_Controller_Plugin_I18n extends Zend_Controller_Plugin_Abstract 
{ 
    protected $_auth;
 
    protected $_viewRenderer;
 
    public function dispatchLoopStartup( Zend_Controller_Request_Abstract $request)
    {
    } 
}

?>
