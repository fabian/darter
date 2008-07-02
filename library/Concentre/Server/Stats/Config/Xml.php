<?php

require_once 'Concentre/Server/Stats/DomDocument.php';

class Concentre_Server_Stats_Config_Xml implements ArrayAccess, Iterator {

   private $xml;
   private $config;

   public function __construct( $filename ) {
	$this->xml = new Concentre_Server_Stats_DomDocument();
	$this->xml->load($filename);
	$this->xml->avt();

	self::__traverse($this->xml->documentElement, $this->config);
   }
 
   // Doit retourne TRUE / FALSE si l'offset existe
   public function offsetExists($offset) {
	return isset($this->config[$offset]);
   }
	
   // Retourne la valeur pour $offset
   public function offsetGet($offset) {
	return $this->config[$offset];
   }
		
   // Entre la valeur $value pour $offset
   public function offsetSet($offset, $value) {
	$this->config[$offset] = $value;
   }
		
   // Supprime la valeur de l'$offset
   public function offsetUnset($offset) {
	unset($this->config[$offset]);
   }

   function key(){
        return key($this->config);
   }

   function current(){
        return current($this->config);
   }

   function rewind(){
	reset($this->config);
   }

   function next(){
	next($this->config);
   } 

   function valid(){
	return $this->current();	
   }

   public static function __attrs_as_array($node) {
        $attrs = array();
        foreach ($node->attributes as $n) {
           $attrs[$n->nodeName] = $n->nodeValue;
        }
	return $attrs;
   }

   private static function __traverse($node,&$config) {
  	foreach ($node->childNodes as $child) {
  		if ($child->nodeType!=1) continue;

		$id = $child->getAttribute('id');

		switch ($child->nodeName) {
			case 'step':
			case 'lang':
			case 'rrdtool':
				$config[ $child->nodeName ] = $child->nodeValue;
				break;
			case 'rras':
				$config[ 'rras' ] = array();
				self::__traverse($child, $config[ 'rras' ] );
				break;
			case 'size':
			case 'period':
			case 'rra':
			case 'graph':
			case 'monitor':
			case 'source':
				$config[ $id ] = self::__attrs_as_array($child);
				self::__traverse($child, $config[ $id ]['params'] );	
				break;
			case 'param':
				if (  $name = $child->getAttribute('name') ) {
					$config[ $name ] =  $child->nodeValue;
				} else {
				       $config[] =  $child->nodeValue;
				}
				break;
			case 'list':
				
				if ( $name = $child->getAttribute('name') ) {	
					self::__traverse($child, $config[ $name ] );
				} else {
					self::__traverse($child, $config[] );
				}

				break;
			default:
				self::__traverse($child, $config[ $child->nodeName ] );
				break;
		}
	}
   }
   
 }

?>
