<?php
	class Launch
	{
		private $_appLocation = "";
		private $_appModule = "";
		private $_appPage = "";
		private $_appRoute = "";
		private $_appServer = "";
		
		public function __construct()
		{
			$this->_appRoute = $GLOBALS["ActiveRoute"];
			$this->_appLocation = $GLOBALS["ActiveRoute"]["route"][0][0];
			$this->_appModule = $GLOBALS["ActiveRoute"]["route"][0][1];
			$this->_appPage = $GLOBALS["ActiveRoute"]["route"][0][2];
			$this->_appServer = $_SERVER;
		}
		
		public function launchApp()
		{
			$route = $GLOBALS["ActiveRoute"]["AppPath"].'/_module/'.$this->_appModule.'/controller/'.$this->_appPage.'.php';
			
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
			
			include($route);
		}
		
		public function getRoute()
		{
			return $this->_appServer;
		}
		
		public function getLocation()
		{
			return $this->_appLocation;
		}
		
		public function getModule()
		{
			return $this->_appModule;
		}
		
		public function getPage()
		{
			return $this->_appPage;
		}
		
		public function getServer()
		{
			return $this->_appServer;
		}
	}