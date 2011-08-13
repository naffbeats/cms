<?php

/**
 * Copyright (C) 2009-2011 Shadez <https://github.com/Shadez>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

define('SINGLE_CELL',   0x01);
define('SINGLE_ROW',    0x02);
define('MULTIPLY_ROW',  0x03);
define('SQL_QUERY',     0x04);
define('OBJECT_QUERY',  0x05);
define('SQL_RAW_QUERY', 0x06);

class Database_Component extends Component
{
	private $dbLink = false;
	private $connectionLink = false;
	private $databaseInfo = array();
	private $connected = false;
	private $configs = array();

	/** Queries counter **/
	private $queryCount = 0;
	private $queryTimeGeneration = 0.0;
	private $db_prefix = null;

	/** Error messages **/
	private $errmsg = null;
	private $errno = 0;

	private $server_version = null;
	private $driver_type = 'mysqli';

	/**
	 * Connect to DB
	 * @access   public
	 * @param    array $configs
	 * @return   bool
	 **/
	public function connect($configs, $delayed = true)
	{
		if ($this->isConnected())
			return true; // Already connected

		$host = &$configs['host'];
		$user = &$configs['user'];
		$password = &$configs['password'];
		$dbName = &$configs['db_name'];
		$charset = &$configs['charset'];
		$prefix = &$configs['prefix'];

		$this->driver_type = &$configs['driver'];

		if ($delayed)
		{
			$this->configs = $configs;
			return true;
		}

		if (!in_array($this->driver_type, array('mysql', 'mysqli')))
			$this->driver_type = 'mysqli'; // Set as default

		if (!extension_loaded($this->driver_type))
			$this->core->terminate('database driver extension (' . $this->driver_type . ') was not loaded');

		if ($this->driver_type == 'mysqli')
		{
			$this->connectionLink = @mysqli_connect($host, $user, $password, $dbName);
			if (!$this->connectionLink)
			{
				$this->errmsg = @mysqli_error($this->connectionLink);
				$this->errno = @mysqli_errno($this->connectionLink);
				$this->c('Log')->writeError('%s : unable to connect to MySQL Server (host: "%s", dbName: "%s"). Error: %s. Check your configs.', __method__, $host, $dbName, $this->errmsg ? $this->errmsg:'none');
				return false;
			}

			$this->dbLink = @mysqli_select_db($this->connectionLink, $dbName);
			if (! $this->dbLink)
			{
				$this->c('Log')->writeError('%s : unable to switch to database "%s"!', __method__, $dbName);
				return false;
			}
		}
		else
		{
			$this->connectionLink = @mysql_connect($host, $user, $password, true);
			if (!$this->connectionLink)
			{
				$this->errmsg = @mysql_error($this->connectionLink);
				$this->errno = @mysql_errno($this->connectionLink);
				$this->c('Log')->writeError('%s : unable to connect to MySQL Server (host: "%s", dbName: "%s"). Error: %s. Check your configs.', __method__, $host, $dbName, $this->errmsg ? $this->errmsg:'none');
				return false;
			}

			$this->dbLink = @mysql_select_db($dbName, $this->connectionLink);
			if (!$this->dbLink)
			{
				$this->c('Log')->writeError('%s : unable to switch to database "%s"!', __method__, $dbName);
				return false;
			}
		}

		$this->connected = true;

		if ($charset == null)
			$this->query("SET NAMES UTF8");
		else
			$this->query("SET NAMES %s", $charset);

		$this->db_prefix = $prefix;
		$this->server_version = $this->selectCell("SELECT VERSION()");

		$this->databaseInfo = array(
			'host' => $host,
			'user' => $user,
			'password' => $password,
			'name' => $dbName,
			'db_name' => $dbName,
			'charset' => ($charset == null) ? 'UTF8' : $charset,
			'prefix' =>	$prefix,
			'hash' => sha1(time()),
			'driver' => $this->driver_type
		);

		return true;
	}

	public function delayedConnect()
	{
		return $this->connect($this->configs, false);
	}

	/**
	 * Returns current database info
	 * @access   public
	 * @param    string $info
	 * @return   mixed
	 **/
	public function GetDatabaseInfo($info)
	{
		return (isset($this->databaseInfo[$info])) ? $this->databaseInfo[$info]:false;
	}

	/**
	 * Tests conection link
	 * @access   public
	 * @return   bool
	 * @deprecated Use isConnected() instead
	 **/
	public function TestLink()
	{
		return $this->connected;
	}

	/**
	 * Tests conection link
	 * @access   public
	 * @return   bool
	 **/
	public function isConnected()
	{
		return $this->connected;
	}

	/**
	 * Execute SQL query
	 * @access   private
	 * @param    string $safe_sql
	 * @param    int $queryType
	 * @return   mixed
	 **/
	private function _query($safe_sql, $queryType)
	{
		// Execute query and calculate execution time
		$make_array = array();
		$query_start = microtime(true);
		$this->queryCount++;

		if ($this->driver_type == 'mysqli')
		{
			$performed_query = @mysqli_query($this->connectionLink, $safe_sql);
			$this->errmsg = @mysqli_error($this->connectionLink);
			$this->errno = @mysqli_errno($this->connectionLink);
		}
		else
		{
			$performed_query = @mysql_query($safe_sql, $this->connectionLink);
			$this->errmsg = @mysql_error($this->connectionLink);
			$this->errno = @mysql_errno($this->connectionLink);
		}

		if (! $performed_query)
		{
			$this->c('Log')->writeDebug('%s : unable to execute SQL query (%s). MySQL error: %s',	__method__, $safe_sql, $this->errmsg ? sprintf('"%s" (Error #%d)', $this->errmsg, $this->errno) : 'none');
			return false;
		}
		$result = false;

		switch ($queryType)
		{
			case SINGLE_CELL:
				if ($this->driver_type == 'mysqli')
				{
					$tmp = @mysqli_fetch_array($performed_query); // this works faster than mysql_result
				}
				else
				{
					$tmp = @mysql_fetch_array($performed_query); // this works faster than mysql_result
				}
				$result = $tmp[0];
				unset($tmp);
				break;
			case SINGLE_ROW:
				if ($this->driver_type == 'mysqli')
				{
					$result = @mysqli_fetch_assoc($performed_query);
				}
				else
				{
					$result = @mysql_fetch_assoc($performed_query);
				}
				if (is_array($result))
				{
					foreach ($result as $rKey => $rValue)
					{
						if (is_string($rKey))
						{
							$make_array[$rKey] = $rValue;
						}
					}
					$result = $make_array;
				}
				break;
			case MULTIPLY_ROW:
				$result = array();
				if ($this->driver_type == 'mysqli')
				{
					while ($_result = @mysqli_fetch_assoc($performed_query))
					{
						if (is_array($_result))
						{
							foreach ($_result as $rKey => $rValue)
							{
								if (is_string($rKey))
								{
									$make_array[$rKey] = $rValue;
								}
							}
							$result[] = $make_array;
						}
						else
						{
							$result[] = $_result;
						}
					}
				}
				else
				{
					while ($_result = @mysql_fetch_assoc($performed_query))
					{
						if (is_array($_result))
						{
							foreach ($_result as $rKey => $rValue)
							{
								if (is_string($rKey))
								{
									$make_array[$rKey] = $rValue;
								}
							}
							$result[] = $make_array;
						}
						else
						{
							$result[] = $_result;
						}
					}
				}
				break;
			case OBJECT_QUERY:
				$result = array();
				if ($this->driver_type == 'mysqli')
				{
					while ($_result = @mysqli_fetch_object($performed_query))
					{
						$result[] = $_result;
					}
				}
				else
				{
					while ($_result = @mysql_fetch_object($performed_query))
					{
						$result[] = $_result;
					}
				}
				break;
			case SQL_QUERY:
				$result = true;
				break;
			default:
				$result = false;
				break;
		}

		$query_end = microtime(true);
		$queryTime = round($query_end - $query_start, 4);
		$this->c('Log')->writeSql('[%s ms]: %s', $queryTime, $safe_sql);
		$this->queryTimeGeneration += $queryTime;

		unset($performed_query);

		return $result;
	}

	private function _prepareQuery($funcArgs, $numArgs, $query_type)
	{
		if (!$this->isConnected())
			// Try to perform delayed connection
			$this->delayedConnect();

		// funcArgs[0] - SQL query text (with placeholders)
		$funcArgs[0] = urldecode($funcArgs[0]);

		if ($query_type != SQL_RAW_QUERY)
		{
			for ($i = 1; $i < $numArgs; ++$i)
			{
				if (is_string($funcArgs[$i]))
				{
					$funcArgs[$i] = addslashes(urldecode($funcArgs[$i]));
				}
				if (is_array($funcArgs[$i]))
				{
					$funcArgs[$i] = $this->ConvertArray($funcArgs[$i]);
				}
			}
		}
		$safe_sql = call_user_func_array('sprintf', $funcArgs);
		if (!$safe_sql)
		{
			$this->c('Log')->writeError('%s : unable to execute sql query, dump:("%s")!', __METHOD__, print_r($funcArgs, true));
		}

		if (preg_match('/DBPREFIX/', $safe_sql))
		{
			if ($this->db_prefix == null)
			{
				$this->c('Log')->writeError('%s : fatal error: database prefix was not defined, unable to execute SQL query (%s)!',	__method__, $safe_sql);
				return false;
			}
			$safe_sql = str_replace('DBPREFIX', $this->db_prefix, $safe_sql);
		}

		return $this->_query($safe_sql, $query_type);
	}

	public function selectCell($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, SINGLE_CELL);
	}

	public function selectRow($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, SINGLE_ROW);
	}

	public function select($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, MULTIPLY_ROW);
	}

	public function query($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, SQL_QUERY);
	}

	public function RawQuery($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, SQL_RAW_QUERY);
	}

	public function selectObject($query)
	{
		$funcArgs = func_get_args();
		$numArgs = func_num_args();

		return $this->_prepareQuery($funcArgs, $numArgs, OBJECT_QUERY);
	}

	/**
	 * Converts array values to string format (for IN(%s) cases)
	 * @access   private
	 * @param    array $source
	 * @return   string
	 **/
	private function ConvertArray($source)
	{
		if (!is_array($source))
		{
			$this->c('Log')->writeError('%s : source must have an array type!', __method__);
			return null;
		}
		$returnString = null;
		$count = count($source);

		for ($i = 0; $i < $count; $i++)
		{
			if (!isset($source[$i]))
			{
				continue;
			}
			if ($i)
			{
				$returnString .= ", '" . addslashes(urldecode($source[$i])) . "'";
			}
			else
			{
				$returnString .= "'" . addslashes(urldecode($source[$i])) . "'";
			}
		}

		return $returnString;
	}

	public function __destruct()
	{
		if ($this->driver_type == 'mysqli')
			@mysqli_close($this->connectionLink);
		else
			@mysql_close($this->connectionLink);

		$this->DropLastErrors();
		$this->DropCounters();
	}

	public function GetServerVersion()
	{
		return $this->server_version;
	}

	public function GetLastErrorMessage()
	{
		return $this->errmsg;
	}
	public function GetLastErrorNum()
	{
		return $this->errno;
	}

	private function DropLastErrors()
	{
		$this->DropLastErrorMessage();
		$this->DropLastErrorNumber();
	}
	private function DropLastErrorMessage()
	{
		$this->errmsg = null;
	}

	private function DropLastErrorNumber()
	{
		$this->errno = 0;
	}

	private function DropCounters()
	{
		$this->queryCount = 0;
		$this->queryTimeGeneration = 0.0;
	}

	public function GetStatistics()
	{
		return array('queryCount' => $this->queryCount, 'queryTimeGeneration' => $this->queryTimeGeneration);
	}

	public function GetInsertID()
	{
		return ($this->driver_type == 'mysqli') ? mysqli_insert_id($this->connectionLink) : mysql_insert_id($this->connectionLink);
	}
}
?>