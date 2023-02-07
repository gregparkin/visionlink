<?php
/**
 * @package    VisionLink
 * @file       oracle.php
 * @author     Greg Parkin <gregparkin58@gmail.com>
 * @date       $Date:  $ GMT
 * @version    $Revision:  $
 */

// alter session set nls_date_format = 'mm/dd/yyyy hh24:mi';
 
//
// Oracle PHP reference manual: http://www.php.net/manual/en/ref.oci8.php
//
// Do not setup debugging in this module!
// 

// var $result;                // Associative array. The row of data returned by a select statement. 
// var $conn;                  // Database connection handle.
// var $dbErrMsg;              // Contains any database error messages.
// var $sql_statement;         // Contains the last copy of the sql statement that was executed.
// var $stid;                  // Database statement id handle.
// var $last_return;           // Function return code of last class function executed. (true or false)
// var $is_select_statement;   // Was this SQL a select statement? (true or false)
// var $rows_affected;         // Number of rows effected by sql statement.
// var $ip_addr;               // SERVER IP Address
	
// function __set($name, $value)                                        Example: $obj->first_name = 'Greg'; $this->result[$name] = $value;
// function __get($name)                                                Example: echo $obj->first_name; return $this->result[$name];
// function __isset($name)                                              Example: isset($obj->first_name); isset($this->result[$name]);
// function __unset($name)                                              Example: unset($obj->first_name); unset($this->result[$name]);
// function clear_result()                                              In case someone wants a way to free the result array so they can start over.
// function init_result()                                               In case you want you just want to empty out all the array elements.
// function dump_result()                                               Calls debug1(..., '$this->result', $this->result);
// function db_error($trace, $msg)                                      Example: $this->db_error(debug_backtrace(), 'msg'); Terminates PHP script.
// function logon($database=NULL)                                       Called by constructor. Only useful if logoff() is called and then used to reconnect.
// function logoff()                                                    Commit updates and close connection.
// function sql($what = "")                                             Parse and execute SQL query.
// function fetch()                                                     Fetch a row of data from select statement into $this->result[]
// function commit()                                                    Commit last batch of updates.
// function rollback()                                                  Rollback last batch of updates.
// function next_seq($sequence_name = '')                               Get the next sequence number from this sequence table.
// function curr_seq($sequence_name = '')                               Get the current sequence number from this sequence table.
// function FixString($receive)                                         Used to format a string for inserts. Copy of this function is also in the library class.
// function escape_quotes($receive)                                     Escape quotes and avoid double quoting for a given string or array
// function escape_result_set()                                         Escape quotes and avoid double quoting for $this->result
// function unescape_result_set()                                       Remove quotes for $this->result (Really don't need this!)
// function add_slashes_recursive($variable)                            Add slashes and avoid double quoting for a given string or array. Example: $_POST = $obj->add_slashes_recursive($_POST);
// function strip_slashes_recursive($variable)                          Strip slashes for a given string or array. Example: $_POST = $obj->strip_slashes_recursive($_POST);
// function setup_new_date_format();                                    Changes default date format to: MM/DD/YYYY HH24:MI  (Called during login())

// insert($table)                                                       INSERT statement
// column($field_name)                                                  Used to add column field name information to INSERT and SELECT statements.
// value($data_type="", $value="", $format='MM/DD/YYYY HH24:MI')        Used add value list for INERT INTO <table> (<column, ...>) VALUES <...>
// select($distinct="", $insert_select=false)                           Beginning of SELECT * FROM ... statement
// from($table)                                                         Add one or more table names for SELECT statement.
// where_open()                                                         Add open parentheses ( to group WHERE evaluations.
// where_close()                                                        Add close parethese ) to group WHERE evaluations.
// where($data_type, $field_name="", $oper="", $value="")               Beginning of the WHERE clause in SELECT statements.
// where_and($data_type, $field_name="", $oper="", $value="")           Add AND evaluation expression to existing WHERE clause.
// where_or($data_type, $field_name="", $oper="", $value="")            Add OR evaluation expression to existing WHERE clause.
// order_by($field_name)                                                Add one or more ORDER BY table field names.
// update($table)                                                       Beginning of the UPDATE statement
// set($data_type="", $field, $value="", $format='MM/DD/YYYY HH24:MI')  UPDATE SET field name assignments.
// delete($table)                                                       Delete one or more records from a table.
// inner_join($table)                                                   Inner joins let you select rows that have same value in both tables
// join($table)                                                         Join (without INNER part).
// cross_join($table)                                                   CROSS JOIN works as same as INNER JOIN.
// left_join($table)                                                    Left joins let you select all the rows from first table (left table)
// right_join($table)                                                   Right joins work opposite to left joins.
// on_open()                                                            Create an open parenthesis ( for ON statement
// on_close()                                                           Create a close parethese ) for ON statement
// on($data_type, $field_name="", $oper="", $value="")                  Beginning of the ON clause JOIN.
// on_and($data_type, $field_name="", $oper="", $value="")              Add AND evaluation expression to existing ON clause.
// on_or($data_type, $field_name="", $oper="", $value="")               Add OR evaluation expression to existing ON clause.
// group_by($field_name)                                                The GROUP BY statement is used in conjunction with the aggregate functions
// having($what)                                                        The HAVING clause was added to SQL because the WHERE keyword could not be used with aggregate functions.
// union()                                                              The UNION operator selects only distinct values by default.
// union_all()                                                          The UNION ALL operator selects all values including duplicates.
// debug()                                                              Send a copy of the SQL we are executing to the debug file.
// execute()                                                            Execute the compiled SQL found in $this->sql_statement. Return true of false for execution.

// format_sql_statement($highlight=true)                                Call SqlFormatter::format_sql to pretty up the SQL found in $this->sql_statement.
// remove_comments(&$output)                                            remove_comments will strip the sql comment lines out of an uploaded sql file
// remove_remarks($sql)                                                 remove_remarks will strip the sql comment lines out of an uploaded sql file
// split_sql_file($sql, $delimiter)                                     split_sql_file will split an uploaded sql file into single sql statements.
// run_sql_file($dbms_schema)                                           Run .sql file



//
// Class autoloader - Removes the need to add include and require statements
//
use classes\library;

if (!function_exists('__autoload'))
{
    require_once('autoloader.php');
}

/** @class oracle
 *  @brief This class is Greg's Oracle API using PHP oci8 library routines.
 *  @brief Used in all programs and classes.
 *  @note Oracle PHP reference manual: http://www.php.net/manual/en/ref.oci8.php
 */
class oracle extends library
{
	//
	// Properties
	//
	var $result;                // Associative array. The row of data returned by a select statement. 
	var $conn;                  // Database connection handle.
	var $dbErrMsg;              // Contains any database error messages.
	var $sql_statement;         // Contains the last copy of the sql statement that was executed.
	var $stid;                  // Database statement id handle.
	var $last_return;           // Function return code of last class function executed. (true or false)
	var $is_select_statement;   // Was this SQL a select statement? (true or false)
	var $rows_affected;         // Number of rows effected by sql statement.
	var $oracle_sid;            // Oracle Database SID
	var $oracle_userid;         // Oracle account userid
	var $oracle_passwd;         // Oracle account password
	
	var $ip_addr;               // SERVER IP Address
	var $from_tz;               // Local user time zone on their workstation (PC)
	var $do_insert;
	var $do_select;
	var $do_update;
	var $do_delete;
	var $do_column;
	var $do_value;
	var $do_from;
	var $do_where;
	var $do_order_by;
	var $do_set;
	var $do_join;
	var $do_on;
	var $do_group_by;
	var $do_having;
	
