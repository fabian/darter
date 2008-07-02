<?php
/**
 * Concentre Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Concentre
 * @package    Concentre_XForms
 * @copyright  Copyright (c) 2008 Zen Soluciones (http://www.zensoluciones.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    0.1 
 */

/**
 * Class for sending an email.
 *
 * @category   Concentre
 * @package    Concentre_XForms
 * @copyright  Copyright (c) 2008 Zen Soluciones (http://www.zensoluciones.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Concentre_XForms_Abstract {

	private $_elements = array();

        /**
         * Initialize the object
         */
	private function init() {
	} 

        /**
         *  Constructor
         */
	public function __construct() {
		$this->init();
	}

        /**
         * Set xml namespace prefix
         * @param string $prefix
         */
	public function setNamespacePrefix($prefix) {
		$this->_namespace_prefix = $prefix;
	}

        /**
         * Add a model to the XForms stack
         * @param Concentre_XForms_Model $elt
         */
       public function addModel(Concentre_XForms_Model $elt) {
		array_push($this->_models, $elt);
                return $this;
        }

	/**
	 * Add an element to the XForms stack
	 * @param string $elt
	 * @param array $options
	 */
	public	function addElement($elt, $options = null) {

		if (is_string($elt)) {

			$classname = 'Concentre_XForms_Element_'. ucfirst(strtolower($elt));

			if (class_exists($classname)) {
				$elt = new $classname();
				if (!($elt instanceof Concentre_XForms_Element)) {
					throw new Concentre_XForms_Exception(sprintf("%s class is not an instance of Concentre_XForms_Element", $classname));
				}
				
			} else {
				throw new Concentre_XForms_Exception(sprintf("class %s doesn't exists", $classname ));
			}

		} elseif (!($elt instanceof Concentre_XForms_Element)) {
			throw new Concentre_XForms_Exception(sprintf("this is not an instance of Concentre_XForms_Element"));		
		}

		array_push($this->_elements, $elt);
		return $elt;
	}

        /**
         * Return serialized data as string
         */
	public function __toString() {

		$str = '';
		foreach ($this->_elements as $elt) {
			
			$str.=$elt->__toString();
			$str.="\n";
		}

		return $str;
	}

}

?>
