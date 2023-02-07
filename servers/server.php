<?php
/**
 * @package   VisionLink
 * @file      server.php
 * @author    Greg Parkin
 */

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

$user_groups = '';
$list = explode(',', $_SESSION['user_groups']);

foreach ($list as $group_name)
{
    if (strlen($user_groups) == 0)
    {
        $user_groups = sprintf("IN ('%s'", $group_name);
    }
    else
    {
        $user_groups .= sprintf(",'%s'", $group_name);
    }
}

if (strlen($user_groups) > 0)
    $user_groups .= ")";

/**
 * @fn     fieldType($field_name)
 * @brief  Returns the Postgres data type for the table "point" field names
 * @param  string $field_name
 * @return string Data type
 */
function fieldType($field_name)
{
    switch ($field_name)
    {
        case 'system_insert_date':
        case 'system_update_date':
        case 'system_respond_by_date':
        case 'system_work_start_date':
        case 'respond_by_date':
        case 'system_work_end_date':
            return "date";
        case 'system_id':
        case 'system_lastid':
        case 'total_contacts_responded':
        case 'total_contacts_not_responded':
            return "number";
        default:
            return "string";
    }

    return "string";
}

/**
 * @fn    prepareWhereClause($key, $str)
 * @brief Prepare the $search_where_clause where
 * @param string $key
 * @param string $str
 */
function prepareWhereClause($key, $str)
{
    global $search_where_clause, $this_operation_group, $this_operation_code;
    global $this_field_name, $this_field_type, $tz;

    if ($key == "groupOp")
    {
        $this_operation_group = $str;
        return;
    }

    if ($key == "field")
    {
        $this_field_name = $str;
        $this_field_type = fieldType($str);

        if (strlen($search_where_clause) == 0)
        {
            $search_where_clause .= sprintf(" t.%s ", $str);
        }
        else
        {
            $search_where_clause .= sprintf(" %s t.%s ", $this_operation_group, $str);
        }

        return;
    }

    // Operation Codes ("op":)
    // eq = equal
    // ne = not equal
    // lt = less
    // le = less or equal
    // gt = greater
    // ge = greater or equal
    // bw = begins with
    // bn = does not begin with
    // in = is in
    // ni = is not in
    // ew = ends with
    // en = does not end with
    // cn = contains
    // nc = does not contain

    if ($key == "op")
    {
        $this_operation_code = $str;

        switch ($str)
        {
            case 'eq':  // equal
                $search_where_clause .= " = ";
                break;
            case 'ne':  // not equal
                $search_where_clause .= " != ";
                break;
            case 'lt':  // less
                $search_where_clause .= " < ";
                break;
            case 'le':  // less or equal
                $search_where_clause .= " <= ";
                break;
            case 'gt':  // greater
                $search_where_clause .= " > ";
                break;
            case 'ge':  // greater or equal
                $search_where_clause .= " >= ";
                break;
            case 'bw':  // begins with
                $search_where_clause .= " like ";
                break;
            case 'bn':  // does not begin with
                $search_where_clause .= " not like ";
                break;
            case 'in':  // is in
                $search_where_clause .= " in ";
                break;
            case 'ni':  // is not in
                $search_where_clause .= " not in ";
                break;
            case 'ew':  // ends with
                $search_where_clause .= " like ";
                break;
            case 'en':  // does not end with
                $search_where_clause .= " not like ";
                break;
            case 'cn':  // contains
                $search_where_clause .= " like ";
                break;
            case 'nc':  // does not contain
                $search_where_clause .= " not like ";
                break;
            default:
                break;
        }

        return;
    }

    if ($key == "data")
    {
        switch ($this_field_type)
        {
            case 'number':
                $search_where_clause .= sprintf(" %d ", $str);
                break;
            case 'date': // Convert Date and Time to a utime (GMT) numeric value.
                $dt = new DateTime($str, new DateTimeZone($tz));
                $dt->setTimezone(new DateTimeZone('GMT'));
                $search_where_clause .=	sprintf(" %d ", $dt->format('U'));
                break;
            default:  // string
                switch ($this_operation_code)
                {
                    case 'bw':  // begins with (like 'xxx%')
                    case 'bn':  // does not begin with (not like 'xxx%')
                        $search_where_clause .= sprintf(" '%s%%' ", $str);
                        break;
                    case 'in':  // is in (in ('xxx','xxx')
                    case 'ni':  // is not in (not in ('xxx','xxx')
                        $search_where_clause .= sprintf(" (%s) ", $str);
                        break;
                    case 'ew':  // ends with (like '%xxx')
                    case 'en':  // does not end with (not like ('%xxx')
                        $search_where_clause .= sprintf(" '%%%s' ", $str);
                        break;
                    case 'cn':  // contains (like '%xxx%')
                    case 'nc':  // does not contain (not like ('%xxx%')
                        $search_where_clause .= sprintf(" '%%%s%%' ", $str);
                        break;
                    default:
                        $search_where_clause .= sprintf(" '%s' ", $str);
                        break;
                }
                break;
        }
    }
}

