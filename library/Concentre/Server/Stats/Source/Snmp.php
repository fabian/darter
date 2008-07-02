<?php

require_once 'Concentre/Server/Stats/Source/Abstract.php';
require_once 'Concentre/Server/Stats/Source/Rrd/Interface.php';
require_once 'Concentre/Server/Stats/Source/Cached/Interface.php';

class Concentre_Server_Stats_Source_Snmp
	extends Concentre_Server_Stats_Source_Abstract 
	implements Concentre_Server_Stats_Source_Rrd
{
	private $host;
	private $objects = array();
	private $community;
	
	private $data = array();
	
	private $dsdef = array();
	
	public function __construct($args)
	{
		$this->host = $args['host'];

		$this->objects = $args['objects'];
		if (!is_array($this->objects))
		{
			$this->objects = array($this->objects);
		}
		$this->community = $args['community']?$args['community']:'public';
	}
	
	public function addDatasourceDefinition($object, $args = array() )
	{
		$this->dsdef[$object] = array_merge ( array(type=>'GAUGE',heartbeat=>null,min=>'U',max=> 'U'), $args);
	}
	
	public function refreshData()
	{
		snmp_set_valueretrieval(SNMP_VALUE_OBJECT);
		foreach ($this->objects as $objectName => $objectData)
		{		
			$object = snmpget($this->host, $this->community, $objectData['oid']);
			if ($object !== false)
			{
				$this->data[$objectName] = $object->value;
			}
		}
	}
	
	public function initRRD(Concentre_Server_Stats_Rrd $rrd)
	{
		foreach ($this->objects as $objectName => $objectData)
		{
			if (isset($this->dsdef[$objectName]))
			{
				$opt = $this->dsdef[$objectName];
				$rrd->addDatasource(
					rrd::escapeDsName($objectName), $opt);
			}
			else
			{
				$objectType = $objectData[type]?$objectData[type]:'GAUGE';
				$rrd->addDatasource(Concentre_Server_Stats_Rrd::escapeDsName($objectName), $objectType);
			}
		}
	}
	
	public function fetchValues()
	{
		$values = array();
		foreach ($this->data as $key => $value)
		{
			$values[Concentre_Server_Stats_Rrd::escapeDsName($key)] = $value;
		}
		return $values;
	}
}

?>
