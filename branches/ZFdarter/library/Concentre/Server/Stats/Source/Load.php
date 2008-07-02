<?php

require_once 'Concentre/Server/Stats/Source/Abstract.php';
require_once 'Concentre/Server/Stats/Source/Rrd/Interface.php';
require_once 'Concentre/Server/Stats/Source/Cached/Interface.php';

class Concentre_Server_Stats_Source_Load
        extends Concentre_Server_Stats_Source_Abstract
        implements Concentre_Server_Stats_Source_Rrd
{
	private $loadavgfile;
	
	private $min1;
	private $min5;
	private $min15;
	private $running;
	private $tasks;
	
	public function __construct($args)
	{
		$this->loadavgfile = $args['loadavgfile']?$args['loadavgfile']:'/proc/loadavg';
	}
	
	public function refreshData()
	{
		if (($temp = @file_get_contents($this->loadavgfile)) === false)
		{
			throw new Exception('Could not read "' . $this->loadavgfile . '"');
		}
		$temp = explode(' ', $temp);
		$this->min1 = $temp[0];
		$this->min5 = $temp[1];
		$this->min15 = $temp[2];
		$temp = explode('/', $temp[3]);
		$this->running = $temp[0];
		$this->tasks = $temp[1];
	}
	
	public function initRRD(Concentre_Server_Stats_Rrd $rrd)
	{
		$rrd->addDatasource('1min', 'GAUGE', null, 0);
		$rrd->addDatasource('5min', 'GAUGE', null, 0);
		$rrd->addDatasource('15min', 'GAUGE', null, 0);
		$rrd->addDatasource('running', 'GAUGE', null, 0);
		$rrd->addDatasource('tasks', 'GAUGE', null, 0);
	}
	
	public function fetchValues()
	{
		$values = array();
		$values['1min'] = $this->min1;
		$values['5min'] = $this->min5;
		$values['15min'] = $this->min15;
		$values['running'] = $this->running;
		$values['tasks'] = $this->tasks;
		return $values;
	}
}

?>
