<?php
	class Launch
	{
		private $_appLocation = "";
		private $_appModule = "";
		private $_appPage = "";
		private $_appRoute = "";
		private $_appServer = "";
		private $_defaultPage = "example/main/home";
		
		public function __construct($route)
		{
			$this->_appRoute = $route;
			$this->_appLocation = $route["route"][0][0];
			$this->_appModule = $route["route"][0][1];
			$this->_appPage = $route["route"][0][2];
			$this->_appServer = $_SERVER;
			
			$GLOBALS["ActiveModule"] = "../app_".$this->_appLocation."/".$this->_appModule;
			$GLOBALS["ActivePath"] = $this->_appPage;
		}
		
		public function launchApp()
		{
			$route = $GLOBALS["ActiveModule"]."/controller/".$this->_appPage.".php";
			
			// this is an auto controller - if no controller go directly to view - use with caution
			// if(!file_exists($route))
			// 		$route = $GLOBALS["ActiveModule"]."/view/".$this->_appPage.".php";
			
			if(!file_exists($route))
				$route = "../framework/error/page_404.html";
			
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