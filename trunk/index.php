<pre><?php
require_once 'inspection.package.php';

/**
 * Some stupid comments about this class
 * and its usage.
 *
 * @author Fabian Vogler
 */
class TestClass {

	/**
	 * This cool method return foo bar. Or
	 * at least something similar.
	 *
	 * @param string $world
	 * @param string $name
	 * @return string
	 */
	public function helloWorld($world, $name) {
		return 'Hello ' . $world . ' to ' . $name . '!';
	}
}

$inspection = new Darter_InspectionClass('TestClass');
var_dump($inspection->getAnnotations('author'));

$inspection = new Darter_InspectionMethod('TestClass', 'helloWorld');
var_dump($inspection->getAnnotations('param'));
var_dump($inspection->getAnnotations('return'));

foreach(get_declared_classes() as $class) {
	$inspection = new Darter_InspectionClass($class);
	if($inspection->isUserDefined()) {
		var_dump($class);
		foreach($inspection->getMethods() as $methodInspection) {
			if($methodInspection->isUserDefined()) {
				var_dump($methodInspection->getName());
			}
		}
	}
}

?></pre>
