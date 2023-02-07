<?php
/**
 * @package    CCT
 * @file       html.php
 * @author     Greg Parkin <parking@us.ibm.com>
 * @date       $Date:  $ GMT
 * @version    $Revision:  $
 *
 * $Log:  $
 *
 *
 * $Source:  $
 */

// MENU lives in html_top()

//
// html_head()                          - Setup the HTML headers, retrieve or set $_SESSION data, disables browser cache, and disables output buffering.
// html_meta()                          - Call: html_head() and Print out the HTML meta data
// html_styles()                        - Call: html_meta() and Load and print out styles used in the construction of the web pages.
// html_scripts()                       - Call: html_styles() and Print out and load Javascript code
// html_body()                          - Call: html_scripts() and Print out HTML body statement and popup any message from ERROR_MESSAGE that may exist.
// html_form()                          - Call: html_body() and if set_program() was to set the PROGRAM, write out the form statement
// html_top()                           - Call: html_body() and Creates the div section with the id=head and writes out the SpryWidget menu. Then call html_form()
// html_bot()                           - Closes the div id=content and writes div id=foot which contains the footer for the web page.
// html_dump()                          - Dump HTML PHP global variables for evaluation.
// page_hits()                          - Opens the counter page hits file for the calling program, extracts the hit number, increments the hit number
// isButton($what)                      - Helper function used to determine if a button has been pressed on a web page.
// set_tool_name($what)                 - Used to override default WWW which was set in the constructor function.
// set_refresh_seconds($what)           - Used to set the meta refresh time interval after the web page loads.
// set_meta_refresh($what)              - Set the META_REFRESH to the URL we want to refresh when the timer elapses.
// set_program($what)                   - Used to set the program and options in a form statement
// set_form_name($what)                 - Overrides the default form name of f1.
// set_method_post()                    - Changes the form method to post which is the default setting in the constructor.
// set_method_get()                     - Changes the form method to get.
// set_loading_file_off()               - Disable the loading page which is the default setting.
// set_loading_file_on($what)           - Sets flag and the text that will be displayed for the loading file screen
// set_title($what)                     - Sets the web browsers title to a message of your choosing.
// set_base_href($what)                 - Overrides the default base_href setting created in the constructor function
// set_on_load($what)                   - Sets the body's onload= to perform some kind of javascript action.
// set_ErrorMessage($what)              - When ERROR_MESSAGE is set, a popup dialog will appear with the text after the page finishes loading
// stop_before_end()                    - Sets a flag to instruct html_bot() to return before writing the ending body and html tags.
// html_stop($file, $func, $line, $msg) - Output a Stop graphic, file, function, line number and message.
// show_page_loading()                  - Used when you don't want to include the header and footer, but you want the page loading screen to be displayed.
// cct_major_version()                  - Return CCT Major version number.
// cct_minor_version()                  - Return CCT Minor version number.
// cct_version()                        - Return CCT Version Number (Major . Minor).
// cct_build_date()                     - REturn CCT Build Date.
//
use classes\library;

/** @class html
 *  @brief HTML page generator which uses a custom templete to include a static position header menu and footer.
 *  @brief Used by all CCT HTML programs.
 */
class html extends library
{
    //
    // CCT Version Numbers.
    //
    var $major_version = 7;
    var $minor_version = 0;
    var $build_date = '05/31/2016';

	//
	// Private properties
	//
	var $parm;                                //!< array of HTML URL parm values by key => value
	var $parm_count;                          //!< number of parms in $parm
	var $numberOfTabs = 0;                    //!< initial value for the number of tabs we are using if we want to use the javascript tab control
	var $colourOfInactiveTab  = "#999966";    //!< Color for web page inactive tabs in javascript tab control.
	var $colourOfActiveTab    = "#cccc99";    //!< Color for web page active tabs in javascript tab control.
	var $colourOfInactiveLink = "#333333";    //!< Color for web page inactive URL links.
	var $colourOfActiveLink   = "black";      //!< Color for web page active URL links. 
	var $msie = 0;                            // If using Microsoft IE, what version is it?
	
