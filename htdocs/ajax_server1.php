<?php
/**
 * @package   VisionLink
 * @file      server.php
 * @author    Greg Parkin
 */

/**
 * allRecords()    - Done!
 * getRecord()
 * insertRecord()
 * deleteRecord()  - Done!
 */
require_once __DIR__ . '/autoload.php';

if (session_id() == '')
    session_start();

ini_set('display_errors', 'Off');

$tz                   = 'America/Denver';
$where_clause         = '';
$search_where_clause  = '';  // Constructed from $filter
$this_operation_group = '';
$this_operation_code  = '';
$this_field_name      = '';
$this_field_type      = '';

// Prevent caching.
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 01 Jan 1996 00:00:00 GMT');

// The JSON standard MIME header.
header('Content-type: application/json');

//
// NOTE: It is very important that you do not turn on debugging without writing to a file for server side AJAX code. Any HTML
//       comments coming from functions while writing JSON will show up in the JSON output and you will get a parsing error
//       in the client side program.
//
$lib = new library();        // classes/library.php
$lib->debug_start('ajax_server.txt');
date_default_timezone_set('America/Denver');

if (!$pg = new postgres("visionlink"))
{
    $lib->debug1(__FILE__, __LINE__, "Cannot connect to visionlink: %s", $pg->getLastError());
    printf("{\n");
    printf("\"status\":    \"error\",\n");
    printf("\"message\":   \"Cannot connect to visionlink: %s\"\n", $pg->getLastError());
    printf("}\n");
    exit();
}

$my_request  = array();
$input       = array();
$input_count = 0;

// Parse QUERY_STRING if it exists
if (isset($_SERVER['QUERY_STRING']))
{
    parse_str($_SERVER['QUERY_STRING'], $my_request);  // Parses URL parameter options into an array called $my_request
    $input_count = count($my_request);                        // Get the count of the number of $my_request array elements.
}

// Read-only stream allows you to read raw data from the request body.
$json = json_decode(file_get_contents("php://input"));

$action = 'all';  // get, all, insert, update, delete
$id     = '';  // point.id
$name   = '';  // point.name
$x      = '';  // point.x
$y      = '';  // point.y
$limit  = 100;
$offset = 0;

if (isset($json->{'action'}))
    $action          = $json->{'action'};  // This will be: get, all, insert, update, delete

if (isset($json->{'id'}))
    $id       = $json->{'id'};

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

    if (isset($request->action))
        $action = $request->action;

    if (isset($request->limit))
        $limit = $request->limit;

    if (isset($request->offset))
        $offset = $request->offset;

    if (isset($request->id))
        $id = $request->id;

    if (isset($request->name))
        $name = $request->name;

    if (isset($request->x))
        $x = $request->x;

    if (isset($request->y))
        $y = $request->y;

    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: action = %s", $action);
    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: limit  = %d", $limit);
    $lib->debug1(  __FILE__, __LINE__, "_REQUEST: offset = %d", $offset);
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

$lib->debug1(__FILE__, __LINE__, "FINAL: action = %s", $action);
$lib->debug1(__FILE__, __LINE__, "FINAL: limit = %d",  $limit);
$lib->debug1(__FILE__, __LINE__, "FINAL: offset = %d", $offset);
$lib->debug1(__FILE__, __LINE__, "FINAL: id = %d",     $id);
$lib->debug1(__FILE__, __LINE__, "FINAL: name = %s",   $name);
$lib->debug1(__FILE__, __LINE__, "FINAL: x = %d",      $x);
$lib->debug1(__FILE__, __LINE__, "FINAL: y = %d",      $y);

