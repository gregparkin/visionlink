<?php


/**
 * @package    VisionLink
 * @file       postgres.php
 * @author     Greg Parkin <gregparkin58@gmail.com>
 */

//include_once __DIR__ . '/autoload.php';

/** @class postgres
 *  @brief This class is Greg's postgres API using PHP oci8 library routines.
 *  @brief Used in all programs and classes.
 *  @note postgres PHP reference manual: http://www.php.net/manual/en/ref.oci8.php
 */
class postgres extends library
{
	//
	// Properties
	//
	var $result_set;            // Associative array. The row of data returned by a select statement.
	var $data;                  // Used for dynamic class variables (getters and setters)
	var $conn;                  // Database connection handle.
	var $dbErrMsg;              // Contains any database error messages.
	var $sql_statement;         // Contains the last copy of the sql statement that was executed.
	var $last_return;           // Function return code of last class function executed. (true or false)
	var $is_select_statement;   // Was this SQL a select statement? (true or false)
	var $rows_affected;         // Number of rows effected by sql statement.
	var $host;                  // postgres Database name or IP address
	var $port;                  // Postgres Port Number
	var $dbname;                  // Postgres Database name
	var $user;                  // Postgres User account
	var $password;                  // Postgres User Password

	var $from_tz;               // Local user time zone on their workstation (PC)

	/** @fn __construct($database=NULL)
	 * @brief Class constructor - called once when the class is created.
	 *  If object is created from a batch runtime script, PHP_SAPI will be 'cli' which means we need
	 *  to do some additional environment setup for postgres.
	 * @param $database is set to NULL by default allow logon() to login to the configured database schema on the local server.
	 *  If $database is not NULL then logon() will try and login to that database.
	 * @return void
	 */
	public function __construct($database = NULL)
	{
		date_default_timezone_set('America/Denver');

		$this->result_set = array();
		$this->data = array();       // Dynamic variables using __get() and __set()
		$this->conn = NULL;
		$this->sql_statement = '';
		$this->last_return = false;
		$this->rows_affected = 0;
		$this->is_select_statement = false;
		$this->NumRows = 0;
		$this->NumCols = 0;
		$this->dbErrMsg = '';
		$this->from_tz = "America/Denver";
		$this->host = '';
		$this->port = '';
		$this->dbname = NULL;
		$this->user = '';
		$this->password = '';

		if (session_id() == '') {
			session_start();
		}

		if (isset($_SESSION['local_timezone_name'])) {
			$this->from_tz = $_SESSION['local_timezone_name'];
		}

		$this->debug_start('postgres.txt');
		$this->debug_on();

		$this->debug1(__FILE__, __LINE__, "Trying logon()");

		if ($this->logon($database) == false)
		{
			$this->debug1(__FILE__, __LINE__, "Cannot logon to %s", $database);
		}
	}

	/** @fn __destruct()
	 * @brief Class destructor called with object is released.
	 *  Call commit() and then logoff() before exiting.
	 * @return void
	 */
	function __destruct()
	{
		if (!$this->conn)
			return;

		$this->logoff();
	}

	/** @fn __set($name, $value)
	 * @brief Used to dynamically create object varables. fetch() result_sets are cached in these varibles.
	 * @brief To use this setter function, create a statement like this: $obj->first_name = 'Greg';
	 * @param $name is the name of the object variable you want to create.
	 * @param $value is the value you want to store in the $name object variable.
	 * @return void
	 */
	public function __set($name, $value)
	{
		$this->debug5(__FILE__, __LINE__, "postgres set: %s = %s", $name, $value);

		if (strlen($name) > 0)
			$this->data[$name] = $value;
	}

	/** @fn __get($name)
	 * @brief Used to retrieve object varables set by the setter function __set($name, $value).
	 * @brief To use this getter function, create a statement like this: printf("%s\n", $obj->first_name);
	 * @param $name is the name of the object variable value you want to retrieve.
	 * @return value of the variable or null
	 */
	public function __get($name)
	{
		$this->debug1(__FILE__, __LINE__, "postgres get: %s", $name);

		if (!$this->data)
		{
			return null;
		}

		if (array_key_exists($name, $this->data))
		{
			return $this->data[$name];
		}

		return null;
	}

