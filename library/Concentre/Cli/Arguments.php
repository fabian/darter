<?php

class Concentre_Cli_Arguments implements Iterator, Countable {

	protected $__cliargs;	
	protected $__scriptname;
	protected $__args = array();
	protected $__numargs;

	private static $instance;
	
	public function __construct() {
		$this->__numargs = 	$_SERVER['argc'];
		$this->__cliargs = $_SERVER['argv'];
		
		$this->__scriptname = array_shift($this->__cliargs);
		
		foreach ($this->__cliargs as $arg) {
			preg_match('/^-{1,2}([^=]+)(=(.+))?/', $arg, $matches);
			$this->__args[ $matches[1]  ] = $matches[3];
		}
	}

      public static function singleton()
      {
          if (!isset(self::$instance)) {
              $className = __CLASS__;
              self::$instance = new $className;
          }

          return self::$instance;
       }



	public function __destruct() {
		unset($this->__numargs);
		unset($this->__args);
	}

 	public function current() {
 		return current($this->__args);
  }

  public function key() {
  	return key($this->__args);
  }

  public function next() {
		return next($this->__args);
  }

  public function rewind() {
  	return reset($this->__args);
  } 
    
	public function valid() {
		return $this->key() == true;
	}

	public function count() {
		return $this->__numargs - 1;
	}

	
	public function __get($key) {
		return $this->__args[$key];
	}

	public function __toString () {
		$str = '';
		foreach ($this->__args as $k => $v) {
			$str.= "$k: $v\n";
		}
		return $str;
	}		
	
}

 
?>
