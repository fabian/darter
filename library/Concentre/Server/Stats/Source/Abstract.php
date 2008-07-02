<?php

require_once 'Concentre/Server/Stats/Rrd.php';

abstract class Concentre_Server_Stats_Source_Abstract
{
	public function init() { }
	abstract function refreshData();
	abstract function fetchValues();
	
	static public function factory($args) {
		$class = 'Concentre_Server_Stats_Source_' . ucfirst(strtolower($args['type']));
				
		if (class_exists($class)) {	
			return new $class($args['params']);
		} else {
		   	echo $class;
		}
		
	}
}


?>
