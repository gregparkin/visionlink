<?php
use classes\library;use classes\oracle;
/**
 * @package    VisionLink
 * @file       template_class.php
 * @author     Greg Parkin <gregparkin58@gmail.com>
 *
 */

/
/** @class template_class
 *  @brief Extract email information for PHP Mail()
 */
class template_class extends library
{
    var $data = array();           // Associated array for any properties we want to create: $this->xxx
    var $ora;                      // Oracle connection handle

    /** @fn __construct()
     *  @brief Class constructor
     *  @return void
     */
    public function __construct()
    {
        $this->ora = new oracle();

        if (PHP_SAPI === 'cli')
        {
            $this->user_cuid                    = 'gparkin';
            $this->user_first_name              = 'Greg';
            $this->user_last_name               = 'Parkin';
            $this->user_name                    = 'Greg Parkin';
            $this->user_email                   = 'parking@us.ibm.com';
            $this->user_company                 = 'IBM';
            $this->user_access_level            = 'admin';

            $this->manager_cuid                 = 'gparkin';
            $this->manager_first_name           = 'Greg';
            $this->manager_last_name            = 'Parkin';
            $this->manager_name                 = 'Greg Parkin';
            $this->manager_email                = 'parking@us.ibm.com';
            $this->manager_company              = 'IBM';

            $this->is_debug_on                  = 'N';

            $this->local_timezone               = "America/Denver(MST)";
            $this->local_timezone_name          = "America/Denver";;
            $this->local_timezone_abbr          = "MST";
            $this->local_timezone_offset        = 0;

            $this->sql_zone_offset              = "(0)";
            $this->sql_zone_abbr                = "MST";

            $this->baseline_timezone            = "America/Denver(MST)";
            $this->baseline_timezone_name       = "America/Denver";
            $this->baseline_timezone_abbr       = "MST";
            $this->baseline_timezone_offset     = 0;
        }
        else
        {
            if (session_id() == '')
                session_start();                // Required to start once in order to retrieve user session information

            if (isset($_SESSION['user_cuid']))
            {
                $this->real_cuid                = $_SESSION['real_cuid'];
                $this->user_cuid                = $_SESSION['user_cuid'];
                $this->user_first_name          = $_SESSION['user_first_name'];
                $this->user_last_name           = $_SESSION['user_last_name'];
                $this->user_name                = $_SESSION['user_name'];
                $this->user_email               = $_SESSION['user_email'];
                $this->user_company             = $_SESSION['user_company'];
                $this->user_or_admin            = $_SESSION['user_or_admin']; // [user_or_admin] => admin

                $this->manager_cuid             = $_SESSION['manager_cuid'];
                $this->manager_first_name       = $_SESSION['manager_first_name'];
                $this->manager_last_name        = $_SESSION['manager_last_name'];
                $this->manager_name             = $_SESSION['manager_name'];
                $this->manager_email            = $_SESSION['manager_email'];
                $this->manager_company          = $_SESSION['manager_company'];

                $this->is_debug_on              = $_SESSION['is_debug_on'];

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
            }
            else
            {
                $this->real_cuid                = 'gparkin';
                $this->user_cuid                = 'gparkin';
                $this->user_first_name          = 'Greg';
                $this->user_last_name           = 'Parkin';
                $this->user_name                = 'Greg Parkin';
                $this->user_email               = 'parking@us.ibm.com';
                $this->user_company             = 'IBM';
                $this->user_or_admin            = 'admin';

                $this->manager_cuid             = 'gparkin';
                $this->manager_first_name       = 'Greg';
                $this->manager_last_name        = 'Parkin';
                $this->manager_name             = 'Greg Parkin';
                $this->manager_email            = 'parking@us.ibm.com';
                $this->manager_company          = 'IBM';

                $this->is_debug_on              = 'N';

                $this->local_timezone           = "America/Denver(MST)";
                $this->local_timezone_name      = "America/Denver";;
                $this->local_timezone_abbr      = "MST";
                $this->local_timezone_offset    = 0;

                $this->sql_zone_offset          = "(0)";
                $this->sql_zone_abbr            = "MST";

                $this->baseline_timezone        = "America/Denver(MST)";
                $this->baseline_timezone_name   = "America/Denver";
                $this->baseline_timezone_abbr   = "MST";
                $this->baseline_timezone_offset = 0;
            }

            $this->debug_start('template_class.txt');
        }


    }

    /** @fn __destruct()
     *  @brief Destructor function called when no other references to this object can be found, or in any
     *  order during the shutdown sequence. The destructor will be called even if script execution
     *  is stopped using exit(). Calling exit() in a destructor will prevent the remaining shutdown
     *  routines from executing.
     *  @brief Attempting to throw an exception from a destructor(called in the time of script termination)
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
     *  @brief Determine if item($name) exists in the $this->data array
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
}
?>
