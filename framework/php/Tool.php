<?php
	class Tool
	{
		static function printr($val)
		{
			echo "<pre>";
			print_r($val);
			echo "</pre>";
		}
		
		static function arrayStrip($target, $remove)
		{
			$result = array();
			
			foreach($target as $index=>$value)
			{
				if(!in_array($value, $remove))
				{
					$result[$index] = $value;
				}
			}
			
			return $result;
		}
		
		static function money($val)
		{
			return '$'.number_format((float)$val, 2, '.', '');
		}
		
		static function url()
		{
			return 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/';
		}
	}