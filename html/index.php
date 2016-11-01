<?php
	///////////////////////////////////////////////////////////////////////////////
	// Application Route Controller
	///////////////////////////////////////////////////////////////////////////////
	
	//error_reporting(E_ERROR | E_WARNING | E_PARSE);
	
	// set the default start app
	$defaultApp = "example";
	
	// include the framework autoloader
	include_once("../framework/autoloader.php");
	
	// uncomment this to enable dev mode - which will return the route array and any other dev messages for troubleshooting
	// Router::$devMode = true;
	
	// create dynamic routing object
	$router = new Router();
	$GLOBALS["ActiveRoute"] = $router->getFullRoute();
	
	// main route teirs, there will always be 3 routes eg. "app"/"module"/"controller"
	// if any teirs are missing the name from the previous teir as copied across eg. if only example is used then the route will be "example"/"example"/"example"
	if($GLOBALS["ActiveRoute"]["route"][0][0] == "")
		$GLOBALS["ActiveRoute"]["route"][0][0] = $defaultApp;
	if(!isset($GLOBALS["ActiveRoute"]["route"][0][1]))
		$GLOBALS["ActiveRoute"]["route"][0][1] = $GLOBALS["ActiveRoute"]["route"][0][0];
	if(!isset($GLOBALS["ActiveRoute"]["route"][0][2]))
		$GLOBALS["ActiveRoute"]["route"][0][2] = $GLOBALS["ActiveRoute"]["route"][0][1];
	
	// this creates some quick referance layers in the global array
	$GLOBALS["ActiveRoute"]["AppPath"] = "../app_".$GLOBALS["ActiveRoute"]["route"][0][0];
	$GLOBALS["ActiveRoute"]["AppModule"] = $GLOBALS["ActiveRoute"]["route"][0][1];
	$GLOBALS["ActiveRoute"]["AppController"] = $GLOBALS["ActiveRoute"]["route"][0][1];
	
	// path to the app launcher
	$launcher = $GLOBALS["ActiveRoute"]["AppPath"]."/Launch.php";
	
	if(file_exists($launcher))
	{
		$router->startApp();
	}
	else
	{
		if(Router::$devMode)
		{
			// test code to allow dev to see route structure - in production comment this out and uncomment the below pointer to the 404 page
			//echo json_encode($router->getFullRoute());
			echo Tool::printr($GLOBALS["ActiveRoute"]);
		}
		else
		{
			// if not found return error
			$error = "../framework/error/page_404.html";
			include($error);
		}
	}