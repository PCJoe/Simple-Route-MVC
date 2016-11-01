<?php
	class Controller
	{
		private $_appLocation = "";
		private $_appRoute = "";
		private $_appServer = "";
		
		public function __construct($route)
		{
			$this->_appLocation = $route["route"][0][0];
			unset($route["route"][0][0]);
			$this->_appRoute = $route;
			$this->_appServer = $_SERVER;
			
			echo $this->_appLocation;
			a::printr($this->_appRoute);
			a::printr($this->_appServer);
			
			$this->runApp();
		}
		
		public function runApp()
		{
			View::get("dashboard/main");
		}
		
		static function get($controller)
		{
			// if the user has include the php extension - remove it
			if(substr($controller, -4) == ".php")
				$controller = substr($view, 0, -4);
			
			// if they have used . for dirextory pathing change it
			$controller = str_replace(".", "/", $controller);
			
			// built the view path
			$path = $GLOBALS["ActiveRoute"]["AppPath"]."/_module/".$GLOBALS["ActiveRoute"]["AppModule"]."/controller/".$controller;
			
			include_once($path.".php");
		}
	}