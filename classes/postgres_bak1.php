<?php

use classes\library;

/**
 * @package    VisionLink
 * @file       postgres.php
 * @author     Greg Parkin <gregparkin58@gmail.com>
 */

// var $result_set;                // Associative array. The row of data returned by a select statement. 
// var $conn;                  // Database connection handle.
// var $dbErrMsg;              // Contains any database error messages.
// var $sql_statement;         // Contains the last copy of the sql statement that was executed.
// var $last_return;           // Function return code of last class function executed. (true or false)
// var $is_select_statement;   // Was this SQL a select statement? (true or false)
// var $rows_affected;         // Number of rows effected by sql statement.
// var $ip_addr;               // SERVER IP Address
	
// function __set($name, $value)                                        Example: $obj->first_name = 'Greg'; $this->result_set[$name] = $value;
// function __get($name)                                                Example: echo $obj->first_name; return $this->result_set[$name];
// function __isset($name)                                              Example: isset($obj->first_name); isset($this->result_set[$name]);
// function __unset($name)                                              Example: unset($obj->first_name); unset($this->result_set[$name]);
// function clear_result_set()                                              In case someone wants a way to free the result_set array so they can start over.
// function init_result_set()                                               In case you want you just want to empty out all the array elements.
// function dump_result_set()                                               Calls debug1(..., '$this->result_set', $this->result_set);
// function db_error($trace, $msg)                                      Example: $this->db_error(debug_backtrace(), 'msg'); Terminates PHP script.
// function logon($database=NULL)                                       Called by constructor. Only useful if logoff() is called and then used to reconnect.
// function logoff()                                                    Commit updates and close connection.
// function sql($what = "")                                             Parse and execute SQL query.
// function fetch()                                                     Fetch a row of data from select statement into $this->result_set[]
// function commit()                                                    Commit last batch of updates.
// function rollback()                                                  Rollback last batch of updates.
// function setup_new_date_format();                                    Changes default date format to: MM/DD/YYYY HH24:MI  (Called during login())
// format_sql_statement($highlight=true)                                Call SqlFormatter::format_sql to pretty up the SQL found in $this->sql_statement.

function class_autoloader($class)
{
	include_once 'classes/' . $class . '.php';
}