	/** @fn __construct($database=NULL)
	 *  @brief Class constructor - called once when the class is created.
	 *  If object is created from a batch runtime script, PHP_SAPI will be 'cli' which means we need
	 *  to do some additional environment setup for Oracle.
	 *  @param $database is set to NULL by default allow logon() to login to the configured database schema on the local server.
	 *  If $database is not NULL then logon() will try and login to that database.
	 *  @return void
	 */		
	public function __construct($database=NULL)
	{
		date_default_timezone_set('America/Denver');

		$this->result = array();
		$this->last_return = false;
		$this->is_select_statement = false;
		$this->NumRows = 0;
		$this->NumCols = 0;
		$this->dbErrMsg = '';
		$this->from_tz = "America/Denver";

		$this->init_builder_flags();

		if (PHP_SAPI === 'cli')
		{
			$this->ip_addr = gethostbyname(gethostname());
			$this->setup_oracle_environment();
		}
		else
		{
			if (session_id() == '')
			{
				session_start();
			}

			$this->ip_addr = $_SERVER['SERVER_ADDR'];

			if (isset($_SESSION['local_timezone_name']))
			{
				$this->from_tz = $_SESSION['local_timezone_name'];
			}

			$this->debug_start('oracle.html');
		}
			
		if ($database !== NULL)
		{
			$this->logon($database);
		}
		else
		{
			$this->logon($this->ip_addr);
		}
	}

	/** @fn __destruct()
	 *  @brief Class destructor called with object is released.
	 *  Call commit() and then logoff() before exiting.
	 *  @return void
	 */	
	function __destruct()
	{
		if (!$this->conn)
			return;
			
		$this->commit();
		$this->logoff();
	}
	
	/** @fn setup_oracle_environment()
	 *  @brief /ibm/apache/bin/envvars has the Oracle database environment defined, but if you are running a script
	 *  from a php (shell) script (see: cct7_auto.php) in 'cli' mode we need to setup Oracle's database environment.
	 *  So this function is called from the __construct() function when in 'cli' mode to get the environment setup.
	 *  @return void
	 */	
	private function setup_oracle_environment()
	{
		$hostname = gethostname();

		$web_server_name = '';

		if (isset($_SERVER['SERVER_NAME']))
		{
			$web_server_name = $_SERVER['SERVER_NAME'];
		}

		if      ($hostname === 'lxomp47x'  || $hostname === 'lxomp47x.corp.intranet'  || $web_server_name === 'cct.corp.intranet')
		{
			// /db/oracle/product/12102_64
			$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "hostname: %s", $hostname);

			$PATH         = getenv("PATH");
			$ORABASE_EXEC = "/db/oracle/product/12102_64/bin/orabase";
			$ORACLE_BASE  = "/home/gparkin/app/gparkin";
			$ORACLE_HOME  = "/db/oracle/product/12102_64";
			$ORACLE_SID   = "ibmtoolp";

			putenv("OPTIND=1");
			putenv("ORABASE_EXEC=" . $ORABASE_EXEC);
			putenv("ORACLE_BASE="  . $ORACLE_BASE);
			putenv("ORACLE_HOME="  . $ORACLE_HOME);
			putenv("ORACLE_SID="   . $ORACLE_SID);
			putenv("ORAENV_ASK=NO");
			putenv("ORAHOME="      . $ORACLE_HOME);
			putenv("PATH=.:" . $PATH . ":" . $ORACLE_HOME . "/bin:/opt/ibmtools/bin:/opt/lampp/bin");
			putenv("LD_LIBRARY_PATH=" . $ORACLE_HOME . "/lib64:" . $ORACLE_HOME . "/jdbc:" . $ORACLE_HOME . "/lib");
			putenv("ORACLE_USER=cct");
			putenv("ORACLE_PASSWORD=candy4Kids");
		}
		else if ($hostname === 'vlodts022' || $hostname === 'vlodts022.test.intranet' || $web_server_name === 'cct.test.intranet')
		{
			// /db/oracle/product/12102_64
			$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "hostname: %s", $hostname);

			$PATH         = getenv("PATH");
			$ORABASE_EXEC = "/db/oracle/product/12102_64/bin/orabase";
			$ORACLE_BASE  = "/home/gparkin/app/gparkin";
			$ORACLE_HOME  = "/db/oracle/product/12102_64";
			$ORACLE_SID   = "ibmtoolt";

