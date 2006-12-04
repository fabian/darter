<?php
require_once 'inspection.package.php';

/**
 * Some stupid comments about this class
 * and its usage.
 *
 * @Resource(foobar, asd=df, asdsdasd=asdsd)
 */
class TestClass {
	
}

class Resource extends Annotation {	
	public $value = 'foo';
}

$inspection = new InspectionClass('TestClass');
var_dump($inspection->isAnnotationPresent('Resource'));
var_dump($inspection->getAnnotation('Resource')->value);

?>