spl_autoload_register('class_autoloader');

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
	var $conn;                  // Database connection handle.
	var $dbErrMsg;              // Contains any database error messages.
	var $sql_statement;         // Contains the last copy of the sql statement that was executed.
	var $last_return;           // Function return code of last class function executed. (true or false)
	var $is_select_statement;   // Was this SQL a select statement? (true or false)
	var $rows_affected;         // Number of rows effected by sql statement.
	var $host;                  // postgres Database name or IP address
	var $port;                  // Postgres Port Number
	var $dbms;                  // Postgres Database name
	var $user;                  // Postgres User account
	var $pass;                  // Postgres User Password

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
printf("new postgres()\n");
		$this->result_set = array();
		$this->conn = '';
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
		$this->dbms = NULL;
		$this->user = '';
		$this->pass = '';

		if (session_id() == '') {
			session_start();
		}

		if (isset($_SESSION['local_timezone_name'])) {
			$this->from_tz = $_SESSION['local_timezone_name'];
		}

		$this->debug_start('postgres.html');
		$this->debug_on();

		printf("Trying logon()\n");
		if ($this->logon($database) == false)
		{
			printf("Cannot logon to %s\n", $database);
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

		$this->commit();
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
		$this->result_set[$name] = $value;
	}

	/** @fn __get($name)
	 * @brief Used to retrieve object varables set by the setter function __set($name, $value).
	 * @brief To use this getter function, create a statement like this: printf("%s\n", $obj->first_name);
	 * @param $name is the name of the object variable value you want to retrieve.
	 * @return value of the variable or null
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->result_set)) {
			return $this->result_set[$name];
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
		return isset($this->result_set[$name]);
	}

	/** @fn __unset($name)
	 * @brief Used to unset a dynamic object variable. Example: unset($obj->name);
	 * @param $name is the name of the object variable you want to unset.
	 * @return void
	 */
	public function __unset($name)
	{
		unset($this->result_set[$name]);
	}

	/** @fn clear_result_set()
	 * @brief Used to clear the postgres result_set array.
	 *  Releases all data so you can start over with another operation.
	 * @return void
	 */
	public function clear_result_set()
	{
		unset($this->result_set);
		$this->result_set = array();
	}

	/** @fn postgres_error()
	 * @brief Used to write debugging information to postgres.txt - sql_statement, dbErrMsg, call stack.
	 * @return void
	 */
	public function postgres_error()
	{
		printf("========= BEGIN: postgres ERROR =========<br>\n");
		printf("<p>%s</p>\n", $this->format_sql($this->sql_statement, true));  // See: classes/SqlFormatter7.php
		printf("<p>%s</p>\n", $this->dbErrMsg);

		// Retrieve and reverse the backtrace data
		$trace = array_reverse(debug_backtrace());
		$total = count($trace);
		$x = 0;

		foreach ($trace as $item) {
			$file_name = '';
			$line_number = '';
			$class_name = '';
			$method_type = '';
			$function_name = '';
			$function_args = NULL;

			if (isset($item['file'])) $file_name = $item['file'];
			if (isset($item['line'])) $line_number = $item['line'];
			if (isset($item['class'])) $class_name = $item['class'];
			if (isset($item['type'])) $method_type = $item['type'];
			if (isset($item['function'])) $function_name = $item['function'];
			if (isset($item['args'])) $function_args = $item['args'];

			$str = sprintf("%d %s(%d)", $x, basename($file_name), $line_number);

			if (strncmp($function_name, "debug", 5) != 0) {
				if (!empty($class_name)) {
					$str .= sprintf(" %s%s%s(", $class_name, $method_type, $function_name);
				} else {
					$str .= sprintf(" %s(", $function_name);
				}

				$separator = false;

				foreach ($function_args as $arg_value) {
					if (is_array($arg_value)) $what = sprintf("<array>");
					else if (is_bool($arg_value)) $what = sprintf("<%s>", $arg_value ? "true" : "false");
					else if (is_callable($arg_value)) $what = sprintf("<callable>");
					else if (is_null($arg_value)) $what = sprintf("<null>");
					else if (is_object($arg_value)) $what = sprintf("<object>");
					else if (is_resource($arg_value)) $what = sprintf("<resource>");
					else if (is_string($arg_value)) $what = sprintf("'%s'", $arg_value);
					else                              $what = sprintf("%s", $arg_value);

					if ($separator) {
						$str .= sprintf(",%s", $what);
					} else {
						$str .= sprintf("%s", $what);
						$separator = true;
					}
				}

				$str .= ")";
			}

			printf("%s<br>\n", $str);

			$x++;
		}

		printf("========== END: postgres ERROR ==========<br>File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
	}

	/** @fn read_postgres_password_file($database)
	 * @brief Retrieve the postgres userid and password from the session cache or postgres account password file
	 * @param $database is the server's IP address or Hostname
	 * @return true or false (true is success)
	 */
	private function read_private_file($database)
	{
		$filename = "../private/$database";

		printf("read_private_file(%s), filename = %s\n", $database, $filename);

		if (file_exists($filename)) {


			if (($fp = fopen($filename, "r")) === false) {
				$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "Cannot open for read: %s", $filename);
				$this->dbErrMsg = sprintf("%s %s %s: Cannot open for read: %s", __FILE__, __FUNCTION__, __LINE__, $filename);
				return false;
			}

			printf("file opened\n");

			while (($buffer = fgets($fp, 2048)) !== false) {
				$field = explode("=", $buffer);

				printf("%s = %s\n", $field[0], $field[1]);

				switch ($field[0]) {
					case 'HOST':
						$this->host = $field[1];
						$_SESSION['HOST'] = $field[1];
						break;
					case 'PORT':
						$this->port = $field[1];
						$_SESSION['PORT'] = $field[1];
						break;
					case 'DBMS':
						$this->dbms = $field[1];
						$_SESSION['DBMS'] = $field[1];
						break;
					case 'USER':
						$this->user = $field[1];
						$_SESSION['USER'] = $field[1];
						break;
					case 'PASS':
						$this->pass = $field[1];
						$_SESSION['PASS'] = $field[1];
						break;
					default:
						break;
				}

				$this->debug5(__FILE__, __FUNCTION__, __LINE__, "HOST:%s PORT:%s DBMS:%s USER:%s PASS=%s",
					$this->host, $this->port, $this->dbms, $this->user, $this->pass);
			}

			fclose($fp);

			$this->last_return = true;
			return true;
		}

		printf("Cannot find: %s\n", $filename);
		$this->debug1(__FILE__, __FUNCTION__, __LINE__, "File does not exist: %s", $filename);
		$this->dbErrMsg = sprintf("%s %s %s: File does not exist: %s", __FILE__, __FUNCTION__, __LINE__, $filename);

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
		printf("logon(%s)\n", $database);

		if ($this->conn) {
			$this->logoff($this->conn);
		}

		if (!$this->read_private_file($database))
		{
			printf("Cannot read_private_file(%s)\n", $database);
			$this->debug1(__FILE__, __FUNCTION__, __LINE__, "Error reading the %s configuration file.", $database);
			$this->last_return = false;
			return false;
		}

		$host = "host = $this->host";
		$port = "port = $this->port";
		$dbname = "dbname = $this->dbms";
		$credentials = "user = $this->user password=$this->pass";

		printf("%s %s %s %s\n", $host, $port, $dbname, $credentials);

		$this->conn = pg_connect("$host $port $dbname $credentials");

		if (!$this->conn) {
			$this->debug1(__FILE__, __FUNCTION__, __LINE__, "Unable to open database: %s", $dbname);
			$this->last_return = false;
			return false;
		}

		$this->setup_new_date_format();   // Changes default date format to: MM/DD/YYYY HH24:MI
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

	/** @fn sql()
	 * @brief Execute SQL using pg_query_parm
	 * @return true or false, where true is success
	 */
	public function sql()
	{
		if (!$this->conn) {
			printf("Not connected to database. File: %s, Line: %d<br>\n", __FILE__, __LINE__);
			$this->last_return = false;
			return false;
		}

		$num_list = func_num_args();
		$arg_list = func_get_args();

		// First arg is the SQL statement with parameters in the form of $1, $2, ...
		// The args after the first one are the arguments
		$sql = $arg_list[0];

		//
		// Build params list
		//
		$params = array();
		$x = 0;

		for ($i = 1; $i < $num_list; $i++) {
			$params[$x] = pg_escape_string($arg_list[$i]);
			$x++;
		}

		printf("num_list = %d\n", $num_list);
		printf("SQL: %s\n", $sql);
		print_r($params);

		if ($num_list == 1)
		{
			try {
				$this->result_set = pg_query_params($this->conn, $sql);
			}
			catch(exception $e)
			{
				printf("exception: %s\n", $e);
			}
		}
		else
		{
			$result = pg_prepare($this->conn, $sql, $params);

			// Execute the prepared query. Note that it is not necessary to escape strings
			$this->result_set = pg_execute($this->conn, $sql, $params);
		}

		$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $sql);

		if (!$this->result_set) {
			$message = pg_last_error($this->conn);
			print "<p>" . htmlentities($message);
			print "\n<pre>\n";
			print $this->format_sql_statement($this->sql_statement);
			print htmlentities($message);
			print "\n</pre></p>\n";
			$this->last_return = false;
			return false;
		}

		$this->rows_affected = pg_num_rows($this->result_set);

		//
		// Case-insensitive search for keyword select in SQL statement.
		// Is this a SELECT statement?
		//
		if (stripos($this->sql_statement, "select") === false) {
			$this->is_select_statement = false;
		} else {
			$this->is_select_statement = true;
		}

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
		if ($this->is_select_statement === false) {
			printf("Previous SQL was not a SELECT statement. File: %s, Func: %s, Line: %d<br>\n",
				__FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		if (!$this->conn) {
			printf("Not connected to %s. File: %s, Func: %s, Line: %d<br>\n",
				$this->dbms, __FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		//
		// Last SQL was a SELECT statement so retrieve a row of data from the database.
		//
		$row = pg_fetch_row($this->result_set);

		//
		// If we do not have a row of data then there are no more rows of data to return.
		//
		if (!$row) {
			$this->last_return = false;
			return false;
		}

		//
		// Map the data to our assoitive
		foreach ($row as $k => $v) {
			$k = mb_strtolower($k, 'UTF-8');
			$this->result_set[$k] = $v;
		}

		$this->last_return = true;
		return true;
	}

	public function begin_transaction()
	{
		if (!$this->conn) {
			printf("Not connected to %s. File: %s, Func: %s, Line: %d<br>\n",
				$this->dbms, __FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		$this->result_set = pg_query($this->conn, "BEGIN");

		if (!$this->result_set) {
			printf("Unable to BEGIN transaction. File: %s, Func: %s, Line: %d<br>\n",
				__FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		$this->last_return = true;
		return true;
	}

	/** @fn commit()
	 * @brief You must be in a tranasction state by calling $this->sql("BEGIN") before using $this->commit()
	 * @return true or false, where true is success
	 */
	public function commit()
	{
		if (!$this->conn) {
			printf("Not connected to %s. File: %s, Func: %s, Line: %d<br>\n",
				$this->dbms, __FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		$r = $this->conn->commit();

		if (!$r) {
			$this->last_return = false;
			return false;
		}

		$this->last_return = true;
		return true;
	}

	/** @fn rollback()
	 * @brief Requires you to be in a transaction state pg_query("BEGIN") or die("Could not start transaction\n");
	 *          Instruct postgres to rollback all updates from the last checkpoint.
	 * @return true or false, where true is success
	 */
	public function rollback()
	{
		if (!$this->conn) {
			printf("Not connected to %s. File: %s, Func: %s, Line: %d<br>\n",
				$this->dbms, __FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

		$this->result_set = pg_query($this->conn, "ROLLBACK");

		if (!$this->result_set) {
			printf("Unable to ROLLBACK transaction. File: %s, Func: %s, Line: %d<br>\n",
				__FILE__, __FUNCTION__, __LINE__);
			$this->last_return = false;
			return false;
		}

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

		if (!$this->conn) {
			printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = 0;
			return false;
		}

		if ($this->sql($alter) === false) {
			$this->postgres_error();
			return false;
		}

		return true;
	}
}
?>
