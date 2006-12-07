<?php
/**
 * Some stupid comments about this class
 * and its usage.
 *
 * @author Fabian Vogler
 * @package PHProcks
 */
class TestClass extends ParentClass implements Stuhl {
	
	/**
	 * Variable Foo describes something...
	 */
	private $foo = '';
	
	
	/**
	 * This cool method return foo bar. Or
	 * at least something similar.
	 *
	 * @param string $world
	 * @param string $name
	 * @return string $helloWorld
	 */
	public function helloWorld($world, $name) {
		return 'Hello ' . $world . ' to ' . $name . '!';
	}
	
	/**
	 * Sets foo
	 * @param string $bar
	 */
	public function setFoo($bar) {
		
	}
	
	private function doSecret() {
		
	}
}

/**
 * Just an exaple parent Class
 * @author Michi Gysel
 */
class ParentClass {
	
	protected function getParentMethod() {
		
	}
	
}

interface Stuhl {
	
}

?>
