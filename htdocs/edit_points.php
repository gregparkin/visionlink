<?php
/**
 * @package   VisionLink
 * @file      edit_points.php
 * @author    Greg Parkin
 */

require_once __DIR__ . '/autoload.php';

if (session_id() == '')
    session_start();

ini_set('display_errors', 'Off');

$tz                   = 'America/Denver';

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

//
// NOTE: It is very important that you do not turn on debugging without writing to a file for server side AJAX code. Any HTML
//       comments coming from functions while writing JSON will show up in the JSON output and you will get a parsing error
//       in the client side program.
//
$lib = new library();        // classes/library.php
$lib->debug_start('edit_points.txt');
date_default_timezone_set('America/Denver');

if (!$pg = new postgres("visionlink"))
{
    printf("<h1>Unable to connect to database: visionlink</h1>\n");
    printf("<p>%s</p>", $pg->getLastError);
    $lib->debug1(__FILE__, __LINE__, "Cannot connect to visionlink: %s", $pg->getLastError());
    exit();
}

$id     = '';  // point.id
$name   = '';  // point.name
$x      = '';  // point.x
$y      = '';  // point.y

$input       = array();
$input_count = 0;

// Parse QUERY_STRING if it exists
if (isset($_SERVER['QUERY_STRING']))
{
    parse_str($_SERVER['QUERY_STRING'], $input);  // Parses URL parameter options into an array called $my_request
    $input_count = count($input);                        // Get the count of the number of $my_request array elements.

    if (isset($input['id']))
    {
        $id = $input['id'];
        $lib->debug1(__FILE__, __LINE__, "Param: id = %s", $id);
    }

    if (isset($input['name']))
    {
        $name = $input['name'];
        $lib->debug1(__FILE__, __LINE__, "Param: name = %s", $name);
    }

    if (isset($input['x']))
    {
        $x = $input['x'];
        $lib->debug1(__FILE__, __LINE__, "Param: x = %s", $x);
    }

    if (isset($input['y']))
    {
        $y = $input['y'];
        $lib->debug1(__FILE__, __LINE__, "Param: y = %s", $y);
    }
}

// Read-only stream allows you to read raw data from the request body.
$json = json_decode(file_get_contents("php://input"));


if (isset($json->{'action'}))
    $action = $json->{'action'};  // This will be: get, all, insert, update, delete

if (isset($json->{'id'}))
    $id = $json->{'id'};

if (isset($json->{'name'}))
    $name = $json->{'name'};

if (isset($json->{'x'}))
    $x = $json->{'x'};

if (isset($json->{'y'}))
    $y = $json->{'y'};

$lib->debug_r1(__FILE__, __LINE__, $_REQUEST, "_REQUEST");

// If w2ui.grid uses a grid delete function then it puts the information in
// an array called: $_REQUEST['request'] where request is another array to the info
// we need below.
if (array_key_exists('request', $_REQUEST))
{
    $lib->debug1(__FILE__, __LINE__, "request: %s", $_REQUEST['request']);

    $request = json_decode($_REQUEST['request']);

    if (isset($request->id))
        $id = $request->id;

    if (isset($request->name))
        $name = $request->name;

    if (isset($request->x))
        $x = $request->x;

    if (isset($request->y))
        $y = $request->y;

    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: id     = %d", $id);
    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: name   = %s", $name);
    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: x      = %d", $x);
    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: y      = %d", $y);
}

// Save record plugs the data directory in $_REQUEST[...]
if (isset($_REQUEST['action']))
    $action = $_REQUEST['action'];

if (isset($_REQUEST['id']))
    $id = $_REQUEST['id'];

if (isset($_REQUEST['name']))
    $name = $_REQUEST['name'];

if (isset($_REQUEST['x']))
    $x = $_REQUEST['x'];

if (isset($_REQUEST['y']))
    $y = $_REQUEST['y'];

$lib->debug_r1(__FILE__, __LINE__, $json, "json");
$lib->debug_r1(__FILE__, __LINE__, $_POST, "_POST");
$lib->debug_r1(__FILE__, __LINE__, $_GET, "_GET");
$lib->debug_r1(__FILE__, __LINE__, $_REQUEST, "_REQUEST");
$lib->debug_r1(__FILE__, __LINE__, $_SERVER, "_SERVER");
$lib->debug_r1(__FILE__, __LINE__, $_SESSION, "_SESSION");

