<!DOCTYPE html>
<html lang="en">
<head>
    <!-- The jQuery library is a prerequisite for all jqSuite products -->
    <script type="text/ecmascript" src="js/jquery.js"></script>

    <link rel="stylesheet" type="text/css" href="css/jqx.base.css">
    <link rel="stylesheet" type="text/css" href="css/jqx.bootstrap.css">
    <link rel="stylesheet" type="text/css" media="screen" href="css/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="css/w2ui-1.5.rc1.css" />
    <script type="text/javascript" src="js/w2ui-1.5.rc1.js"></script>

    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">

    <meta charset="utf-8" />
    <title>VisionLink</title>
    <base href="visionlink.test">
</head>
<body>

<?php

require_once __DIR__ . '/autoload.php';

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

printf("<pre>\n");
$pg = new postgres("visionlink");

if (!$pg->sql("select * from point order by name", array()))
{
    printf("select failed\n");
}

while ($pg->fetch())
{
    printf("%s %d %d\n", $pg->name, $pg->x, $pg->y);
}

?>
<button onclick="popup2('Point Editor', 3)">Click me</button>
<?php

?>

<!--
<script type="text/javascript">

    function openDialog(title, id) {
        var url = 'dialog_edit_point.php?action=update&id=' + id;
        var content = '<iframe src="' + url + '" ' +
            'style="border: none; min-width: 100%; min-height: 100%;">' + '</iframe>';

        //var close_button =
        //     '<a data-toggle="id_close" title="Close this dialog box.">' +
        //    '<button class="btn" onclick="w2popup.close();">Close</button></a>';

        //var close_button =
        //    '<a data-toggle="id_close" title="Close this dialog box.">' +
        //    '<input title="Close Dailog box." type="button" value="Close" onclick="alert('Close');</a>';

        w2popup.open({
            title: title,
            body: content,
            buttons: '<input title="Close Dailog box." type="button" value="Close" onclick="w2popup.close();">',
            resizable: false,
            width: '600',
            height: '300',
            overflow: 'hidden',
            color: '#333',
            speed: '0.1',
            opacity: '0.8',
            modal: true,
            showClose: true,
            showMax: true,
            actions: ['Ok', 'Cancel'],
            onOpen: function (event) {

            },
            onClose: function (event) {

            },
            onMax: function (event) {
                console.log('max');
            },
            onMin: function (event) {
                console.log('min');
            },
            onKeydown: function (event) {
                console.log('keydown');
            }
        });
    }
-->

<script type="module">
    import { w2popup } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'
    window.popup2 = function(title, id) {

        var url = 'dialog_edit_point.php?action=update&id=' + id;
        var content = '<iframe src="' + url + '" style="border: none; min-width: 99%; min-height: 99%;"></iframe>';

        w2popup.open({
            title: title,
            body: content,
            actions: {
                Ok(event) {
                    w2popup.close()
                },
                Cancel(event) {
                    w2popup.close()
                }
            },
            width: 500,
            height: 300,
            modal: true,
            showClose: true,
            showMax: true
        })
    }

</script>

