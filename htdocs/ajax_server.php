<?php
/**
 * @package   VisionLink
 * @file      server.php
 * @author    Greg Parkin
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
$lib->debug_start('ajax_server.html');
date_default_timezone_set('America/Denver');

if (!$pg = new postgres("visionlink"))
{
    printf("{\n");
    printf("\"status\":    \"FAILED\",\n");
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

$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $my_request);

// Read-only stream allows you to read raw data from the request body.
$json = json_decode(file_get_contents("php://input"));
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $json);

// Data can be sent on the URL with options.
$action = (array_key_exists('action', $my_request)) ? $my_request['action'] : '';  // get, all, insert, update, delete
$id     = (array_key_exists('id', $my_request)) ? $my_request['id'] : '';          // point.id
$name   = (array_key_exists('name', $my_request)) ? $my_request['name'] : '';      // point.name
$x      = (array_key_exists('x', $my_request)) ? $my_request['x'] : '';            // point.x
$y      = (array_key_exists('y', $my_request)) ? $my_request['y'] : '';            // point.y

// See if the data came in the body as a JSON array.
if (isset($json->action))
    $action = $json->action;  // This will be: get, all, insert, update, delete

if (isset($json->id))
    $id = $json->id;

if (isset($json->name))
    $name = $json->name;

if (isset($json->x))
    $x = $json->x;

if (isset($json->y))
    $y = $json->y;

$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "action = %s", $action);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "id = %d",     $id);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "name = %s",   $name);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "x = %d",      $x);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "y = %d",      $y);

$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "json: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $json);
$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "_POST: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_POST);
$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "_GET: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_GET);
$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "_REQUEST: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_REQUEST);
$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "_SERVER: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_SERVER);
$lib->debug1(  __FILE__, __FUNCTION__, __LINE__, "_SESSION: ");
$lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $_SESSION);

// get, select, insert, update, delete
// if ($action == "get")      // Retrieve record from the "point" table

/**
 * @brief  select all rows from the point table ordered by name.
 * @return void
 */
function allRecords()
{
    global $lib, $pg;

    $row = array();

    $sql = sprintf("select * from point order by name");
    $params = array();
    $lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $params);

    if (!$pg->sql($sql, $params))
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();
        exit();
    }

    printf("{\n");
    printf("\"status\":  \"SUCCESS\",\n");
    printf("\"message\": \"Sending all records in point table.\",\n");
    printf("\"rows\": [\n");
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
        $lib->debug1(__FILE__, __FUNCTION__, __LINE__, "SENDING: %s", json_encode($row));
    }

    printf("]}\n");  // Close out the data stream
    $pg->logoff();

    exit();
}

/**
 * @brief Get one row of data selected by $id
 * @param $id
 * @return void
 */
function getRecord($id)
{
    global $lib, $pg;

    //$sql = sprintf("select * from point where id = id", $id);
    $sql = "select * from point where id = $1";
    $lib->debug_sql1(__FILE__, __FUNCTION__, __LINE__, $sql);
    $params = array($id);
    $lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $params);

    if (!$pg->sql($sql, $params))
    {
        printf("{\n");
        printf("\"status\":  \"FAILED\",\n");
        printf("\"message\": \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    if (!$pg->fetch())
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record id=%d NOT FOUND: %s\"\n", $id, $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    printf("{\n");
    printf("\"status\":  \"SUCCESS\",\n");
    printf("\"message\": \"There be a whale here Captain!\",\n");
    printf("\"rows\": [\n");  // rows is where the actual json data is kept.

    $row['id']   =  $pg->id;
    $row['name'] =  $pg->name;
    $row['x']    =  $pg->x;
    $row['y']    =  $pg->y;

    echo json_encode($row);
    $lib->debug1(__FILE__, __FUNCTION__, __LINE__, "SENDING: %s", json_encode($row));
    printf("]}\n");  // Close out the data stream

    $pg->logoff();
    exit();
}

/**
 * @brief Insert new data into point table.
 * @param $name    Not-NULL
 * @param $x       Not-NULL
 * @param $y       NOT-NULL
 * @return void
 */
function insertRecord($name, $x, $y)
{
    global $lib, $pg;

    $lib->debug_sql1(__FILE__, __FUNCTION__, __LINE__, "name=%s, x=%d, y=%d", $name, $x, $y);

    $sql = sprintf("insert into point (name, x, y) values ($1, $2, $3)");
    $lib->debug_sql1(__FILE__, __FUNCTION__, __LINE__, $sql);

    $params = array($name, $x, $y);
    $lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $params);

    if (!$pg->sql($sql, $params))
    {
        printf("{\n");
        printf("\"status\":   \"FAILED\",\n");
        printf("\"message\":  \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    allRecords();
}

/**
 * @brief Update record in point table identified by $id
 * @param $id
 * @param $name
 * @param $x
 * @param $y
 * @return void
 */
function updateRecord($id, $name, $x, $y)
{
    global $lib, $pg;

    $sql = sprintf("update point set name = $1, x = $2, y = $3 where id = $4");
    $lib->debug_sql1(__FILE__, __FUNCTION__, __LINE__, $sql);
    $params = array($name, $x, $y, $id);
    $lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $params);

    if (!$pg->sql($sql, $params))
    {
        printf("{\n");
        printf("\"status\":  \"FAILED\",\n");
        printf("\"message\": \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    allRecords();
}

/**
 * @brief Delete a record identified by $id from the point table.
 * @param $id
 * @return void
 */
function deleteRecord($id)
{
    global $lib, $pg;

    $sql = sprintf("delete from point where id = $1");
    $lib->debug_sql1(__FILE__, __FUNCTION__, __LINE__, $sql);
    $params = array($id);
    $lib->debug_r1(__FILE__, __FUNCTION__, __LINE__, $params);

    $params = array();
    $params[0] = $id;

    if (!$pg->sql($sql, $params))
    {
        printf("{\n");
        printf("\"status\":  \"FAILED\",\n");
        printf("\"message\": \"SQL Error: %s\"\n", $pg->getLastError());
        printf("}\n");
        $pg->logoff();

        exit();
    }

    allRecords();
}

switch ($action)
{
    case 'get':
        getRecord($id);
        break;
    case 'all':
        allRecords();
        break;
    case 'insert':
        insertRecord($name, $x, $y);
        break;
    case 'update':
        updateRecord($id, $name, $x, $y);
        break;
    case 'delete':
        deleteRecord($id);
        break;
    default:
        printf("{\n");
        printf("\"status\":  \"FAILED\",\n");
        printf("\"message\": \"Invalid action: %s\"\n", $action);
        printf("}\n");
        $pg->logoff();
        exit();
        break;
}
