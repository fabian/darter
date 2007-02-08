<?php
/**
 * Some stupid comments about this class
 * and its usage.
 *
 * @author Fabian Vogler
 * @package php.rocks
 */
class Penguin extends Animal {
	
	/**
	 * Variable Foo describes something...
	 * 
	 * @var ParentClass
	 */
	private $foo = '';
	
	
	/**
	 * This cool method returns foo bar. Or
	 * at least something similar.
	 *
	 * @param string $world
	 * @param string $name
	 * @return string $helloWorld
	 */
	public function helloWorld($world, $name) {
		return 'Hello ' . $world . ' to ' . $name . '!';
	}
	
	private final function doSecret() {
		
	}
}

/**
 * Just an exaple parent Class
 * @author Michi Gysel
 */
class Animal {
	
	protected function getParentMethod() {
		
	}
	
}

class Water extends Element implements Drinkable, Liquid {
	
	/**
	 * Sets foo
	 * @param string $bar
	 */
	public function setFoo($bar) {
		
	}
}

abstract class Element {
	
}

/**
 * My personal interface.
 * 
 * Or something like that.
 */
interface Drinkable {
	
	/**
	 * Sets foo
	 * @param string $bar
	 */
	public function setFoo($bar);
}

interface Liquid {
	
}

?>