$lib->debug1(__FILE__, __LINE__, "FINAL: id = %d",     $id);
$lib->debug1(__FILE__, __LINE__, "FINAL: name = %s",   $name);
$lib->debug1(__FILE__, __LINE__, "FINAL: x = %d",      $x);
$lib->debug1(__FILE__, __LINE__, "FINAL: y = %d",      $y);


function calculateDistance($x1, $y1, $x2, $y2)
{
    // Return the distance between two sets of points
    return sqrt( ($x2 - $x1) * ($x2 - $x1) + ($y2 - $y1) * ($y2 - $y1) );
}

function newPrecision($n, $i)
{
    return floor( pow(10, $i) * $n) / pow(10, $i);
}


$lib->debug1(__FILE__, __LINE__, "In getDistances() method");
$row = array();

if (!$pg->sql("select * from point order by name"))
{
    printf("<h1>SQL Error: %d</h1>\n", $pg->getLastError());
    $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
    $pg->logoff();
    exit();
}

$nearest  = 0.;
$farthest = 0.;
$top = $p = null;
$row_count = 0;
while ($pg->fetch())
{
    $row_count++;
    // $x and $y are values we are editing.
    $distance  = newPrecision(calculateDistance($x, $y, $pg->x, $pg->y), 1);
    $no_rounding = calculateDistance($x, $y, $pg->x, $pg->y);

    $lib->debug1(__FILE__, __LINE__, "calculateDistance(%f, %f, %f, %f) = %f",
        $x, $y, $pg->x, $pg->y, calculateDistance($x, $y, $pg->x, $pg->y));
    $lib->debug1(__FILE__, __LINE__, "newPrecision(calculateDistance(%f, %f, %f, %f), 1) = %f",
        $x, $y, $pg->x, $pg->y, newPrecision(calculateDistance($x, $y, $pg->x, $pg->y), 1));

    if ($top === null)
    {
        $top = new data_node();
        $p = $top;
    }
    else
    {
        $p->next = new data_node();
        $p = $p->next;
    }

    $p->distance    = $distance;
    $p->no_rounding = $no_rounding;
    $p->id          = $pg->id;
    $p->name        = $pg->name;
    $p->x           = $pg->x;
    $p->y           = $pg->y;

    if ($nearest == 0)
        $nearest = $no_rounding;

    if ($farthest == 0)
        $farthest = $no_rounding;

    if ($no_rounding != 0 && $no_rounding < $nearest)
        $nearest = $no_rounding;

    if ($no_rounding != 0 && $no_rounding > $farthest)
        $farthest = $no_rounding;

    $lib->debug1(__FILE__, __LINE__, "farthest: %.1f  nearest: %.1f", $farthest, $nearest);

//    for ($p=$top; $p!=null; $p=$p->next)
//    {
//        $lib->debug1(__FILE__, __LINE__, "distance: %.2f, id: %d, name: %s, x: %d, y: %d",
//            $p->distance, $p->id, $p->name, $p->x, $p->y);
//    }

}

$lib->debug1(__FILE__, __LINE__, "row_count = %d", $row_count);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Vision Link</title>
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script>
        function cancel()
        {
            location.href='/';
        }

        function saveData()
        {
            let id = document.getElementById("id").value;
            let name = document.getElementById("name").value;
            let x = document.getElementById("x").value;
            let y = document.getElementById("y").value;

            if (id.length == 0)
            {
                alert('ID cannot be changed and cannot be empty');
                return;
            }

            if (name.length == 0)
            {
                alert('Name cannot be an empty string');
                return;
            }

            if (x.length == 0)
            {
                alert('X cannot be empty');
                return;
            }

            if (y.length == 0)
            {
                alert('Y cannot be empty');
                return;
            }

            $.ajax({
                url: 'ajax_server.php',
                data: {
                    action: 'update',
                    id: id,
                    name: name,
                    x: x,
                    y: y
                },
                dataType: "json",
                success: function (data) {
                    console.log(data);
                },
                error: function (error) {
                    console.log(`Error ${error}`);
                }
            });

            location.href='/';
        }
    </script>
