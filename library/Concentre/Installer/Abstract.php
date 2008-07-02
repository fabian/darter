<?php

require_once 'Concentre/Installer/Interface.php';

class Concentre_Installer_Abstract implements Concentre_Installer_Interface {

	public function __construct() {

	}

	public function __destruct() {

	}

	private function _checkPhpVersion($version='5.2') {
		return version_compare(php_version(), $version, '>='); ;
	}

	private function _phpExtensions() {

 		$this->datas->php = phpversion();
 		
 		$_php_extensions = array('xml','xsl','soap','zlib','mysql','mysqli','pgsql','ldap','gd');
 		$_php_extensions_detected = array();
 		
 		foreach ($php_extensions as $ext) {
 			  $php_extensions_detected[$ext] = extension_loaded($ext);
	 	}

		return  $_php_extensions_detected;
	}

	private function _isWritable() {
 	
		$_folders = array (
 				'log' => is_writable( 'var/log' ),
 				'cache' => is_writable( 'var/cache' ),
 				'tmp' => is_writable( 'tmp' ),
 				'session.save_path' => is_writable(ini_get('session.save_path'))
 		);

		return $_folders;
	}

	private function _phpRecomendedSettings() {

 		$_php_recommended_settings_parsed = array();
		$_php_recommended_settings = array(array ('Safe Mode','safe_mode',false),
		array ('Display Errors','display_errors',true),
		array ('File Uploads','file_uploads',true),
		array ('Magic Quotes GPC','magic_quotes_gpc',true),
		array ('Magic Quotes Runtime','magic_quotes_runtime',false),
		array ('Register Globals','register_globals',false),
		array ('Output Buffering','output_buffering',false),
		array ('Session auto start','session.auto_start',false)
		);

		foreach ($_php_recommended_settings as $phprec) {
			 $_php_recommended_settings_parsed[$phprec[1]] = array('label'=> $phprec[0], 'current'=>$this->get_php_setting($phprec[1]),'recommended'=>$phprec[2]);	
		}

		return $_php_recommended_settings_parsed;
	}
}
