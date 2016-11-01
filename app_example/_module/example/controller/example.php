<script language="php">
	// get the header
	View::get("layout.header");
	
	// get the view data model
	$model = array(
		"data1" => Data::getModel(),
		"data2" => test\Data2::getModel(),
		"data3" => Car::getModel()
	);
	
	// get the view and parse the model
	View::get("body", $model);
	
	// get the foot
	View::get("layout.footer");
</script>
	