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
class Concentre_XForms_Element_Abstract implements Concentre_XForms_Element_Interface {
	
	protected $_tagname;
	protected $_attributes = array();
	protected $_elements = array();

	protected $_allowed_attributes = array();

	private function init() {
	}

	public function __construct() {
		$this->init();
	}
	
	public function setAttribute($name,$value) {
		if (!in_array($name, $this->_allowed_attributes)) {
			throw new Concentre_XForms_Exception(sprintf('unallowed attribute: %s', $name));
		}
		$this->_attributes[$name] = $value;
		return $this;
	}		

        public function setLabel($value) {
		$label = new Concentre_XForms_Element_Label();
		$this->addElement($label->setText($value));
                return $this;
        }

        public  function __call($method, $arguments) {

		if ( preg_match('/^set([A-Za-z0-1]+)/', $method, $matches)) {
			$this->setAttribute(strtolower($matches[1]), $arguments[0]);
		} else {
			throw new Concentre_XForms_Exception('unknown method');
		}

		return $this;
        }


        public  function addElement(Concentre_XForms_Element $elt) {
                array_push($this->_elements, $elt);
                return $this;
        }

	private function _getAttributes() {

		$attrs = array();

		foreach ($this->_attributes as $k => $v) {
		    array_push( $attrs, sprintf('%s="%s"', $k,$v));
		}
			
		return implode(' ', $attrs);
	}

	public function __toString() {

		$result= sprintf("<%s:%s", Concentre_XForms::XMLNS_PREFIX, $this->_tagname);
		
		if (count($this->_attributes)) {
			$result.= ' '.$this->_getAttributes().' ';
		}

		if (count($this->_elements)) {
			$result.=">\n";
			foreach ($this->_elements as $elt) {
                	        $result.=$elt->__toString();
                	}
			$result.= sprintf("</%s:%s>\n", Concentre_XForms::XMLNS_PREFIX, $this->_tagname);
 		} else {
                       $result.="/>";
		}
	
		return $result;	
	}
}

?>
