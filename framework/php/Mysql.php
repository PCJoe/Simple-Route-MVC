<?php
	class Mysql extends PDO
	{
		static $_username = "";
		static $_password = "";
		static $_server = "localhost";
		
		static function newPDO($database, $persistent = true)
		{
			try
			{
				if($persistent)
				{
					$pdo = new Mysql('mysql:host='.self::$_server.';dbname='.$database, self::$_username, self::$_password, array(PDO::ATTR_PERSISTENT => true));
				}
				else
				{
					$pdo = new Mysql('mysql:host='.self::$_server.';dbname='.$database, self::$_username, self::$_password);
				}
				
				// the following tells PDO we want it to throw Exceptions for every error.
				// this is far more useful than the default mode of throwing php errors
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
			catch (PDOException $e)
			{
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			
			return $pdo;
		}
		
		public function qExe($query, $binds = array())
		{
			$stmt = $this->prepare($query);
			
			foreach($binds as $pointer=>$value)
			{
				$stmt->bindValue($pointer, $value);
			}
			
			$stmt->execute();
			
			return $stmt;
		}
		
		public function addPointers($data)
		{
			$result = array();
			foreach($data as $index=>$value)
			{
				$result[":".$index] = $value;
			}
			return $result;
		}
		
		public function qInsert($table, $params)
		{
			// create insert query string
			$query = "INSERT INTO `".$table."` (`".str_replace(":", "", implode('`, `', array_keys($params)))."`) VALUES (".implode(', ', array_keys($params)).")";
			
			// execute the query
			$this->qExe($query, $params);
			
			// return the insert id
			return $this->lastInsertId();
		}
		
		public function qUpdate($table, $data, $where="")
		{
			// if where is notheing, don't set it
			if($where!="") $where = " WHERE ".$where;
			
			$params = array();
			foreach($data as $pointer=>$val)
			{
				$params[] = "`".str_replace(':', '', $pointer)."` = ".$pointer."";
			}
			$query = "UPDATE ".$table." SET ".implode(', ', $params).$where;
			
			// execute the query
			$this->qExe($query, $data);
			
			return true;
		}
		
		static function qPdoModel($array)
		{
			$result = array();
			foreach($array as $pointer=>$val)
			{
				$result[] = "`".str_replace(':', '', $pointer)."` = ".$pointer."";
			}
			return implode(', ', $result);
		}
		
		public function paramify($params)
		{
			$result = array();
			foreach($params as $index=>$value)
			{
				$result[":".$index] = $value;
			}
			return $result;
		}
	}