			putenv("OPTIND=1");
			putenv("ORABASE_EXEC=" . $ORABASE_EXEC);
			putenv("ORACLE_BASE="  . $ORACLE_BASE);
			putenv("ORACLE_HOME="  . $ORACLE_HOME);
			putenv("ORACLE_SID="   . $ORACLE_SID);
			putenv("ORAENV_ASK=NO");
			putenv("ORAHOME="      . $ORACLE_HOME);
			putenv("PATH=.:" . $PATH . ":" . $ORACLE_HOME . "/bin:/opt/ibmtools/bin:/opt/lampp/bin");
			putenv("LD_LIBRARY_PATH=" . $ORACLE_HOME . "/lib64:" . $ORACLE_HOME . "/jdbc:" . $ORACLE_HOME . "/lib");
			putenv("ORACLE_USER=cct");
			putenv("ORACLE_PASSWORD=candy4Kids");
		}
		else
		{
			// LEVNOVO gethostname: oc5723165606.ibm.com
			$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "hostname: %s", $hostname);

			$PATH         = getenv("PATH");
			$ORABASE_EXEC = "/home/gparkin/app/gparkin/product/12.1.0/dbhome_1/bin/orabase";
			$ORACLE_BASE  = "/home/gparkin/app/gparkin";
			$ORACLE_HOME  = "/home/gparkin/app/gparkin/product/12.1.0/dbhome_1";
			$ORACLE_SID   = "orcl";

			putenv("OPTIND=1");
			putenv("ORABASE_EXEC=" . $ORABASE_EXEC);
			putenv("ORACLE_BASE="  . $ORACLE_BASE);
			putenv("ORACLE_HOME="  . $ORACLE_HOME);
			putenv("ORACLE_SID="   . $ORACLE_SID);
			putenv("ORAENV_ASK=NO");
			putenv("ORAHOME="      . $ORACLE_HOME);
			putenv("PATH=.:" . $PATH . ":" . $ORACLE_HOME . "/bin:/opt/ibmtools/bin:/opt/lampp/bin");
			putenv("LD_LIBRARY_PATH=" . $ORACLE_HOME . "/lib64:" . $ORACLE_HOME . "/jdbc:" . $ORACLE_HOME . "/lib");
			putenv("ORACLE_USER=cct");
			putenv("ORACLE_PASSWORD=candy4Kids");
		}
	}	
			
	/** @fn __set($name, $value)
	 *  @brief Used to dynamically create object varables. fetch() results are cached in these varibles.
	 *  @brief To use this setter function, create a statement like this: $obj->first_name = 'Greg';
	 *  @param $name is the name of the object variable you want to create.
	 *  @param $value is the value you want to store in the $name object variable.
	 *  @return void
	 */		
	public function __set($name, $value)
	{
		$this->result[$name] = $value;
	}
	
	/** @fn __get($name)
	 *  @brief Used to retrieve object varables set by the setter function __set($name, $value).
	 *  @brief To use this getter function, create a statement like this: printf("%s\n", $obj->first_name);
	 *  @param $name is the name of the object variable value you want to retrieve.
	 *  @return value of the variable or null
	 */		
	public function __get($name)
	{	
		if (array_key_exists($name, $this->result))
		{
			return $this->result[$name];
		}
			
		return null;
	}
	
	/** @fn __isset($name)
	 *  @brief Used to determine if dynamic variables have been created.
	 *  @brief Example: var_dump(isset($obj->first_name));
	 *  @param $name is the name of the object variable you want to verify.
	 *  @return true or false
	 */			
	public function __isset($name)
	{
		return isset($this->result[$name]);
	}
	
	/** @fn __unset($name)
	 *  @brief Used to unset a dynamic object variable. Example: unset($obj->name);
	 *  @param $name is the name of the object variable you want to unset.
	 *  @return void
	 */			
	public function __unset($name)
	{
		unset($this->result[$name]);
	}
	
	/** @fn clear_result()
	 *  @brief Used to clear the Oracle result array. 
	 *  Releases all data so you can start over with another operation.
	 *  @return void
	 */		
	public function clear_result()
	{
		unset($this->result);
		$this->result = array();
	}	
	
	/** @fn init_result()
	 *  @brief Used if you want you just want to empty out all the array elements.
	 *  @return void
	 */		
	public function init_result()
	{
		foreach ($this->result as $k => $v)
		{
			$this->result[$k] = NULL;
		}
	}
	
	/** @fn oracle_error()
	 *  @brief Used to write debugging information to oracle.txt - sql_statement, dbErrMsg, call stack.
	 *  @return void
	 */		
	public function oracle_error()
	{
		printf("========= BEGIN: ORACLE ERROR =========<br>\n");
		printf("<p>%s</p>\n", $this->format_sql($this->sql_statement, true));  // See: classes/SqlFormatter7.php
		printf("<p>%s</p>\n", $this->dbErrMsg);
		
		// Retrieve and reverse the backtrace data
		$trace = array_reverse(debug_backtrace());		
		$total = count($trace);
		$x = 0;
				
		foreach ($trace as $item)
		{
			$file_name = '';
			$line_number = '';
			$class_name = '';
			$method_type = '';
			$function_name = '';
			$function_args = NULL;
		
			if (isset($item['file'])) 		$file_name = $item['file'];
			if (isset($item['line'])) 		$line_number = $item['line'];
			if (isset($item['class'])) 		$class_name = $item['class'];
			if (isset($item['type'])) 		$method_type = $item['type'];
			if (isset($item['function'])) 	$function_name = $item['function'];
			if (isset($item['args'])) 		$function_args = $item['args'];

			$str = sprintf("%d %s(%d)", $x, basename($file_name), $line_number);
			
			if (strncmp($function_name, "debug", 5) != 0)
			{
				if (!empty($class_name))
				{
					$str .= sprintf(" %s%s%s(", $class_name, $method_type, $function_name);
				}
				else
				{
					$str .= sprintf(" %s(", $function_name);
				}
				
				$separator = false;

				foreach($function_args as $arg_value)
				{
					if      (is_array($arg_value))    $what = sprintf("<array>");
					else if (is_bool($arg_value))     $what = sprintf("<%s>", $arg_value ? "true" : "false");
					else if (is_callable($arg_value)) $what = sprintf("<callable>");
					else if (is_null($arg_value))     $what = sprintf("<null>");
					else if (is_object($arg_value))   $what = sprintf("<object>");
					else if (is_resource($arg_value)) $what = sprintf("<resource>");
					else if (is_string($arg_value))   $what = sprintf("'%s'", $arg_value);
					else                              $what = sprintf("%s", $arg_value);
					
					if ($separator)
					{
						$str .= sprintf(",%s", $what);
					}
					else
					{
						$str .= sprintf("%s", $what);
						$separator = true;
					}			
				}
				
				$str .= ")";
			}
			
			printf("%s<br>\n", $str);
			
			$x++;
		}
		
		printf("========== END: ORACLE ERROR ==========<br>File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);		
	}

	/** @fn read_oracle_password_file($database)
	 *  @brief Retrieve the oracle userid and password from the session cache or oracle account password file
	 *  @param $database is the server's IP address
	 *  @return true or false (true is success)
	 */
	private function read_oracle_password_file($database)
	{
		$filename = '';

		switch ( $database )
		{
			case 'localhost':  // LENOVO
			case '127.0.0.1':
				$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "cct_lenovo ORCL: %s", $database);
				$this->oracle_sid = "localhost/ORCL";
				$this->oracle_userid = "cct";
				//$filename = "/opt/ibmtools/cct7/etc/cct.txt";
				$filename = "/opt/ibmtools/private/db.acc";
				$label = "cct_lenovo";
				break;

			case 'lxomp47x':
			case 'lxomp47x.corp.intranet':
			case 'cct.corp.intranet':
			case '151.117.146.20':
				$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "cct_prod IBMTOOLP: %s", $database);
				$this->oracle_sid = "IBMTOOLP";
				$this->oracle_userid = "cct";
				//$filename = "/opt/ibmtools/cct7/etc/cct.txt";
				$filename = "/opt/ibmtools/private/db.acc";
				$label = "cct_prod";
				break;

			case 'vlodts022':
			case 'vlodts022.test.intranet':
			case 'cct.test.intranet':
			case '151.117.209.10':
				$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "cct_test IBMTOOLT: %s", $database);
				$this->oracle_sid = "IBMTOOLT";
				$this->oracle_userid = "cct";
				//$filename = "/opt/ibmtools/cct7/etc/cct.txt";
				$filename = "/opt/ibmtools/private/db.acc";
				$label = "cct_test";
				break;

			default:
				$this->dbErrMsg = "Cannot determine where oracle password file is located. (See: dbms.php read_oracle_password())";
				return false;
		}

		/*
		if (file_exists($filename))
		{
			if (($fp = fopen($filename, "r")) === false)
			{
				$this->dbErrMsg = sprintf("%s %s %s: Cannot open for read: %s", __FILE__, __FUNCTION__, __LINE__, $filename);	
				return false;
			}
			
			$this->oracle_password = trim(fread($fp, 80));
			fclose($fp);
			return true;
		}
		*/

		// db.acc = cct_prod|lxomp47x.corp.intranet:1532|ibmtoolp|cct|candy4Kids|Oracle

		if (file_exists($filename))
		{
			if (($fp = fopen($filename, "r")) === false)
			{
				$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "Cannot open for read: %s", $filename);
				$this->dbErrMsg = sprintf("%s %s %s: Cannot open for read: %s", __FILE__, __FUNCTION__, __LINE__, $filename);
				return false;
			}

			while ( ($buffer = fgets($fp, 2048)) !== false )
			{
				$field = explode("|", $buffer);

				if (count($field) >= 5)
				{
					$this->oracle_label    = trim($field[0]);
					$this->oracle_hostname = trim($field[1]);
					//$this->oracle_sid      = trim($field[2]);
					//$this->oracle_userid   = trim($field[3]);
					$this->oracle_password = trim($field[4]);
				}

				if (strcmp($label, $this->oracle_label) == 0)
				{
					break;
				}
			}

			fclose($fp);

			return true;
		}

		$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "File does not exist: %s", $filename);
		$this->dbErrMsg = sprintf("%s %s %s: File does not exist: %s", __FILE__, __FUNCTION__, __LINE__, $filename);

		return false;		
	}
				
	/** @fn logon($database=NULL)
	 *  @brief Login to Oracle. Called when the object is created. See __construct()
	 *  @param $database is the database we want to connect to
	 *  @return true or false, where true means success
	 */			
	public function logon($database=NULL)
	{
		if ($this->conn)
		{
			oci_close($this->conn);
		}
		
		if ($database === NULL)
		{
			$database = $this->ip_addr;
		}

		//
		// Unless there's a security flaw in your app, someone can't just up and change session variables - those
		// are stored on the server, and the client never has direct access to them.
		//
		// What they can do, however, is change their session ID by going to a URL like http://your.site.com/?PHPSESSID=2342f24502ade525.
		// The potential for abuse there is twofold: (1) if they happened to know a logged-in user's session ID somehow, the session
		// ID would let them impersonate that user, giving them all the access that user has; and (2) If they can trick someone into
		// going to a URL that has a session ID attached, and that person logs in, they now know that user's session ID (because they
		// provided it!), and we're back to (1).
		//
		
		//
		// If this is a cli program (shell) then we always read the password file.
		//
		if (PHP_SAPI === 'cli')
		{
			//printf("PHP_SAPI = cli<br>\n");

			//
			// This PHP program is running outside the apache web server
			//
			if ($this->read_oracle_password_file($database) == false)
			{
				printf("%s %s %s: Cannot read_oracle_password_file: %s<br>\n", __FILE__, __FUNCTION__, __LINE__, $database);
				return false;
			}
		}
		else if (!isset($_SESSION['orasid']) || !isset($_SESSION['orauser']) || !isset($_SESSION['orapwd']))	
		{
			//
			// Assume that we are running this program from the apache web server
			//
			if ($this->read_oracle_password_file($database) == false)
			{
				printf("%s %s %s: Cannot read_oracle_password_file: %s<br>%s\n", __FILE__, __FUNCTION__, __LINE__, $database, $this->dbErrMsg);
				return false;
			}
				
			//
			// Store the userid and password into the user's session cache
			//
			$_SESSION['orasid'] = $this->oracle_sid;
			$_SESSION['orausr'] = $this->oracle_userid;
			$_SESSION['orapwd'] = $this->oracle_password;
		}
		else
		{
			//
			// Retrieve the userid and password from the user's session cache
			//
			$this->oracle_sid    = $_SESSION['orasid'];
			$this->oracle_userid = $_SESSION['orausr'];
			$this->oracle_passwd = $_SESSION['orapwd'];	
		}	

		// printf("Connecting with: %s/%s sid=%s\n", $this->oracle_userid, $this->oracle_password, $this->oracle_sid);
		$this->conn = oci_connect($this->oracle_userid, $this->oracle_password, $this->oracle_sid);

		if (!$this->conn) 
		{
			$e = oci_error();  // For oci_connect errors do not pass a handle
			$this->dbErrMsg = $e['message'];
			$this->debug_dump_stack();
			$this->last_return = false;
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
			return false;
		}
		
		$this->setup_new_date_format();   // Changes default date format to: MM/DD/YYYY HH24:MI
		$this->last_return = true;
		return true;
	}
	
	/** @fn logoff()
	 *  @brief Logout of Oracle. Called when object is released. See __destruct()
	 *  @return true or false, where true means success
	 */		
	public function logoff()
	{
		if (!$this->conn)
		{
			//printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
		    //$this->debug_dump_stack();
			//$this->last_return = false;	
			return false;	
		}
					
		oci_close($this->conn);
		$this->last_return = true;
		return true;
	}
	
	/** @fn escape_quotes($receive)
	 *  @brief Escape quotes and avoids double-quoting for a given string or array.
	 *  @param $receive is the string we want to escape the quotes.
	 *  @return the new formatted string
	 */		
	public function escape_quotes($receive)
	{
		if (!is_array($receive))
			$thearray = array($receive);
		else
			$thearray = $receive;
			
		foreach (array_keys($thearray) as $string)
		{
			$thearray[$string] = addslashes($thearray[$string]);
			$thearray[$string] = preg_replace("/[\\/]+/","/",$thearray[$string]);
		}
		
		if (!is_array($receive))
		{
			return $thearray[0];
		}
		else
		{
			return $thearray;
		}
	}
	
	/** @fn FixString($receive)
	 *  @brief Used to format a string for inserts. Copy of this function is also in the library class.
	 *  @param $receive is the string we want fix.
	 *  @return the new formatted string
	 */			
	public function FixString($receive)
	{
		$s = '';
		$str = str_split($receive);
		$len = count($str);
		
		for ($x=0; $x<$len; $x++)
		{
			//if ($str[$x] == '\'')
			//	$s .= '\'';
				
			if ($str[$x] == '%')
				$s .= '%';
				
			$s .= $str[$x];
		}
		
		return str_replace("'", "''", $s);
	}
	
	/** @fn escape_result_set()
	 *  @brief Add slashes to all data strings in the $this->result set.
	 *  If you want to add slashes to special symbols that would interfere with a regular 
	 *  expression (i.e., . \ + * ? [ ^ ] $ ( ) { } = ! < > | :), you should use the preg_quote() function.
	 *  @return the new formatted string
	 */	
	public function escape_result_set()
	{
		$this->result = $this->add_slashes_recursive($this->result);
	}
	
	/** @fn unescape_result_set()
	 *  @brief Remove slashes to all data strings in the $this->result set.
	 *  @return the new formatted string
	 */		
	public function unescape_result_set()
	{
		$this->result = $this->strip_slashes_recursive($this->result);
	}

	/** @fn add_slashes_recursive($variable)
	 *  @brief given a string - it will simply add slashes
	 *  given an array - it will recursively add slashes from the array and all of it subarrays. 
	 *  if the value is not a string or array - it will remain unmodified!
	 *  @param $variable is the string we want to add the slashes.
	 *  @return the new formatted string
	 */		
	public function add_slashes_recursive($variable)
	{
		if ( is_string( $variable ) )
		{
			$my_string = addslashes($variable);
			return preg_replace("/[\\/]+/","/",$my_string);  // Avoid double quoting
 		}
		elseif ( is_array( $variable ) )
		{
			foreach( $variable as $i => $value )
				$variable[ $i ] = $this->add_slashes_recursive( $value ) ;	
		}
				
		return $variable;
	}
	
	/** @fn strip_slashes_recursive($variable)
	 *  @brief given a string - it will simply strip slashes
	 *  given an array - it will recursively strip slashes from the array and all of it subarrays. 
	 *  if the value is not a string or array - it will remain unmodified!
	 *  @param $variable is the string we want to remove the slashes.
	 *  @return the new formatted string
	 */		
	public function strip_slashes_recursive($variable)
	{
		if ( is_string( $variable ) )
			return stripslashes( $variable ) ;

		if ( is_array( $variable ) )
			foreach( $variable as $i => $value )
				$variable[ $i ] = $this->strip_slashes_recursive( $value ) ;
     
		return $variable ; 	
	}
	
	/** @fn sql()
	 *  @brief Execute printf style SQL statement on the Oracle server.
	 *  @return true or false, where true is success
	 */		
	public function sql()
	{
		$argv = func_get_args();
		$format = array_shift($argv);
		
		if (isset($format) && isset($argv))
		{
			$what = sprintf($format, $argv);
		}
		else
		{
			$this->dbErrMsg = "Invalid number of arguments in sql function: Please contact Greg";
			$this->last_return = false;
			return false;
		}
		
		if (!$this->conn)
		{
		    printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;	
			return false;		
		}

		if (strlen($what) == 0)
		{
			printf("SQL statement is a empty string. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);	
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;					
		}
		
		$this->sql_statement = $what;

		$this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $this->sql_statement);
		//$this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $this->ora->dbErrMsg);
		
		//
		// Free any previous statement handles
		//
		if ($this->stid)
		{
			oci_free_statement($this->stid);
		}
		
		//
		// Prepare the statement
		//	
		$this->stid = oci_parse($this->conn, $this->sql_statement);

		if (!$this->stid)
		{
			//
			// Something is wrong with the SQL syntax
			//
			$e = oci_error($this->stid);
			$this->dbErrMsg = $e['message'];
			
			//
			// Send nice formatted text about the error to STDOUT
			//
   			print "<p>" . htmlentities($e['message']);
		    print "\n<pre>\n";
		    print htmlentities($e['sqltext']);
		    printf("\n%".($e['offset']+1)."s", "^");
		    print "\n</pre></p>\n";		
		
			//
			// Write any debugging information
			//
			$this->oracle_error();  // write SQL, dbErrMsg, and backtrack data
			
			$this->last_return = false;
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
			return false;		
		}

		//
		// Perform the logic of the query
		// 	
		$r = oci_execute($this->stid);
			
		if (!$r)
		{
			//
			// Something went wrong while executing the SQL
			//
			$e = oci_error($this->stid);  // For oci_execute errors pass the statement handle 
			$this->dbErrMsg = $e['message'];
			
			//
			// Send nice formatted text about the error to STDOUT
			//
   			print "<p>" . htmlentities($e['message']);
		    print "\n<pre>\n";
		    print htmlentities($e['sqltext']);
		    printf("\n%".($e['offset']+1)."s", "^");
		    print "\n</pre></p>\n";
			
			//
			// Write any debugging information
			//
			$this->oracle_error();  // write SQL, dbErrMsg, and backtrack data
			
			$this->last_return = false;
			return false;
		}

		$this->rows_affected = oci_num_rows($this->stid);

		//
		// Case insensitive search for keyword select in SQL statement
		//
		if (stripos($this->sql_statement, "select") === false)
		{
			$this->is_select_statement = false;
		}
		else
		{
			$this->is_select_statement = true;
		}

		$this->last_return = true;
		return true;
	}

	/** @fn     sql2($what)
	 *
	 *  @brief  Execute $what as SQL
	 *
	 *  @param  string $what is the SQL we want to execute.
	 *
	 *  @return true or false, where true is success
	 */
	public function sql2($what)
	{
		if (!$this->conn)
		{
			printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		if (strlen($what) == 0)
		{
			printf("SQL statement is a empty string. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		$this->sql_statement = $what;

		//
		// Free any previous statement handles
		//
		if ($this->stid)
		{
			oci_free_statement($this->stid);
		}

		//
		// Prepare the statement
		//
		$this->stid = oci_parse($this->conn, $this->sql_statement);

		if (!$this->stid)
		{
			//
			// Something is wrong with the SQL syntax
			//
			$e = oci_error($this->stid);
			$this->dbErrMsg = $e['message'];

			printf("\n<pre>\n");
			printf("%s\n", $this->sql_statement);
			printf("%s\n", $this->dbErrMsg);
			printf("\n</pre>\n");

			//
			// Send nice formatted text about the error to STDOUT
			//
			//print "<p>" . htmlentities($e['message']);
			//print "\n<pre>\n";
			//print htmlentities($e['sqltext']);
			//printf("\n%".($e['offset']+1)."s", "^");
			//print "\n</pre></p>\n";

			//
			// Write any debugging information
			//
			$this->oracle_error();  // write SQL, dbErrMsg, and backtrack data

			$this->last_return = false;
			trigger_error(htmlentities($e['message']), E_USER_ERROR);
			return false;
		}

		//
		// Perform the logic of the query
		//
		$r = oci_execute($this->stid);

		if (!$r)
		{
			//
			// Something went wrong while executing the SQL
			//
			$e = oci_error($this->stid);  // For oci_execute errors pass the statement handle
			$this->dbErrMsg = $e['message'];

			//
			// Send nice formatted text about the error to STDOUT
			//
			print "<p>" . htmlentities($e['message']);
			print "\n<pre>\n";
			print htmlentities($e['sqltext']);
			printf("\n%".($e['offset']+1)."s", "^");
			print "\n</pre></p>\n";

			//
			// Write any debugging information
			//
			$this->oracle_error();  // write SQL, dbErrMsg, and backtrack data

			$this->last_return = false;
			return false;
		}

		$this->rows_affected = oci_num_rows($this->stid);

		//
		// Case insensitive search for keyword select in SQL statement
		//
		if (stripos($this->sql_statement, "select") === false)
		{
			$this->is_select_statement = false;
		}
		else
		{
			$this->is_select_statement = true;
		}

		$this->last_return = true;
		return true;
	}

	// 
	// Just some NOTES:
	//
	// $stid = oci_parse($conn, 'SELECT id, description FROM mytab');
	// oci_execute($stid);
	// 
	// while (($row = oci_fetch_array($stid, OCI_NUM))) {
	//     echo $row[0] . "<br>\n";
	//     echo $row[1]->read(11) . "<br>\n"; // this will output first 11 bytes from DESCRIPTION
	// }
	// 
	// $stid = oci_parse($conn, 'SELECT department_id, department_name FROM departments');
	// oci_execute($stid);
	// 
	// while (($row = oci_fetch_array($stid, OCI_BOTH))) {
	//     // Use the uppercase column names for the associative array indices
	//     echo $row[0] . " and " . $row['DEPARTMENT_ID']   . " are the same<br>\n";
	//     echo $row[1] . " and " . $row['DEPARTMENT_NAME'] . " are the same<br>\n";
	// }
	// 
	//                               oci_fetch_array() Modes Constant Description 
	// 							  --------------------------------------------
	// OCI_BOTH          Returns an array with both associative and numeric indices. This is the same as OCI_ASSOC + OCI_NUM and is the default behavior. 
	// OCI_ASSOC         Returns an associative array. 
	// OCI_NUM           Returns a numeric array. 
	// OCI_RETURN_NULLS  Creates elements for NULL fields. The element values will be a PHP NULL.  
	// OCI_RETURN_LOBS   Returns the contents of LOBs instead of the LOB descriptors. 
	// 
	// 
	// The default mode is OCI_BOTH. 
	// 
	// Use the addition operator "+" to specify more than one mode at a time. 
	// 	

	/** @fn fetch()
	 *  @brief Return a row of data for the previously executed SQL select query.
	 *  Results are returned to this->result[fieldname] = value. This is an associative array
	 *  and values can be accessed directory using getters and setters functions using the fieldnames.
	 *  Example: 
	 *    $this->sql(select my_name from name_table where my_cuid = 'gparkin');  // Execute SQL
	 *    $this->fetch();   // Fetch data into associative $this->result[] array
	 *    printf("My name: %s\n", $this->my_name);  // Access using getter __get($name) list above.
	 *  @return true or false, where true means we have data
	 */	
	public function fetch()
	{
		if (!$this->conn)
		{
			printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
		    $this->debug_dump_stack();
			$this->last_return = false;	
			return false;	
		}	
		
		if ($this->is_select_statement === false)
		{
			printf("This is not a SELECT statement. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->oracle_error();
			$this->last_return = false;	
			return false;
		}
		
		//
		// Notes on other OCI8 functions that are available:
		// ------------------------------------------------------------------------------------------
		// oci_fetch_assoc()  - Returns the next row from a query as an associative array
		// oci_fetch()        - Fetches the next row from a query into internal buffers
		// oci_fetch_all()    - Fetches multiple rows from a query into a two-dimensional array
		// oci_fetch_array()  - Returns the next row from a query as an associative or numeric array
		// oci_fetch_object() - Returns the next row from a query as an object
		// oci_fetch_row()    - Returns the next row from a query as a numeric array
		//
		
		if ($row = oci_fetch_assoc($this->stid))
		{			
			//
			// Place data in $this->result[] associative array
			//
			foreach ($row as $k => $v)
			{
				$k = mb_strtolower($k, 'UTF-8');
				$this->result[$k] = $v;
			}			
			
			$this->last_return = true;
			return true;
		}
		
		$this->last_return = false;	
		return false;
	}
	
	/** @fn commit()
	 *  @brief Instruct Oracle to commit all updates to the database.
	 *  This function is also called by the __destruct() function when the object is released.
	 *  @return true or false, where true is success
	 */		
	public function commit()
	{
		if (!$this->conn)
		{
		    //printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			//$this->debug_dump_stack();
			//$this->last_return = false;	
			return false;		
		}	
		
		$r = oci_commit($this->conn);

		if (!$r) 
		{
		    $e = oci_error();
			printf("%s\n", $e['message']);
			$this->dbErrMsg = $e['message'];
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		$this->last_return = true;
		return true;		
	}
	
	/** @fn rollback()
	 *  @brief Instruct Oracle to rollback all updates from the last checkpoint.
	 *  @return true or false, where true is success
	 */		
	public function rollback()
	{
		if (!$this->conn)
		{
		    printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;	
			return false;	
		}	
		
		$r = oci_rollback($this->conn);

		if (!$r) 
		{
		    $e = oci_error();
			printf("%s\n", $e['message']);
			$this->dbErrMsg = $e['message'];
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		$this->last_return = true;
		return true;			
	}
	
	/** @fn next_seq($sequence_name = '')
	 *  @brief Get the next sequence number for record inserts from the specified sequence table name.
	 *  This function is used heavily throughout CCT.
	 *  @param $sequence_name is the name of the sequence table you want the next sequence number from.
	 *  @return true or false, where true is success
	 */		
	public function next_seq($sequence_name = '')
	{	
		if (!$this->conn)
		{
		    printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = 0;	
			return 0;	
		}	
		
		if (strlen($sequence_name) === 0)
		{
			printf("Must include sequence_name. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->last_return = 0;	
			return 0;			
		}
		
		if ($this->sql('select ' . $sequence_name . '.nextval as nextval from dual') === false)
		{
			printf("Get next sequence for %s failed. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", $sequence_name, __FILE__, __LINE__);
			return 0;
		}
		
		if ($this->fetch())
		{
			return $this->result['nextval'];
		}

		printf("Get next sequence for %s failed. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", $sequence_name, __FILE__, __LINE__);
		return 0;
	}
	
	/** @fn curr_seq($sequence_name = '')
	 *  @brief Get the current sequence number from the specified sequence table name.
	 *  @param $sequence_name is the name of the sequence table you want the current sequence number from.
	 *  @return true or false, where true is success
	 */		
	public function curr_seq($sequence_name = '')
	{	
		if (!$this->conn)
		{
		    printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;	
			return false;	
		}	
		
		if (strlen($sequence_name) === 0)
		{
		    printf("Must include sequence_name. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->last_return = 0;	
			return 0;			
		}
		
		if ($this->sql('select ' . $sequence_name . '.currval as currval from dual') === false)
		{
			printf("Get current sequence for %s failed. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", $sequence_name, __FILE__, __LINE__);
			return 0;
		}
		
		if ($this->fetch())
		{
			return $this->result['currval'];
		}

		printf("Get current sequence for %s failed. returning 0. File: %s, Line: %d - Call Greg Parkin<br>\n", $sequence_name, __FILE__, __LINE__);
		return 0;		
	}
	
	/** @fn setup_new_date_format()
	 *  @brief Set NLS DATE FORMAT to: MM/DD/YYYY HH:MI  Called by $this->login() after successful Oracle connection.
	 *  For CCT we want to always use this new format when Oracle retrieves dates from any database table.
	 *  @return true or false, where true is success
	 */			
	private function setup_new_date_format()
	{
		$alter = "alter session set nls_date_format = 'mm/dd/yyyy hh24:mi'";
		
		if (!$this->conn)
		{
		    printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = 0;	
			return false;	
		}	
		
		if ($this->sql($alter) === false)
		{
			$this->oracle_error();
			return false;
		}

		return true;	
	}

	// xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
	
	private function init_builder_flags()
	{
		$this->do_insert = 0;
		$this->do_select = 0;
		$this->do_update = 0;
		$this->do_delete = 0;
		$this->do_column = 0;
		$this->do_value = 0;
		$this->do_from = 0;
		$this->do_where = 0;
		$this->do_order_by = 0;
		$this->do_set = 0;
		$this->do_join = 0;
		$this->do_on = 0;
		$this->do_group_by = 0;
		$this->do_having = 0;
	}

	/**
	 * @fn insert($table)
	 * @brief INSERT statement
	 *
	 * @param $table - Name of the table we are inserting records into.
	 *
	 * @return $this
	 */
	public function insert($table)
	{
		$this->init_builder_flags();
		$this->do_insert = 1;
		$this->sql_statement = "INSERT INTO " . $table;
		$this->sql_statement .= " ";

		return $this;
	}

	/**
	 * @fn column($field_name)
	 * @brief Used to add column field name information to INSERT and SELECT statements.
	 *
	 * @param $field_name
	 *
	 * @return $this
	 */
	public function column($field_name)
	{
		if ($this->do_insert == 1)
		{
			$this->do_insert = 0;
			$this->sql_statement .= " ( ";
		}

		if ($this->do_column == 0)
		{
			$this->do_column = 1;
			$this->sql_statement .= $field_name . " ";
		}
		else
		{
			$this->sql_statement .= ", " . $field_name . " ";
		}

		return $this;
	}

	/**
	 * @fn value($data_type="", $value="", $format='%m/%d/%Y')
	 * @brief Used add value list for INERT INTO <table> (<column, ...>) VALUES <...>
	 *
	 * @param string $data_type - Oracle DATE type
	 * @param string $value - Value being assigned
	 * @param string $format - Date format if data type is for date, time, datetime or timestamp
	 *
	 * @return $this
	 */
	public function value($data_type="", $value="", $format='MM/DD/YYYY HH24:MI')
	{
		if ($this->do_column == 1)
		{
			$this->sql_statement .= " ) ";
			$this->do_column = 0;
		}

		if ($this->do_value == 0)
		{
			$this->sql_statement .= " VALUES ( ";
			$this->do_value = 1;
		}
		else
		{
			$this->sql_statement .= ", ";
		}

		$lc = strtolower($data_type);

		if ($lc === 'to_date')
		{
			$this->sql_statement .= "TO_DATE('" . $value . ", '" . $format . "')";
		}
		else if ($lc === 'to_char')
		{
			$this->sql_statement .= "TO_CHAR('" . $value . ", '" . $format . "')";
		}
		else if ($lc === 'sysdate')
		{
			$this->sql_statement .= "SYSDATE";
		}
		else if ($lc === 'now')
		{
			// Get the current GMT Unix utime in London (offset 0)
			date_default_timezone_set('Europe/London');
			$this->sql_statement .= date('U', time());
		}
		else if ($lc === 'utime')
		{
			$dt = new DateTime($value, new DateTimeZone($this->from_tz));
			$dt->setTimezone(new DateTimeZone('Europe/London'));     // GMT offset 0
			$this->sql_statement .= $dt->format('U');
		}
		else if ($lc === 'int' || $lc === 'number'|| $lc === 'func')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= "0";
            }
            else
            {
                $this->sql_statement .= $value;
            }
		}
		else
		{
			//$this->sql_statement .= "'" . $this->escape_quotes($value) . "'";
			$this->sql_statement .= "'" . $this->FixString($value) . "'";
		}

		return $this;
	}

	/**
	 * @fn select($distinct="")
	 * @brief Beginning of SELECT * FROM ... statement
	 *
	 * @param string $distinct - Add DISTINCT of string is 'distinct'
	 * @param string $insert_select - SELECT is part of INSERT INTO ... SELECT ...
	 *
	 * @return $this
	 */
	public function select($distinct="", $insert_select=false)
	{
		$this->init_builder_flags();

		if ($insert_select)
		{
			$this->sql_statement .= " ) SELECT ";
		}
		else
		{
			$this->sql_statement = "SELECT ";
		}

		$this->do_select = 1;

		if (strtolower($distinct) === 'distinct')
			$this->sql_statement .= " DISTINCT ";

		return $this;
	}

	/**
	 * @fn from($table)
	 * @brief Add one or more table names for SELECT statement.
	 *
	 * @param $table - Name of the table plus any alias identifier lable.
	 *
	 * @return $this
	 */
	public function from($table)
	{
		if ($this->do_column == 1)
			$this->do_column = 0;

		if ($this->do_from == 0)
		{
			$this->do_from = 1;
			$this->sql_statement .= " FROM " . $table . " ";
		}
		else
		{
			$this->sql_statement .= ", " . $table . " ";
		}

		return $this;
	}

	/**
	 * @fn where_open()
	 * @brief Add open parentheses ( to group WHERE evaluations.
	 *
	 * @return $this
	 */
	public function where_open()
	{
		$this->sql_statement .= " ( ";

		return $this;
	}

	/**
	 * @fn where_close();
	 * @brief Add close parethese ) to group WHERE evaluations.
	 *
	 * @return $this
	 */
	public function where_close()
	{
		$this->sql_statement .= " ) ";

		return $this;
	}

	/**
	 * @fn where($data_type, $field_name, $oper, $value)
	 * @brief Beginning of the WHERE clause in SELECT statements. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - Oracle evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function where($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		if ($this->do_where == 0)
		{
			$this->do_where = 1;
			$this->sql_statement .= " WHERE ";
		}

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'number' || strtolower($data_type) === 'func')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char' || strtolower($data_type) === 'varchar2')
		{
			$this->sql_statement .= $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn where_and($data_type, $field_name="", $oper="", $value="")
	 * @brief Add AND evaluation expression to existing WHERE clause. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - MySQL evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function where_and($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_where == 0)
			return $this;

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'func')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= " AND " . $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= " AND " . $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char')
		{
			$this->sql_statement .= " AND " . $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " AND " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn where_or($data_type, $field_name="", $oper="", $value="")
	 * @brief Add OR evaluation expression to existing WHERE clause. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - MySQL evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function where_or($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_from == 1)
		{
			$this->do_from = 0;
			$this->do_where = 1;
			$this->sql_statement .= " where ";
		}

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'func')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= " or " . $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= " or " . $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char')
		{
			$this->sql_statement .= " or " . $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " OR " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn order_by($order)
	 * @brief Add one or more ORDER BY table field names.
	 *
	 * @param $field_name
	 *
	 * @return $this
	 */
	public function order_by($field_name)
	{
		if ($this->do_where == 1)
			$this->do_where = 0;

		if ($this->do_order_by == 0)
		{
			$this->do_order_by = 1;
			$this->sql_statement .= " ORDER BY ";
		}
		else
		{
			$this->sql_statement .= ", ";
		}

		$this->sql_statement .= $field_name . " ";

		return $this;
	}

	/**
	 * @fn update($table)
	 * @brief Beginning of the UPDATE statement
	 *
	 * @param $table - Name of table we are updating.
	 *
	 * @return $this
	 */
	public function update($table)
	{
		$this->init_builder_flags();
		$this->do_update = 1;

		$this->sql_statement = "UPDATE " . $table . " ";

		return $this;
	}

	/**
	 * @fn set($data_type="", $field, $value="", $format='MM/DD/YYYY HH24:MI')
	 * @brief UPDATE SET field name assignments.
	 *
	 * @param string $data_type - Oracle DATE type.
	 * @param        $field - Table field name.
	 * @param string $value - Assign value for field name
	 * @param string $format - Format if $data_type is 'date', 'time', 'datetime', or 'timestamp'.
	 *
	 * @return $this
	 */
	public function set($data_type="", $field, $value="", $format='MM/DD/YYYY HH24:MI')
	{
		if ($this->do_set == 0)
		{
			$this->do_set = 1;
			$this->sql_statement .= " SET ";
		}
		else
		{
			$this->sql_statement .= ", ";
		}

		$lc = strtolower($data_type);

		if ($lc === 'to_date')
		{
			$this->sql_statement .= $field . " = TO_DATE('" . $value . ", '" . $format . "')";
		}
		else if ($lc === 'to_char')
		{
			$this->sql_statement .= $field . " = TO_CHAR('" . $value . ", '" . $format . "')";
		}
		else if ($lc === 'sysdate')
		{
			$this->sql_statement .= $field . " = SYSDATE";
		}
		else if ($lc === 'now')
		{
			// Get the current GMT Unix utime in London (offset 0)
			date_default_timezone_set('Europe/London');
			$this->sql_statement .= $field . " = " . date('U', time());
		}
		else if ($lc === 'utime')
		{
			$dt = new DateTime($value, new DateTimeZone($this->from_tz));
			$dt->setTimezone(new DateTimeZone('Europe/London'));     // GMT offset 0
			$this->sql_statement .= $dt->format('U');
		}
		else if ($lc === 'int' || $lc === 'number' || $lc === 'func')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= " = 0";
            }
            else
            {
                $this->sql_statement .= $field . " = " . $value;
            }
		}
		else
		{
			//$this->sql_statement .= $field . " = '" . $this->escape_quotes($value) . "'";
			$this->sql_statement .= $field . " = '" . $this->FixString($value) . "'";
		}

		return $this;
	}

	/**
	 * @fn delete($table)
	 * @brief Delete one or more records from a table.
	 *
	 * @param $table - Name of the table to delete records from.
	 *
	 * @return $this
	 */
	public function delete($table)
	{
		$this->init_builder_flags();
		$this->do_delete = 1;

		$this->sql_statement = "DELETE FROM " . $table;

		return $this;
	}

	/**
	 * @fn inner_join($table)
	 * @brief Inner joins let you select rows that have same value in both tables for specified columns thereby
	 *        returns matching rows. We specify the first table after FROM as in normal SELECT statements and the
	 *        second table is specified after INNER JOIN.
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function inner_join($table)
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		$this->do_join = 1;
		$this->sql_statement .= " INNER JOIN " . $table . " ";

		return $this;
	}

	/**
	 * @fn join($table)
	 * @brief Join (without INNER part).
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function join($table)
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		$this->do_join = 1;
		$this->sql_statement .= " JOIN " . $table . " ";

		return $this;
	}

	/**
	 * @fn cross_join($table)
	 * @brief CROSS JOIN works as same as INNER JOIN.
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function cross_join($table)
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		$this->do_join = 1;
		$this->sql_statement .= " CROSS JOIN " . $table . " ";

		return $this;
	}

	/**
	 * @fn left_join($table)
	 * @brief Left joins let you select all the rows from first table (left table) for specified relationship and
	 *        fetch only the matching ones from the second table (right table.)
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function left_join($table)
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		$this->do_join = 1;
		$this->sql_statement .= " LEFT JOIN " . $table . " ";

		return $this;
	}

	/**
	 * @fn right_join($table)
	 * @brief Right joins work opposite to left joins. That is, priority is given to right table and fetchs all the
	 *        rows from right table for given relationship.
	 *
	 * @param $table
	 *
	 * @return $this
	 */
	public function right_join($table)
	{
		if ($this->do_from == 1)
			$this->do_from = 0;

		$this->do_join = 1;
		$this->sql_statement .= " RIGHT JOIN " . $table . " ";

		return $this;
	}

	/**
	 * @fn on_open()
	 * @brief Create an open parenthesis ( for ON statement
	 * @return $this
	 */
	public function on_open()
	{
		$this->sql_statement .= " ( ";

		return $this;
	}

	/**
	 * @fn on_close()
	 * @brief Create a close parethese ) for ON statement
	 * @return $this
	 */
	public function on_close()
	{
		$this->sql_statement .= " ) ";

		return $this;
	}

	/**
	 * @fn on($data_type, $field_name, $oper, $value)
	 * @brief Beginning of the ON clause JOIN. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - Oracle evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function on($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_join == 1)
			return $this;

		if ($this->do_on == 0)
		{
			$this->do_on = 1;
			$this->sql_statement .= " ON ";
		}

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'number')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char' || strtolower($data_type) === 'varchar2')
		{
			$this->sql_statement .= $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn on_and($data_type, $field_name="", $oper="", $value="")
	 * @brief Add AND evaluation expression to existing ON clause. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - Oracle evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function on_and($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_join == 0)
			return $this;

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'number')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= " AND " . $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= " AND " . $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char' || strtolower($data_type) === 'varchar2')
		{
			$this->sql_statement .= " AND " . $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " AND " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn on_or($data_type, $field_name="", $oper="", $value="")
	 * @brief Add OR evaluation expression to existing ON clause. If $data_type is not 'int' or 'char' then
	 *        we use the contents of $data_type as the evaluation expression and ignore the rest of the params.
	 *
	 * @param $data_type - Expects 'int' or other data type.
	 * @param $field_name - Name of the table field name being evaluated.
	 * @param $oper - MySQL evaluation operator
	 * @param $value - Value to evaluate field name against.
	 *
	 * @return $this
	 */
	public function on_or($data_type, $field_name="", $oper="", $value="")
	{
		if ($this->do_join == 0)
			return $this;

		if (strtolower($data_type) === 'int' || strtolower($data_type) === 'number')
		{
            if (is_null($value) || !is_numeric($value))
            {
                $this->sql_statement .= " OR " . $field_name . " " . $oper . " 0 ";
            }
            else
            {
                $this->sql_statement .= " OR " . $field_name . " " . $oper . " " . $value . " ";
            }
		}
		else if (strtolower($data_type) === 'char' || strtolower($data_type) === 'varchar2')
		{
			$this->sql_statement .= " OR " . $field_name . " " . $oper . " '" . $value . "' ";
		}
		else if (strlen($data_type) > 0)
		{
			$this->sql_statement .= " OR " . $data_type . " ";
		}

		return $this;
	}

	/**
	 * @fn group_by($field_name)
	 * @brief The GROUP BY statement is used in conjunction with the aggregate functions to group the result-set by
	 *        one or more columns.
	 *
	 * @param $field_name
	 *
	 * @return $this
	 */
	public function group_by($field_name)
	{
		if ($this->do_group_by == 0)
		{
			$this->do_group_by = 1;
			$this->sql_statement .= $field_name . " ";
		}
		else
		{
			$this->sql_statement .= ", " . $field_name . " ";
		}

		return $this;
	}

	/**
	 * @fn having($what)
	 * @brief The HAVING clause was added to SQL because the WHERE keyword could not be used with aggregate functions.
	 *
	 * @example SELECT Employees.LastName, COUNT(Orders.OrderID) AS NumberOfOrders FROM (Orders
	 *          INNER JOIN Employees
	 *          ON Orders.EmployeeID=Employees.EmployeeID)
	 *          GROUP BY LastName
	 *          HAVING COUNT(Orders.OrderID) > 10;
	 *
	 * @param $what - Field name or aggregate function.
	 *
	 * @return $this
	 */
	public function having($what)
	{
		if ($this->do_group_by == 1)
			$this->do_group_by = 0;

		if ($this->do_having == 0)
		{
			$this->do_having = 1;
			$this->sql_statement .= $what . " ";
		}
		else
		{
			$this->sql_statement .= ", " . $what . " ";
		}

		return $this;
	}

	/**
	 * @fn union()
	 * @brief The UNION operator selects only distinct values by default. To allow duplicate values, use the ALL
	 *        keyword with UNION.
	 *
	 * @return $this
	 */
	public function union()
	{
		if ($this->do_union == 0)
		{
			$this->do_union = 1;
			$this->sql_statement .= " UNION ";
		}

		return $this;
	}

	/**
	 * @fn union_all()
	 * @brief The UNION ALL operator selects all values including duplicates.
	 *
	 * @return $this
	 */
	public function union_all()
	{
		if ($this->do_union == 0)
		{
			$this->do_union = 1;
			$this->sql_statement .= " UNION ALL ";
		}

		return $this;
	}

	/**
	 * @fn debug()
	 * @brief Send a copy of the SQL we are executing to the debug file.
	 *
	 * @return $this
	 */
	public function debug()
	{
		$this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $this->format_sql_statement());
		return $this;
	}

	/**
	 * @fn execute()
	 * @brief Execute the compiled SQL found in $this->sql_statement. Return true of false for execution.
	 *
	 * @return bool
	 */
	public function execute()
	{
		if ($this->do_value == 1)
		{
			$this->do_value = 0;
			$this->sql_statement .= ")";
		}

		$query = $this->sql_statement;

		return $this->sql2($query);
	}

	/**
	 * @fn format_sql_statement($highlight=true)
	 * @brief Call SqlFormatter::format_sql to pretty up the SQL found in $this->sql_statement.
	 *        Class oracle extends library which extends SqlFormatter.
	 *
	 * @param bool $highlight - Use HTML color highlighting to display syntax errors.
	 *
	 * @return String
	 */
	public function format_sql_statement($highlight=true)
	{
		return $this->format_sql($this->sql_statement, $highlight);
	}

	//
	// remove_comments will strip the sql comment lines out of an uploaded sql file
	// specifically for mssql and postgres type files in the install....
	//
	public function remove_comments(&$output)
	{
		$lines = explode("\n", $output);
		$output = "";

		// try to keep mem. use down
		$linecount = count($lines);

		$in_comment = false;
		for($i = 0; $i < $linecount; $i++)
		{
			if( preg_match("/^\/\*/", preg_quote($lines[$i])) )
			{
				$in_comment = true;
			}

			if( !$in_comment )
			{
				$output .= $lines[$i] . "\n";
			}

			if( preg_match("/\*\/$/", preg_quote($lines[$i])) )
			{
				$in_comment = false;
			}
		}

		unset($lines);
		return $output;
	}

	//
	// remove_remarks will strip the sql comment lines out of an uploaded sql file
	//
	public function remove_remarks($sql)
	{
		$lines = explode("\n", $sql);

		// try to keep mem. use down
		$sql = "";

		$linecount = count($lines);
		$output = "";

		for ($i = 0; $i < $linecount; $i++)
		{
			if (($i != ($linecount - 1)) || (strlen($lines[$i]) > 0))
			{
				if (isset($lines[$i][0]) && $lines[$i][0] != "#")
				{
					$output .= $lines[$i] . "\n";
				}
				else
				{
					$output .= "\n";
				}
				// Trading a bit of speed for lower mem. use here.
				$lines[$i] = "";
			}
		}

		return $output;

	}

	//
	// split_sql_file will split an uploaded sql file into single sql statements.
	// Note: expects trim() to have already been run on $sql.
	//
	public function split_sql_file($sql, $delimiter)
	{
		// Split up our string into "possible" SQL statements.
		$tokens = explode($delimiter, $sql);

		// try to save mem.
		$sql = "";
		$output = array();

		// we don't actually care about the matches preg gives us.
		$matches = array();

		// this is faster than calling count($oktens) every time thru the loop.
		$token_count = count($tokens);
		for ($i = 0; $i < $token_count; $i++)
		{
			// Don't wanna add an empty string as the last thing in the array.
			if (($i != ($token_count - 1)) || (strlen($tokens[$i] > 0)))
			{
				// This is the total number of single quotes in the token.
				$total_quotes = preg_match_all("/'/", $tokens[$i], $matches);
				// Counts single quotes that are preceded by an odd number of backslashes,
				// which means they're escaped quotes.
				$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$i], $matches);

				$unescaped_quotes = $total_quotes - $escaped_quotes;

				// If the number of unescaped quotes is even, then the delimiter did NOT occur inside a string literal.
				if (($unescaped_quotes % 2) == 0)
				{
					// It's a complete sql statement.
					$output[] = $tokens[$i];
					// save memory.
					$tokens[$i] = "";
				}
				else
				{
					// incomplete sql statement. keep adding tokens until we have a complete one.
					// $temp will hold what we have so far.
					$temp = $tokens[$i] . $delimiter;
					// save memory..
					$tokens[$i] = "";

					// Do we have a complete statement yet?
					$complete_stmt = false;

					for ($j = $i + 1; (!$complete_stmt && ($j < $token_count)); $j++)
					{
						// This is the total number of single quotes in the token.
						$total_quotes = preg_match_all("/'/", $tokens[$j], $matches);
						// Counts single quotes that are preceded by an odd number of backslashes,
						// which means they're escaped quotes.
						$escaped_quotes = preg_match_all("/(?<!\\\\)(\\\\\\\\)*\\\\'/", $tokens[$j], $matches);

						$unescaped_quotes = $total_quotes - $escaped_quotes;

						if (($unescaped_quotes % 2) == 1)
						{
							// odd number of unescaped quotes. In combination with the previous incomplete
							// statement(s), we now have a complete statement. (2 odds always make an even)
							$output[] = $temp . $tokens[$j];

							// save memory.
							$tokens[$j] = "";
							$temp = "";

							// exit the loop.
							$complete_stmt = true;
							// make sure the outer loop continues at the right point.
							$i = $j;
						}
						else
						{
							// even number of unescaped quotes. We still don't have a complete statement.
							// (1 odd and 1 even always make an odd)
							$temp .= $tokens[$j] . $delimiter;
							// save memory.
							$tokens[$j] = "";
						}

					} // for..
				} // else
			}
		}

		return $output;
	}

	public function run_sql_file($dbms_schema)
	{
		if (!$this->conn)
		{
			printf("Not connected to database. File: %s, Line: %d - Call Greg Parkin<br>\n", __FILE__, __LINE__);
			$this->debug_dump_stack();
			$this->last_return = false;
			return false;
		}

		// @ in front of a function suppresses warning messages where no @ does not.
		$sql_query = @fread(@fopen($dbms_schema, 'r'), @filesize($dbms_schema)) or die("Cannot open schema file: " . $dbms_schema);
		$sql_query = $this->remove_remarks($sql_query);
		$sql_query = $this->split_sql_file($sql_query, ';');

		foreach($sql_query as $sql)
		{
			printf("%s\n", $sql);

			if ($this->sql2($sql) == false)
			{
				$this->dbErrMsg = "run_sql_file(" . $dbms_schema . "): " . $this->dbErrMsg;
				return false;
			}
		}

		return true;
	}
}
?>
