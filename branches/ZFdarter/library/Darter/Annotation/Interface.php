<?php
/**
 * Darter
 *
 * @category   Darter
 * @package    Darter_Annotation
 * @copyright  - 
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    0.1
 */

/**
 * Class for sending an email.
 *
 * @category   Darter
 * @package    Darter_Annotation
 * @copyright  -
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
interface Darter_Annotation_Interface {
	
	public static function getName();	
	public function __construct($match);	
	public function getTitle();	
	public function getBody();
}

?>
