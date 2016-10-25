<?php
	// mvc controller autoloader
	function mvc_autoload($className)
	{
		//echo $GLOBALS["ActiveModule"]."<br>";
		// class variables
		$dirToCheck = array();                   
		$currentLocation = str_replace('\\','/',getcwd()).'/';
		
		// if not in any of the above check the framework
		$dirToCheck['model'] = $GLOBALS["ActiveModule"].'/model/'.str_replace('\\','/',$className).'.php';
		$dirToCheck['local'] = $GLOBALS["ActiveModule"].'/local/php/'.str_replace('\\','/',$className).'.php';
		$dirToCheck['framework'] = '/var/www/framework/php/'.str_replace('\\','/',$className).'.php';
		
		//echo "<pre>"; print_r($dirToCheck); echo "</pre>";
		
		// if any exsist include them
		foreach($dirToCheck as $dir=>$classFile)
		{
			if(file_exists($classFile))
			{
				include_once($classFile);
				break;
			}
		}
	}
	spl_autoload_register('mvc_autoload');