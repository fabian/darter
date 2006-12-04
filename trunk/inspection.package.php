<?php
require_once 'util.package.php';
require_once 'annotations.package.php';

class InspectionClass extends ReflectionClass {
	
	private $annotationClass;
	
	private $annotations;
	
	public function __construct($class) {
		parent::__construct($class);
		
		$this->annotationClass = new ReflectionClass('Annotation');
		$this->annotations = new Collection;
		
		preg_match_all('/@([A-Za-z]*)(\(([{}A-Za-z, ]*)(, [A-Za-z]*\=[{}A-Za-z, ]*)*\))?/', $this->getDocComment(), $matches);
		foreach($matches[1] as $key => $class) {			
			if(!isset($annotations[$class])) {
				$annotation = null;
				try {
					var_dump($matches);
					$reflection = new ReflectionClass($class);
					if($reflection->isSubclassOf($this->annotationClass)) {
						$annotation = new $class();
						$annotation->value = $matches[3][$key];
					}
				} catch (ReflectionException $e) {
				}
			
				$this->annotations->set($class, $annotation);
			}
		}
	}
	
	public function getAnnotations() {		
		return $this->annotations;
	}
	
	public function getAnnotation($annotation) {
		return $this->annotations->get($annotation);
	}
	
	public function isAnnotationPresent($annotation) {
		return $this->annotations->exists($annotation);
	}
}

?>
