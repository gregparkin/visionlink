<?php
/**
 * @package    VisionLink
 * @file       library.php
 * @author     Greg Parkin <gregparkin58@gmail.com>
 */

//
// Base class library of reusable code!
//
// NOTE: It is very important that you do not turn on debugging without writing to a file for server side AJAX code. Any HTML
//       comments coming from functions while writing XML will show up in the XML output and you will get a XML parsing error
//       in the client side program.
//
// sql_insert_varchar2(&$query, $value, $add_comma)
// sql_insert_number(&$query, $value, $add_comma)
// sql_insert_to_date(&$query, $value, $add_comma)
// sql_insert_sysdate(&$query, $add_comma)
// sql_insert_sysdate_gmt_utime(&$query, $add_comma)
//
// sql_update_varchar2(&$query, $fieldname, $value, $add_comma)
// sql_update_number(&$query, $fieldname, $value, $add_comma)
// sql_update_to_date(&$query, $fieldname, $value, $add_comma)
// sql_update_sysdate(&$query, $fieldname, $add_comma)
// sql_update_sysdate_gmt_utime(&$query, $fieldname, $add_comma)
//
// fixDuration(&$duration)
// FixString($receive)
// isValidEmail($email)
// phone_clean($string)
// rightPad($str, $len)
// leftPad($str, $len)
// remove_doublewhitespace($s = null)
// remove_whitespace($s = null)
// remove_whitespace_feed($s = null)
// smart_clean($s = null)
// strip($str = null)
// substractDays($date, $days)
// addDays($date, $days)
//
// debug_start($debug_file)
// debug_on()
// debug_off()
// debug1()
// debug2()
// debug3()
// debug4()
// debug5()
// debug_sql1()
// debug_sql2()
// debug_sql3()
// debug_sql4()
// debug_sql5()
// debug_r1($file, $func, $line, $what = "")
// debug_r2($file, $func, $line, $what = "")
// debug_r3($file, $func, $line, $what = "")
// debug_r4($file, $func, $line, $what = "")
// debug_r5($file, $func, $line, $what = "")
// backtrace()
// error_reporting($level)
// environment_dump()
//

//include_once __DIR__ . '/autoload.php';

/** @class library
 *  @brief Library of useful miscellanous functions.
 *  @brief Used by all classes.
 *  @brief Called directly in program: trace_data_sources.php
 *  @brief Used by all Ajax servers.
 */
class library extends SqlFormatter
{
	var $default_timezone_name = '';
	var $fp_debug = null;
	var $sql_formatter = null;
	var $time_start = 0;
	var $time_end = 0;
	var $run_time = 0;

	var $user_timezone_name;
	var $user_timezone;

	var $debug_onoff = 0;

	var $debug_flag1 = false;
	var $debug_flag2 = false;
	var $debug_flag3 = false;
	var $debug_flag4 = false;
	var $debug_flag5 = false;

	//var $whoops;

	/** @fn __construct()
	 *
	 *  @brief Constructor function for the class library
	 *  @brief Called once when the class is first created.
	 */
	public function __construct()
	{
		date_default_timezone_set('America/Denver');

		//
		// The following is required by $this->now_to_gmt_utime();
		//
		$this->default_timezone_name = date_default_timezone_get();  // See timezone in php.ini

		if (PHP_SAPI === 'cli')
		{
			$this->user_timezone_name = 'America/Denver';
		}
		else
		{
			if (session_id() == '')
				session_start();     // Required to start once in order to retrieve user session information

			if (isset($_SESSION['local_timezone_name']))
			{
				$this->user_timezone_name = $_SESSION['local_timezone_name'];
			}
			else
			{
				$this->user_timezone_name = 'America/Denver';
			}
		}
	}

	/** @fn __destruct()
	 *  @brief Destructor function called when no other references to this object can be found, or in any
	 *  @brief order during the shutdown sequence. The destructor will be called even if script execution
	 *  @brief is stopped using exit(). Calling exit() in a destructor will prevent the remaining shutdown
	 *  @brief routines from executing.
	 *  @brief Attempting to throw an exception from a destructor (called in the time of script termination)
	 *  @brief causes a fatal error.
	 *  @return null
	 */
	public function __destruct()
	{
	}

	/**
	 * @fn    maxStringLength($str, $max_length)
	 *
	 * @brief Trim or truncate end of string down to a specific length. If it needs to be
	 *        truncated it will replace the last three strings in the max_length of the string
	 *        with ...
	 *
	 * @param string $str
	 * @param int    $max_length
	 *
	 * @return string
	 */
	public function maxStringLength($str, $max_length)
	{
		$max_length = 340;

		if (strlen($str) > $max_length)
		{
			$offset = ($max_length - 3) - strlen($str);
			return substr($str, 0, strrpos($str, ' ', $offset)) . '...';
		}

		return $str;
	}

