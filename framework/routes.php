<?php
	// route
	$routes = array();
	
	// example route for method, alias url and the real route
	$routes[] = array(
		"method" => "GET",
		"alias" => "my-app/{id}/any/{name}",
		"route" => "app/module/controller"
	);
	
	// example route for method, alias url and the real route
	$routes[] = array(
		"method" => "GET",
		"alias" => "auto",
		"route" => "app/module/controller"
	);