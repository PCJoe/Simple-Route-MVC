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
			include("../app_api/global/php/View.php");
			View::get("dashboard/main");
		}
	}