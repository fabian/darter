<?php

require_once 'Concentre/Server/Stats/Source/Abstract.php';
require_once 'Concentre/Server/Stats/Source/Rrd/Interface.php';
require_once 'Concentre/Server/Stats/Source/Cached/Interface.php';

class Concentre_Server_Stats_Source_Traffic
        extends Concentre_Server_Stats_Source_Abstract
        implements Concentre_Server_Stats_Source_Rrd

{
	private $ifs;
	private $data;
	private $procfile;
	
	public function __construct($args)
	{
		
		$ifs = $args['interfaces']?$args['interfaces']:'eth0';
		$procfile = $args['procfile']?$args['procfile']:'/proc/net/dev';
		
		if (is_string($ifs))
		{
			$ifs = array($ifs);
		}
		if (!is_array($ifs))
		{
			throw new Exception('Parameter must be an array');
		}
		$this->ifs = $ifs;
		$this->data = array();
		$this->procfile = $procfile;
	}
	
	public function refreshData()
	{
		if (($lines = @file($this->procfile)) === false)
		{
			throw new Exception('Could not read ' . $this->procfile);
		}
		foreach($lines as $line)
		{
			if (preg_match('/^\s*([\w\d\.\-]+):\s*(\d+)\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+(\d+)\s+(\d+)\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+\s+\d+/', $line, $m))
			{
				if (in_array($m[1], $this->ifs))
				{
					$this->data[$m[1]] = array(
						'rbytes'   => $m[2],
						'rpackets' => $m[3],
						'tbytes'   => $m[4],
						'tpackets' => $m[5]
					);
				}
			}
		}
	}
	
	public function initRRD(Concentre_Server_Stats_Rrd $rrd)
	{
		foreach ($this->ifs as $if)
		{
			$rrd->addDatasource($if . '_rbytes', 'COUNTER', null, 0, 4294967295);
			$rrd->addDatasource($if . '_rpackets', 'COUNTER', null, 0, 4294967295);
			$rrd->addDatasource($if . '_tbytes', 'COUNTER', null, 0, 4294967295);
			$rrd->addDatasource($if . '_tpackets', 'COUNTER', null, 0, 4294967295);
		}
	}
	
	public function fetchValues()
	{
		$values = array();
		foreach ($this->ifs as $if)
		{
			if (isset($this->data[$if]))
			{
				$values[$if . '_rbytes'] = $this->data[$if]['rbytes'];
				$values[$if . '_rpackets'] = $this->data[$if]['rpackets'];
				$values[$if . '_tbytes'] = $this->data[$if]['tbytes'];
				$values[$if . '_tpackets'] = $this->data[$if]['tpackets'];
			}
		}
		return $values;
	}
}

?>

