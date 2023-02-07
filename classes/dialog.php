<?php
/**
 * @package    CCT
 * @file       dialog.php
 * @author     Greg Parkin <parking@us.ibm.com>
 * @date       $Date:  $ GMT
 * @version    $Revision:  $
 *
 * $Log:  $
 *
 *
 * $Source:  $
 */

//
// Class autoloader - Removes the need to add include and require statements
//
use classes\library;
use classes\oracle;

if (!function_exists('__autoload'))
{
	require_once('autoloader.php');  // See: includes/autoloader.php
}

/** @class dialog
 *  @brief CLASS DESCRIPTION
 */
class dialog extends library
{
	var $data = array();        // Associated array for properties of $this->xxx
	var $ora;                   // Database connection object
	var $info = array();        // Status bar text info for sb_<dialog_name>()
	
	/** @fn __construct()
	 *  @brief Class constructor - Create oracle object and setup some dynamic class variables
	 *  @return void 
	 */
	public function __construct()
	{
		$this->ora = new oracle();
		
		// Default settings
		$this->border           = 0;
		$this->colspan          = 4;
		$this->width            = 765;
		$this->heigth           = 475;
		$this->color            = "0, 0, 0";
		$this->status_bar_color = "blue";
		$this->rgb              = "255, 237, 115";
		$this->z_index          = 20;
		
		$this->focus = "";

		if (PHP_SAPI === 'cli')
		{
			$this->user_cuid              = 'gparkin';
			$this->user_first_name        = 'Greg';
			$this->user_last_name         = 'Parkin';
			$this->user_name              = 'Greg Parkin';
			$this->user_email             = 'parking@us.ibm.com';
			$this->user_company           = 'IBM';
			$this->user_or_admin      = 'admin';
			
			$this->manager_cuid           = 'gparkin';
			$this->manager_first_name     = 'Greg';
			$this->manager_last_name      = 'Parkin';
			$this->manager_name           = 'Greg Parkin';
			$this->manager_email          = 'parking@us.ibm.com';
			$this->manager_company        = 'IBM';
		}
		else
		{			
			if (session_id() == '')
				session_start();                // Required to start once in order to retrieve user session information
			
			if (isset($_SESSION['user_cuid']))
			{
				$this->user_cuid          = $_SESSION['user_cuid'];
				$this->user_first_name    = $_SESSION['user_first_name'];
				$this->user_last_name     = $_SESSION['user_last_name'];
				$this->user_name          = $_SESSION['user_name'];
				$this->user_email         = $_SESSION['user_email'];
				$this->user_company       = $_SESSION['user_company'];	
				$this->user_or_admin      = $_SESSION['user_or_admin'];
                $this->member_can_close   = $_SESSION['member_can_close'];
				
				$this->manager_cuid       = $_SESSION['manager_cuid'];
				$this->manager_first_name = $_SESSION['manager_first_name'];
				$this->manager_last_name  = $_SESSION['manager_last_name'];
				$this->manager_name       = $_SESSION['manager_name'];
				$this->manager_email      = $_SESSION['manager_email'];
				$this->manager_company    = $_SESSION['manager_company'];		
				
				$this->is_debug_on        = $_SESSION['is_debug_on'];
			}
			else
			{
				$this->user_cuid          = 'gparkin';
				$this->user_first_name    = 'Greg';
				$this->user_last_name     = 'Parkin';
				$this->user_name          = 'Greg Parkin';
				$this->user_email         = 'parking@us.ibm.com';
				$this->user_company       = 'IBM';
				$this->user_or_admin      = 'admin';
				
				$this->manager_cuid       = 'gparkin';
				$this->manager_first_name = 'Greg';
				$this->manager_last_name  = 'Parkin';
				$this->manager_name       = 'Greg Parkin';
				$this->manager_email      = 'parking@us.ibm.com';
				$this->manager_company    = 'IBM';
				
				$this->is_debug_on        = 'N';	
			}
			
			$this->debug_start('dialog.txt');
		}
	}
	
