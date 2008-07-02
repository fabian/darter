<?php
/**
 * Darter
 *
 * @category   Darter
 * @package    Darter_Inspection
 * @copyright  -
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    0.1
 */

/**
 * Class for sending an email.
 *
 * @category   Darter
 * @package    Darter_Inspection
 * @copyright  -
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Darter_Inspection {

	static $excluded;	
	static $source;
	static $suffix;

	public static function load($config) {
		self::$source = $config->source;
		self::$suffix = $config->suffix;

		if(is_file(self::$source)) {
			include_once self::$source;
		} else {
			self::scan(self::$source, self::$suffix);
		}

		self::$excluded = $config->excluded;
	}

	private static function scan($path, $suffix) {
		$suffixLength = strlen($suffix);
		foreach (scandir($path) as $file) {
			$current = $path . '/' . $file;
			if($file != '.' and $file != '..' and is_dir($current)) {
				self::scan($current, $suffix);
			} else {
				if (substr($file, -$suffixLength) == $suffix) {
					include_once $current;
				}
			}
		}
	}

	public static function parseAnnotations($comment) {
		$annotations = array();

		$annotationClassesList = array(
			'Darter_Annotation_Package',
                        'Darter_Annotation_Author',
                        'Darter_Annotation_Copyright',
                        'Darter_Annotation_Deprecated',
                        'Darter_Annotation_Parameter',
                        'Darter_Annotation_Version'
		);

		
		foreach($annotationClassesList as $class) {
			$reflection = new ReflectionClass($class);
			if($reflection->implementsInterface('Darter_Annotation_Interface')) {
				$annotationClasses[] = $reflection;
			}
		}
		
		$array = explode( "\n" , $comment );
		

		$sentence = '';
		foreach($array as $line) {
			foreach($annotationClasses as $reflection) {
				
				$name = call_user_func(array($reflection->getName(), 'getName'));
				if (preg_match('/\*\s+@' . call_user_func(array($reflection->getName(), 'getName')) . '\s+(.*)/', $line, $matches)) {
					$class = $reflection->getName();
					$annotation = new $class($matches[1]);

					if(!isset($annotations[$name])) {

						$annotations[$name] = array();

					}

					$annotations[$name][] = $annotation;
				}
			}
		}

		return $annotations;
	}

	public static function parseDescription($comment) {
		$array = explode( "\n" , $comment );

		$sentence = '';
		foreach($array as $line) {
			if (preg_match("/\* ([^@].*)/", $line, $matches)) {
				$sentence .= trim($matches[1]) . ' ';
			}
		}

		return trim($sentence);
	}

	public static function parseType($comment) {
		$array = explode("\n" , $comment);

		$type = '';
		foreach($array as $line) {
			if (preg_match('/\* @var (.*)/', $line, $matches)) {
				$type = $matches[1];
				break;
			}
		}

		return $type;
	}

	public static function isNotExcluded($name) {
		foreach(explode(',', self::$excluded) as $exclude) {
			if(substr($exclude, 0, 1) == '*') {
				$exclude = substr($exclude, 1);
				if (substr($name, -strlen($exclude)) == $exclude) {
					return false;
				}
			} elseif (substr($exclude, -1) == '*') {
				$exclude = substr($exclude, 0, -1);
				if (substr($name, 0, strlen($exclude)) == $exclude) {
					return false;
				}
			} else {
				if ($name == $exclude) {
					return false;
				}
			}
		}
		return true;
	}
}

?>