	/** @fn __isset($name)
	 * @brief Used to determine if dynamic variables have been created.
	 * @brief Example: var_dump(isset($obj->first_name));
	 * @param $name is the name of the object variable you want to verify.
	 * @return true or false
	 */
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}

	/** @fn __unset($name)
	 * @brief Used to unset a dynamic object variable. Example: unset($obj->name);
	 * @param $name is the name of the object variable you want to unset.
	 * @return void
	 */
	public function __unset($name)
	{
		unset($this->data[$name]);
	}

	/** @fn read_postgres_password_file($database)
	 * @brief Retrieve the postgres userid and password from the session cache or postgres account password file
	 * @param $database is the server's IP address or Hostname
	 * @return true or false (true is success)
	 */
	private function read_private_file($database)
	{
		$filename = "../private/$database";

		$this->debug1(__FILE__, __LINE__, "read_private_file(%s), filename = %s", $database, $filename);

		if (file_exists($filename))
		{
			if (($fp = fopen($filename, "r")) === false)
			{
				$this->debug1(__FILE__, __LINE__, "Cannot open for read: %s", $filename);
				$this->dbErrMsg = sprintf("%s %s %s: Cannot open for read: %s", __FILE__, __LINE__, $filename);
				return false;
			}

			$this->debug2(__FILE__, __LINE__, "private file opened: %s", $filename);

			while (($buffer = fgets($fp, 2048)) !== false)
			{
				$field = explode("=", $buffer);
				$value = trim($field[1]);

				switch ($field[0]) {
					case 'HOST':
						$this->host = $value;
						$_SESSION['HOST'] = $value;
						break;
					case 'PORT':
						$this->port = $value;
						$_SESSION['PORT'] = $value;
						break;
					case 'DBNAME':
						$this->dbname = $value;
						$_SESSION['DBNAME'] = $value;
						break;
					case 'USER':
						$this->user = $value;
						$_SESSION['USER'] = $value;
						break;
					case 'PASSWORD':
						$this->password = $value;
						$_SESSION['PASSWORD'] = $value;
						break;
					default:
						break;
				}
			}

			fclose($fp);

			$this->debug5(__FILE__, __LINE__, "HOST:%s PORT:%s DBNAME:%s USER:%s PASSWORD=%s",
				$this->host, $this->port, $this->dbname, $this->user, $this->password);

			$this->last_return = true;
			return true;
		}

		$this->debug1(__FILE__, __LINE__, "File does not exist: %s", $filename);
		$this->dbErrMsg = sprintf("%s %s %s: File does not exist: %s", __FILE__, __LINE__, $filename);

		$this->last_return = false;
		return false;
	}

	/** @fn logon($database=NULL)
	 * @brief Login to postgres. Called when the object is created. See __construct()
	 * @param $database is the database we want to connect to
	 * @return true or false, where true means success
	 */
	public function logon($database = NULL)
	{
		if ($this->conn) {
			$this->logoff($this->conn);
		}

		if (!$this->read_private_file($database))
		{
			$this->debug1(__FILE__, __LINE__, "Error reading the %s configuration file.", $database);
			$this->last_return = false;
			return false;
		}

		$host = "host = $this->host";
		$port = "port = $this->port";
		$dbname = "dbname = $this->dbname";
		$credentials = "user = $this->user password=$this->password";

		$this->debug1(__FILE__, __LINE__, "Host: %s Port: %s DB: %s %s", $host, $port, $dbname, $credentials);

		$this->conn = pg_connect("$host $port $dbname $credentials");

		if (!$this->conn)
		{
			$this->debug1(__FILE__, __LINE__, "Unable to open database: %s", $dbname);
			$this->last_return = false;
			return false;
		}

		$this->debug5(__FILE__, __LINE__, "Connected!");
		//$this->setup_new_date_format();   // Changes default date format to: MM/DD/YYYY HH24:MI
		$this->last_return = true;
		return true;
	}

	/** @fn logoff()
	 * @brief Logout of postgres. Called when object is released. See __destruct()
	 * @return true or false, where true means success
	 */
	public function logoff()
	{
		if (!$this->conn) {
			//printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			//$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		pg_close($this->conn);
		$this->conn = NULL;
		$this->last_return = true;
		return true;
	}

	/**
	 * @brief Format and execute the SQL
	 * @return bool
	 */
	public function sql()
	{
		$this->debug1(__FILE__, __LINE__, "running sql() method");

		$argv = func_get_args();
		$this->sql_statement = vsprintf(array_shift($argv), array_values($argv));

		$this->debug_sql1(__FILE__, __LINE__, "%s", $this->sql_statement);

		$this->result_set  = pg_query($this->conn, $this->sql_statement);

		if (!$this->result_set )
		{
			$this->debug1(__FILE__, __LINE__, "pg_execute failed! - %s", pg_last_error());
			$this->last_return = false;
			return false;
		}

		//
		// Case-insensitive search for keyword select in SQL statement.
		// Is this a SELECT statement?
		//
		if (stripos($this->sql_statement, "select") === false)
		{
			$this->is_select_statement = false;
		}
		else
		{
			$this->is_select_statement = true;
			$this->rows_affected = pg_num_rows($this->result_set);
			$this->debug1(__FILE__, __LINE__, "Number of rows: %d\n", $this->rows_affected);
		}

		$this->debug1(__FILE__, __LINE__,
			"is_select_statement = %s", $this->is_select_statement == true ? "true" : "false");

		$this->last_return = true;
		return true;
	}

	/** @fn fetch()
	 * @brief Fetch will return a row of data from the sql() method and will place it into
	 *         $this->resut_set[COLUMN_NAME] = [COLUMN_VALUE].
	 *
	 *  Example:
	 *    $this->sql(select my_name from name_table where my_cuid = 'gparkin');  // Execute SQL
	 *    $this->fetch();   // Fetch data into associative $this->result_set[] array
	 *    printf("My name: %s\n", $this->my_name);  // Access using getter __get($name) list above.
	 * @return true or false, where true means we have data
	 */
	public function fetch()
	{
		if ($this->is_select_statement === false)
		{
			$this->debug1(__FILE__, __LINE__, "Previous SQL was not a SELECT statement.");
			$this->last_return = false;
			return false;
		}

		if (!$this->conn)
		{
			$this->debug1(__FILE__, __LINE__, "Not connected to %s", $this->dbname);
			$this->last_return = false;
			return false;
		}

		//
		// Last SQL was a SELECT statement so retrieve a row of data from the database.
		//
		$row = pg_fetch_row($this->result_set, null, PGSQL_ASSOC);

		//
		// If we do not have a row of data then there are no more rows of data to return.
		//
		if (!$row)
		{
			$this->last_return = false;
			return false;
		}

		//
		// Map the data to our assoitive
		foreach ($row as $k => $v)
		{
			$k = mb_strtolower($k, 'UTF-8');
			$this->data[$k] = $v;
		}

		$this->debug_r1(__FILE__, __LINE__, $row, "row");

		$this->last_return = true;
		return true;
	}

	/** @fn setup_new_date_format()
	 * @brief Set NLS DATE FORMAT to: MM/DD/YYYY HH:MI  Called by $this->login() after successful postgres connection.
	 *  For CCT we want to always use this new format when postgres retrieves dates from any database table.
	 * @return true or false, where true is success
	 */
	private function setup_new_date_format()
	{
		$alter = "alter session set nls_date_format = 'mm/dd/yyyy hh24:mi'";

		if (!$this->conn)
		{
			$this->debug1(__FILE__, __LINE__, "Not connected to database %s.", $this->dbname);
			$this->debug_dump_stack();
			$this->last_return = 0;
			return false;
		}

		if ($this->sql($alter) === false)
		{
			$this->postgres_error();
			return false;
		}

		return true;
	}

	public function getLastError()
	{
		if (!$this->conn)
		{
			$this->debug1(__FILE__, __LINE__, "Not connected to database %s.", $this->dbname);
			$this->debug_dump_stack();
			$this->last_return = 0;
			return false;
		}

		return pg_last_error($this->conn);
	}
}
?>
