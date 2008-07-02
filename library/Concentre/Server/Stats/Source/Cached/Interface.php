<?php

interface Concentre_Server_Stats_Source_Cached
{
	public function initCache();
	public function loadCache($cachedata);
	public function getCache();
}



?>