	/**
	 * @fn    cleanString($text)
	 *
	 * @brief Returns an string clean of UTF8 characters. It will convert them to a similar ASCII character
	 *
	 * @param $text - String to clean.
	 *
	 * @return mixed
	 */
	public function cleanString($text)
	{
		// 1) convert á ô => a o
		$text = preg_replace("/[áàâãªä]/u","a",$text);
		$text = preg_replace("/[ÁÀÂÃÄ]/u","A",$text);
		$text = preg_replace("/[ÍÌÎÏ]/u","I",$text);
		$text = preg_replace("/[íìîï]/u","i",$text);
		$text = preg_replace("/[éèêë]/u","e",$text);
		$text = preg_replace("/[ÉÈÊË]/u","E",$text);
		$text = preg_replace("/[óòôõºö]/u","o",$text);
		$text = preg_replace("/[ÓÒÔÕÖ]/u","O",$text);
		$text = preg_replace("/[úùûü]/u","u",$text);
		$text = preg_replace("/[ÚÙÛÜ]/u","U",$text);
		$text = preg_replace("/[’‘‹›‚]/u","'",$text);
		$text = preg_replace("/[“”«»„]/u",'"',$text);
		$text = str_replace("–","-",$text);
		$text = str_replace(" "," ",$text);
		$text = str_replace("ç","c",$text);
		$text = str_replace("Ç","C",$text);
		$text = str_replace("ñ","n",$text);
		$text = str_replace("Ñ","N",$text);

		//2) Translation CP1252. &ndash; => -
		$trans = get_html_translation_table(HTML_ENTITIES);
		$trans[chr(130)] = '&sbquo;';   // Single Low-9 Quotation Mark
		$trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook
		$trans[chr(132)] = '&bdquo;';   // Double Low-9 Quotation Mark
		$trans[chr(133)] = '&hellip;';  // Horizontal Ellipsis
		$trans[chr(134)] = '&dagger;';  // Dagger
		$trans[chr(135)] = '&Dagger;';  // Double Dagger
		$trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent
		$trans[chr(137)] = '&permil;';  // Per Mille Sign
		$trans[chr(138)] = '&Scaron;';  // Latin Capital Letter S With Caron
		$trans[chr(139)] = '&lsaquo;';  // Single Left-Pointing Angle Quotation Mark
		$trans[chr(140)] = '&OElig;';   // Latin Capital Ligature OE
		$trans[chr(145)] = '&lsquo;';   // Left Single Quotation Mark
		$trans[chr(146)] = '&rsquo;';   // Right Single Quotation Mark
		$trans[chr(147)] = '&ldquo;';   // Left Double Quotation Mark
		$trans[chr(148)] = '&rdquo;';   // Right Double Quotation Mark
		$trans[chr(149)] = '&bull;';    // Bullet
		$trans[chr(150)] = '&ndash;';   // En Dash
		$trans[chr(151)] = '&mdash;';   // Em Dash
		$trans[chr(152)] = '&tilde;';   // Small Tilde
		$trans[chr(153)] = '&trade;';   // Trade Mark Sign
		$trans[chr(154)] = '&scaron;';  // Latin Small Letter S With Caron
		$trans[chr(155)] = '&rsaquo;';  // Single Right-Pointing Angle Quotation Mark
		$trans[chr(156)] = '&oelig;';   // Latin Small Ligature OE
		$trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis
		$trans['euro'] = '&euro;';      // euro currency symbol
		ksort($trans);

		foreach ($trans as $k => $v)
		{
			$text = str_replace($v, $k, $text);
		}

		// 3) remove <p>, <br/> ...
		$text = strip_tags($text);

		// 4) &amp; => & &quot; => '
		$text = html_entity_decode($text);

		// 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
		$text = preg_replace('/[^(\x20-\x7F)]*/','', $text);

		$targets=array('\r\n','\n','\r','\t');
		$results=array(" "," "," ","");
		$text = str_replace($targets,$results,$text);

		//XML compatible
		/*
		$text = str_replace("&", "and", $text);
		$text = str_replace("<", ".", $text);
		$text = str_replace(">", ".", $text);
		$text = str_replace("\\", "-", $text);
		$text = str_replace("/", "-", $text);
		*/

		return ($text);
	}

	/**
	 * @fn     globalCounter()
	 *
	 * @brief  Update the global counter file for footer.php
	 *
	 * @return int
	 */
	public function globalCounter()
	{
		$page_hit_count = 0;

		// Defined in cct_init.php
		// $_SESSION['COUNTER_FILE']      = '/Users/gregparkin/www/visionlink.test/counters/global';

		$page_hit_file = "/Users/gregparkin/www/visionlink.test/counters/global";

		if (file_exists($page_hit_file))
		{
			if (($fp = fopen($page_hit_file, "r")) === false)
			{
				/**
				$trace = debug_backtrace();
				trigger_error(
					'Cannot open file for read: ' . $page_hit_file .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);
				*/

				$this->error = sprintf("Cannot open file for read: %s", $page_hit_file);

				return 0;
			}

			$count = fread($fp, 80);
			$count += 1;
			fclose($fp);
			$page_hit_count = $count;
		}
		else
		{
			$page_hit_count = 1;
			$count = 1;
		}

		if (($fp = fopen($page_hit_file, "w")) === false)
		{
			/**
			$trace = debug_backtrace();
			trigger_error(
				'Cannot open file for write: ' . $page_hit_file .
				' in ' . $trace[0]['file'] .
				' on line ' . $trace[0]['line'],
				E_USER_NOTICE);
			*/

			$this->error = sprintf("Cannot open file for write: %s", $page_hit_file);

			return false;
		}

		fprintf($fp, "%d\n", $count);
		fclose($fp);

		return $page_hit_count;
	}

	public function yesterday(&$start_utime, &$end_utime, &$start_string, &$end_string)
	{
		$dt = new DateTime("now");
		$dt->setTimezone(new DateTimeZone('GMT'));

		$start_utime = strtotime('-1 day', strtotime($dt->format('m/d/Y 00:00:00')));
		$end_utime   = strtotime('-1 day', strtotime($dt->format('m/d/Y 23:59:59')));

		$start_string = date ( 'm/d/Y H:i:s' , $start_utime );
		$end_string = date ( 'm/d/Y H:i:s' , $end_utime );
	}

	public function today(&$start_utime, &$end_utime, &$start_string, &$end_string)
	{
		$dt = new DateTime("now");

		$start = $dt->format('m/d/Y 00:00:00');
		$end   = $dt->format('m/d/Y 23:59:59');

		$dt1 = new DateTime($start);
		$dt1->setTimezone(new DateTimeZone('GMT'));

		$dt2 = new DateTime($end);
		$dt2->setTimezone(new DateTimeZone('GMT'));

		$start_utime  = $dt1->format('U');
		$end_utime    = $dt2->format('U');

		$start_string = $dt1->format('m/d/Y H:i:s');
		$end_string   = $dt2->format('m/d/Y H:i:s');
	}

	public function tomorrow(&$start_utime, &$end_utime, &$start_string, &$end_string)
	{
		$dt = new DateTime("now");
		$dt->setTimezone(new DateTimeZone('GMT'));

		$start_utime  = strtotime('+1 day', strtotime($dt->format('m/d/Y 00:00:00')));
		$end_utime    = strtotime('+1 day', strtotime($dt->format('m/d/Y 23:59:59')));

		$start_string = date ( 'm/d/Y H:i:s' , $start_utime );
		$end_string   = date ( 'm/d/Y H:i:s' , $end_utime );
	}

	public function now_to_gmt_utime()
	{
		$dt = new DateTime();

		if (strlen($this->user_timezone_name) == 0)
		{
			if (session_id() == '')
				session_start(); // Required to start once in order to retrieve user session information

			if (isset($_SESSION['local_timezone_name']))
			{
				$this->user_timezone_name = $_SESSION['local_timezone_name'];
			}
			else
			{
				$this->user_timezone_name = 'America/Denver';
			}
		}
		else
		{
			$dt->setTimezone(new DateTimeZone($this->user_timezone_name));
		}

		$dt->setTimestamp(time());

		return $dt->format('U');
	}

