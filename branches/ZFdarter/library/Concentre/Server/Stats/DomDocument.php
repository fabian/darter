<?php

class Concentre_Server_Stats_DomDocument extends DomDocument {

 private static function _avt($matches) {
         extract($GLOBALS);

         $entries = $xp->evaluate($matches[1], $elt);
         if ($entries instanceof DOMNodeList) {
                return $entries->item(0)->nodeValue;
         } else {
                return $entries;
         }
 }

 public function avt() {
	global $xp, $elt;
	$elts = $this->getElementsByTagNameNS('urn:serverstats','*');
	foreach ($elts as $elt) {
		$value = $elt->getAttribute('value');
		if ($value) {
			$elt->removeAttribute('value');
			$xp = new domxpath($elt->ownerDocument);
			$result = preg_replace_callback('/\{([^\}]+)\}/',array(Concentre_Server_Stats_DomDocument,'_avt'), $value);
			$elt->appendChild($elt->ownerDocument->createTextNode($result));
			}

		}
	}
 }

?>
