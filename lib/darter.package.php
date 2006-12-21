<?php

class Darter {
	public static function getClasses() {
		$classes = array();
		
		foreach(get_declared_classes() as $class) {
			$inspection = new Darter_InspectionClass($class);
			if($inspection->isUserDefined() && $inspection->isNotDarterClass()) {
				$classes[$inspection->getName()] = $inspection;
			}
		}
		
		ksort($classes);
		
		return $classes;
	}
	
	public static function getIndexedClasses() {
		$index = array();
		
		foreach(self::getClasses() as $class) {
			if(isset($index[substr($class->getName(), 0, 1)])) {
				$index[substr($class->getName(), 0, 1)][] = $class;
			} else {
				$index[substr($class->getName(), 0, 1)] = array($class);
			}
		}
		
		return $index;
	}
}

?>