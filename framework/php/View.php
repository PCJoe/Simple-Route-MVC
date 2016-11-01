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
			$route = $GLOBALS["ActiveRoute"]["AppPath"]."/_module/".$GLOBALS["ActiveRoute"]["route"][0][1]."/view/".$view.".php";
			
			if(!file_exists($route))
			{
				if(Router::$devMode)
				{
					// test code to allow dev to see route structure - in production comment this out and uncomment the below pointer to the 404 page
					//echo json_encode($router->getFullRoute());
					echo Tool::printr($GLOBALS["ActiveRoute"]);
					exit;
				}
				else
				{
					// if not found return error
					$route = "../framework/error/page_404.html";
				}
			}
			
			include_once($route);
		}
	}