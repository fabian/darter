<?php

require_once 'Concentre/Server/Stats/Source/Abstract.php';
require_once 'Concentre/Server/Stats/Source/Rrd/Interface.php';
require_once 'Concentre/Server/Stats/Source/Cached/Interface.php';

class Concentre_Server_Stats_Source_Memory
        extends Concentre_Server_Stats_Source_Abstract
        implements Concentre_Server_Stats_Source_Rrd
{
	private $meminfofile;
	private $data = array();
	private $show = array();
	
	public function __construct($args) {
		$this->meminfofile = $args['meminfofile']?$args['meminfofile']:'/proc/meminfo';
		$this->show = $args['show'];
		if (!isset($this->show))
		{
			$this->show = array(
					'MemTotal',
					'MemFree',
					'Cached',
					'SwapCached',
					'SwapTotal',
					'SwapFree'
			);
		} else if (!is_array($this->show))
		{
			$this->show = array($this->show);
		}
	}
	
	public function refreshData()
	{
		if (($temp = @file($this->meminfofile)) === false)
		{
			throw new Exception('Could not read "' . $this->meminfofile . '"');
		}
		foreach($temp as &$row)
		{
			if (preg_match('/^([a-zA-Z0-9_]{1,19})\s*:\s*([0-9\.]+)(\s*(.+))?$/', $row, $split))
			{
				if (isset($split[4]))
				{
					switch (strtolower($split[4]))
					{
						// without break!
						case 'gb':
							$split[2] *= 1024;
						case 'mb':
							$split[2] *= 1024;
						case 'kb':
							$split[2] *= 1024;
					}
				}
				$this->data[$split[1]] = $split[2];
			}
		}
	}
	
	public function initRRD(Concentre_Server_Stats_Rrd $rrd)
	{
		foreach ($this->data as $name => $value)
		{
			if (in_array($name, $this->show))
			{
				$rrd->addDatasource($name, 'GAUGE', null, 0);
			}
		}
	}
	
	public function fetchValues()
	{
		$values = array();
		foreach ($this->data as $name => $value)
		{
			if (in_array($name, $this->show))
			{
				$values[$name] = $value;
			}
		}
		return $values;
	}
}

?>