	/**
	 * @fn     to_gmt($datetime_string, $from_tz)
	 *
	 * @brief  Takes a date string (ex. 07/25/2016 23:00) and converts it from it's TZ to GMT and returns utime.
	 * @brief  This function is used to store server work start/end in the database as numbers utime so that who
	 *         ever views the record in their browser can see the start/end in the time zone they are located in.
	 *
	 * @param  $datetime_string - '07/25/2016 23:00' or '07/25/2016' or etc.
	 * @param  $from_tz         - Originating time zone for this $datatime_string (ex. 'America/Chicago')
	 *
	 * @return string           - Returns GMT utime numeric value.
	 */
	public function to_gmt($datetime_string, $from_tz="America/Denver")
	{
		//
		// The trick to remember here is that you have to set $dt with a starting TZ. That way when
		// you set the new time zone to GMT it will give you the correct utime.
		// $mmddyyyy_hhmm can also accept '07/25/2016' without the time part (defaults to 00:00).
		//
		$dt = new DateTime($datetime_string, new DateTimeZone($from_tz));
		$dt->setTimezone(new DateTimeZone('GMT'));

		return $dt->format('U');
	}

	/**
	 * @fn     gmt_to_format($gmt_utime, $time_format, $to_tz)
	 *
	 * @brief  This function takes a $gmt_utime value, convert's to $to_tz and displays a string in $time_format.
	 *
	 * @param  int    $gmt_utime    - Database stored utime value.
	 * @param  string $time_format  - 'm/d/Y' or 'm/d/Y H:i', etc.
	 * @param  string $to_tz        - User's local timezone: 'America/Denver'
	 *
	 * @return string        - Returns the formatted date time string.
	 */
	public function gmt_to_format($gmt_utime, $time_format, $to_tz="America/Denver")
	{
		$dt = new DateTime();
		$dt->setTimezone(new DateTimeZone('GMT'));
		$dt->setTimestamp($gmt_utime);
		$dt->setTimezone(new DateTimeZone($to_tz));

		return $dt->format($time_format);
	}

	/**
	 * @fn     canClassBeAutoloaded($class_name)
	 *
	 *  @brief Determines if a class can be loaded
	 *
	 *  @param object $class_name is the name of the class
	 *
	 *  @return bool - true if class can be loaded, false if it cannot
	 */
	public function canClassBeAutoloaded($class_name)
	{
		return class_exists($class_name);
	}

	/**
	 * @fn    timeStart()
	 *
	 * @brief Used to time routines in PHP. Record start time.
	 */
	public function timeStart()
	{
		$this->time_start = microtime(true);
		$this->time_end = 0;
	}

	/**
	 * @fn    timeEnd()
	 *
	 * @brief Used to time routines in PHP. Record end time and calculate run_time (seconds).
	 */
	public function timeEnd()
	{
		if ($this->time_start > 0)
		{
			$this->time_end = microtime(true);
			$this->run_time = $this->time_end - $this->time_start;
		}

		$this->time_start = 0;
		$this->time_end = 0;
	}

	/**
	 * @fn   runTime()
	 *
	 * @brief Used to time routines in PHP. Return the run time in seconds.
	 */
	public function runTime()
	{
		return $this->run_time;
	}

	/**
	 * @fn    debug_to_console( $data )
	 *
	 * @brief Write $data to a Javascript console for debugging purposes. ( Don't user in AJAX server! )
	 *
	 * @param string $data can be a variable or array.
	 */
	function debug_to_console( $data )
	{

		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		else
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

		echo $output;
	}