/**
 * @fn    multiDimensionalArrayMap($func, $arr)
 * @brief Used to construct $search_where_clause from the $input->filter string
 * @param string $func
 * @param string $arr
 * @return array
 */
function multiDimensionalArrayMap($func, $arr)
{
    $newArr = array();

    if (!empty($arr))
    {
        foreach($arr AS $key => $value)
        {
            $newArr[$key] = (is_array($value) ? multiDimensionalArrayMap($func, $value) : $func($key, $value));
        }
    }

    return $newArr;
}

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
$lib->debug_start('server.html');
date_default_timezone_set('America/Denver');

$my_request  = array();
$input       = array();
$input_count = 0;

if (isset($_SERVER['QUERY_STRING']))   // Parse QUERY_STRING if it exists
{
    parse_str($_SERVER['QUERY_STRING'], $my_request);  // Parses URL parameter options into an array called $my_request
    $input_count = count($my_request);                        // Get the count of the number of $my_request array elements.
}

// Read-only stream allows you to read raw data from the request body.
$json = json_decode(file_get_contents("php://input"));

$action = '';  // get, put, delete
$id     = '';
$name   = '';
$x      = '';
$j      = '';

if (isset($json->{'action'}))
    $action          = $json->{'action'};

if (isset($json->{'id'}))
    $id       = $json->{'id'};

if (isset($json->{'name'}))
    $name = $json->{'name'};

if (isset($json->{'x'}))
    $x = $json->{'x'};

if (isset($json->{'y'}))
    $y = $json->{'y'};

$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "action = %s", $action);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "id = %s",     $id);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "name = %s",   $name);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "x = %s",      $x);
$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "y = %s",      $y);

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

function allRecords($dbconn)
{
    global $lib;

    $row = array();

    $sql = sprintf("select * from point order by name");
    $result = pg_query($dbconn, $sql);
    $record = pg_fetch_row($result);

    if (!$record)
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record id not found in point table\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
    }

    printf("{\n");
    printf("\"status\":  \"SUCCESS\",\n");
    printf("\"message\": \"There be whales here Captain!\",\n");
    printf("\"rows\": [\n");
    $count_records = 0;

    do
    {
        if ($count_records > 0)
        {
            printf(",\n");  // the client know we have more records to send
        }

        $count_records++;

        $row['id']   =  $record[0];
        $row['name'] =  $record[1];
        $row['x']    =  $record[2];
        $row['y']    =  $record[3];

        echo json_encode($row);
        $lib->debug1(__FILE__, __FUNCTION__, __LINE__, "SENDING: %s", json_encode($row));

    } while ($row = pg_fetch_row($result));

    printf("]}\n");  // Close out the data stream
    pg_close($dbconn);
    exit();
}
function getRecord($dbconn, $id)
{

    $sql = sprintf("select * from point where id = id", $id);
    $result = pg_query($dbconn, $sql);
    $row = pg_fetch_row($result);

    if (!$row)
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record id not found in point table\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
    }

    printf("{\n");
    printf("\"status\":  \"SUCCESS\",\n");
    printf("\"message\": \"There be whales here Captain!\",\n");
    printf("\"id\":      \"%s\",\n", $row[0]);
    printf("\"name\":    \"%s\",\n", $row[1]);
    printf("\"x\":       \"%s\",\n", $row[2]);
    printf("\"y\":       \"%s\"\n",  $row[3]);
    printf("}\n");

    pg_close($dbconn);
    exit();
}

function insertRecord($dbconn, $name, $x, $y)
{
    $sql = sprintf("insert into point (name, x, y) values ('%s', %d, %d)",$name, $x, $y);

    if (!pg_query($dbconn, $sql))
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record insert failed!\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
    }

    allRecords($dbconn);
}

function updateRecord($dbconn, $id, $name, $x, $y)
{
    $sql = sprintf("update point set name='%s', x=%d, y=%d where id = %d", $name, $x, $y, $id);

    if (!pg_query($dbconn, $sql))
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record update failed!\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
    }

    allRecords($dbconn);
}

function deleteRecord($dbconn, $id)
{
    $sql = sprintf("delete from point where id = %d", $id);

    if (!pg_query($dbconn, $sql))
    {
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Record delete failed!\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
    }

    allRecords($dbconn);
}

if (!$dbconn = pg_connect("dbname=visionlink"))
{
    printf("{\n");
    printf("\"status\":                         \"FAILED\",\n");
    printf("\"message\":                        \"Cannot connect to VisionLink\"\n");
    printf("}\n");
    exit();
}

switch ($action)
{
    case 'all':
        allRecords($dbconn);
        break;
    case 'get':
        getRecord($dbconn, $id);
        break;
    case 'insert':
        insertRecord($dbconn, $name, $x, $y);
        break;
    case 'update':
        updateRecord($dbconn, $id, $name, $x, $y);
        break;
    case 'delete':
        deleteRecord($dbconn, $id);
        break;
    default:
        printf("{\n");
        printf("\"status\":                         \"FAILED\",\n");
        printf("\"message\":                        \"Unknow action\"\n");
        printf("}\n");
        pg_close($dbconn);
        exit();
        break;
}
