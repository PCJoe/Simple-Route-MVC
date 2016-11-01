<?php
	class Local
	{
		static function get($local = "", $model = array())
		{
			// if the user has include the php extension - remove it
			if(substr($local, -4) == ".php")
				$local = substr($local, 0, -4);
			
			// if they have used . for dirextory pathing change it
			$local = str_replace(".", "/", $local);
			
			// built the view path			
			$path = "../app_".$GLOBALS["ActiveRoute"]["route"][0][0]."/_local/".$local;
			
			include_once($path.".php");
		}
	}