switch ($action)
{
    case 'distance':
        getDistances();
        break;
        break;
    case 'all':
        allRecords();
        break;
    case 'update':
        $lib->debug1(__FILE__, __LINE__, "update: action = %s", $action);
        $lib->debug1(__FILE__, __LINE__, "update: limit = %d",  $limit);
        $lib->debug1(__FILE__, __LINE__, "update: offset = %d", $offset);
        $lib->debug1(__FILE__, __LINE__, "update: id = %d",     $id);
        $lib->debug1(__FILE__, __LINE__, "update: name = %s",   $name);
        $lib->debug1(__FILE__, __LINE__, "update: x = %d",      $x);
        $lib->debug1(__FILE__, __LINE__, "update: y = %d",      $y);
        updateRecord();
        break;
    case 'insert':
        $lib->debug1(__FILE__, __LINE__, "insert: action = %s", $action);
        $lib->debug1(__FILE__, __LINE__, "insert: limit = %d",  $limit);
        $lib->debug1(__FILE__, __LINE__, "insert: offset = %d", $offset);
        $lib->debug1(__FILE__, __LINE__, "insert: id = %d",     $id);
        $lib->debug1(__FILE__, __LINE__, "insert: name = %s",   $name);
        $lib->debug1(__FILE__, __LINE__, "insert: x = %d",      $x);
        $lib->debug1(__FILE__, __LINE__, "insert: y = %d",      $y);
        insertRecord();
        break;
    case 'delete':
        deleteRecord();
        break;
    default:
        $lib->debug1(__FILE__, __LINE__, "Invalid action: (%s)", $action);
        printf("{\n");
        printf("\"status\":     \"error\",\n");
        printf("\"message\":    \"Invalid action: %s\"\n", $action);
        printf("}\n");
        $pg->logoff();
        break;
}

function calculateDistance($x1, $y1, $x2, $y2)
{
    // Return the distance between two sets of points
    return sqrt( ($x2 - $x1) * ($x2 - $x1) + ($y2 - $y1) * ($y2 - $y1) );
}

function newPrecision($n, $i)
{
    return floor( pow(10, $i) * $n) / pow(10, $i);
}

function getDistances()
{
    global $lib, $pg, $x, $y;

    $lib->debug1(__FILE__, __LINE__, "In getDistances() method");
    $row = array();

    if (!$pg->sql("select * from point order by name"))
    {
        $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();
        exit();
    }

    printf("{\n");
    printf("\"status\":  \"success\",\n");
    printf("\"message\": \"Sending all nearest point records where 1.4 in point table.\",\n");
    printf("\"records\": [\n");

    $count_records = 0;

    while ($pg->fetch())
    {
        // $x and $y are values we are editing.
        $distance  = newPrecision(calculateDistance($x, $y, $pg->x, $pg->y), 1);

        $lib->debug1(__FILE__, __LINE__, "calculateDistance(%f, %f, %f, %f) = %f",
            $x, $y, $pg->x, $pg->y, calculateDistance($x, $y, $pg->x, $pg->y));
        $lib->debug1(__FILE__, __LINE__, "newPrecision(calculateDistance(%f, %f, %f, %f), 1) = %f",
            $x, $y, $pg->x, $pg->y, newPrecision(calculateDistance($x, $y, $pg->x, $pg->y), 1));

        if ($distance != 1.4 && $distance != 2.2)
        {
            continue;    // Not interested in sending this record
        }

        if ($count_records > 0)
            printf(",\n");  // Let the client know we have more records to send

        $count_records++;

        $row['id']   =  $pg->id;
        $row['name'] =  $pg->name;
        $row['x']    =  $pg->x;
        $row['y']    =  $pg->y;
        $row['distance'] = $distance;  // This will be 1.4 or 2.2

        echo json_encode($row);
        $lib->debug1(__FILE__, __LINE__, "SENDING: %s", json_encode($row));
    }

    printf("\n]\n}\n");
    $lib->debug1(__FILE__, __LINE__, "Exiting allRecords() function");
    $pg->logoff();

    exit();
}

/**
 * @brief  select all rows from the point table ordered by name.
 * @return void
 *
 * WORKING!
 *
 */
function allRecords()
{
    global $lib, $pg;

    $lib->debug1(__FILE__, __LINE__, "In allRecords() method");
    $row = array();

    if (!$pg->sql("select * from point order by name"))
    {
        $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();
        exit();
    }

    printf("{\n");
    printf("\"status\":  \"success\",\n");
    printf("\"message\": \"Sending all records in point table.\",\n");
    printf("\"records\": [\n");

    $count_records = 0;

    while ($pg->fetch())
    {
        if ($count_records > 0)
            printf(",\n");  // Let the client know we have more records to send

        $count_records++;

        $row['id']   =  $pg->id;
        $row['name'] =  $pg->name;
        $row['x']    =  $pg->x;
        $row['y']    =  $pg->y;

        echo json_encode($row);
        $lib->debug1(__FILE__, __LINE__, "SENDING: %s", json_encode($row));
    }

    printf("\n]\n}\n");
    $lib->debug1(__FILE__, __LINE__, "Exiting allRecords() function");
    $pg->logoff();

    exit();
}

