<?php

class Concentre_View_Helper_FormSelectCumple  {

    protected $_view = null;
	public function setView($view) {
		$this->_view = $view;
    }

	function FormSelectCumple($name, $value, $attributes ) {
		

		//list($anio,$mes,$dia) = explode('-', $value);
		
		$dias = array();
		$anios = array();
		$meses = array( 1=>'Enero',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',
					  8=>'Agosto', 9=>'Septiembre', 11=>'Octubre', 11=>'Noviembre', 12=>'Diciembre'
					 );

	  	for ($i=1;$i<32;$i++) {
  			$k = sprintf('%02s', $i);
  			$dias[$k]=$k;
  		}
  
	  	$anio = date('Y');
  	
  		for ($i=$anio-100;$i<=$anio;$i++) {
  			$anios[$i]=$i;
  		}
	
		$_html = $this->_view->formSelect($name."_dia", null, $attributes, $dias);
		$_html.= $this->_view->formSelect($name."_mes", null, $attributes, $meses); 
		$_html.= $this->_view->formSelect($name."_anio", null, $attributes, $anios); 
		
		
		return $_html;
	}
}

?>
