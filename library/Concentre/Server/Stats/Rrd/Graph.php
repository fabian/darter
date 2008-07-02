<?


class Concentre_Server_Stats_Rrd_Graph {

	private $rrdtoolbin;
	
	private $content = array();
	private $defs = array();

	private $params = array(
		'imgformat' => 'PNG',		
		'width'  => 500,
		'height' => 150
	);

	
	public function __construct($rrdtoolbin, $start, $end = null)
	{
		$this->rrdtoolbin = $rrdtoolbin;
		$this->start = $start;
		$this->end = $end;
	}
	
	public function setParam($key,$value) {

		switch ($value) {
			case 'true':
				$this->params[$key] = '';
				break;
			case 'false':
				break;
			default: 
				$this->params[$key] = $value;
		}

	}

	public static function escape($text)
	{
		return str_replace(':', '\\:', $text);
	}
	
	public function add($type, $p1 = null, $p2 = null, $p3 = null, $p4 = null, $p5 = null, $p6 = null, $p7 = null, $p8 = null)
	{
		switch ($type)
		{
			case 'DEF':
				// DEF:<vname>=<rrdfile>:<dsname>:<CF>[:step=<step>][:start=<time>][:end=<time>][:reduce=<CF>]
				if (!(isset($p1) && isset($p2) && isset($p3) && isset($p4)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				if (isset($this->defs[$p1]))
				{
					throw new Exception('Name already in use');
				}
				$this->content[] = array(
					'type' => $type,
					'cf' => $p4,
					'vname' => $p1,
					'ds' => $p3,
					'rrdfile' => $p2,
					'start' => $p6,
					'step' => $p5,
					'end' => $p7,
					'reduce' => $p8
				);
				$this->defs[$p1] = $type;
				break;
			case 'CDEF':
				// CDEF:vname=RPN expression
			case 'VDEF':
				// VDEF:vname=RPN expression
				if (!(isset($p1) && isset($p2)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				if (isset($this->defs[$p1]))
				{
					throw new Exception('Name already in use');
				}
				$this->content[] = array(
					'type' => $type,
					'vname' => $p1,
					'expression' => $p2
				);
				$this->defs[$p1] = $type;
				break;
			case 'LINE':
				// LINE[width]:value[#color][:[legend][:STACK]]
				if (!isset($p2))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				if (!isset($p5))
				{
					$p5 = false;
				}
				$this->content[] = array(
					'type' => $type,
					'width' => $p1,
					'vname' => $p2,
					'color' => $p3,
					'legend' => $p4,
					'stacked' => $p5
				);
				break;
			case 'AREA':
				// AREA:value[#color][:[legend][:STACK]]
				if (!isset($p1))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				if (!isset($p4))
				{
					$p4 = false;
				}
				$this->content[] = array(
					'type' => $type,
					'vname' => $p1,
					'color' => $p2,
					'legend' => $p3,
					'stacked' => $p4
				);
				break;
			case 'TICK':
				// TICK:vname#rrggbb[aa][:fraction[:legend]]
				if (!(isset($p1) && isset($p2)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				$this->content[] = array(
					'type' => $type,
					'vname' => $p1,
					'color' => $p2,
					'fraction' => $p3,
					'legend' => $p4
				);
				break;
			case 'VRULE':
				// VRULE:time#color[:legend]
				if (!(isset($p1) && isset($p2)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				$this->content[] = array(
					'type' => $type,
					'time' => $p1,
					'color' => $p2,
					'legend' => $p3
				);
				break;
			case 'GPRINT':
				// GPRINT:vname:format
				if (!(isset($p1) && isset($p2)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				$this->content[] = array(
					'type' => $type,
					'vname' => $p1,
					'format' => $p2
				);
				break;
			case 'COMMENT':
				// COMMENT:text
				if (!isset($p1))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				$this->content[] = array(
					'type' => $type,
					'text' => $p1
				);
				break;
			case 'SHIFT':
				// SHIFT:vname:offset
				if (!(isset($p1) && isset($p2)))
				{
					throw new Exception('Wrong Paramcount for ' . $type);
				}
				$this->content[] = array(
					'type' => $type,
					'vname' => $p1,
					'offset' => $p2
				);
				break;
			default:
				throw new Exception('Unknown Graphcontent ' . $type);
				break;
		}
	}
	
	public function addDEF($vname, $rrdfile, $ds, $cf, $step = null, $start = null, $end = null, $reduce = null)
	{
		$this->add('DEF', $vname, $rrdfile, $ds, $cf, $step, $start, $end, $reduce);
	}
	
	public function addCDEF($vname, $expression)
	{
		$this->add('CDEF', $vname, $expression);
	}
	
	public function addVDEF($vname, $expression)
	{
		$this->add('VDEF', $vname, $expression);
	}
	
	public function addLINE($width = null, $vname, $color = null, $legend = null, $stacked = false)
	{
		$this->add('LINE', $width, $vname, $color, $legend, $stacked);
	}
	
	public function addAREA($vname, $color = null, $legend = null, $stacked = false)
	{
		$this->add('AREA', $vname, $color, $legend, $stacked);
	}
	
	public function addTICK($vname, $color, $fraction = null, $legend = null)
	{
		$this->add('TICK', $vname, $color, $fraction, $legend);
	}
	
	public function addSHIFT($vname, $offset)
	{
		$this->add('SHIFT', $vname, $offset);
	}
	
	public function addGPRINT($vname, $format)
	{
		$this->add('GPRINT', $vname, $format);
	}
	
	public function addVRULE($time, $color, $legend = null)
	{
		$this->add('VRULE', $time, $color, $legend);
	}
	
	public function addCOMMENT($text)
	{
		$this->add('COMMENT', $text);
	}
	
	private function command($file = '-')
	{

		$params = ' graph ' . escapeshellarg($file);

		foreach ($this->params as $key => $value) {
		 		   	
		    if (isset($value)) {	
			if($value=='') {
				$params.=" --$key";
			} else {
				$params.=" --$key=".escapeshellarg($value);
			}
		    } 
 		}

		$params.=' ';

		foreach ($this->content as $c)
		{
			$optline = $c['type'];
			switch ($c['type'])
			{
				case 'DEF':
					$optline .= ':' . $c['vname'] . '=' . $c['rrdfile'] . ':' . $c['ds'] . ':' . $c['cf'];
					if (isset($c['start']))
					{
						$optline .= ':start=' . $c['start'];
					}
					if (isset($c['step']))
					{
						$optline .= ':step=' . $c['step'];
					}
					if (isset($c['end']))
					{
						$optline .= ':end=' . $c['end'];
					}
					if (isset($c['reduce']))
					{
						$optline .= ':reduce=' . $c['reduce'];
					}
					break;
				case 'CDEF':
				case 'VDEF':
					$optline .= ':' . $c['vname'] . '=' . $c['expression'];
					break;
				case 'LINE':
					if (isset($c['width']))
					{
						$optline .= $c['width'];
					}
					$optline .= ':' . $c['vname'];
					if (isset($c['color']))
					{
						$optline .= '#' . $c['color'];
					}
					if (isset($c['legend']))
					{
						$optline .= ':' . $c['legend'];
					}
					if ($c['stacked'])
					{
						$optline .= ':STACK';
					}
					break;
				case 'AREA':
					$optline .= ':' . $c['vname'];
					if (isset($c['color']))
					{
						$optline .= '#' . $c['color'];
					}
					if (isset($c['legend']))
					{
						$optline .= ':' . $c['legend'];
					}
					if ($c['stacked'])
					{
						$optline .= ':STACK';
					}
					break;
				case 'GPRINT':
					$optline .= ':' . $c['vname'] . ':' . $c['format'];
					break;
				case 'VRULE':
					$optline .= ':' . $c['time'] . '#' . $c['color'];
					if (isset($c['legend']))
					{
						$optline .= ':' . $c['legend'];
					}
					break;
				case 'COMMENT':
					$optline .= ':' . $c['text'];
					break;
				default:
					throw new Exception('NOT IMPLEMENTED');
					break;
			}
			$params .= ' ' . escapeshellarg($optline);
		}
		return (escapeshellcmd($this->rrdtoolbin) . $params);
	}
	
	public function save($file)
	{
		$output = array();
		$return = 0;
		$command = $this->command($file);
			
		exec($command . ' 2>&1', $output, $return);
		if ($return != 0)
		{
			throw new Exception('rrdtool ("' . $command . '") finished with exitcode ' . $return . "\n" . implode("\n", $output));
		}
	}
	
	public function output()
	{

		$command = $this->command();
		ob_start();
		passthru($command, $return);
		$out = ob_get_clean();

		if ($return != 0)
		{
  		  throw new Exception('rrdtool ("' . $command . '") finished with exitcode ' . $return);
		} 
		return $out;
	}
	
	public function setBase($base)
	{
		$this->base = $base;
	}
	
	public function setUpperLimit($upperLimit)
	{
		$this->upperLimit = $upperLimit;
	}
	
	public function setLowerLimit($lowerLimit)
	{
		$this->lowerLimit = $lowerLimit;
	}
	
	public function setVerticalLabel($verticalLabel)
	{
		$this->verticalLabel = $verticalLabel;
	}
	
	public function setUnitsExponent($unitsExponent)
	{
		$this->unitsExponent = $unitsExponent;
	}
	
	public function setAltYMrtg($altYMrtg = true)
	{
		$this->altYMrtg = $altYMrtg;
	}
	
	public function setAltAutoscale($altAutoscale = true)
	{
		$this->altAutoscale = $altAutoscale;
	}
	
	public function setAltAutoscaleMax($altAutoscaleMax = true)
	{
		$this->altAutoscaleMax = $altAutoscaleMax;
	}
	
	public function setLazy($lazy = true)
	{
		$this->lazy = $lazy;
	}
}

?>

