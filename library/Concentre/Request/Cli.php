<?php

/** Zend_Controller_Request_Exception */
require_once 'Zend/Controller/Request/Exception.php';

/** Zend_Controller_Request_Abstract  */
require_once 'Zend/Controller/Request/Abstract.php';

Zend_Loader::loadClass('Concentre_Cli_Arguments');


/**
 * Zend_Controller_Request_Cli
 *
 * Cli request object for use with Zend_Controller family.
 *
 * @uses Zend_Controller_Request_Abstract
 * @package Zend_Controller
 * @subpackage Request
 */
class Concentre_Controller_Request_Cli extends Zend_Controller_Request_Abstract
{

    function __construct() {

		$args = new Concentre_Cli_Arguments();

		foreach ($args as $k => $v) {
			switch ($k) {
				case 'module':
					$this->setModuleName($v);
					break;
                                case 'controller':
                                        $this->setControllerName($v);
                                        break;
                                case 'action':
                                        $this->setActionName($v);
                                        break;
				default:
					$this->setParam($k,$v);
					break;	
			}
		}

	}
	
}

?>