	/** @fn makeInsertCHAR($query, $value, $add_comma)
	 *  @brief SQL insert string builder for VARCHAR2 or CHAR.
	 *  @brief Example: $obj->makeInsertCHAR($insert, $ticket_no, true);
	 *  @param $query This is the string where we append the value to the SQL insert command.
	 *  @param $value This is the VARCHAR2 or CHAR value we are inserting.
	 *  @param $add_comma true if a comma is needed at the end or false if it isn't needed.
	 *  @return null
	 */
	public function makeInsertCHAR(&$query, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("'%s', ", $this->FixString($value));
		}
		else
		{
			$query .= sprintf("'%s' ",  $this->FixString($value));
		}
	}

	/** @fn makeInsertINT($query, $value, $add_comma)
	 *  @brief SQL insert string builder for NUMBER or INT values.
	 *  @brief Example: $obj->makeInsertINT($insert, $system_id, true);
	 *  @param $query This is the string where we append the value to the SQL insert command.
	 *  @param $value This is the NUMBER or INT value we are inserting.
	 *  @param $add_comma true if a comma is needed at the end or false if it isn't needed.
	 *  @return null
	 */
	public function makeInsertINT(&$query, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%d, ", $value);
		}
		else
		{
			$query .= sprintf("%d ", $value);
		}
	}

	/** @fn makeInsertDateTIME($query, $value, $add_comma)
	 *  @brief SQL insert string builder for DATE.
	 *  @brief Example: $obj->makeInsertDateTIME($insert, $cm_start_date, true);
	 *  @param $query This is the string where we append the value to the SQL insert command.
	 *  @param $value This is the charachter string representing the date and time.
	 *  @param $add_comma true if a comma is needed at the end or false if it isn't needed.
	 *  @return null
	 */
	public function makeInsertDateTIME(&$query, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("to_date('%s', 'MM/DD/YYYY HH24:MI'), ", $value);
		}
		else
		{
			$query .= sprintf("to_date('%s', 'MM/DD/YYYY HH24:MI') ", $value);
		}
	}

	/** @fn makeInsertDATE($query, $value, $add_comma)
	 *  @brief SQL insert string builder for DATE.
	 *  @brief Example: $obj->makeInsertDATE($insert, $cm_closed_date, true);
	 *  @param $query This is the string where we append the value to the SQL insert command.
	 *  @param $value This is the charachter string representing the date.
	 *  @param $add_comma true if a comma is needed at the end or false if it isn't needed.
	 *  @return null
	 */
	public function makeInsertDATE(&$query, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("to_date('%s', 'MM/DD/YYYY'), ", $value);
		}
		else
		{
			$query .= sprintf("to_date('%s', 'MM/DD/YYYY') ", $value);
		}
	}

	/** @fn makeInsertDateNOW($query, $add_comma)
	 *  @brief SQL insert string builder for DATE where set the date to SYSDATE or now.
	 *  @brief Example: $obj->makeInsertDateNOW($insert, true);
	 *  @param $query This is the string where we append the value to the SQL insert command.
	 *  @param $add_comma true if a comma is needed at the end or false if it isn't needed.
	 *  @return null
	 */
	public function makeInsertDateNOW(&$query, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= "SYSDATE, ";
		}
		else
		{
			$query .= "SYSDATE ";
		}
	}

	/** @fn makeUpdateCHAR($query, $fieldname, $value, $add_comma)
	 *  @brief SQL update string builder for VARCHAR2 or CHAR.
	 *  @brief Example: $obj->makeUpdateCHAR($insert, "cm_ticket_no", $ticket_no, true);
	 *  @param $query SQL update string builder for VARCHAR2 or CHAR values.
	 *  @param $fieldname is the name of the table column name.
	 *  @param $value is the string value we want to update.
	 *  @param $add_comma true if we want to include a comma after the statement or not.
	 *  @return null
	 */
	public function makeUpdateCHAR(&$query, $fieldname, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%s='%s', ", $fieldname, $this->FixString($value));
		}
		else
		{
			$query .= sprintf("%s='%s' ",  $fieldname, $this->FixString($value));
		}
	}

	/** @fn makeUpdateINT($query, $fieldname, $value, $add_comma)
	 *  @brief SQL update string builder for NUMBER or INT.
	 *  @brief Example: $obj->makeUpdateINT($insert, "system_id", $system_id, true);
	 *  @param $query SQL update string builder for NUMBER or INT values.
	 *  @param $fieldname is the name of the table column name.
	 *  @param $value is the number value we want to update.
	 *  @param $add_comma true if we want to include a comma after the statement or not.
	 *  @return null
	 */
	public function makeUpdateINT(&$query, $fieldname, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%s=%d, ", $fieldname, $value);
		}
		else
		{
			$query .= sprintf("%s=%d ", $fieldname, $value);
		}
	}

	/** @fn makeUpdateDateTIME($query, $fieldname, $value, $add_comma)
	 *  @brief SQL update string builder for DATE.
	 *  @brief Example: $obj->makeUpdateDateTIME($insert, "cm_start_date", $cm_start_date, true);
	 *  @param $query SQL update string builder for DATE values.
	 *  @param $fieldname is the name of the table column name.
	 *  @param $value is the date time string we want to update.
	 *  @param $add_comma true if we want to include a comma after the statement or not.
	 *  @return null
	 */
	public function makeUpdateDateTIME(&$query, $fieldname, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%s=to_date('%s', 'MM/DD/YYYY HH24:MI'), ", $fieldname, $value);
		}
		else
		{
			$query .= sprintf("%s=to_date('%s', 'MM/DD/YYYY HH24:MI') ", $fieldname, $value);
		}
	}

	/** @fn makeUpdateDateHHMISS($query, $fieldname, $value, $add_comma)
	 *  @brief SQL update string builder for DATE.
	 *  @brief Example: $obj->makeUpdateDateHHMISS($insert, "cm_start_date", $cm_start_date, true);
	 *  @param $query SQL update string builder for DATE values.
	 *  @param $fieldname is the name of the table column name.
	 *  @param $value is the date time string we want to update.
	 *  @param $add_comma true if we want to include a comma after the statement or not.
	 *  @return null
	 */
	public function makeUpdateDateHHMISS(&$query, $fieldname, $value, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%s=to_date('%s', 'MM/DD/YYYY HH24:MI:SS'), ", $fieldname, $value);
		}
		else
		{
			$query .= sprintf("%s=to_date('%s', 'MM/DD/YYYY HH24:MI:SS') ", $fieldname, $value);
		}
	}

	/** @fn makeUpdateDateNOW($query, $fieldname, $add_comma)
	 *  @brief SQL update string builder for DATE.
	 *  @brief Example: $obj->makeUpdateDateNOW($insert, "cm_start_date", $cm_start_date, true);
	 *  @param $query SQL update string builder for DATE values.
	 *  @param $fieldname is the name of the table column name.
	 *  @param $add_comma true if we want to include a comma after the statement or not.
	 *  @return null
	 */
	public function makeUpdateDateNOW(&$query, $fieldname, $add_comma)
	{
		if ($add_comma == true)
		{
			$query .= sprintf("%s=SYSDATE, ", $fieldname);
		}
		else
		{
			$query .= sprintf("%s=SYSDATE ", $fieldname);
		}
	}

	/**
	 * @fn    fixDuration(&$duration)
	 *
	 * @brief Used to change Remedys formatted computed duration string from 0 : 4 : 59 to 00:04:59
	 *
	 * @param string $duration is the Remedy computed duration string we want to fix.
	 *
	 * @return true on success, false on failure.
	 */
	public function fixDuration(&$duration)
	{
		if (strlen($duration) == 0)
		{
			$this->debug5(__FILE__, __FUNCTION__, __LINE__, "duration is null");
			return false;
		}

		$arr = explode(":", $duration);

		if (count($arr) != 3)
		{
			$this->debug5(__FILE__, __FUNCTION__, __LINE__, "$arr count is not 3. It is %d", count($arr));
			return false;
		}

		$days = trim($arr[0]);
		$hours = trim($arr[1]);
		$minutes = trim($arr[2]);

		$duration = sprintf("%02d:%02d:%02d", $days, $hours, $minutes);
		return true;
	}

	/**
	 * @fn     FixString($receive)
	 *
	 * @brief  Escape any single quotes ' before inserting or updating in Oracle
	 *
	 * @param  string $receive is the string we want to escape single quotes.
	 *
	 * @return string
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

	/**
	 * @fn    isValidEmail($email)
	 *
	 * @brief Checks to see if we hava a valid email address.
	 *
	 * @param string $email is the email address we want to check.
	 *
	 * @return bool true if the email address is okay, false if not.
	 */
	function isValidEmail($email)
	{
		return filter_var($email, FILTER_VALIDATE_EMAIL);  // Available in PHP >= 5.2.0
	}

	/**
	 * @fn    phone_clean($string)
	 *
	 * @brief Cleans up phone number strings and strips any phone number extensions.
	 *
	 * @param string $string This is the phone number string we want to fix up.
	 *
	 * @return string
	 */
	public function phone_clean($string)
	{
		$pattern = '/\D*\(?(\d{3})?\)?\D*(\d{3})\D*(\d{4})\D*(\d{1,8})?/';

		if (preg_match($pattern, $string, $match))
		{
			if (isset($match[3]) && $match[3])
			{
				if (isset($match[1]) && $match[1])
				{
					$num = $match[1] . '-' . $match[2] . '-' . $match[3];
				}
				else
				{
					$num = $match[2] . '-' . $match[3];
				}
			}
			else
			{
				$num = NULL;
			}
			if (isset($match[4]) && $match[4])
			{
				$ext = $match[4];
			}
			else
			{
				$ext = NULL;
			}
		}
		else
		{
			$num = NULL;
			$ext = NULL;
		}

		return $num;
	}

	/**
	 * @fn    rightPad($string)
	 *
	 * @brief Used to right pad HTML spaces in a listbox that is using the courier new font
	 *
	 * @param string $str is the string we want to pad.
	 * @param int    $len is the length of the string we want to pad spaces too.
	 *
	 * @return string
	 */
	public function rightPad($str, $len)
	{
		$rc = "";
		$l = strlen($str);

		while ($l < $len)
		{
			$rc = $rc . "&nbsp;";
			$l++;
		}

		$rc = $rc . $str;

		return $rc;
	}

	/**
	 * @fn    rightPad($string)
	 *
	 * @brief Used to left pad HTML spaces in a listbox that is using the courier new font
	 *
	 * @param string $str is the string we want to pad.
	 * @param int    $len is the length of the string we want to pad spaces too.
	 *
	 * @return string
	 */
	public function leftPad($str, $len)
	{
		$rc = $str;
		$l = strlen($str);

		while ($l < $len)
		{
			$rc = $rc . "&nbsp;";
			$l++;
		}

		return $rc;
	}

	/**
	 * @fn    remove_doublewhitespace($string)
	 *
	 * @brief Remove double white spaces from a string.
	 *
	 * @param string $s is the string you want to work on.
	 *
	 * @return a new string.
	 *
	 *  (.) capture any character
	 *  \1  if it is followed by itself
	 *  +   one or more
	 */
	public function remove_doublewhitespace($s = null)
	{
		return preg_replace('/([\s])\1+/', ' ', $s);
	}

	/**
	 * @fn    remove_whitespace($string)
	 *
	 * @brief Remove whitespace
	 *
	 * @param string $s - is the string you want to work on.
	 *
	 * @return string
	 */
	public function remove_whitespace($s = null)
	{
		return preg_replace('/[\s]+/', '', $s );
	}

	/**
	 * @fn    remove_whitespace_feed($string)
	 *
	 * @brief Remove whitespaces, tabs, new-line chars, and carriage-returns
	 *
	 * @param string $s - is the string you want to work on.
	 *
	 * @return string
	 */
	public function remove_whitespace_feed($s = null)
	{
		return preg_replace('/[\t\n\r\0\x0B]/', '', $s);
	}

	/**
	 * @fn    smart_clean($string)
	 *
	 * @brief Remove double while spaces and white space feed
	 *
	 * @param string $s - is the string you want to work on.
	 *
	 * @return string
	 *
	 *  Example:
	 *   $string = " Hey   yo, what's \t\n\tthe sc\r\nen\n\tario! \n";
	 *   echo smart_clean(string);
	 */
	public function smart_clean($s = null)
	{
		return trim( $this->remove_doublewhitespace( $this->remove_whitespace_feed($s) ) );
	}

	/**
	 * @fn    strip($string)
	 *
	 * @brief Used to left pad HTML spaces in a listbox that is using the courier new font
	 *
	 * @param string $s - is the string you want to work on.
	 *
	 * @return string
	 *
	 *  Example:
	 *   $str = "This is  a string       with
	 *   spaces, tabs and newlines present";
	 *   echo strip($str);
	 *   output: This is a string with spaces, tabs and newlines present
	 */
	public function strip($str = null)
	{
		return preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', $str);
	}

	/**
	 * @fn substractDays($date, $days)
	 *
	 * @brief Substract x number of days from a given date
	 *
	 * @param string $date is the date string you want to substract days from
	 * @param int    $days is the number of days to substract
	 *
	 * @return string - the new date
	 */
	public function substractDays($date, $days)
	{
		$ndays = sprintf("-%d days", $days);
		$newdate = strtotime($ndays, strtotime($date));
		$newdate = date('m/d/Y H:i', $newdate);

		return $newdate;
	}

	/**
	 * @fn    addDays($date, $days)
	 *
	 * @brief Add x number of days to a given date
	 *
	 * @param string $date is the date string you want to add days to
	 * @param int    $days is the number of days to add
	 *
	 * @return string - the new date string
	 */
	public function addDays($date, $days)
	{
		$ndays = sprintf("+%d days", $days);
		$newdate = strtotime($ndays, strtotime($date));
		$newdate = date('m/d/Y H:i', $newdate);

		return $newdate;
	}

	/**
	 * @fn    startsWith($haystack, $needle)
	 *
	 * @brief Checks to see if the starting of a string (haystack) begins with the pattern (needle)
	 *
	 * @param string $haystack is the string to search
	 * @param string $needle is the pattern we are checking that we want to match
	 *
	 * @return int -1, 0, or 1, where 0 means match
	 */
	function startsWith($haystack, $needle)
	{
		return strncmp($haystack, $needle, strlen($needle)) == 0;
	}

	/**
	 * @fn    endsWith($haystack, $needle)
	 *
	 * @brief Check to see if the end of the string (haystack) matches the pattern string (needle)
	 *
	 * @param string $haystack is the the string to search
	 * @param string $needle is the pattern we are checking for at the end of the string
	 *
	 * @return int -1, 0, or 1, where 0 means match
	 */
	function endsWith($haystack, $needle)
	{
		return substr_compare($haystack, $needle, -strlen($needle)) == 0;
	}

	/**
	 * @fn    html_stop()
	 *
	 * @brief Output a Stop graphic, file, function, line number and message.
	 *
	 * @param string $file File name of calling function. __FILE__
	 * @param string $func Function name of calling module. __FUNCTION__
	 * @param int    $line Line number in File of calling function. __LINE__
	 * @param string $msg This is the error message
	 */
	public function html_stop($file, $func, $line, $msg)
	{
		$argv   = func_get_args();
		$file   = array_shift($argv);
		$func   = array_shift($argv);
		$line   = array_shift($argv);
		$format = array_shift($argv);
		$what   = vsprintf($format, $argv);

		printf("<html lang=\"en\">\n");
		printf("<head>\n");
		printf("<meta http-equiv=\"x-ua-compatible\" content=\"IE=EmulateIE10\">\n");
		printf("</head>\n");
		printf("<body>\n");
		printf("<p align=\"center\"><img border=\"0\" src=\"images/stop.gif\" width=\"75\" height=\"74\"></p>\n");

		// Some php code may not be in a function
		if (empty($func))
			printf("<p align=\"center\">%s %d: %s</p>\n", basename($file), $line, $what);
		else
			printf("<p align=\"center\">%s %s() %d: %s</p>\n", basename($file), $func, $line, $what);

		printf("</body>\n");
		printf("</html>\n");

		exit();
	}

	/**
	 * @fn    debug_start($debug_file)
	 *
	 * @brief Check session cache for debugging information. If on, file will be opened for writing $this->debugX()
	 *
	 * @param string $debug_file is the name of the debug file $this->debugX() will write to.
	 *
	 * @return bool - true or false
	 */
	public function debug_start($debug_file)
	{
		//
		// Debugging not available for scripting because there is no session cookies.
		//
		if (PHP_SAPI == 'cli')
			return false;


		if (session_id() == '')
			session_start();

		if (strlen(trim($debug_file)) == 0)
			$debug_file = 'debug.html';

		if (!isset($_SESSION['is_debug_on']) || $_SESSION['is_debug_on'] == 'N')
			return false;

		//$debug_level_set = false;

		if ($_SESSION['debug_level1'] == 'Y')
		{
			$this->debug_flag1 = true;
			$this->error_reporting(1);
			//$debug_level_set = true;
		}

		if ($_SESSION['debug_level2'] == 'Y')
		{
			$this->debug_flag2 = true;
			$this->error_reporting(2);
			//$debug_level_set = true;
		}

		if ($_SESSION['debug_level3'] == 'Y')
		{
			$this->debug_flag3 = true;
			$this->error_reporting(3);
			//$debug_level_set = true;
		}

		if ($_SESSION['debug_level4'] == 'Y')
		{
			$this->debug_flag4 = true;
			$this->error_reporting(4);
			//$debug_level_set = true;
		}

		if ($_SESSION['debug_level5'] == 'Y')
		{
			$this->debug_flag5 = true;
			$this->error_reporting(5);
			//$debug_level_set = true;
		}

		if (strlen(trim($debug_file)) > 0)
		{
			$debug_path = $_SESSION['debug_path'];

			$filename = $debug_path . $debug_file;

			$this->fp_debug = fopen($filename, $_SESSION['debug_mode']);

			if ($this->fp_debug == null || $this->fp_debug == false)
			{
				printf("<!-- Unable to open debug file: %s in mode: %s -->\n", $filename, $_SESSION['debug_mode']);
				return false;
			}

			fprintf($this->fp_debug, "==========================================================================================================================\n");

			$mode = "APPEND";

			if ($_SESSION['debug_mode'] == 'w')
			{
				$mode = "WRITE";
			}

			fprintf($this->fp_debug,
					"Debug file: %s/%s created on %s. Mode: %s.\n\n",
					$debug_path, $debug_file, date("r", time()), $mode);
		}

		$this->debug_onoff = 1;
		return true;
	}

	//
	// There are 5 debug out messages types that you can use in your program.
	//	$obj->debug1(...);  and  $obj->debug_r1($array);
	//	$obj->debug2(...);  and  $obj->debug_r2($array);
	//	$obj->debug3(...);  and  $obj->debug_r3($array);
	//	$obj->debug4(...);  and  $obj->debug_r4($array);
	//	$obj->debug5(...);  and  $obj->debug_r5($array);
	//
	// You can control what debug messages (1-5) you want to display when you call $obj->on([...]);
	// Examples:
	//  $obj->debug_on();        Include all debug messages (1-5)
	//  $obj->debug_on(1,2,3);   Include debug messages for 1, 2, and 3
	//  $obj->debug_on(5);       Include debug messages for 5
	//

	/**
	 * @fn    debug_on()
	 *
	 * @brief Turn on debugging statement in the form of HTML comments found in the web page.
	 *
	 * @brief Example: $obj->debug_on();              Include all debug messages (1-5)
	 * @brief Example: $obj->debug_on(1,2,3);         Include debug messages for 1, 2, and 3
	 * @brief Example: $obj->debug_on(5);             Include debug messages for 5
	 * @brief Example: $obj->debug_on('output.txt');  Write to output file instead of creating <!-- comments -> lines.
	 */
	public function debug_on()
	{
		$argv = func_get_args();

		$debug_level_set = false;

		foreach($argv as $arg)
		{
			switch ( $arg )
			{
				case 1:
					$this->debug_flag1 = true;
					$this->error_reporting(1);
					$debug_level_set = true;
					break;
				case 2:
					$this->debug_flag2 = true;
					$this->error_reporting(2);
					$debug_level_set = true;
					break;
				case 3:
					$this->debug_flag3 = true;
					$this->error_reporting(3);
					$debug_level_set = true;
					break;
				case 4:
					$this->debug_flag4 = true;
					$this->error_reporting(4);
					$debug_level_set = true;
					break;
				case 5:
					$this->debug_flag5 = true;
					$this->error_reporting(5);
					$debug_level_set = true;
					break;
				default:
					$debug_path = '/Users/gregparkin/www/visionlink.test/debug/';
					$filename = $debug_path . $arg;

					$this->fp_debug = fopen($filename, 'w');

					if ($this->fp_debug == null)
					{
						printf("<!-- Unable to open debug file: %s -->\n", $filename);
					}

					break;
			}
		}

		if ($debug_level_set == false)
		{
			$this->debug_flag1 = true;
			$this->error_reporting(1);
			$this->debug_flag2 = true;
			$this->error_reporting(2);
			$this->debug_flag3 = true;
			$this->error_reporting(3);
			$this->debug_flag4 = true;
			$this->error_reporting(4);
			$this->debug_flag5 = true;
			$this->error_reporting(5);
		}

		$this->debug_onoff = 1;
	}

	/**
	 * @fn    debug_off()
	 *
	 * @brief Turn off debugging statement in the form of HTML comments found in the web page.
	 */
	public function debug_off()
	{
		$this->debug_onoff = 0;
		$this->debug_flag1 = true;
		$this->debug_flag2 = true;
		$this->debug_flag3 = true;
		$this->debug_flag4 = true;
		$this->debug_flag5 = true;
		$this->error_reporting(0);

		if ($this->fp_debug != null)
		{
			fclose($this->fp_debug);
			$this->fp_debug = null;
		}
	}

	/**
	 * @fn    debug1()
	 *
	 * @brief Write debug_on(1) debugging comments to the HTML web page.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug1(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug1()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag1 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug,
				"d1: %s %d: %s\n", basename($file), $line, $what);
		}
	}

	/**
	 * @fn    debug2()
	 *
	 * @brief Write debug_on(2) debugging comments to the HTML web page.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug1(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug2()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag2 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug,
				"d2: %s %d: %s\n", basename($file), $line, $what);
		}
	}

	/**
	 * @fn    debug3()
	 *
	 * @brief Write debug_on(3) debugging comments to the HTML web page.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug1(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug3()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag3 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			fprintf($this->fp_debug,
				"d3: %s %d: %s\n", basename($file), $line, $what);
		}
	}

	/**
	 * @fn    debug4()
	 *
	 * @brief Write debug_on(4) debugging comments to the HTML web page.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug1(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug4()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag4 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			fprintf($this->fp_debug,
				"d4: %s %d: %s\n", basename($file), $line, $what);
		}
	}

	/**
	 * @fn    debug5()
	 *
	 * @brief Write debug_on(5) debugging comments to the HTML web page.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug1(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug5()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			fprintf($this->fp_debug,
				"d5: %s %d: %s\n", basename($file), $line, $what);
		}
	}

	/**
	 * @fn    debug_sql1()
	 *
	 * @brief This works like all other debug1-5 functions except it is used when you want to format SQL statements in HTML.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug5(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug_sql1()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			if ($this->fp_debug != null)
			{
				fprintf($this->fp_debug, "s1: %s %d SQL:\n%s\n",
					basename($file), $line, $this->format_sql($what, true));
			}
		}
	}

	/**
	 * @fn    debug_sql2()
	 *
	 * @brief This works like all other debug1-5 functions except it is used when you want to format SQL statements in HTML.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug5(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug_sql2()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			if ($this->fp_debug != null)
			{
				fprintf($this->fp_debug, "s2: %s %d SQL:\n%s\n",
					basename($file), $line, $this->format_sql($what, true));
			}
		}
	}

	/**
	 * @fn    debug_sql3()
	 *
	 * @brief This works like all other debug1-5 functions except it is used when you want to format SQL statements in HTML.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug5(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug_sql3()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			if ($this->fp_debug != null)
			{
				fprintf($this->fp_debug, "s3: %s %d SQL:\n%s\n",
					basename($file), $line, $this->format_sql($what, true));
			}
		}
	}

	/**
	 * @fn    debug_sql4()
	 *
	 * @brief This works like all other debug1-5 functions except it is used when you want to format SQL statements in HTML.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug5(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug_sql4()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			if ($this->fp_debug != null)
			{
				fprintf($this->fp_debug, "s4: %s %d SQL:\n%s\n",
					basename($file), $line, $this->format_sql($what, true));
			}
		}
	}

	/**
	 * @fn    debug_sql5()
	 *
	 * @brief This works like all other debug1-5 functions except it is used when you want to format SQL statements in HTML.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug5(__FILE__, __FUNCTION__, __LINE__, "Error code = %d", $errno);
	 */
	public function debug_sql5()
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$argv = func_get_args();
		$file = array_shift($argv);
		$line = array_shift($argv);

		$what = vsprintf(array_shift($argv), array_values($argv));

		// Some php code may not be in a function
		if (empty($func))
		{
			if ($this->fp_debug != null)
			{
				fprintf($this->fp_debug, "s5: %s %d SQL:\n%s\n",
					basename($file), $line, $this->format_sql($what, true));
			}
		}
	}

	/**
	 * @fn    debug_r1()
	 *
	 * @brief Write debug_on(1) debugging comments for a PHP array.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug_r1(__FILE__, __FUNCTION__, __LINE__, $myarray);
	 */
	public function debug_r1($file, $line, $what = NULL, $label = "")
	{
		if ($this->debug_onoff == 0 || $this->debug_flag1 == false)
			return;

		$file = basename($file);

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug, "r1: %s %d: %s\n", $file, $line, $label);
			if (is_array($what))
			{
				$out = print_r($what, true);
				fprintf($this->fp_debug, "%s", $out);
			}
		}
	}

	/**
	 * @fn    debug_r2()
	 *
	 * @brief Write debug_on(1) debugging comments for a PHP array.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug_r1(__FILE__, __FUNCTION__, __LINE__, $myarray);
	 */
	public function debug_r2($file, $line, $what = NULL, $label = "")
	{
		if ($this->debug_onoff == 0 || $this->debug_flag2 == false)
			return;

		$file = basename($file);

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug, "r2: %s %d: %s\n", $file, $line, $label);
			if (is_array($what))
			{
				$out = print_r($what, true);
				fprintf($this->fp_debug, "%s", $out);
			}
		}
	}

	/**
	 * @fn    debug_r3()
	 *
	 * @brief Write debug_on(1) debugging comments for a PHP array.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug_r1(__FILE__, __FUNCTION__, __LINE__, $myarray);
	 */
	public function debug_r3($file, $line, $what = NULL, $label = "")
	{
		if ($this->debug_onoff == 0 || $this->debug_flag3 == false)
			return;

		$file = basename($file);

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug, "r3: %s %d: %s\n", $file, $line, $label);
			if (is_array($what))
			{
				$out = print_r($what, true);
				fprintf($this->fp_debug, "%s", $out);
			}
		}
	}

	/**
	 * @fn    debug_r4()
	 *
	 * @brief Write debug_on(1) debugging comments for a PHP array.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug_r1(__FILE__, __FUNCTION__, __LINE__, $myarray);
	 */
	public function debug_r4($file, $line, $what = NULL, $label = "")
	{
		if ($this->debug_onoff == 0 || $this->debug_flag4 == false)
			return;

		$file = basename($file);

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug, "r4: %s %d: %s\n", $file, $line, $label);
			if (is_array($what))
			{
				$out = print_r($what, true);
				fprintf($this->fp_debug, "%s", $out);
			}
		}
	}

	/**
	 * @fn    debug_r5()
	 *
	 * @brief Write debug_on(1) debugging comments for a PHP array.
	 *
	 * @brief argument 1 is the name of the program file or module name. __FILE__
	 * @brief argument 2 is the function name within the program. __FUNCTION__
	 * @brief argument 3 is the line number within the program. __LINE__
	 * @brief the rest of the arguments if the remainder of the text to be made into HTML comments.
	 * @brief Example: $obj->debug_r1(__FILE__, __FUNCTION__, __LINE__, $myarray);
	 */
	public function debug_r5($file, $line, $what = NULL, $label = "")
	{
		if ($this->debug_onoff == 0 || $this->debug_flag5 == false)
			return;

		$file = basename($file);

		if ($this->fp_debug != null)
		{
			fprintf($this->fp_debug, "r5: %s %d: %s\n", $file, $line, $label);
			if (is_array($what))
			{
				$out = print_r($what, true);
				fprintf($this->fp_debug, "%s", $out);
			}
		}
	}

	/**
	 * @fn    debug_dump_stack()
	 *
	 * @brief Used to dump the PHP call stack in reverse order
	 */
	public function debug_dump_stack()
	{
		if ($this->fp_debug == null)
			return;

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

			fprintf($this->fp_debug, "%s<br>\n", $str);

			$x++;
		}
	}

	/**
	 * @fn    get_caller($function = NULL, $use_stack = NULL)
	 *
	 * @brief This function will return the name string of the function that called $function. To return the
	 *        caller of your function, either call get_caller(), or get_caller(__FUNCTION__).
	 *
	 * @param string $function
	 * @param string $use_stack
	 *
	 * @return string
	 */
	public function get_caller($function = NULL, $use_stack = NULL)
	{
		if ( is_array($use_stack) )
		{
			//
			// If a function stack has been provided, used that.
			//
			$stack = $use_stack;
		}
		else
		{
			//
			// Otherwise create a fresh one.
			//
			$stack = $this->debug_backtrace();
			echo "\nPrintout of Function Stack: \n\n";
			print_r($stack);
			echo "\n";
		}

		if ($function == NULL)
		{
			//
			// We need $function to be a function name to retrieve its caller. If it is omitted, then
			// we need to first find what function called get_caller(), and substitute that as the
			// default $function. Remember that invoking get_caller() recursively will add another
			// instance of it to the function stack, so tell get_caller() to use the current stack.
			//
			$function = $this->get_caller(__FUNCTION__, $stack);
		}

		if ( is_string($function) && $function != "" )
		{
			//
			// If we are given a function name as a string, go through the function stack and find
			// it's caller.
			//
			for ($i = 0; $i < count($stack); $i++)
			{
				$curr_function = $stack[$i];

				//
				// Make sure that a caller exists, a function being called within the main script
				// won't have a caller.
				//
				if ( $curr_function["function"] == $function && ($i + 1) < count($stack) )
				{
					return $stack[$i + 1]["function"];
				}
			}
		}

		//
		// At this stage, no caller has been found, bummer.
		//
		return "";
	}


	/**
	 * @fn    error_reporting($level)
	 *
	 * @brief Called by debug_on(...) to setup additional PHP error reporting messages.
	 *
	 * @param int $level is the highest debugging level we want messages for.
	 */
	public function error_reporting($level)
	{
		switch ( $level )
		{
			case 0:  // Turn off all error reporting
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "All error reporting is turned off.");
				error_reporting(0);
				break;
			case 1:  // Report simple running errors
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "PHP will report simple running errors.");
				error_reporting(E_ERROR | E_WARNING | E_PARSE);
				break;
			case 2:  // Reporting E_NOTICE can be good too (to report unitialized variables or catch variable name misspellings ...)
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "PHP will report unitialized variables or catch variable name mispellings.");
				error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
				break;
			case 3:  // Report all errors except E_NOTICE. This is the default value set in php.ini
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "PHP will report on all errors except E_NOTICE.");
				error_reporting(E_ALL ^ E_NOTICE);
				break;
			case 4:  // Report all PHP errors (see changelog)
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "PHP will report all E_ALL errors.");
				error_reporting(E_ALL);
				break;
			case 5:  // Report all PHP errors
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "PHP will report all errors.");
				error_reporting(-1);
				break;
			default:
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "Invalid level specified. Use 1-5");
				break;
		}
	}

	/**
	 * @fn    environment_dump()
	 *
	 * @brief If running from apache this function dump the apache server global arrays.
	 */
	public function environment_dump()
	{
		if (PHP_SAPI !== 'cli')
		{
			if (session_id() == '')
				session_start();    // Required to start once in order to retrieve user session information

			//
			// debug_r1($file, $func, $line, $what = "")
			//
			foreach ($_POST as $key => $value)
			{
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "_POST: %s = %s", $key, $value);
			}

			foreach ($_GET as $key => $value)
			{
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "_GET: %s = %s", $key, $value);
			}

			foreach ($_REQUEST as $key => $value)
			{
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "_REQUEST: %s = %s", $key, $value);
			}

			foreach ($_SERVER as $key => $value)
			{
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "_SERVER: %s = %s", $key, $value);
			}

			foreach ($_SESSION as $key => $value)
			{
				$this->debug1(__FILE__, __FUNCTION__, __LINE__, "_SESSION: %s = %s", $key, $value);
			}
		}
	}

	/**
	 * @fn get_mountain_timezone($timezone_id='America/Denver')
	 *
	 * @brief Returns the abbreviated timezone for a given zone: (i.e. America/Denver = MST or MDT)
	 *        Used to convert the Remedy tickets to the Mountain Time zone whether it's MST or MDT
	 *
	 * @return string 'MST' or 'MDT'
	 */
	public function get_mountain_timezone($timezone_id='America/Denver')
	{
		if ($timezone_id)
		{
			$dateTime = new DateTime();
			$dateTime->setTimeZone(new DateTimeZone($timezone_id));

			return $dateTime->format('T');
		}

		return false;
	}
}
?>
