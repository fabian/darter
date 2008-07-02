<?php 
/**
 * Concentre
 * 
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://concentre.zensoluciones.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * Please let me know if you use this package. I will be happy to know that is usefull ;)
 * 
 * @category   Concentre
 * @package	   Concentre_Modules
 * @copyright  2008 (c) Sébastien Cramatte <scramatte@zensoluciones.com>
 */
 
class Concentre_Modules {
 
 
  /**
   * Return list of all modules, controllers and actions
   *
   * @param  string $modulesPath Optional; defaults to '../application'
   * @return array
   */
   public static function getList($modulesPath='../application/modules') {
 
   		$result = array();
 
   		try {
 
   			$modules = new DirectoryIterator($modulesPath);
 
   			// iterate through modules lists
			foreach ($modules as $m) {
	        		if ($m->isDir() && !preg_match('/^\.+/',$m)) {
 
	                		$moduleName = $m->getFilename();
 
	                		// controller must be stored in "controllers" directory 
	                		$controllersPath = $modulesPath.'/'.$moduleName.'/controllers/';
 
 
	                		$controllers = new DirectoryIterator($controllersPath);
 
		        		$module = array(
						'property' => array('name'=>$moduleName),
						'type' => 'folder',
						'children' => array()
					);
 
	                		foreach ($controllers as $c) {
 
		                		// search for ended by "Controller.php" filenames 
								if ($c->isFile() && preg_match('/((.+)Controller).php$/',$c->getFilename(),$matches)) {
 
	        						$className = ucfirst($matches[1]);
	        						$fullClassName = $moduleName=='default'?$className:ucfirst($moduleName).'_'.$className;
 
	        						if ($className) {
 
	        								// avoid throwing error when iterate throught the current controller
									       	if (!@class_exists($fullClassName)) {	        							
											Zend_Loader::loadFile("$className.php", $controllersPath);
										}
 									
											
			       							$class = new ReflectionClass( $fullClassName );
 
			       							$controller = array(
					                                                'property' => array('name'=> strtolower($matches[2])),
                                					                'type' => 'folder',
                                               						'children' => array()
										);
 
 
		        							$methods = $class->getMethods();
		        							foreach ($methods as $mm) {
		        								if (preg_match('/(.+)Action$/',$mm->name,$matches)) {
 
												$action = array(
 	                                                                                       		'property' => array('name'=> $matches[1]),
        	                                                                                	'type' => 'folder'
                                                                                		);      
												 $controller['children'][] = $action; 
		        								}
		        							}
 											
									}
 
		       					$module['children'][] = $controller;
	        					}
 
 
	                		}
 
	                		$result[] = $module;
	        		}
			}
 
   		} catch (Exception  $e) {
		 	echo $e->getMessage();
		}
 
		return $result;
   	}
}
 
?>
