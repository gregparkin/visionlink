<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The jQuery library is a prerequisite for all jqSuite products -->
    <script type="text/ecmascript" src="/js/jquery.js"></script>

    <!-- A link to a jQuery UI ThemeRoller theme, more than 22 built-in and many more custom -->
    <link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui.css" />

    <meta charset="utf-8" />
    <title>VisionLink</title>
    <base href="visionlink.test">
</head>
<body>

<?php
set_include_path("/Users/gregparkin/www/visionlink.test/htdocs/classes");
function class_autoloader($class)
{
    include_once 'classes/' . $class . '.php';
}

spl_autoload_register('class_autoloader');

//
// Required to start once in order to retrieve user session information
//
if (session_id() == '')
    session_start();

if (isset($_SESSION['user_cuid']) && $_SESSION['user_cuid'] == 'gparkin')
{
    ini_set('xdebug.collect_vars',    '5');
    ini_set('xdebug.collect_vars',    'on');
    ini_set('xdebug.collect_params',  '4');
    ini_set('xdebug.dump_globals',    'on');
    ini_set('xdebug.dump.SERVER',     'REQUEST_URI');
    ini_set('xdebug.show_local_vars', 'on');

    //$path = '/usr/lib/pear';
    //set_include_path(get_include_path() . PATH_SEPARATOR . $path);
}
else
{
    ini_set('display_errors', 'Off');
}

header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>VisionLink</title>
    <base href="visionlink.test">
</head>

<body>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#example').DataTable({
                ajax: 'http://visionlink.test/input.json',
            });
        });
    </script>

    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>Name</th>
                <th>Position</th>
                <th>Office</th>
                <th>Extn.</th>
                <th>Start date</th>
                <th>Salary</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>