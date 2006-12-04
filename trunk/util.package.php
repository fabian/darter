<?php

class Collection extends ArrayObject {
	
	public function set($key, $value) {
		$this[$key] = $value;
	}
	
	public function get($key) {
		return $this[$key];
	}
	
	public function remove($key) {
		unset($this[$key]);
	}
	
	public function exists($key) {
		return isset($this[$key]);
	}
	
	public function contains($value) {
		return in_array($value, (array) $this);
	}
	
	public function krsort() {
		$array = $this->getArrayCopy();
		krsort($array);
		$this->exchangeArray($array);
	}
	
	public function merge(Collection $array) {
		$this->exchangeArray(array_merge((array) $this, (array) $array));
	}
	
	public function unshift($value) {
		array_unshift($this, $value);
	}
	
	public function map($function) {
		array_map($function, $this);
	}
	
	public function getKeys() {
		return array_keys($this);
	}
	
	public function toReadableString() {
		return self::readableString($this->array);
	}
	
	public static function readableString($array) {
		$string = '';
		reset($array);
		$size = count($array);

		if ($size > 0) {
			$string .= current($array);

			if ($size > 1) {
				next($array);

				$i = 1;
				while ($i < $size -1) {
					$string .= ', ' . current($array);
					next($array);
					$i++;
				}

				$string .= ' and ' . current($array);
			}
		}

		return $string;
	}
}

?>