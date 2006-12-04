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

$inspection = new DarterInspectionClass('TestClass');
var_dump($inspection->getAnnotations('author'));

$inspection = new DarterInspectionMethod('TestClass', 'helloWorld');
var_dump($inspection->getAnnotations('param'));
var_dump($inspection->getAnnotations('return'));

?></pre>
