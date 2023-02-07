<?php
/**
 * dialog_edit_point.php
 *
 * @package   VisionLink
 * @file      dialog_edit_point.php
 * @author    Greg Parkin
 */

require_once __DIR__ . '/autoload.php';

session_start(); // Call to make $_SESSION['...'] data available

ini_set('display_errors', 'Off');

$param = array();
$param_count = 0;

//
// NOTE: It is very important that you do not turn on debugging without writing to a file for server side AJAX code. Any HTML
//       comments coming from functions while writing XML will show up in the XML output and then you will get a XML parsing error
//       in the client side program.
//
$lib = new library();  // classes/library.php
$lib->debug_start('dialog_edit_point.html');
date_default_timezone_set('America/Denver');

$action = "";
$id = 0;
$name = "";
$x = 0;
$y = 0;

//
// Parse QUERY_STRING
//
if (isset($_SERVER['QUERY_STRING']))
{
    parse_str($_SERVER['QUERY_STRING'], $param);
    $param_count = count($param);

    $lib->debug1(__FILE__, __FUNCTION__, __LINE__, "QUERY_STRING: %s", $_SERVER['QUERY_STRING']);

    foreach ($param as $key => $value)
    {
        $lib->debug1(__FILE__, __FUNCTION__, __LINE__, "param[%s] = %s", $key, $value);
        switch ($key)
        {
            case 'action':
                $action = $value;
                break;
            case 'id':
                $id = $value;
                break;
            case 'name':
                $name = $value;
                break;
            case 'x':
                $x = $value;
                break;
            case 'y':
                $y = $value;
                break;
            default:
                break;
        }
    }
}

$lib->debug1(__FILE__, __FUNCTION__, __LINE__, "id: %d, name=%s, x=%d, y=%d", $id, $name, $x, $y);

