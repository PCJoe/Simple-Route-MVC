<?php
	class Router
	{
		private $_uriArray;			// holds the uri delimited array
		private $_uriMethod;		// is either GET, POST, PUT or DELETE
		private $_uriParam;			// any paramaters pased through the URI
		private $_methodValues;		// any paramaters passed though the HTTP
		private $_httpRequest;		// any paramaters passed though the Header
		static $devMode = false;	// this is to either show the correct error page or display the route
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @__construct - feeds all data into the properties of this object from the $_SERVER
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function __construct()
		{
			$requestUri = explode('?', $_SERVER['REQUEST_URI']);
			$routeArray = array();
			$methodArray = array();
			
			// build segmits
			$baseSegment = explode("//", trim($_SERVER['REDIRECT_URL'], '/'));
			
			foreach($baseSegment as $index=>$row)
			{
				$buffer = explode('/', $row);
				foreach($buffer as $key=>$value)
				{
					if(stristr($value, ':'))
					{
						$buffer2 = explode(':', $value);
						$routeArray[$index][$buffer2[0]] = $buffer2[1];
					}
					else
					{
						$routeArray[$index][$key] = $value;
					}
				}
			}
			
			$this->_uriArray = $routeArray;
			
			$this->_uriMethod = $_SERVER['REQUEST_METHOD'];
			
			$this->_methodValues[$this->_uriMethod] = array();
			
			if($this->_uriMethod == "POST")
			{
				$this->_methodValues[$this->_uriMethod] = $_POST;
			}
			else
			{
				foreach(explode('&', $requestUri[1]) as $cell)
				{
					$var = explode('=', $cell);
					$this->_methodValues[$this->_uriMethod][$var[0]] = $var[1];
				}
				
				if($this->_methodValues[$this->_uriMethod][$var[0]] == null)
				{
					$this->_methodValues[$this->_uriMethod] = array();
				}
			}
			
			$this->_httpRequest = array();
			$ignore = array("HTTP_USER_AGENT", "HTTP_HOST", "HTTP_ACCEPT");
			foreach($_SERVER as $index=>$value)
			{
				if(stristr($index, "HTTP_") && !in_array($index, $ignore))
				{
					$this->_httpRequest[$index] = $value;
				}
			}
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @param @string - the name of the app. Which will match the directory name with the prefix of app_
		// @return @object - hand over the conection to the relevent app
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function startApp()
		{
			include_once($GLOBALS["ActiveRoute"]["AppPath"]."/Launch.php");
			$launch = new Launch($this->getFullRoute());
			$launch->launchApp();
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - Rreturn a PHP array of every detail of the api call
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function getFullRoute()
		{
			return array(
				"route" => $this->getRoute(),
				"method" => $this->getVars(),
				"http" => $this->getHttp()
			);
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - Return the delimiterd route
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function getRoute()
		{
			return $this->_uriArray;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @string - return the method type
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function getMethod()
		{
			return $this->_uriMethod;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - Return and Paramaters pased through the URI
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function getVars()
		{
			return $this->_methodValues;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - Return and Paramaters pased through the header
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function getHttp()
		{
			return $this->_httpRequest;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - check if an alias route is being used
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		public function alias($routes = array())
		{
			// set the routes
			include_once("../framework/routes.php");
			
			// collect the cuurent route
			$currentRoute = $this->getRoute()[0];
			$routeVar = array();
			
			if(count($routes)>0)
			{				
				foreach($routes as $route)
				{
					if($this->_uriMethod == $route['method'])
					{
						$alias = explode('/', $route['alias']);
						if(count($alias) == count($currentRoute))
						{
							$match = true;
							foreach($alias as $key=>$alia)
							{
								if(strstr($alia, "{"))
								{
									$var = str_replace(array('{','}'), '', $alia);
									$routeVar[$var] = $currentRoute[$key];
								}
								elseif($alia != $currentRoute[$key])
								{
									$match = false;
								}
							}

							if($match)
							{
								$this->_uriArray = array(array_merge(explode('/', $route['route']), $routeVar));
								$GLOBALS["ActiveRoute"] = $this->getFullRoute();
								break;
							}
						}
					}
				}
			}
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @bool - Return true if $method is set eg GET, POST, PUT, DELETE
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		static function is($method)
		{
			return (isset($GLOBALS['ActiveRoute']['method'][$method]))?true:false;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @bool - Return true if worked
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		static function setModule($module)
		{
			$GLOBALS["ActiveRoute"]["route"][0][1] = $module;
			$GLOBALS["ActiveRoute"]["AppModule"] = $module;
			return true;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @bool - Return true if worked
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		static function setController($controller)
		{
			$GLOBALS["ActiveRoute"]["route"][0][2] = $controller;
			$GLOBALS["ActiveRoute"]["AppController"] = $controller;
			return true;
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - display in a pintr the current route array
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		static function get()
		{
			return $GLOBALS["ActiveRoute"];
		}
		
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		// @return @array - display in a pintr the current route array
		///////////////////////////////////////////////////////////////////////////////////////////////////////
		static function show()
		{
			echo "<pre>";
			print_r(self::get());
			echo "<pre>";
		}
	}