<?php

class Darter_View {

	const PATH = 'views';

	const SUFFIX = '.view.php';

	const LAYOUT_SUFFIX = '.layout.php';

	private $data = array ();
	private $template;

	public function __construct($template) {
		$this->template = $template;
	}

	public function display() {
		$this->show($this->template);
	}

	private function show($template) {
		$this->data['template'] = $template;
		include self :: PATH . '/' . $template . self :: SUFFIX;
	}

	private $layouts = array ();

	private function layout($template) {
		$this->layouts[] = $template;
		ob_start();
	}

	private function endlayout() {
		$content = ob_get_clean();
		include self :: PATH . '/' . array_pop($this->layouts) . self :: LAYOUT_SUFFIX;
	}

	public static function out(& $variable, $default = '') {
		if (isset ($variable)) {
			echo $variable;
		} else {
			echo $default;
		}
	}

	public function __set($key, $value) {
		$this->data[$key] = $value;
	}

	public function __get($key) {
		return isset ($this->data[$key]) ? $this->data[$key] : '';
	}
}

?>