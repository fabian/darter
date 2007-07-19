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
	 * @deprecated use sayHello() instead
	 * @param string $world
	 * @param string $name
	 * @return string $helloWorld
	 */
	public function helloWorld($world, $name) {
		return 'Hello ' . $world . ' to ' . $name . '!';
	}
	
	/**
	 * says hello!
	 *
	 */
	public function sayHello() {
		
	}
	
	/**
	 * huhuu, you should not know about this!
	 */
	private final function doSecret() {
		
	}
}
/**
 * this is a huge penguin!
 * @package php.rocks
 */
class KingPenguin extends Penguin {
	
}
/**
 * Just an exaple parent Class
 * @author Michi Gysel
 * @package php.rocks
 */
class Animal {
	
	protected function getParentMethod() {
		
	}
	
}

/**
 * @package elements
 *
 */
class Water extends Element implements Drinkable, Liquid {
	
	/**
	 * Sets foo
	 * @param string $bar
	 */
	public function setFoo($bar) {
		
	}
}

/**
 * @package elements
 *
 */
class SaltWater extends Water {
	
	/**
	 * returns the concentration of salt
	 * @return float factor of percentage
	 */
	public function getSaltConcentration() {
		
	}
}

/**
 * @package elements
 *
 */
class SugarWater extends Water {
	
	/**
	 * returns the concentration of sugar
	 * @return float factor of percentage
	 */
	public function getSugarConcentration() {
		
	}
}

/**
 * @package elements
 *
 */
class Fire extends Element {
	
}

/**
 * @package elements
 *
 */
abstract class Element {
	
	/**
	 * an element just exists...
	 */
	public function exist() {
		
	}
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