	/** @fn __destruct()
	 *  @brief Destructor function called when no other references to this object can be found, or in any
	 *  order during the shutdown sequence. The destructor will be called even if script execution
	 *  is stopped using exit(). Calling exit() in a destructor will prevent the remaining shutdown
	 *  routines from executing.
	 *  @brief Attempting to throw an exception from a destructor (called in the time of script termination)
	 *  causes a fatal error.
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
	
	public function status_bar($i, $text)
	{
		$this->info[$i] = $text;
	}	
	
	public function foreground($color)
	{
		switch ($color)
		{
			case "red":
				$this->color = "255, 0, 0";
				break;
			case "blue":
				$this->color = "0, 0, 255";
				break;
			case "green":
				$this->color = "0, 255, 0";
				break;
			case "yellow":
				$this->color = "255, 255, 0";
				$this->status_bar_color = "cyan";
				break;
			case "purple":
				$this->color = "255, 0, 255";
				break;
			case "white":
				$this->color = "255, 255, 255";
				$this->status_bar_color = "cyan";
				break;
			default: // black
				$this->color = "0, 0, 0";
				break;
		}
	}
	
	public function background($color)
	{
		switch ($color)
		{
			case "red":
				$this->rgb = "255, 39, 11";
				break;
			case "orange":
				$this->rgb = "254, 139, 39";
				break;
			case "lime":
				$this->rgb = "216, 240, 0";
				break;
			case "turquoise":
				$this->rgb = "1, 255, 214";
				break;
			case "gray":
				$this->rgb = "221, 221, 221"; // DDDDDD - light gray
				break;
			case "tan":
				$this->rgb = "236, 233, 216"; // ECE9D8 - light tan
				break;
			case "green":
				$this->rgb = "152, 251, 152"; // 98FB98 - light green
				break;
			case "cyan":
				$this->rgb = "102, 205, 170"; // 66CDAA - light blue
				break;
			case "blue":
				$this->rgb = "66, 28, 254";
				break;
			case "purple":
				$this->rgb = "144, 3, 189";
				break;
			case "pink":
				$this->rgb = "244, 172, 186";
				break;
			default: // yellow
				$this->rgb = "255, 237, 115"; //        - yellow
				break;
		}
	}
	
	private function styles()
	{
		printf("<style type=\"text/css\">\n");
		printf("#back_%s {\n", $this->dialog_name);
		printf("position: absolute;\n");
		printf("top: 0;\n");
		printf("right: 0;\n");
		printf("bottom: 0;\n");
		printf("left: 0;\n");
		printf("margin: auto;\n");
		printf("margin-top: 0px;\n");
		printf("width: %dpx;\n", $this->width);
		printf("height: %dpx;\n", $this->height);
		printf("z-index: %d;\n", $this->z_index);
		printf("visibility: hidden;\n");
		printf("}\n");
		
		printf("#front_%s {\n", $this->dialog_name);
		printf("position: absolute;\n");
		printf("top: 0;\n");
		printf("right: 0;\n");
		printf("bottom: 0;\n");
		printf("left: 0;\n");
		printf("margin: 5px 5px 5px 5px;\n");
		printf("padding : 10px;\n");
		printf("width: %dpx;\n", $this->width - 10);
		printf("height: %dpx;\n", $this->height - 10);
		printf("visibility: hidden;\n");
		printf("border: 0px solid black;\n");
		printf("z-index: %d;\n", $this->z_index + 5);
		printf("}\n");

		printf("#table_%s\n", $this->dialog_name);
		printf("{ \n");
		printf("border: %s;\n", $this->border);
		printf("padding: 10px;\n");
		printf("border-radius: 10px;\n");
		printf("top: 10px;\n");
		printf("left: 10px;\n");
		printf("color: rgb(%s);\n", $this->color);
		printf("font-family: Verdana, Geneva, sans-serif;\n");
		printf("font-size: 10pt;\n");
		printf("position: absolute;\n");
		printf("opacity: 1;\n");
		printf("box-shadow: 3px 3px 10px #000000;\n");
		printf("background-color: rgb(%s);\n", $this->rgb);
		printf("}\n");
		printf("</style>\n");
	}
	
	private function scripts()
	{
		printf("<script type=\"text/javascript\">\n");
		printf("var info_%s = new Array();\n", $this->dialog_name);
		//printf("info[0]  = "Start here for New PDR/project request.";
		//printf("info[1]  = "View OPEN projects assigned to PM.";
		//printf("info[2]  = "Enter an Assigned PDR # or Project Number to VIEW ONLY.";
		//printf("info[3]  = "Open on-line help and training material.";
		
		for ($i=0; $i<count($this->info); $i++)
		{
			printf("info_%s[%d] = \"%s\";\n", $this->dialog_name, $i, $this->info[$i]);
		}

		// Select PM Dialog box
		printf("function sb_%s(what)\n", $this->dialog_name);
		printf("{\n");
		printf("	document.getElementById('sb_%s').innerHTML = '<font color=%s>' + info_%s[what] + '</font>';\n", $this->dialog_name, $this->status_bar_color, $this->dialog_name);
		printf("}\n");  
		printf("function isIE_%s()\n", $this->dialog_name);
		printf("{\n");
		printf("	var ua = window.navigator.userAgent;\n");
		printf("	var msie = ua.indexOf ( \"MSIE \" );\n"); //alert(msie);
		printf("	if ( msie > 0 && msie < 25)\n");          // If Internet Explorer, return version number (Issued fixed in IE 10)
		printf("		return true;\n");
		printf("	return false;\n");  // If another browser, return false
		printf("}\n");
		printf("function show_%s()\n", $this->dialog_name);
		printf("{\n");
		printf("	var top = document.getElementById('content').scrollTop;\n");
		printf("	if (isIE_%s() == true)\n", $this->dialog_name);
		printf("	{\n");
		printf("		var content_width = document.getElementById('content').offsetWidth / 2;\n");
		printf("		var frontlayer_width = document.getElementById('front_%s').offsetWidth / 2;\n", $this->dialog_name);
		printf("		if (content_width > frontlayer_width)\n");
		printf("		{\n");
		printf("			document.getElementById('back_%s').style.left = (content_width - frontlayer_width) - 50;\n", $this->dialog_name);
		printf("		}\n");
		printf("		else\n");
		printf("		{\n");
		printf("			document.getElementById('back_%s').style.left = 0;\n", $this->dialog_name);
		printf("		}\n");
		printf("		document.getElementById('back_%s').style.top = top + 60;\n", $this->dialog_name);
		printf("	}\n");
		printf("	else\n");
		printf("	{\n");
		printf("		var content_width = document.getElementById('content').offsetWidth / 2 + 'px';\n");
						// var content_height = document.getElementById('content').offsetHeight;
						// alert('content_width: ' + content_width + ' content_height: ' + content_height);
						// frontlayer width: 1175px;
						// frontlayer height: 515px;
		printf("		var frontlayer_width = document.getElementById('front_%s').offsetWidth / 2 + 'px';\n", $this->dialog_name);
						// var frontlayer_height = document.getElementById('frontlayer2').offsetHeight;
						// alert('frontlayer_width: (1175) ' + frontlayer_width + ' frontlayer_height: (515) ' + frontlayer_height);
		printf("		if (content_width > frontlayer_width)\n");
		printf("		{\n");
		printf("			document.getElementById('back_%s').style.left = (content_width - frontlayer_width) - 50 + 'px';\n", $this->dialog_name);
		printf("		}\n");
		printf("		else\n");
		printf("		{\n");
		printf("			document.getElementById('back_%s').style.left = 0 + 'px';\n", $this->dialog_name);
		printf("		}\n");

		printf("		document.getElementById('back_%s').style.top = top + 60 + 'px';\n", $this->dialog_name);
		printf("	}\n");
					// document.getElementById('frontlayer2').style.top = top;\n");
					// document.getElementById('bg_mask2').style.visibility='visible';
		printf("	document.getElementById('front_%s').style.visibility='visible';\n", $this->dialog_name);
					// disable_sb3 = false;  // turn on status bar text
		printf("	document.getElementById('sb_%s').innerHTML = '&nbsp;';\n", $this->dialog_name);
		
		if (strlen($this->focus) > 0)
		{
			printf("	document.getElementById('%s').focus();\n", $this->focus);
		}
		
		printf("}\n");

		printf("function hide_%s()\n", $this->dialog_name);
		printf("{\n");
		printf("	document.getElementById('back_%s').style.visibility='hidden';\n", $this->dialog_name);
		printf("	document.getElementById('front_%s').style.visibility='hidden';\n", $this->dialog_name);
		printf("}\n");
		printf("</script>\n");		
	}
	
	public function begin_table()
	{
		$this->styles();
		$this->scripts();
		
		printf("<div id=\"back_%s\" align=\"center\" class=\"ui-widget-content\">\n", $this->dialog_name);
		printf("<div id=\"front_%s\" align=\"center\">\n", $this->dialog_name);
		printf("<table id=\"table_%s\">\n", $this->dialog_name);
	}
	
	public function end_table()
	{
		printf("<tr>\n");
		printf("    <td align=\"left\" valign=\"top\" colspan=\"%d\">\n", $this->colspan);
		printf("        <div id=\"%s_status_bar\">\n", $this->dialog_name);
		printf("            <span id=\"sb_%s\"><center><font color=blue size=\"+2\"></font></center></span>\n", $this->dialog_name);
		printf("        </div>\n");
		printf("    </td>\n");
		printf("</tr>\n"); 
		printf("</table>\n");	
		printf("</div>\n");	
		printf("</div>\n");	
	}
		
}
?>
