<?php
	class Model
	{
		static function get($view, $model)
		{
			$module = explode("controller/", $_SERVER['SCRIPT_FILENAME']);
			include_once($module[0]."view/".$view);
		}
	}