</head>
<body>
    <center><h1>Edit Record</h1>
        <div id="form" style="width: 200px">
            <div class="w2ui-page page-0">
                <div class="w2ui-column-container">
                    <div class="w2ui-column col-0">
                        <div class="w2ui-field w2ui-span6">
                            <label>ID</label>
                            <div><input id="id" name="id" class="w2ui-input" style="width: 100px" type="text" value="<?php echo $id ?>" disabled></div>
                        </div>
                        <div class="w2ui-field w2ui-span6">
                            <label>Name</label>
                            <div><input id="name" name="name" class="w2ui-input" style="width: 100px" type="text" tabindex="1" value="<?php echo $name ?>"></div>
                        </div>
                        <div class="w2ui-field w2ui-span6">
                            <label>X</label>
                            <div><input id="x" name="x" class="w2ui-input" style="width: 100px" type="text" tabindex="2" value="<?php echo $x ?>"></div>
                        </div>
                        <div class="w2ui-field w2ui-span6">
                            <label>Y</label>
                            <div><input id="y" name="y" class="w2ui-input" style="width: 100px" type="text" tabindex="3" value="<?php echo $y ?>"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w2ui-buttons" style="align-content: center">
                <button name="save" class="w2ui-btn w2ui-btn-blue" onclick="saveData()" tabindex="4">Save</button>
                <button name="cancel" class="w2ui-btn " onclick="cancel()" tabindex="5">Cancel</button>
            </div>
        </div>
        <br>
        <table>
            <tr>
                <td colspan="4"><b>Nearest points at distance <?php printf("%.1f", $nearest); ?>:</b></td>
            </tr>
            <tr>
                <td style="width:10%" align="center">ID</td>
                <td style="width:10%" align="center">Name</td>
                <td style="width:10%" align="center">X</td>
                <td style="width:10%" align="center">Y</td>
                <td style="width:10%" align="center">Distance</td>
                <td style="width:10%" align="right">No Rounding</td>
            </tr>
            <?php
            for ($p=$top; $p!=NULL; $p=$p->next)
            {
                if ($p->no_rounding != $nearest)
                    continue;

                printf("<tr>\n");
                printf("<td><center>%d</center></td>", $p->id);
                printf("<td><center>%s</center></td>", $p->name);
                printf("<td><center>%d</center></td>", $p->x);
                printf("<td><center>%d</center></td>", $p->y);
                printf("<td><center>%.1f</center></td>", $p->distance);
                printf("<td align='right'>%f</td>", $p->no_rounding);
                printf("</tr>\n");
            }
            ?>
        </table>
        <br>
        <table>
            <tr>
                <td colspan="4"><b>Farthest points at distance <?php printf("%.1f", $farthest); ?>:</b></td>
            </tr>
            <tr>
                <td style="width:10%" align="center">ID</td>
                <td style="width:10%" align="center">Name</td>
                <td style="width:10%" align="center">X</td>
                <td style="width:10%" align="center">Y</td>
                <td style="width:10%" align="center">Distance</td>
                <td style="width:10%" align="right">No Rounding</td>
            </tr>
            <?php
            for ($p=$top; $p!=NULL; $p=$p->next)
            {
                if ($p->no_rounding != $farthest)
                    continue;

                printf("<tr>\n");
                printf("<td><center>%d</center></td>", $p->id);
                printf("<td><center>%s</center></td>", $p->name);
                printf("<td><center>%d</center></td>", $p->x);
                printf("<td><center>%d</center></td>", $p->y);
                printf("<td><center>%.1f</center></td>", $p->distance);
                printf("<td align='right'>%f</td>", $p->no_rounding);
                printf("</tr>\n");
            }
            ?>
        </table>
        <br>
        <table>
            <tr>
                <td colspan="4"><b>TESTING:</b></td>
            </tr>
            <tr>
                <td style="width:10%" align="center">ID</td>
                <td style="width:10%" align="center">Name</td>
                <td style="width:10%" align="center">X</td>
                <td style="width:10%" align="center">Y</td>
                <td style="width:10%" align="center">Distance</td>
                <td style="width:10%" align="right">No Rounding</td>
            </tr>
            <?php
            for ($p=$top; $p!=NULL; $p=$p->next)
            {
                printf("<tr>\n");
                printf("<td><center>%d</center></td>", $p->id);
                printf("<td><center>%s</center></td>", $p->name);
                printf("<td><center>%d</center></td>", $p->x);
                printf("<td><center>%d</center></td>", $p->y);
                printf("<td><center>%.1f</center></td>", $p->distance);
                printf("<td align='right'>%f</td>", $p->no_rounding);
                printf("</tr>\n");
            }
            ?>
        </table>
    </center>
</body>
</html>