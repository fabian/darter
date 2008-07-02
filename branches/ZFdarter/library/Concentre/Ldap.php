<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Concentre
 * @package    Concentre_Ldap
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: Ldap.php 8403 2008-02-25 19:43:31Z darby $
 */


/**
 * @category   Concentre
 * @package    Concentre_Ldap
 * @copyright  Copyright (c) 2005-2008 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
 
class Concentre_Ldap extends Zend_Ldap {

	protected $_resource = null;
	protected $_options = null;
		
	public function __construct(array $options=array()) 
	{
		$this->setOptions($options);
	}

 	public function setOptions(array $options)
    {
        $defaultOptions = array(
            'host'                      => null,
            'port'                      => 389,
            'useSSL'                    => false,
            'useV3'						=> false,
            'baseDn'					=> null,
            'username'                  => null,
            'password'                  => null,
        );

        $diff = array_diff_key($options, $defaultOptions);
        if ($diff) {
            list($key, $val) = each($diff);
            require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, "Unknown Zend_Ldap option: $key");
        }

        foreach ($defaultOptions as $key => $val) {
            if (!array_key_exists($key, $options)) {
                $options[$key] = $val;
            }
        }

        $this->_options = $options;

        return $this;
    }

	public function connect()
	{
 		if (!extension_loaded('ldap')) {
            /**
             * @see Zend_Ldap_Exception
             */
            require_once 'Zend/Ldap/Exception.php';
            throw new Zend_Ldap_Exception(null, 'LDAP extension not loaded');
        }
		
		if (!$this->_options['baseDn']) {
				require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'Base DN not set');		
		}
		

		$this->_resource = ldap_connect($this->_options['host'], $this->_options['port']);
	
		if ($this->_options['useV3']) {
			ldap_set_option($this->_resource, LDAP_OPT_PROTOCOL_VERSION, 3);
		}
        
		if (!is_resource($this->_resource)) {
				require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'Not connected');
		}
		
		
		
		ldap_bind($this->_resource, $this->_options['username'], $this->_options['password']);
		
		return $this;
	}	
	
	public function disconnect()
    {
        if (is_resource($this->_resource)) {
            if (!extension_loaded('ldap')) {
                /**
                 * @see Zend_Ldap_Exception
                 */
                require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'LDAP extension not loaded');
            }
            @ldap_unbind($this->_resource);
        	@ldap_close($this->_resource);
        }
        
        $this->_resource = null;
        return $this;
    }
	
    /**
     * @return array The current options.
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * @return resource The raw LDAP extension resource.
     */
    public function getResource()
    {
        /**
         * @todo by reference?
         */
        return $this->_resource;
    }

    /**
     * @return string The hostname of the LDAP server being used to authenticate accounts
     */
    protected function _getHost()
    {
        return $this->_options['host'];
    }

    /**
     * @return int The port of the LDAP server or 0 to indicate that no port value is set
     */
    protected function _getPort()
    {
        return $this->_options['port'];
    }

    /**
     * @return string The default acctname for binding
     */
    protected function _getUsername()
    {
        return $this->_options['username'];
    }

    /**
     * @return string The default password for binding
     */
    protected function _getPassword()
    {
        return $this->_options['password'];
    }

    /**
     * @return boolean The default SSL / TLS encrypted transport control
     */
    protected function _getUseSsl()
    {
        return $this->_options['useSSL'];
    }

    /**
     * @return string The default base DN under which objects of interest are located
     */
    protected function _getBaseDn()
    {
        return $this->_options['baseDn'];
    }
		
	public function add($dn,$ldiff)
	{
		ldap_add($this->_resource, $dn, $ldiff);
	}

	public function delete($dn)
	{
		ldap_delete($this->_resource, $dn);		
	}
	
	public function update($dn, $ldiff)
	{
		ldap_modify($this->_resource, $dn, $ldiff);	
	}

	private function _getVersion() {
		ldap_get_option($this->_resource, LDAP_OPT_PROTOCOL_VERSION, $version);
		return $version;
	}


	public function copy($dn, $newdn)
	{
	
		if ($this->_getVersion()!=3) {
                /**
                 * @see Zend_Ldap_Exception
                 */
                require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'LDAP version 3 is required');		
		}
		
	
	}

	public function move($dn, $newdn)
	{
	
		if ($this->_getVersion()!=3) {
                /**
                 * @see Zend_Ldap_Exception
                 */
                require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'LDAP version 3 is required');		
		}
		
		//ldap_rename( $this->_resource , $dn, $newdn, $newparent, true);
				
	}

	public function getDn( $sr ) {

		if (!is_resource($sr)) {
				require_once 'Zend/Ldap/Exception.php';
                throw new Zend_Ldap_Exception(null, 'No search result');
		}
		
		return @ldap_get_dn($this->_resource, $sr);
	
	}

	public function getOne($filter='(objectClass=*)', $attributes=array(), $dn=null)
	{

		if (!$dn)
		{
			$dn = $this->_options['baseDn'];
		}
				
		$sr=@ldap_read($this->_resource, $dn, $filter, $attributes);
		$r=@ldap_get_entries($this->_resource, $sr);
		
		return is_array($r)?$r[0]:null;	
	}
	
	public function getList($filter='(objectClass=*)', $attributes=array(), $dn=null)
	{

		if (!$dn)
		{
			$dn = $this->_options['baseDn'];
		}
				
		$sr=@ldap_list($this->_resource, $dn, $filter, $attributes);
		$r=@ldap_get_entries($this->_resource, $sr);

		return is_array($r)?$r:null;

	}	
	
	public function search($filter='(objectClass=*)', $attributes=array(), $dn=null)
	{

		if (!$dn)
		{
			$dn = $this->_options['baseDn'];
		}
				
		$sr=@ldap_search($this->_resource, $dn, $filter, $attributes);
		$r=@ldap_get_entries($this->_resource, $sr);

		return is_array($r)?$r:null;
	}

}


?>