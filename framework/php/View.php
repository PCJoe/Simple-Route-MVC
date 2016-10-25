<?php
	class View
	{
		static function get($view = "", $model = array())
		{
			// if the user has include the php extension - remove it
			if(substr($view, -4) == ".php")
				$view = substr($view, 0, -4);
			
			// if they have used . for dirextory pathing change it
			$view = str_replace(".", "/", $view);
			
			// built the view path			
			$path = $GLOBALS["ActiveModule"]."/view/".$view;
			
			include_once($path.".php");
		}
	}