/**
 * @brief Get one row of data selected by $id
 * @return void
 */
function getRecord()
{
    global $lib, $pg, $id;

    $lib->debug1(__FILE__, __LINE__, "In getRecord(%d) method", $id);

    if (!$pg->sql("select * from point where id = %d", $id))
    {
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    if (!$pg->fetch())
    {
        $lib->debug1(__FILE__, __LINE__, "Redord id=%d NOT FOUND: %s", $id, $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"Record id=%d NOT FOUND: %s\"\n", $id, $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    printf("{\n");
    printf("\"status\":  \"SUCCESS\",\n");
    printf("\"message\": \"There be a whale here Captain!\",\n");
    printf("\"rows\": [\n");  // rows is where the actual json data is kept.
    printf("\"id\":      \"%d\",\n", $pg->id);
    printf("\"name\":    \"%s\",\n", $pg->name);
    printf("\"x\":       \"%d\",\n", $pg->x);
    printf("\"y\":       \"%d\"\n",  $pg->y);
    printf("]}\n");  // Close out the data stream

    $pg->logoff();
    exit();
}

/**
 * @brief Insert new data into point table.
 * @return void
 *
 * WORKING!
 *
 */
function insertRecord()
{
    global $lib, $pg, $name, $x, $y;

    $lib->debug1(__FILE__, __LINE__, "insertRecord: name = %s",   $name);
    $lib->debug1(__FILE__, __LINE__, "insertRecord: x = %d",      $x);
    $lib->debug1(__FILE__, __LINE__, "insertRecord: y = %d",      $y);

    if (!isset($name))
        $lib->debug1(__FILE__, __LINE__, "name is not set");

    if (!isset($x))
        $lib->debug1(__FILE__, __LINE__, "x is not set");

    if (!isset($y))
        $lib->debug1(__FILE__, __LINE__, "y is not set");

    $lib->debug2(__FILE__, __LINE__, "bookmark");

    $format = 'insert into point (name, x, y) values (\'%s\', %d, %d)';
    $insert = sprintf($format, $name, $x, $y);

    $lib->debug2(__FILE__, __LINE__, "bookmark");

    if (!$pg->sql($insert))
    {
        $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();
        exit();
    }

    $lib->debug2(__FILE__, __LINE__, "bookmark");
    printf("{\n");
    printf("\"status\":                         \"success\",\n");
    printf("\"message\":                        \"Record successfully inserted!\"\n");
    printf("}\n");
    $pg->logoff();
}

/**
 * @brief Update record in point table identified by $id
 * @return void
 *
 * WORKING!
 *
 */
function updateRecord()
{
    global $lib, $pg, $id, $name, $x, $y;

    $lib->debug1(__FILE__, __LINE__, "updateRecord: id = %d", $id);
    $lib->debug1(__FILE__, __LINE__, "updateRecord: name = %s",   $name);
    $lib->debug1(__FILE__, __LINE__, "updateRecord: x = %d",      $x);
    $lib->debug1(__FILE__, __LINE__, "updateRecord: y = %d",      $y);

    if (!isset($id))
        $lib->debug1(__FILE__, __LINE__, "id is not set");
    
    if (!isset($name))
        $lib->debug1(__FILE__, __LINE__, "name is not set");

    if (!isset($x))
        $lib->debug1(__FILE__, __LINE__, "x is not set");

    if (!isset($y))
        $lib->debug1(__FILE__, __LINE__, "y is not set");

    $format = 'update point set name = \'%s\', x = %d, y = %d where id = %d';
    $update = sprintf($format, $name, $x, $y, $id);

    if (!$pg->sql($update))
    {
        $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    printf("{\n");
    printf("\"status\":                         \"success\",\n");
    printf("\"message\":                        \"Record successfully updated!\"\n");
    printf("}\n");
    $pg->logoff();
}

/**
 * @brief Delete a record identified by $id from the point table.
 * @return void
 */
function deleteRecord()
{
    global $lib, $pg, $id;

    $lib->debug1(__FILE__, __LINE__, "In deleteRecord(%d) method", $id);

    if (!$pg->sql("delete from point where id = %d", $id))
    {
        $lib->debug1(__FILE__, __LINE__, "SQL Error: %s", $pg->getLastError());
        printf("{\n");
        printf("\"status\":                         \"error\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    allRecords();
}

$lib->debug1(__FILE__, __LINE__, "Ready process action: %s\n", $action);

