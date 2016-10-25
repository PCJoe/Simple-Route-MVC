<?php
	///////////////////////////////////////////////////////////////////////////////
	// Application Route Controller
	///////////////////////////////////////////////////////////////////////////////
	
	$GLOBALS["ActiveModule"] = dirname(__FILE__);
	$GLOBALS["ActivePath"] = "";
	$GLOBALS["ActiveRoute"] = array();
	
	// include the framework autoloader
	include_once("../framework/autoloader.php");
	
	// check for excluded pathing
	$excludeArray = array();
	
	// check for re-routing paths
	$reRouteArray = array();
	
	// create dynamic routing object
	$router = new Router();
	$GLOBALS["ActiveRoute"] = $router->getFullRoute();
	
	$app = $GLOBALS["ActiveRoute"]['route'][0][0];
	$launcher = "../app_".$app."/Launch.php";
	
	if(file_exists($launcher))
	{
		$app = $router->startApp($app);
	}
	else
	{
		// test code to allow dev to see route structure - in production comment this out and uncomment the below pointer to the 404 page
		echo json_encode($router->getFullRoute());
		
		// if not found return error
		// $error = "../framework/error/page_404.html";
		// include($error);
	}