// If we have an $id then go retrieve the record.
if (strlen($id) > 0)
{
    $okay = true;
    if (!$pg = new postgres("visionlink"))
    {
        $msg = sprintf("Cannot connect to visionlink: %s\"\n", $pg->getLastError());
        ?><script>alert("<?php echo $msg; ?>");</script><?php
        $okay = false;
    }

    if (!$okay)
    {
        if (!$pg->sql("select * from point where id = $1", array($id)))
            $okay = false;
    }

    $pg->fetch();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Point Record</title>
    <style>
        .ui-dialog-content {
            overflow: hidden;
        }

        .table {
            overflow: hidden;
        }

        .loader
        {
            position:         fixed;
            left:             0px;
            top:              0px;
            width:            100%;
            height:           100%;
            z-index:          9999;
            background:       url('images/gears_animated.gif') 100% 100% no-repeat rgb(249,249,249);
        }

        b {
            font-size: 13px;
        }

        textarea {
            font-size: 12px;
        }

        select {
            font-size: 12px;
        }

        .green {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding: 4px 23px;
            border: 1px solid #046a14;
            border-radius: 8px;
            background: #08c825;
            background: -webkit-gradient(linear, left top, left bottom, from(#08c825), to(#046a14));
            background: -moz-linear-gradient(top, #08c825, #046a14);
            background: linear-gradient(to bottom, #08c825, #046a14);
            -webkit-box-shadow: #0af02c 4px 4px 5px 0px;
            -moz-box-shadow: #0af02c 4px 4px 5px 0px;
            box-shadow: #0af02c 4px 4px 5px 0px;
            text-shadow: #033f0c 3px 2px 0px;
            font: normal normal bold 20px arial;
            color: #ffffff;
            text-decoration: none;
        }
        .green:hover,
        .green:focus {
            border: 1px solid ##057d17;
            background: #0af02c;
            background: -webkit-gradient(linear, left top, left bottom, from(#0af02c), to(#057f18));
            background: -moz-linear-gradient(top, #0af02c, #057f18);
            background: linear-gradient(to bottom, #0af02c, #057f18);
            color: #ffffff;
            text-decoration: none;
        }
        .green:active {
            background: #046a14;
            background: -webkit-gradient(linear, left top, left bottom, from(#046a14), to(#046a14));
            background: -moz-linear-gradient(top, #046a14, #046a14);
            background: linear-gradient(to bottom, #046a14, #046a14);
        }
        .red {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding: 4px 23px;
            border: 1px solid #64070d;
            border-radius: 8px;
            background: #ff1423;
            background: -webkit-gradient(linear, left top, left bottom, from(#ff1423), to(#64070d));
            background: -moz-linear-gradient(top, #ff1423, #64070d);
            background: linear-gradient(to bottom, #ff1423, #64070d);
            -webkit-box-shadow: #ff182a 4px 4px 5px 0px;
            -moz-box-shadow: #ff182a 4px 4px 5px 0px;
            box-shadow: #ff182a 4px 4px 5px 0px;
            text-shadow: #380407 3px 2px 0px;
            font: normal normal bold 20px arial;
            color: #ffffff;
            text-decoration: none;
        }
        .red:hover,
        .red:focus {
            border: 1px solid #6f080e;
            background: #ff182a;
            background: -webkit-gradient(linear, left top, left bottom, from(#ff182a), to(#780810));
            background: -moz-linear-gradient(top, #ff182a, #780810);
            background: linear-gradient(to bottom, #ff182a, #780810);
            color: #ffffff;
            text-decoration: none;
        }
        .red:active {
            background: #64070d;
            background: -webkit-gradient(linear, left top, left bottom, from(#64070d), to(#64070d));
            background: -moz-linear-gradient(top, #64070d, #64070d);
            background: linear-gradient(to bottom, #64070d, #64070d);
        }
        .purple {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding: 4px 23px;
            border: 1px solid #570784;
            border-radius: 8px;
            background: #a30df8;
            background: -webkit-gradient(linear, left top, left bottom, from(#a30df8), to(#570784));
            background: -moz-linear-gradient(top, #a30df8, #570784);
            background: linear-gradient(to bottom, #a30df8, #570784);
            -webkit-box-shadow: #c410ff 4px 4px 5px 0px;
            -moz-box-shadow: #c410ff 4px 4px 5px 0px;
            box-shadow: #c410ff 4px 4px 5px 0px;
            text-shadow: #33044e 3px 2px 0px;
            font: normal normal bold 20px arial;
            color: #ffffff;
            text-decoration: none;
        }
        .purple:hover,
        .purple:focus {
            border: 1px solid #66089b;
            background: #c410ff;
            background: -webkit-gradient(linear, left top, left bottom, from(#c410ff), to(#68089e));
            background: -moz-linear-gradient(top, #c410ff, #68089e);
            background: linear-gradient(to bottom, #c410ff, #68089e);
            color: #ffffff;
            text-decoration: none;
        }
        .purple:active {
            background: #570784;
            background: -webkit-gradient(linear, left top, left bottom, from(#570784), to(#570784));
            background: -moz-linear-gradient(top, #570784, #570784);
            background: linear-gradient(to bottom, #570784, #570784);
        }
    </style>
    <script type="text/javascript" src="js/jquery-2.1.4.js"></script>
    <!-- w2ui popup -->
    <!-- link rel="stylesheet" type="text/css" href="css/w2ui-1.4.3.css" / -->
    <!-- script type="text/javascript" src="js/w2ui-1.4.3.js"></script -->

    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.css" />
    <script type="text/javascript" src="js/w2ui-1.5.rc1.js"></script>

    <script type="text/javascript">
        function callAjax(action)
        {
            $(".loader").show();

            var data;

            // Retrieve the DOM elements from the form
            var id   = document.getElementById('id').value;
            var name = document.getElementById('name').value;
            var x    = document.getElementById('x').value;
            var y    = document.getElementById('y').value;

            //
            // Prepare the data that will be sent to ajax_server.php
            //
            <?php
                if ($id > 0)
                {
                    ?>
                        data = {
                            "action":            update,
                            "id":                id,
                            "name":              name,
                            "x":                 x,
                            "y":                 y
                        };
                    <?php
                }
                else
                {
                    ?>
                        data = {
                            "action":            insert,
                            "name":              name,
                            "x":                 x,
                            "y":                 y
                        };
                    <?php
                }
            ?>

            var url = 'ajax_server.php';

            $.ajax(
                {
                    type:     "GET",
                    url:      url,
                    dataType: "json",
                    data:     JSON.stringify(data),
                    success:  function(data)
                    {
                        $(".loader").fadeOut("slow");
                        alert(data['ajax_message']);

                        // Instruct parent to close this window.
                        parent.postMessage('close w2popup', "*");
                    },
                    error: function(jqXHR, exception, errorThrown)
                    {
                        if (jqXHR.status === 0) {
                            alert('Not connect.\n Verfiy Network.');
                        } else if (jqXHR.status == 404) {
                            alert('Requested page not found. [404]');
                        } else if (jqXHR.status == 500) {
                            alert('Internal Server Error [500]');
                        } else if (exception === 'parsererror') {
                            alert('Requested JSON parse failed.' + ' Error code: ' + errorThrown + ' ResponseText: ' + jqXHR.responseText);
                        } else if (exception === 'timeout') {
                            alert('Time out error.');
                        } else if (exception === 'abort') {
                            alert('Ajax request aborted.');
                        } else {
                            alert('Uncaught Error.\n' + jqXHR.responseText);
                        }
                    }
                }
            );
        }

        function buttonClick(ele)
        {
            switch ( ele.id )
            {
                case 'delete':
                    callAjax('remove', <?php echo $id; ?>);
                    break;
                case 'add':  // Create new list
                    callAjax('add',    <?php echo $id; ?>);
                    break;
                case 'save': // Save new or changed list name
                    callAjax('save',   <?php echo $id; ?>);
                    break;
                default:
                    alert('No logic coded for this button: ' + ele.id);
                    break;
            }
        }
    </script>
    <script type="text/javascript">
        $(window).load(function()
        {
            $(".loader").fadeOut("slow");
        });
    </script>
</head>
<body>
<div class="loader"></div>
<form name="f1">
    <div id="divit">
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
        <table style="width='100%' cellspacing='6' cellpadding='6' style='color: black'">
            <tr>
                <th align="center">Name</th>
                <th align="center">X</th>
                <th align="center">Y</th>
            </tr>
            <tr>
                <td align="center" valign="middle" width="25%">
                    <input title="Type in the name."
                           style="width: 100%" size="30" maxlength="20"
                           type="text" name="name" id="name"
                           value="<?php echo $name; ?>">
                </td>
                <td align="center" valign="middle" width="25%">
                    <input title="Type in x value."
                           style="width: 100%" size="30" maxlength="20"
                           type="text" name="x" id="x"
                           value="<?php echo $x; ?>">
                </td>
                <td align="center" valign="middle" width="25%">
                    <input title="Type in y value."
                           style="width: 100%" size="30" maxlength="20"
                           type="text" name="y" id="y"
                           value="<?php echo $y; ?>">
                </td>
            </tr>
        </table>
    </div>
</form>
</body>
</html>