	/** @fn __construct()
	 *  @brief Class constructor - Create oracle object and setup some dynamic class variables
	 *  @return void 
	 */
	public function __construct()
	{
		if (session_id() == '')
			session_start();                // Required to start once in order to retrieve user session information
		
		$this->parm = array();              // Parameters from $_SERVER['QUERY_STRING (e.g., "id=234&name=greg")
		$this->parm_count = 0;              // Number of parms in $parm array.
		
		$this->data = array();              // Associated array for public class variables.
		
		$this->COUNTER_DIR          = "/opt/ibmtools/cct6/counters/";                          // Path to counter file directory
		$this->COUNTER_FILE         = basename($_SERVER['SCRIPT_FILENAME'], '.php');           // Counter filename
		$this->ICON_FILE            = 'icons/handshake1.ico';                                  // Browser application icon file
		$this->PROGRAM              = "";                                                      // Program name. See: set_program()
		$this->FORM_NAME            = "f1";                                                    // HTML form name=f1
		$this->BASE_HREF            = "";                                                      // HTML base_ref path
		$this->METHOD               = "post";                                                  // HTML form method=post
		$this->ON_LOAD              = "";                                                      // On load message. See: set_loading_file_on()
		$this->NUMBEROFTABS         = 0;                                                       // Number of tabs to create for tab control
		$this->COLOUROFINACTIVETAB  = "#C0C0C0";                                               // Color of inactive tabs
		$this->COLOUROFACTIVETAB    = "#ECE9D8";                                               // Color of active tab
		$this->COLOUROFINACTIVELINK = "#333333";                                               // Color of inactive links
		$this->COLOUROFACTIVELINK   = "black";                                                 // Color of active links
        $this->PAGE_HITS            = true;                                                    // Page Hits turned on by default
		
		if (isset($_SESSION['alert']) && strlen($_SESSION['alert']) > 0)
		{
			$this->ERROR_MESSAGE    = $_SESSION['alert'];                                      // Popup message from session data
			unset($_SESSION['alert']);
		}
		else
		{
			$this->ERROR_MESSAGE    = "";                                                      // Popup message on load. See: set_ErrorMessage()
		}
		
		$this->META_REFRESH         = "";                                                      // URL to load on refresh. See: set_meta_refresh()
		$this->REFRESH_RATE         = "";		                                               // Seconds to wait before refresh. See: set_refresh_seconds()
		$this->META_KEYWORDS        = 'cct, change, coordination, request';                    // Meta tags for search engines
		$this->META_DISTRIBUTION    = 'company';                                           // Meta distribution tag
		$this->META_COMPANY         = 'IBM';                                                   // Meta company tag - company that created CCT
		$this->META_CONTACT_PERSON  = 'Greg Parkin';                                           // Meta contact person
		$this->META_CONTACT_EMAIL   = 'parking[AT]us[DOT]ibm[DOT]com';                         // Meta contact email
		
		$this->IS_LOADING_FILE_ON   = false;                                                   // Flag to enable onload screen. See: set_loading_file_on()
		$this->LOADING_MESSAGE      = "";                                                      // Message for onload screen. See: set_loading_file_on()
		$this->STOP_BEFORE_END      = false;                                                   // Stop before end of body and html statements. See html_bot()
		$this->LOAD_MENU            = "main";                                                  // Load the main menu by default
				
		//
		// Determine what server CCT is running on and setup server specific variables.
		//)
		switch ( $_SERVER['SERVER_NAME'] )
		{                                                       
			case 'lxomp11m.qintra.com':                                                     // Production CCT server on lxomp11m - 151.117.157.53
				$this->BASE_HREF             = 'https://lxomp11m.qintra.com/cct6/';         // HTML base_ref location from Apache web doc root
				$this->WWW                   = 'https://lxomp11m.qintra.com/cct6';          // HTML URL on production: lxomp11m.qintra.com/CCT
				$this->CCT_APPLICATION       = 'Change Coordination Tool - Production';     // CCT application title for Production
				$this->CCT_APPLICATION_COLOR = 'lightgreen';                                // CCT application title text color
				$this->CCT_SERVER            = 'Production Server';                         // CCT application server type
				$this->DEBUG_PATH            = '/ibm/cct6/debug';                           // Path to debug directory containing debug files
				$this->LOG_PATH              = '/ibm/cct6/logs';                            // Path to log directory containing log files
				$this->ICON_FILE             = 'images/superman2.gif';                      // Browser application icon file
				$this->HTML_TITLE            = 'Change Coordination Tool';                  // HTML web page title text: <title> ... </title>
                $this->DOCUMENT_ROOT         = $_SERVER['DOCUMENT_ROOT'];                   // (i.e. /ibm/www/CCT)
				break;
				
			case 'cct.qintra.com':                                                          // Production CCT server on lxomp11m - 151.117.157.53
				$this->BASE_HREF             = 'https://cct.qintra.com/';                   // HTML base_ref location from Apache web doc root
				$this->WWW                   = 'https://cct.qintra.com';                    // HTML URL on production: cct.qintra.com
                $this->CCT_APPLICATION       = 'Change Coordination Tool - Production';     // CCT application title for Production
                $this->CCT_APPLICATION_COLOR = 'lightgreen';                                // CCT application title text color
                $this->CCT_SERVER            = 'Production Server';                         // CCT application server type
                $this->DEBUG_PATH            = '/ibm/cct6/debug';                           // Path to debug directory containing debug files
                $this->LOG_PATH              = '/ibm/cct6/logs';                            // Path to log directory containing log files
                $this->ICON_FILE             = 'images/superman2.gif';                      // Browser application icon file
                $this->HTML_TITLE            = 'Change Coordination Tool';                  // HTML web page title text: <title> ... </title>
                $this->DOCUMENT_ROOT         = $_SERVER['DOCUMENT_ROOT'];                   // (i.e. /ibm/www/cct)
				break;
							                                                       
			case 'lxomt12m.dev.qintra.com':                                                 // Dev/Test CCT server on lxomt12m - 151.117.41.173
				$this->BASE_HREF             = 'https://lxomt12m.dev.qintra.com/cct/';      // HTML base_ref location from Apache web doc root
				$this->WWW                   = 'https://lxomt12m.dev.qintra.com/cct';       // HTML URL on Dev/Test: lxomt12m.dev.qintra.com/cct
				$this->CCT_APPLICATION       = 'Change Coordination Tool - Dev/Test';       // CCT application title for Dev/Test
				$this->CCT_APPLICATION_COLOR = 'yellow';                                    // CCT application title text color
				$this->CCT_SERVER            = 'Dev/Test Server';                           // CCT application server type
				$this->DEBUG_PATH            = '/ibm/cct6/debug';                           // Path to debug directory containing debug files
				$this->LOG_PATH              = '/ibm/cct6/logs';                            // Path to log directory containing log files
				$this->ICON_FILE             = 'images/superman2.gif';                      // Browser application icon file
				$this->HTML_TITLE            = 'Change Coordination Tool Dev/Test';         // HTML web page title text: <title> ... </title>
                $this->DOCUMENT_ROOT         = $_SERVER['DOCUMENT_ROOT'];                   // (i.e. /ibm/www/cct)
				break;
				
			case 'cct.dev.qintra.com':
				$this->BASE_HREF             = 'https://cct.dev.qintra.com/';               // HTML base_ref location from Apache web doc root
				$this->WWW                   = 'https://cct.dev.qintra.com';                // HTML URL on Dev/Test: cct.dev.qintra.com
                $this->CCT_APPLICATION       = 'Change Coordination Tool - Dev/Test';       // CCT application title for Dev/Test
                $this->CCT_APPLICATION_COLOR = 'yellow';                                    // CCT application title text color
                $this->CCT_SERVER            = 'Dev/Test Server';                           // CCT application server type
                $this->DEBUG_PATH            = '/ibm/cct6/debug';                           // Path to debug directory containing debug files
                $this->LOG_PATH              = '/ibm/cct6/logs';                            // Path to log directory containing log files
                $this->ICON_FILE             = 'images/superman2.gif';                      // Browser application icon file
                $this->HTML_TITLE            = 'Change Coordination Tool Dev/Test';         // HTML web page title text: <title> ... </title>
                $this->DOCUMENT_ROOT         = $_SERVER['DOCUMENT_ROOT'];                   // (i.e. /ibm/www/cct)
				break;			

			default:                                                                        // Dev/Test CCT server on LENOVO - 127.0.0.1
				$this->BASE_HREF             = 'http://cct.localhost/';                     // HTML base_ref location from Apache web doc root
				$this->WWW                   = 'http://cct.localhost';                      // HTML URL on GREG-PC: localhost/supertracker
				$this->CCT_APPLICATION       = 'Change Coordination Tool - LENOVO';         // CCT application title for Dev/Test
				$this->CCT_APPLICATION_COLOR = 'cyan';                                      // CCT application title text color
				$_SERVER['REMOTE_USER']      = "gparkin";                                   // LDAP not setup on LENOVO so set REMOTE_USER to gparkin
				$this->CCT_SERVER            = 'Development Server';                        // CCT application server type
				$this->DEBUG_PATH            = '/opt/ibmtools/cct6/debug';                  // Path to debug directory containing debug files
				$this->LOG_PATH              = '/opt/ibmtools/cct6/logs';                   // Path to log directory containing log files
				$this->ICON_FILE             = 'images/superman2.gif';                      // Browser application icon file
				$this->HTML_TITLE            = 'Change Coordination Tool LENOVO';           // HTML web page title text: <title> ... </title>
				$this->DOCUMENT_ROOT         = $_SERVER['DOCUMENT_ROOT'] ;                  // (i.e. /ibm/www/cct)
		}
		
		//
		// Initialize variables for session data
		//
        $this->user_cuid                 = 'gparkin';
        $this->user_first_name           = 'Greg';
        $this->user_last_name            = 'Parkin';
        $this->user_name                 = 'Greg Parkin';
        $this->user_email                = 'parking@us.ibm.com';
        $this->user_company              = 'IBM';
        $this->user_or_admin             = 'admin';

        $this->manager_cuid              = 'gparkin';
        $this->manager_first_name        = 'Greg';
        $this->manager_last_name         = 'Parkin';
        $this->manager_name              = 'Greg Parkin';
        $this->manager_email             = 'parking@us.ibm.com';
        $this->manager_company           = 'IBM';

        $this->is_debug_on               = 'Y';
        $this->debug_level1              = 'Y';
        $this->debug_level2              = 'Y';
        $this->debug_level3              = 'Y';
        $this->debug_level4              = 'Y';
        $this->debug_level5              = 'Y';
        $this->debug_path                = '/opt/ibmtools/cct6/debug';
        $this->debug_mode                = 'w';

        $this->local_timezone            = "America/Denver (MST)";
        $this->local_timezone_name       = "America/Denver";
        $this->local_timezone_abbr       = "MST";
        $this->local_timezone_offset     = 0;

        $this->sql_zone_offset           = "(0)";
        $this->sql_zone_abbr             = "MST";

        $this->baseline_timezone         = "America/Denver (MST)";
        $this->baseline_timezone_name    = "America/Denver";
        $this->baseline_timezone_abbr    = "MST";
        $this->baseline_timezone_offset  = 0;

        $this->time_difference           = "0 seconds or 0 hours";
		
		$this->user_report_output        = isset($_SESSION['user_report_output'])
            ? $_SESSION['user_report_output'] : "HTML"; // Remote user report output setting

		//
		// Information for the FOOTER
		//
		$this->NET_GROUP_NAME  = "AIM-TOOLS-BOM";   // Footer Remedy Assign Group for creating trouble tickets
		$this->NET_PIN         = "17340";           // Footer Net-Pin number for Net-Tool paging
		$this->APP_ACRONYM     = 'CCT';             // Change Coordination Tool acronym - CCT
		$this->BUILD_DATE      = $this->build_date; // Last release date for CCT
		$this->BUILD_VERSION   = $this->major_version . "." . $this->minor_version; // Last release version for CCT
			
		$this->parm_count = 0;
							
		//
		// Parse QUERY_STRING
		//
		if (isset($_SERVER['QUERY_STRING']))   // Parse QUERY_STRING if it exists
		{
			//printf("<!-- QUERY_STRING = %s -->\n", $_SERVER['QUERY_STRING']);
			
			//
			// $myQryStr = "first=1&second=Z&third[]=5000&third[]=6000";
			// parse_str($myQryStr, $myArray);
			// echo $myArray['first']; //will output 1
			// echo $myArray['second']; //will output Z
			// echo $myArray['third'][0]; //will output 5000
			// echo $myArray['third'][1]; //will output 6000
			//
			parse_str($_SERVER['QUERY_STRING'], $this->parm);  // Parses URL parameter options into an array called $this->parm
			$this->parm_count = count($this->parm);            // Get the parm count. Number of items in the $this->parm array.
		}	
		
		//
		// Copy the $_REQUEST information to our $this->data[key] = value
		//
		// For example if you have a HTML form input variable called 'cm_ticket_no' then you will be
		// to access the information in this form: $obj->cm_ticket_name
		//
		foreach ($_REQUEST as $key => $value)
		{
			$this->data[$key] = $value;
		}	
		
		$this->debug_start('html.html');
		
		//
		// If the user is running Internet Explorer then what version is it?
		// (i.e. Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0))
		//
		$this->msie = 0;
		
		preg_match('/MSIE (.*?);/', $_SERVER['HTTP_USER_AGENT'], $matches);
		
		if(count($matches)<2)
		{
			preg_match('/Trident\/\d{1,2}.\d{1,2}; rv:([0-9]*)/', $_SERVER['HTTP_USER_AGENT'], $matches);
		}
		
		if (count($matches)>1)
		{
			$this->msie = $matches[1];
		}
		
		if ($this->msie == 7)
		{
			$this->msie = 9;
		}

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "HTML: parm");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $this->parm);

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "_POST");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_POST);

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "_GET");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_GET);

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "_REQUEST");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_REQUEST);

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "_SERVER");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_SERVER);

        $this->debug1(  __FILE__, __FUNCTION__, __LINE__, "_SESSION");
        $this->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_SESSION);
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
		
	/** @fn __set($name, $value)
	 *  @brief Setter function for $this->data
	 *  @brief Example: $obj->first_name = 'Greg';
	 *  @param $name is the key in the associated $data array
	 *  @param $value is the value in the assoicated $data array for the identified key
	 *  @return null 
	 */
	public function __set($name, $value)
	{
		$this->data[$name] = $value;
	}
	
	/** @fn __get($name)
	 *  @brief Getter function for $this->data
	 *  @brief echo $obj->first_name;
	 *  @param $name is the key in the associated $data array
	 *  @return null 
	 */
	public function __get($name)
	{
		if (array_key_exists($name, $this->data))
		{
			return $this->data[$name];
		}
		
		// $trace = debug_backtrace();
		// trigger_error(
		// 	'Undefined property via __get(): ' . $name .
		// 	' in ' . $trace[0]['file'] .
		// 	' on line ' . $trace[0]['line'],
		// 	E_USER_NOTICE);
			
		return null;
	}
	
	/** @fn __isset($name)
	 *  @brief Determine if item ($name) exists in the $this->data array
	 *  @brief var_dump(isset($obj->first_name));
	 *  @param $name is the key in the associated $data array
	 *  @return null 
	 */	
	public function __isset($name)
	{
		return isset($this->data[$name]);
	}
	
	/** @fn __unset($name)
	 *  @brief Unset an item in $this->data assoicated by $name
	 *  @brief unset($obj->name);
	 *  @param $name is the key in the associated $data array
	 *  @return null 
	 */		
	public function __unset($name)
	{
		unset($this->data[$name]);
	}

    /** @fn cct_major_version()
	 *  @brief Return the CCT major version number. (i.e. 6 or 7)
	 *  @return int
	 */
    public function cct_major_version()
    {
        return $this->major_version;
    }

    /** @fn cct_version()
	 *  @brief Return the CCT version number. (i.e. 7.1)
	 *  @return string or int
	 */
    public function cct_version()
    {
        return $this->major_version . "." . $this->minor_version;
    }

    /** @fn cct_build_date()
	 *  @brief Return the CCT build date. (i.e. 05/31/2016)
	 *  @return string
	 */
    public function cct_build_date()
    {
        return $this->build_date;
    }

    /** @fn cct_minor_version()
	 *  @brief Return the CCT minor version number.
	 *  @return int
	 */
    public function cct_minor_version()
    {
        return $this->minor_version;
    }

	/** @fn html_head()
	 *  @brief Setup the HTML headers, retrieve or set $_SESSION data, disables browser cache, and disables output buffering.
	 *  @brief Function executes once.
	 *  @return null 
	 */	
	public function html_head()
	{
		if (isset($this->head))
        {
            return;
        }

		$this->head = 1;  // Flag set to 1 to indicate that html_head() had been executed once.
		
		echo "<!DOCTYPE HTML>\n";   // Enable HTML 5
		
		if (session_id() == '')
        {
            session_start();
        }

        if (empty($_SERVER['REMOTE_USER']))
        {
            $this->html_stop(__FILE__, __FUNCTION__, __LINE__, "_SERVER['REMOTE_USER'] data is missing!");
        }

        //
        // There can be multiple applications that use a copy of this class (html.php) such as Super Tracker.
        // We need to check that we are looking at the right session data for this application. We will check
        // a session variable called "APP_ACRONYM" to see if it contains: "cct6". If it doesn't then we want to
        // reload the session data.
        //
        // If this is the first time the user has logged into this web site this session variable
        // CALL_HTML_TIMEZONE will not be set. In this case we want to set it to YES to instruct the AJAX
        // code below will call server/html_timezone.php to retrieve the local user's workstation timezone
        // information. The session variable in the AJAX routine will set this variable to NO meaning
        // it has the timezone information stored in other session variables. After the AJAX routine
        // finishes running it will reload the index.php page where now the CALL_HTML_TIMEZONE variable
        // will be set to NO.
        //
        if (!isset($_SESSION['APP_ACRONYM']) || $_SESSION['APP_ACRONYM'] != $this->APP_ACRONYM || !isset($_SESSION['CALL_HTML_TIMEZONE']))
        {
        	$_SESSION['APP_ACRONYM'] = $this->APP_ACRONYM;
        	$_SESSION['CALL_HTML_TIMEZONE'] = "YES";
        }

		//
		// If the CALL_HTML_TIMEZONE session variable has been set to NO, it means AJAX has run to
        // receive the user's local timezone information. Next we check to see if session variable
        // user_cuid has been set. If it hasn't we need to retrieve the user's information from the
        // cct_mnet (company Employee Director table) table to set additional session variables.
        //
		if ($_SESSION['CALL_HTML_TIMEZONE'] == "NO" && !isset($_SESSION['cct6']))
		{
 			$this->debug1(__FILE__, __FUNCTION__, __LINE__, "Session data does not exist for this user.");

            $ora = new oracle7();  // classes/oracle.php

            $_SESSION['user_report_output'] = $this->user_report_output; // initialized to 'browser' in: __construct()

            $this->debug1(__FILE__, __FUNCTION__, __LINE__, "Getting cct7_mnet record for user_cuid=%s", $_SERVER['REMOTE_USER']);

            //
            // Retrieve user information and store in session values.
            //
            $query  = "select * from cct7_mnet where ";
            $query .= sprintf("lower(mnet_cuid) = lower('%s') or ", $_SERVER['REMOTE_USER']);
            $query .= sprintf("lower(mnet_workstation_login) = lower('%s')", $_SERVER['REMOTE_USER']);

            if ($ora->sql($query) == false)
            {
                $this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->sql_statement);
                $this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->dbErrMsg);
                $this->error = sprintf("SQL syntax error in file: %s, line: %d. Please contact Greg Parkin", __FILE__, __LINE__);
                $this->ERROR_MESSAGE = $this->error;
            }

            if ($ora->fetch())
            {
                $this->debug1(__FILE__, __FUNCTION__, __LINE__,
                    "Got cct7_mnet record for user %s", $_SERVER['REMOTE_USER']);

                //
                // Copy this user's MNET data into their $_SESSION data variables
                //
                $_SESSION['real_cuid']       = $ora->mnet_cuid;
                $_SESSION['real_name']       =
                    (empty($ora->mnet_nick_name)
                        ? $ora->mnet_first_name
                        : $ora->mnet_nick_name) . " " . $ora->mnet_last_name;

                $_SESSION['user_cuid']       = $this->user_cuid       = $this->real_cuid      = $ora->mnet_cuid;
                $_SESSION['user_first_name'] = $this->user_first_name = $this->real_name      = $ora->mnet_first_name;
                $_SESSION['user_last_name']  = $this->user_last_name  = $ora->mnet_last_name;
                $_SESSION['user_name']       = $this->user_name       = $ora->mnet_name;
                $_SESSION['user_email']      = $this->user_email      = $ora->mnet_email;
                $_SESSION['user_company']    = $this->user_company    = $ora->mnet_company;

                //
                // Does the users manager's cuid exist?
                //
                if (!empty($ora->mnet_mgr_cuid))
                {
                    $this->debug1(__FILE__, __FUNCTION__, __LINE__,
                        "Getting cct7_mnet record for user %s managers cuid=%s",
                        $_SERVER['REMOTE_USER'], $ora->mnet_mgr_cuid);

                    //
                    // Retrieve the manager's cuid from MNET
                    //
                    if ($ora->sql("select * from cct7_mnet where mnet_cuid = '" . $ora->mnet_mgr_cuid . "'") == false)
                    {
                        $this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->sql_statement);
                        $this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->dbErrMsg);
                        $this->error = sprintf("SQL syntax error in file: %s, line: %d. Please contact Greg Parkin",
                            __FILE__, __LINE__);
                        $this->ERROR_MESSAGE = $this->error;
                    }

                    if ($ora->fetch())
                    {
                        $this->debug1(__FILE__, __FUNCTION__, __LINE__,
                            "Got cct7_mnet record for user %s manager's cuid %s",
                            $_SERVER['REMOTE_USER'], $ora->mnet_cuid);
                        //
                        // Add the users manager's MNET data to the $_SESSION data
                        //
                        $_SESSION['manager_cuid']       = $this->manager_cuid       = $ora->mnet_cuid;
                        $_SESSION['manager_first_name'] = $this->manager_first_name = $ora->mnet_first_name;
                        $_SESSION['manager_last_name']  = $this->manager_last_name  = $ora->mnet_last_name;
                        $_SESSION['manager_name']       = $this->manager_name       = $ora->mnet_name;
                        $_SESSION['manager_email']      = $this->manager_email      = $ora->mnet_email;
                        $_SESSION['manager_company']    = $this->manager_company    = $ora->mnet_company;
                    }
                }
            }
            else
            {
                //
                // This code should never reach here because the user must authenticate using their CTL cuid where
                // is always (should be anyway) found in the MNET database (cct_mnet).
                //
                printf("<html><h2>Unable to locate User ID: %s in company Directory table!</h2></html>\n", $_SERVER['REMOTE_USER']);
                exit();
            }

            $this->issue_changed = $_SESSION['issue_changed'] = time(); // UNIX Timestamp (i.e. 1431656775)

            //
            // Next we want to create or update the cct7_users record for this user and retrieve their
            // debugging session data. Debugging is only for the CCT admins, but all debugging settings are
            // now located in the cct7_users table instead of everyone using the global settings found in
            // the old cct7_debugging table.
            //
            // First off set see if the user record in cct7_users exist. If not create a new record. If it
            // does exist, then update the record with information about their browser settings, when they
            // lasted logged, and their local timezone information. The information about their browser and
            // local timezone is used debugging problems with CCT. It's helpful to know what browser they are
            // using where they are located in the world.
            //
            $query  = "select * from cct7_users where user_cuid = '" . $_SERVER['REMOTE_USER'] . "'";

            if ($ora->sql($query) == false)
            {
                $this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->sql_statement);
                $this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->dbErrMsg);
                $this->error = sprintf("SQL syntax error in file: %s, line: %d. Please contact Greg Parkin", __FILE__, __LINE__);
                $this->ERROR_MESSAGE = $this->error;
            }

            if ($ora->fetch() == false)
            {
                //
                // Record does not exist so lets create one for this user.
                //
				$rc = $ora
					->insert("cct7_users")
					->column("user_cuid")
					->column("insert_cuid")
					->column("insert_name")
					->column("local_timezone")
					->column("local_timezone_name")
					->column("local_timezone_abbr")
					->column("local_timezone_offset")
					->column("baseline_timezone")
					->column("baseline_timezone_name")
					->column("baseline_timezone_abbr")
					->column("baseline_timezone_offset")
					->column("time_difference")
					->column("sql_zone_offset")
					->column("sql_zone_abbr")
					->column("last_login_date")
					->column("http_user_agent")
					->value("char", $this->user_cuid)                      // user_cuid
					->value("char", $this->user_cuid)                      // insert_cuid
					->value("char", $this->user_name)                      // insert_name
					->value("char", $_SESSION['local_timezone'])           // local_timezone
					->value("char", $_SESSION['local_timezone_name'])      // local_timezone_name
					->value("char", $_SESSION['local_timezone_abbr'])      // local_timezone_abbr
					->value("int",  $_SESSION['local_timezone_offset'])    // local_timezone_offset
					->value("char", $_SESSION['baseline_timezone'])        // baseline_timezone
					->value("char", $_SESSION['baseline_timezone_name'])   // baseline_timezone_name
					->value("char", $_SESSION['baseline_timezone_abbr'])   // baseline_timezone_abbr
					->value("int",  $_SESSION['baseline_timezone_offset']) // baseline_timezone_offset
					->value("char", $_SESSION['time_difference'])          // time_difference
					->value("char", $_SESSION['sql_zone_offset'])          // sql_zone_offset
					->value("char", $_SESSION['sql_zone_abbr'])            // sql_zone_abbr
					->value("now")                                         // last_login_date
					->value("char", $_SERVER['HTTP_USER_AGENT'])           // http_user_agent
					->execute();

				if ($rc == false)
                {
                    $this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $this->ora->sql_statement);
                    $this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $this->ora->dbErrMsg);
                    $this->error = sprintf("SQL syntax error in file: %s, line: %d. Please contact Greg Parkin: %s",
                        __FILE__, __LINE__, $ora->sql_statement);
                    $this->ERROR_MESSAGE = $this->error;
                }

                $ora->commit();

                $this->user_access_level = $_SESSION['user_access_level'] = "user";
                $this->is_debug_on       = $_SESSION['is_debug_on']       = 'N';
                $this->debug_level1      = $_SESSION['debug_level1']      = 'Y';
                $this->debug_level2      = $_SESSION['debug_level2']      = 'Y';
                $this->debug_level3      = $_SESSION['debug_level3']      = 'Y';
                $this->debug_level4      = $_SESSION['debug_level4']      = 'Y';
                $this->debug_level5      = $_SESSION['debug_level5']      = 'Y';
                $this->debug_path        = $_SESSION['debug_path']        = '/opt/ibmtools/src/cct6/debug/';
                $this->debug_mode        = $_SESSION['debug_mode']        = 'w';
			}
            else
            {
                //
                // Update the user's cct7_users record with the information we want to save.
                //
				$rc = $ora
					->update("cct7_users")
					->set("char", "update_cuid",              $this->user_cuid)
					->set("char", "update_name",              $this->user_name)
					->set("char", "local_timezone",           $_SESSION['local_timezone'])
					->set("char", "local_timezone_name",      $_SESSION['local_timezone_name'])
					->set("char", "local_timezone_abbr",      $_SESSION['local_timezone_abbr'])
					->set("int",  "local_timezone_offset",    $_SESSION['local_timezone_offset'])
					->set("char", "baseline_timezone",        $_SESSION['baseline_timezone'])
					->set("char", "baseline_timezone_name",   $_SESSION['baseline_timezone_name'])
					->set("char", "baseline_timezone_abbr",   $_SESSION['baseline_timezone_abbr'])
					->set("int",  "baseline_timezone_offset", $_SESSION['baseline_timezone_offset'])
					->set("char", "time_difference",          $_SESSION['time_difference'])
					->set("char", "sql_zone_offset",          $_SESSION['sql_zone_offset'])
					->set("char", "sql_zone_abbr",            $_SESSION['sql_zone_abbr'])
					->set("now",  "last_login_date")
					->set("char", "http_user_agent",          $_SERVER['HTTP_USER_AGENT'])
					->where("char", "user_cuid", "=", $this->user_cuid)
					->execute();

				if ($rc == false)
                {
                    $this->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->sql_statement);
                    $this->debug1(__FILE__, __FUNCTION__, __LINE__, "%s", $ora->dbErrMsg);
                    $this->error = sprintf("SQL syntax error in file: %s, line: %d. Please contact Greg Parkin", __FILE__, __LINE__);
                    $this->ERROR_MESSAGE = $this->error;
                }

                $ora->commit();

                //
                // Update the user's debugging session cache variables.
                //
                $this->user_access_level = $_SESSION['user_access_level'] = $ora->user_or_admin;
                $this->is_debug_on       = $_SESSION['is_debug_on']       = $ora->is_debug_on;
                $this->debug_level1      = $_SESSION['debug_level1']      = $ora->debug_level1;
                $this->debug_level2      = $_SESSION['debug_level2']      = $ora->debug_level2;
                $this->debug_level3      = $_SESSION['debug_level3']      = $ora->debug_level3;
                $this->debug_level4      = $_SESSION['debug_level4']      = $ora->debug_level4;
                $this->debug_level5      = $_SESSION['debug_level5']      = $ora->debug_level5;
                $this->debug_path        = $_SESSION['debug_path']        = $ora->debug_path;
                $this->debug_mode        = $_SESSION['debug_mode']        = $ora->debug_mode;
            }
		} // END: if ($_SESSION['CALL_HTML_TIMEZONE'] == "NO" && !isset($_SESSION['user_cuid']))
        else if ($_SESSION['CALL_HTML_TIMEZONE'] == "NO")
        {
            // Always refresh this session value
            $_SESSION['issue_changed'] = time();

			//
			// $_SESSION data already exists so retrieve it and copy the data into our global class variables for
			// further processing by any program that may need it.
			//
			$this->real_cuid                = $_SESSION['real_cuid'];
			$this->real_name                = $_SESSION['real_name'];
			
			$this->user_cuid                = $_SESSION['user_cuid'];
			$this->user_first_name          = $_SESSION['user_first_name'];
			$this->user_last_name           = $_SESSION['user_last_name'];
			$this->user_name                = $_SESSION['user_name'];
			$this->user_email               = $_SESSION['user_email'];
			$this->user_company             = $_SESSION['user_company'];
			$this->user_report_output       = $_SESSION['user_report_output'];

			$this->manager_cuid             = $_SESSION['manager_cuid'];
			$this->manager_first_name       = $_SESSION['manager_first_name'];
			$this->manager_last_name        = $_SESSION['manager_last_name'];
			$this->manager_name             = $_SESSION['manager_name'];
			$this->manager_email            = $_SESSION['manager_email'];
			$this->manager_company          = $_SESSION['manager_company'];

            //
            // This data actually comes from cct_members except for the timezone info which
            // is figured out by servers/html_timezone.php and then updated in cct_members
            // for debugging and tracking purposes.
            //
            $this->member_cuid              = $_SESSION['member_cuid'];
            $this->member_name              = $_SESSION['member_name'];
            $this->member_email             = $_SESSION['member_email'];
            $this->member_can_close         = $_SESSION['member_can_close'];
            $this->member_city              = $_SESSION['member_city'];
            $this->member_state_code        = $_SESSION['member_state_code'];
            $this->member_country_code      = $_SESSION['member_country_code'];
            $this->member_can_close         = $_SESSION['member_can_close'];
            $this->local_timezone           = $_SESSION['local_timezone'];
            $this->local_timezone_name      = $_SESSION['local_timezone_name'];
            $this->local_timezone_abbr      = $_SESSION['local_timezone_abbr'];
            $this->local_timezone_offset    = $_SESSION['local_timezone_offset'];
            $this->sql_zone_offset          = $_SESSION['sql_zone_offset'];
            $this->sql_zone_abbr            = $_SESSION['sql_zone_abbr'];
            $this->baseline_timezone        = $_SESSION['baseline_timezone'];
            $this->baseline_timezone_name   = $_SESSION['baseline_timezone_name'];
            $this->baseline_timezone_abbr   = $_SESSION['baseline_timezone_abbr'];
            $this->baseline_timezone_offset = $_SESSION['baseline_timezone_offset'];
            $this->time_difference          = $_SESSION['time_difference'];
            $this->user_or_admin            = $_SESSION['user_or_admin'];
            $this->is_debug_on              = $_SESSION['is_debug_on'];
            $this->debug_level1             = $_SESSION['debug_level1'];
            $this->debug_level2             = $_SESSION['debug_level2'];
            $this->debug_level3             = $_SESSION['debug_level3'];
            $this->debug_level4             = $_SESSION['debug_level4'];
            $this->debug_level5             = $_SESSION['debug_level5'];
            $this->debug_path               = $_SESSION['debug_path'];
            $this->debug_mode               = $_SESSION['debug_mode'];
            $this->pref_sort_field1         = $_SESSION['pref_sort_field1'];
            $this->pref_sort_field2         = $_SESSION['pref_sort_field2'];
            $this->pref_sort_field3         = $_SESSION['pref_sort_field3'];
            $this->pref_sort_field4         = $_SESSION['pref_sort_field4'];
            $this->pref_sort_field5         = $_SESSION['pref_sort_field5'];
            $this->pref_sort_field6         = $_SESSION['pref_sort_field6'];
            $this->pref_sort_direction      = $_SESSION['pref_sort_direction'];
            $this->pref_starting_date       = $_SESSION['pref_starting_date'];
            $this->pref_show_open           = $_SESSION['pref_show_open_issues'];
            $this->pref_show_closed         = $_SESSION['pref_show_closed_issues'];
            $this->pref_show_deleted_issues = $_SESSION['pref_show_deleted_issues'];
            $this->pref_just_mine           = $_SESSION['pref_show_just_mine'];
            $this->pref_excel_action_items  = $_SESSION['pref_excel_action_items'];
            $this->pref_excel_status_notes  = $_SESSION['pref_excel_status_notes'];
            $this->pref_excel_private_notes = $_SESSION['pref_excel_private_notes'];
            $this->work_group_name          = $_SESSION['work_group_name'];
            $this->issue_changed            = $_SESSION['issue_changed'];

		} // END: else if ($_SESSION['CALL_HTML_TIMEZONE'] == "NO")

		// 
		// header() is a PHP function for modifying the HTML header information 
		// going to the client's browser. Here we tell their browser not to cache
		// the page coming in so their browser will always rebuild the page from
		// scratch instead of retrieving a copy of one from its cache.
		//
		// header("Expires: " . gmstrftime("%a, %d %b %Y %H:%M:%S GMT"));
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: no-store, no-cache, must-revalidate");
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		
		//
		// QUERY_STRING is actually parsed in the constructor function so programs can know right
		// away if there are any parms available. Below we just show the parm information if present.
		//
		if (isset($_SERVER['QUERY_STRING']))
		{
			printf("<!-- QUERY_STRING = %s -->\n", $_SERVER['QUERY_STRING']);
		}
	
		//
		// Disable buffering - This is what makes the loading screen work properly.
		//
		@apache_setenv('no-gzip', 1);
		@ini_set('zlib.output_compression', 0);
		@ini_set('output_buffering', 'Off');
		@ini_set('implicit_flush', 1);
		
		ob_implicit_flush(1); // Flush buffers
		
		for ($i = 0, $level = ob_get_level(); $i < $level; $i++) 
		{
			ob_end_flush();
		}

        printf("<html lang=\"en\">\n");
        printf("<head>\n");
        printf("<meta http-equiv=\"x-ua-compatible\" content=\"IE=9\">\n");
        printf("<title>%s</title>\n", $this->HTML_TITLE);
        printf("<link rel=\"icon\" type=\"image/png\" href=\"supertracker.png\" />\n");

		//
		// Print out the base_ref information identified above.
		//
		if (isset($this->BASE_HREF))
			printf("<base href=\"%s\">\n", $this->BASE_HREF); 
			
		$this->debug1(__FILE__, __FUNCTION__, __LINE__, "user_cuid=%s, user_name=%s", $this->user_cuid, $this->user_name);			
	}

	/** @fn html_meta()
	 *  @brief Print out the HTML meta data.
	 *  @brief Function executes once.
	 *  @return null 
	 */	
	public function html_meta()
	{
		//
		// Run this function only once.
		//
		if (isset($this->meta) && strlen($this->meta) > 0)
			return;
			
		$this->meta = 1;  // Indicate that we have run this function
		$this->html_head();	      // Ensure that this function has executed at least once.
        ?>
        <!-- META -->
        <META NAME="Description" CONTENT="<?php echo $this->HTML_TITLE?>">
        <META NAME="Keywords" CONTENT="<?php echo $this->META_KEYWORDS?>">
        <META NAME="robots" CONTENT="no, none">
        <META NAME="resource-type" CONTENT="document">
        <META NAME="distribution" CONTENT="<?php echo $this->META_DISTRIBUTION?>">
        <META NAME="country" CONTENT="USA">
        <META HTTP-EQUIV="PUBLIC" CONTENT="YES">
        <META NAME="security" CONTENT="public">
        <META NAME="CATEGORY" CONTENT="Tool">
        <META NAME="MS.LOCALE" CONTENT="EN-US">
        <META HTTP-EQUIV="LANGUAGE" CONTENT="ENGLISH">
        <META NAME="Usergroup" CONTENT="Public">
        <META NAME="rating" CONTENT="General">
        <META HTTP-EQUIV="EXPIRES" CONTENT="0">
        <META NAME="REVISIT-AFTER" CONTENT="15 days">
        <META http-equiv="Cache-Control" content="no-cache">
        <META HTTP-EQUIV="content-type" CONTENT="text/html;charset=iso-8859-1">
        <META NAME="creation_date" content = "<?php echo date('m-d-Y')?>">
        <META NAME="company" CONTENT="<?php echo $this->META_COMPANY?>">
        <META NAME="contact person" CONTENT="<?php echo $this->META_CONTACT_PERSON?>">
        <META NAME="owner" CONTENT="<?php echo $this->META_CONTACT_EMAIL?>">
        <META NAME="Reply-To" CONTENT="<?php echo $this->META_CONTACT_EMAIL?>">
        <META NAME="alias" CONTENT="<?php $this->WWW?>">
        <META NAME="Copyright" CONTENT="<?php echo $this->META_COPYRIGHT?>">
        <META NAME="Copyright Law" CONTENT="<?php echo $this->META_COPYRIGHT_LAW?>">
        <?php
		//
		// This is useful for auto-refresh or URL redirects. 
		// If META_REFRESH and META_REFRESH are not null then write out the meta
		// data used to refresh or redirect a web page.
		//
		if (isset($this->META_REFRESH) && strlen($this->META_REFRESH) > 0)
		{
			printf("<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"%d; url=%s\">", 
				$this->REFRESH_RATE, $this->META_REFRESH);
		}
	}

	/** @fn html_styles()
	 *  @brief Load and print out styles used in the construction of the web pages.
	 *  @brief Function executes once.
	 *  @return null 
	 */		
	public function html_styles()
	{
		//
		// Run this function only once.
		//
		if (isset($this->styles))
			return;
			
		$this->styles = 1;	 // Indicate that we have run this function
		$this->html_meta();	         // Ensure that this function has executed at least once.
        ?>
        <!-- BEGIN: STYLES -->
        <!-- jQWidgets CSS -->
        <!-- <link rel="stylesheet" href="css/themes/smoothness/jquery-ui.css"> -->

        <link rel="stylesheet" type="text/css"                href="css/jqx.base.css">
        <link rel="stylesheet" type="text/css"                href="css/jqx.bootstrap.css">
        <link rel="stylesheet" type="text/css"                href="css/jqx.shinyblack.css">
        <link rel="stylesheet" type="text/css"                href="css/html.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" media="screen" href="jqGrid.4.7.1/css/ui.jqgrid.css">
        <link rel="stylesheet" type="text/css" media="all"    href="css/jquery-ui-timepicker-addon.css">
        <!-- END: STYLES -->
<?php	
	}

	/** @fn html_scripts()
	 *  @brief Print out and load Javascript code
	 *  @brief Function executes once.
	 *  @return null
	 */		
	public function html_scripts()
	{
		//
		// Run this function only once.
		//	
		if (isset($this->scripts))
			return;
			
		$this->scripts = 1;		 // Indicate that we have run this function
		$this->html_styles();		     // Ensure that this function has executed at least once.
?>
        <!-- SCRIPTS -->
        <script type="text/javascript" src="js/jquery-1.11.3.js"></script>


        <!-- <script type="text/javascript" src="js/DateTimePicker.js"></script> -->
        <!-- Bootstrap core JavaScript ================================================== -->
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/jquery-ui.js"></script><!-- must come after bootstrap.min.js -->
        <script type="text/javascript" src="js/jquery.themeswitcher.js"></script>

        <script type="text/javascript" src="js/jqxcore.js"></script><!-- jqWidgets: base code -->
        <script type="text/javascript" src="js/jqxmenu.js"></script><!-- jqWidgets: jqxMenu - runs nav menu -->
        <script type="text/javascript" src="js/jstz.js"></script><!-- Determines user's timezone of the PC their using -->
        <script type="text/javascript" src="js/html.js"></script>

		<!-- jqGrid.4.8.2 does not work with Change Coordination Tool -->
        <script type="text/javascript" src="jqGrid.4.7.1/js/jquery.jqGrid.min.js"></script>
        <script type="text/javascript" src="jqGrid.4.7.1/js/i18n/grid.locale-en.js"></script>
        <!-- <script type="text/javascript" src="js/jquery.blockUI.js"></script> -->

        <script type="text/javascript" src="js/jquery-ui-timepicker-addon.js"></script>
        <script type="text/javascript" src="js/jquery-ui-sliderAccess.js"></script>

        <script type="text/javascript" src="js/detect.js"></script><!-- Detect browser so we can size dialog boxes -->

        <!--[if lt IE 9]>
        <script src="js/IE9.js"></script>
        <![endif]-->

        <script type="text/javascript">

            function escapeHTML(html)
            {
                if (typeof html !== 'string')
                    return html;

                var fn = function(tag)
                {
                    var charsToReplace = {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&#34;'
                    };

                    return charsToReplace[tag] || tag;
                };

                return html.replace(/[&<>"]/g, fn);
            }

        $(document).ready(
            function ()
            {
                $("#navBar").jqxMenu(
                    {
                        autoSizeMainItems:  true,
                        theme:              "shinyblack",
                        showTopLevelArrows: true,
                        width:              '100%'
                    }
                );
                $("#navBar").css("visibility", "visible");
            }
        );

        $(document).ready(
            function()
            {
                <?php
                if ($_SESSION['CALL_HTML_TIMEZONE'] === "YES")
                {
                    $_SESSION['CALL_HTML_TIMEZONE'] = "NO";
                ?>
                    //alert('CALLING HTML_TIMEZONE7.PHP');

                    var tz = jstz.determine();
                    $.ajax(
                        {
                            type: "GET",
                            url:  "<?php echo $this->WWW; ?>/servers/html_timezone7.php",
                            data: 'timezone=' + tz.name(),
                            success: function()
                            {
                                f1.action = "<?php echo $this->WWW; ?>/index7.php";
                                f1.submit();
                            }
                        }
                    );
                <?php
                }
                ?>
            }
        );
        </script>

        <?php
		if ($this->numberOfTabs > 0)
		{
			printf("<script language=\"JavaScript\">\n");
			printf("function domTab(i)\n");
			printf("{\n");
			printf("  // Variables for customisation:\n");
			printf("  var numberOfTabs = %d;\n", $this->numberOfTabs);
			printf("  var colourOfInactiveTab = \"%s\";\n", $this->colourOfInactiveTab);
			printf("  var colourOfActiveTab = \"%s\";\n", $this->colourOfActiveTab);
			printf("  var colourOfInactiveLink = \"%s\";\n", $this->colourOfInactiveLink);
			printf("  var colourOfActiveLink = \"%s\";\n", $this->colourOfActiveLink);
			printf("  // end variables\n");
			printf("  if (document.getElementById)\n");
			printf("  {\n");
			printf("    for (f=1;f<numberOfTabs+1;f++)\n");
			printf("    {\n");
			printf("      document.getElementById('contentblock'+f).style.display='none';\n");
			printf("      document.getElementById('link'+f).style.background=colourOfInactiveTab;\n");
			printf("      document.getElementById('link'+f).style.color=colourOfInactiveLink;\n");
			printf("    }\n");
			printf("    document.getElementById('contentblock'+i).style.display='block';\n");
			printf("    document.getElementById('link'+i).style.background=colourOfActiveTab;\n");
			printf("    document.getElementById('link'+i).style.color=colourOfActiveLink;\n");
			printf("  }\n");
			printf("}\n");
			printf("</script>\n");		
		}
	}	
	
	/** @fn html_body()
	 *  @brief Print out HTML body statement and popup any message from ERROR_MESSAGE that may exist.
	 *  @brief Function executes once.
	 *  @return null 
	 */			
	public function html_body()
	{
		//
		// Run this function only once.
		//		
		if (isset($this->body))
			return;
			
		$this->body = 1;		 // Indicate that we have run this function	
		$this->html_scripts();		     // Ensure that this function has executed at least once.

		printf("\n<!-- HEAD END -->\n");
		printf("</head>\n");

		printf("\n<!-- BODY -->\n");
		
		//
		// If $this->ERROR_MESSAGE has a message then it displayed in a popup dialog box in the users browser.
		//
		if (isset($this->ERROR_MESSAGE) && strlen($this->ERROR_MESSAGE) > 0)
		{
			if (isset($this->ON_LOAD) && strlen($this->ON_LOAD) > 0)
			{
				printf("<body onLoad=\"alert('%s');%s\">\n",
					$this->ERROR_MESSAGE, $this->ON_LOAD);
			}
			else
			{
				printf("<body onLoad=\"alert('%s');\">\n",
					$this->ERROR_MESSAGE);
			}
		}
		else
		{
			if (isset($this->ON_LOAD) && strlen($this->ON_LOAD) > 0)
			{
				printf("<body onLoad=\"%s\">\n", $this->ON_LOAD);
			}
			else
			{
				printf("<body>\n");
			}		
		}	
	}	

	/** @fn html_form()
	 *  @brief if set_program() was to set the PROGRAM, write out the form statement
	 *  @brief Function executes once.
	 *  @return null 
	 */		
	public function html_form()
	{
		//
		// Run this function only once.
		//	
		if (isset($this->form))
			return;
			
		$this->form = 1;		// Indicate that we have run this function
		$this->html_body();		        // Ensure that this function has executed at least once.
		
		printf("\n<!-- FORM -->\n");
		
		if (strlen($this->PROGRAM) === 0)
		{
			printf("<form name=\"%s\" method=\"%s\">\n", $this->FORM_NAME, $this->METHOD);
		}
		else
		{
			printf("<form name=\"%s\" method=\"%s\" action=\"%s\">\n", $this->FORM_NAME, $this->METHOD, $this->PROGRAM);
		}
        ?>
        <?php
	}	

	/** @fn html_top()
	 *  @brief Ensures that html_head(), html_meta(), html_styles(), html_scripts(), html_body(), and html_form() have run.
	 *  @brief Creates the div section with the id=head and writes out the SpryWidget menu.
	 *  @brief Writes out code for when set_loading_file_on() is called to display loading page.
	 *  @brief Ends div id=head and starts div id=content where main programs can begin to write out content.
	 *  @brief Function executes once.
	 *  @return null 
	 */		
	public function html_top()
	{
		//
		// Run this function only once.
		//		
		if (isset($this->html_top))
			return;
			
		$this->html_top = 1;	 // Indicate that we have run this function
		$this->html_body();		 // Ensure that this function has executed at least once. html_form() is call before leaving this function.
?>
        <!-- BEGIN: MENU -->
        <!-- Fixed navbar -->
        <!-- NavBar Menu option names must be single words or the menu will not display properly -->
        <!-- div class="navbar navbar-default navbar-fixed-top" role="navigation" -->
        <div class="head navbar-default">
            <div style="visibility: hidden;" id="navBar" >
                <ul>
                    <li style="width: 100px;" title="Takes you to the Change Coordination Tool Home Page."><img src="images/home8.png" align="top"><a href="index7.php"><b>Home</b></a></li>
                    <!-- BEGIN: FILE -->
                    <li style="width: 100px;"><img src="images/folders.gif" align="top"><b>File</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <li><a href="new_work_request7.php" title="Create a new work request">New Work Request</a></li>
                            <li type="separator"></li>
                            <li><a onclick="openEditPreferencesDialog('User Preferences')"        >User Preferences</a></li>
                        </ul>
                    </li><!-- END: FILE -->
                    <!-- BEGIN: EDIT -->
                    <li style="width: 100px;" title="Setup and configure Change Coordination Tool."><img src="images/edit22.gif" align="top"><b>Edit</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <li><a onclick="alert('Not Implemented yet!')"                              >Members</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                              >Teams</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                               >Remedy Group Names</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                              >Custom Action List</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                              >Custom Category List</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                              >Purge Records</a></li>
                        </ul>
                    </li><!-- END: EDIT -->
                    <!-- BEGIN: VIEW -->
                    <li style="width: 100px;" title="Web page theme selector and Grid view options."><img src="images/icon_eyes.gif" align="top"><b>View</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <li><a onclick="openThemeDialog('Select UI Theme')"          >Theme Selector</a></li>
                            <li type="separator"></li>
                            <li>                                                           Work Requests
                                <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                                    <li><a onclick="alert('Not Implemented yet!')"                              >By Ticket</a></li>
                                    <li><a onclick="alert('Not Implemented yet!')"                              >By Net-Pin</a></li>
                                    <li><a onclick="alert('Not Implemented yet!')"                              >By Contact</a></li>
                                    <li><a onclick="alert('Not Implemented yet!')"                              >Members</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <!-- END: VIEW -->
                    <!-- BEGIN: ACTIONS -->
                    <li style="width: 100px;" title="Startup background tasks."><img src="images/run1.png" align="top"><b>Actions</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <li><a onclick="openRunRemedySyncDialog('Run Remedy Sync')"               >Run Remedy Sync</a></li>
                            <!-- <li type="separator"></li> -->
                        </ul>
                    </li><!-- END: ACTIONS -->
                    <!-- BEGIN: REPORTS -->
                    <li style="width: 100px;"><img src="images/reports3.png" align="top"><b>Reports</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <?php
                            printf("<li><a href=\"report_output.php\"                          >Report Output: %s</a></li>\n", $this->user_report_output);
                            ?>
                            <li><a onclick="alert('Not Implemented yet!')"                                 >History</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                                >Activity Log</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"               >Last Login</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"               >Sendmail Activity</a></li>
                        </ul>
                    </li><!-- END: REPORTS -->
                    <?php
                    //
                    // Include the ADMIN menu if this users user_or_admin == 'admin'
                    //
                    if ($this->user_or_admin == "admin")
                    {
                        ?>
                        <!-- BEGIN: SUPPORT -->
                        <li style="width: 100px;" title="Greg's support tools menu."><img src="images/support1.png" align="top"><b>Support</b>
                            <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                                <li><a onclick="alert('Not Implemented yet!')"                              >Work Groups</a></li>
                                <li><a onclick="alert('Not Implemented yet!')"                              >Switch User</a></li>
                                <li><a onclick="alert('Not Implemented yet!')"                              >Debug Options</a></li>
                                <li><a onclick="grid_info()"                                                >Grid Information</a></li>
                                <li><a href="file_viewer_debug.php"                                         >Debug Files</a></li>
                                <li><a href="dump_env.php"                                                  >Dump Env</a></li>
                                <li><a href="phpinfo.php"                                                   >PHP Information</a></li>
                                <li><a onclick="alert('Not Implemented yet!')"                              >Cron Jobs</a></li>
                                <li><a onclick="alert('Not Implemented yet!')"                              >CCT Admins</a></li>
                                <li>                                                                        CCT Documentation
                                    <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                                        <li><a onclick="alert('Not Implemented yet!')"                              >Database Schema</a></li>
                                        <li><a onclick="alert('Not Implemented yet!')"                         >Source Code</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li><!-- END: SUPPORT -->
                    <?php
                    }
                    ?>
                    <!-- BEGIN: HELP -->
                    <li style="width: 100px;"><img src="images/help14.png" align="top"><b>Help</b>
                        <ul style="width: 250px; box-shadow: 10px 10px 5px #888;">
                            <li><a onclick="alert('Not Implemented yet!')"                               >Power Point Slides</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                              >CCT Overview Videos</a></li>
                            <li><a onclick="alert('Not Implemented yet!')"                               >About Change Coordination Tool</a></li>
                        </ul>
                    </li><!-- END: ADMIN -->
                </ul>
            </div><!--/.nav-collapse -->
        </div>
        <!-- END: MENU -->

        <!-- BEGIN: CONTENT -->
        <div id="content">
<?php
        //
        // Write paging loading screen when set_loading_file_on() has been called.
        //
        if ($this->IS_LOADING_FILE_ON == true)
        {
?>
            <!--this is the loading screen div-->
            <div id="loading" class="loading-invisible">
                <p align=center><img src="images/gears_animated.gif" alt="Loading..." /><br><h1><?php echo $this->LOADING_MESSAGE ?></h1></p>
            </div>
<?php
        }
?>
        <!--this is the loading screen JavaScript-->
        <script type="text/javascript">
        document.getElementById("loading").className = "loading-visible";

        var hideDiv = function()
            {
              document.getElementById("loading").className = "loading-invisible";
            };

        var oldLoad = window.onload;

        var newLoad = oldLoad ? function()
            {
              hideDiv.call(this);
              oldLoad.call(this);
            } : hideDiv;

        window.onload = newLoad;
        </script>
<?php	
		//
		// Last by not least, make sure we call html_form()
		//
		$this->html_form();
	}

	/** @fn html_bot()
	 *  @brief Closes the div id=content and writes div id=foot which contains the footer for the web page.
	 *  @return null 
	 */			
	public function html_bot()
	{
?>
        </form>
        </div><!-- END: CONTENT -->
	
        <!-- BEGIN: FOOT -->
        <div id="foot">
        <center>
        <table border="0" cellpadding="8" cellspacing="4" style="border-collapse: collapse" bordercolor="#111111"
               width="100%">
        <tr>
            <td align="left" valign="top" width="25%">
                <?php
                if (isset($_SESSION['user_name']))
                {
                ?>
                    <font color="#4485c4"><b>Welcome:</b> <?php echo $_SESSION['user_name'] ?></font>
                    <br>
                    <font color="#800000"><b>For help, contact: </b>
                        <a href="javascript:NewWindow('http://net.qintra.com/NET/Notification.jsp?gid=<?php echo $this->NET_PIN; ?>')">
                            <font color="#800000"><?php echo $this->NET_GROUP_NAME; ?></font></a></font><br>
                    <font color="#800000"><b>CCT: </b><?php echo $this->BUILD_VERSION; ?> - <?php echo $this->BUILD_DATE; ?></font>&nbsp;
                    <img align="absmiddle" src="images/php_powered.png">
                    <?php
                    if (isset($_SESSION['is_debug_on']) && $_SESSION['is_debug_on'] == 'Y')
                    {
                        printf("<img align=\"absmiddle\" src=\"images/ladybug.png\">\n");
                    }
                    ?>
                    <br><font size="2" color="#8b008b"><b>Local TZ:</b> <?php printf("%s", $_SESSION['local_timezone']); ?></font>
                <?php
                }
                else
                {
                    ?><img src="images/bigSnake.gif"><?php // Display animated loading circle called bigSnake.gif
                }
                ?>

            </td>
            <td valign="top" align="center" width="50%">
                <font size="2" color="#800000" face="Arial Narrow">
                Internal Use Only<br>
                Disclose and Distribute only to Authorized IBM Employees<br>
                Disclosure outside of IBM is prohibited without authorization</font>
            </td>
            <td valign="top" align="center" width="25%">

                <font size="2" color="#800000"><b><?php echo $this->CCT_APPLICATION; ?></b></font><br>
                <a href="<?php echo $this->WWW; ?>"><font size="1" color="#800000"><b><?php echo $this->WWW; ?></b></font></a><br>
                <?php $this->page_hits(); ?>
            </td>
        </tr>
        </table>
        </center>
        </div><!-- END: FOOT -->
<?php   
		//
		// If stop_before_end() has been called then html_bot() will return here.
		// Some web pages require additional javascript code to be added before the 
		// closing body and html tags. After the main program calls stop_before_end()
		// and html_bot(), they will insert additional code and then they must manual
		// write the ending body and html tags.
		//
		if ($this->STOP_BEFORE_END)
		{
			printf("<!-- STOP BEFORE END -->\n");
			return;
		}
		
?>		
        </body>
        </html>
<?php	
	}

	/** @fn page_hits()
	 *  @brief Opens the counter page hits file for the calling program, extracts the hit number, increments the hit number
	 *  @brief and writes the new hit number to the counter file.
	 *  @brief HTML is then generated to display the page hit images in the proper sequence.
	 *  @brief page_hits() called from html_bot().
	 *  @return null 
	 */	
	public function page_hits()
	{
		$page_hit_count = 0;
		$page_hit_file = $this->COUNTER_DIR . $this->COUNTER_FILE;
		
		if (file_exists($page_hit_file))
		{
			if (($fp = fopen($page_hit_file, "r")) === false)
			{
				$page_hit_count = 0;
				$trace = debug_backtrace();
				trigger_error(
					'Cannot open file for read: ' . $page_hit_file .
					' in ' . $trace[0]['file'] .
					' on line ' . $trace[0]['line'],
					E_USER_NOTICE);		
				return;
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
			$trace = debug_backtrace();
			trigger_error(
				'Cannot open file for write: ' . $page_hit_file .
				' in ' . $trace[0]['file'] .
				' on line ' . $trace[0]['line'],
				E_USER_NOTICE);			
		}
		
		fprintf($fp, "%d\n", $count);
		fclose($fp);
		
		printf("<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" style=\"border-collapse: collapse\" bordercolor=\"#111111\">\n");
		printf("<tr>\n");
		printf("<td><b><font size=\"2\" color=\"#800000\">Page Hits:&nbsp;</font></b></td>\n");
		
		$str = sprintf("%1$08d", $page_hit_count);
		$len = strlen($str);
		
		$str2 = str_split($str);
		reset($str2);
		
		while (list(, $value) = each($str2))
		{
			echo "<td><img border=0 src=images/$value.gif width=9 height=13></td>";
		}

		printf("</tr>\n");
		printf("</table>\n");
	}

	/** @fn isButton()
	 *  @brief Helper function used to determine if a button has been pressed on a web page.
	 *  @brief Buttons must have name set to button in order for this function to work.
	 *  @param $what is button name (i.e. value='Okay') isButton('Okay')
	 *  @return true = button was pressed, false = button was not pressed
	 */	
	public function isButton($what)
	{
		if (isset($_REQUEST['button']) && $_REQUEST['button'] == $what)
		{
			return true;
		}
		
		return false;
	}

	/** @fn set_tool_name()
	 *  @brief Used to override default WWW which was set in the constructor function.
	 *  @brief This is the URL to the application like: https://cct.qintra.com
	 *  @param $what is the URL
	 *  @return null
	 */			
	public function set_tool_name($what)
	{
		if (strlen($what) > 0)
			$this->WWW = $what;
	}

    /** @fn goHome()
     *  @brief Used to cause the home page to load when we were expecting url options to be set before continuing.
     */
    public function goHome()
    {
        $this->set_meta_refresh($this->WWW . "/index7.php");
        $this->set_refresh_seconds(0);
        $this->html_top();
        $this->set_loading_file_on("Loading CCT Home Page");
        $this->set_program("index7.php");
        $this->html_bot();
        exit();
    }

	/** @fn set_refresh_seconds()
	 *  @brief Used to set the meta refresh time interval after the web page loads.
	 *  @brief If using for page redirects, set the refresh time to 0.
	 *  @param $what is the interval in seconds.
	 *  @return null
	 */		
	public function set_refresh_seconds($what)
	{
		$this->REFRESH_RATE = $what;
	}
	
	/** @fn set_meta_refresh()
	 *  @brief Set the META_REFRESH to the URL we want to refresh when the timer elapses.
	 *  @param $what is the URL
	 *  @return null
	 */		
	public function set_meta_refresh($what)
	{
		$this->META_REFRESH = $what;
	}

	/** @fn set_program()
	 *  @brief Used to set the program and options in a form statement
	 *  @param $what is the action in a form statement
	 *  @return null
	 */		
	public function set_program($what)
	{
		if (isset($this->WWW))
		{
			$this->PROGRAM = $this->WWW . '/' . $what;
		}
		else
		{
			$this->PROGRAM = $what;
		}
	}

	/** @fn set_form_name()
	 *  @brief Overrides the default form name of f1. 
	 *  @brief Recommend you don't use change the form name because many utility functions rely of the form name being f1
	 *  @param $what is the new form name
	 *  @return null
	 */	
	public function set_form_name($what)
	{
		$this->FORM_NAME = $what;
	}	

	/** @fn set_method_post()
	 *  @brief Changes the form method to post which is the default setting in the constructor.
	 *  @return null
	 */		
	public function set_method_post()
	{
		$this->METHOD = "post";
	}

	/** @fn set_method_get()
	 *  @brief Changes the form method to get.
	 *  @return null
	 */		
	public function set_method_get()
	{
		$this->METHOD = "get";
	}

	/** @fn set_loading_file_off()
	 *  @brief Disable the loading page which is the default setting.
	 *  @return null
	 */		
	public function set_loading_file_off()
	{
		$this->IS_LOADING_FILE_ON = false;
	}

	/** @fn set_loading_file_on()
	 *  @brief Sets flag and the text that will be displayed for the loading file screen
	 *  @param $what is the loading message
	 *  @return null
	 */		
	public function set_loading_file_on($what)
	{
		if (strlen($what) > 0)
		{
			$this->LOADING_MESSAGE = $what;
		}
		else
		{
			$this->LOADING_MESSAGE = 'Loading File...';
		}
		
		$this->IS_LOADING_FILE_ON = true;
	}
	
	/** @fn set_title()
	 *  @brief Sets the web browsers title to a message of your choosing.
	 *  @param $what is the title message
	 *  @return null
	 */		
	public function set_title($what)
	{
		$this->HTML_TITLE = $what;	
	}
	
	/** @fn set_help_menu()
	 *  @brief By default the main CCT 6.0 menu is displayed. This function tells the program we want to use
	 *  the help menu for display video training content.
	 *  @return null
	 */
	public function set_help_menu()
	{
		$this->LOAD_MENU = "help";
	}

	/** @fn set_base_href()
	 *  @brief Overrides the default base_href setting created in the constructor function
	 *  @param $what is the new base_ref path
	 *  @return null
	 */	
	public function set_base_href($what)
	{
		$this->BASE_HREF = $what;	
	}

	/** @fn set_on_load()
	 *  @brief Sets the bodys onload= to perform some kind of javascript action.
	 *  @param $what is the javascript action (i.e. set_on_load("alert('Hello World!')")
	 *  @return null
	 */		
	public function set_on_load($what)
	{
		$this->ON_LOAD = $what;	
	}

	/** @fn set_ErrorMessage()
	 *  @brief When ERROR_MESSAGE is set, a popup dialog will appear with the text after the page finishes loading
	 *  @brief This does not have to be an error message. You can use it for notification messages as well.
	 *  @param $what is the error message
	 *  @return null
	 */		
	public function set_ErrorMessage($what)
	{
		$this->ERROR_MESSAGE = $what;
	}

	/** @fn stop_before_end()
	 *  @brief Sets a flag to instruct html_bot() to return before writing the ending body and html tags.
	 *  @brief This gives programs a chance to add additional javascript code to the web page before adding the ending body and html tags.
	 *  @return null
	 */		
	public function stop_before_end()
	{
		$this->STOP_BEFORE_END = true;
	}

	/** @fn html_stop()
	 *  @brief Output a Stop graphic, file, function, line number and message.
	 *  @param $file File name of calling function. __FILE__
	 *  @param $func Function name of calling module. __FUNCTION__
	 *  @param $line Line number in File of calling function. __LINE__
	 *  @param $msg This is the error message
	 *  @return null
	 */		
	public function html_stop($file, $func, $line, $msg)
	{
		$argv = func_get_args();
		$file = array_shift($argv);
		$func = array_shift($argv);  
		$line = array_shift($argv);
		$format = array_shift($argv);	
		$what = vsprintf($format, $argv);

        // If your program already called html_top() then this function will just return.
		$this->html_top();
		
		printf("<p align=\"center\"><img border=\"0\" src=\"images/stop.gif\" width=\"75\" height=\"74\"></p>\n");
		
		// Some php code may not be in a function
		if (empty($func)) 
			printf("<p align=\"center\">%s %d: %s</p>\n", basename($file), $line, $what);
		else
			printf("<p align=\"center\">%s %s() %d: %s</p>\n", basename($file), $func, $line, $what);
				
		$this->html_bot();
		exit();
	}	

	/** @fn show_page_loading()
	 *  @brief Used when you don't want to include the header and footer, but you want the page loading screen to be displayed.
	 *  @brief You must call first: $h->set_loading_file_on("Work Requests"); to set the load page message. Once the page loads this message disappears
	 *  @return null
	 */		
	public function show_page_loading()
	{
		//
		// Write paging loading screen when set_loading_file_on() has been called.
		//
		if ($this->IS_LOADING_FILE_ON == true)
		{
?>
			<!--this is the loading screen CSS-->
			<style type="text/css">
			/*this is what we want the div to look like	when it is not showing*/
			div.loading-invisible {
				/*make invisible*/
				display:none;
			}

			/*this is what we want the div to look like when it IS showing*/
			div.loading-visible {
				/*make visible*/
				display:block;

				/*position it 200px down the screen*/
				position:absolute;
				top:200px;
				left:0;
				width:100%;
				text-align:center;

				/*in supporting browsers, make it a little transparent*/
				background:#fff;
				filter: alpha(opacity=75); /* internet explorer */
				-khtml-opacity: 0.75;      /* khtml, old safari */
				-moz-opacity: 0.75;       /* mozilla, netscape */
				opacity: 0.75;           /* fx, safari, opera */
				border-top:1px solid #ddd;
				border-bottom:1px solid #ddd;
			}
			</style>

			<!--this is the loading screen div-->
			<div id="loading" class="loading-invisible">      
    	    <p align=center><img src="images/gears_animated.gif" alt="Loading..."><br><h1><?php echo $this->LOADING_MESSAGE ?></h1></p>
			</div>
<?php
		}
?>
		<!--this is the loading screen JavaScript-->
		<script type="text/javascript">
			document.getElementById("loading").className = "loading-visible";
			var hideDiv = function() { document.getElementById("loading").className = "loading-invisible"; };
			var oldLoad = window.onload;
			var newLoad = oldLoad ? function() { hideDiv.call(this); oldLoad.call(this); } : hideDiv;
            window.onload = newLoad;
		</script>	
<?php       
	}

	/** @fn html_dump()
	 *  @brief Dump HTML PHP global variables for evaluation.
	 *  @brief Used for debugging your web pages.
	 *  @return null
	 */		
	public function html_dump()
	{
?>
        <pre><!-- DUMPING HTML PHP SUPER GLOBAL VARIABLES FOR EVALUATION -->
<?php
		printf("parm_count=%d\n", $this->parm_count);
		printf("\nparm: ");
		print_r($this->parm);
		printf("\n_POST: ");
		print_r($_POST);
		printf("\n_GET: ");
		print_r($_GET);
		printf("\n_REQUEST: ");
		print_r($_REQUEST);
		printf("\n_SERVER: ");
		print_r($_SERVER);
		printf("\n_SESSION: ");
		print_r($_SESSION);
?>
        </pre><!-- END: DUMP -->
<?php		
	}
}
?>
