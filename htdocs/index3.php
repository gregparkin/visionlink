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
?>

<!DOCTYPE html>
<html>
<head>
    <title>W2UI Demo: combo/8</title>
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
</head>
<body>

<div style="padding: 20px 0px">
    <button class="w2ui-btn" onclick="openPopup()">Open Popup</button>
</div>

<script type="module">
import { w2layout, w2grid, w2form, w2popup, w2utils } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

// widget configuration
let config = {
    layout: {
        name: 'layout',
        padding: 4,
        panels: [
            { type: 'left', size: '50%', resizable: true, minSize: 300 },
            { type: 'main', minSize: 300, style: 'overflow: hidden' }
        ]
    },
    grid: {
        name: 'grid',
        style: 'border: 1px solid #efefef',
        columns: [
            { field: 'fname', text: 'First Name', size: '33%', sortable: true, searchable: true },
            { field: 'lname', text: 'Last Name', size: '33%', sortable: true, searchable: true },
            { field: 'email', text: 'Email', size: '33%' },
            { field: 'sdate', text: 'Start Date', size: '120px', render: 'date' }
        ],
        records: [
            { recid: 1, fname: 'John', lname: 'Doe', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 2, fname: 'Stuart', lname: 'Motzart', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 3, fname: 'Jin', lname: 'Franson', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 4, fname: 'Susan', lname: 'Ottie', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 5, fname: 'Kelly', lname: 'Silver', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 6, fname: 'Francis', lname: 'Gatos', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 7, fname: 'Mark', lname: 'Welldo', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 8, fname: 'Thomas', lname: 'Bahh', email: 'jdoe@gmail.com', sdate: '4/3/2012' },
            { recid: 9, fname: 'Sergei', lname: 'Rachmaninov', email: 'jdoe@gmail.com', sdate: '4/3/2012' }
        ],
        async onClick(event) {
            await event.complete // needs to wait for evnet complete cycle, so selection is right
            let sel = grid.getSelection()
            if (sel.length == 1) {
                form.recid  = sel[0]
                form.record = w2utils.clone(grid.get(sel[0]))
                form.refresh()
            } else {
                form.clear()
            }
        }
    },
    form: {
        header: 'Edit Record',
        name: 'form',
        style: 'border: 1px solid #efefef',
        fields: [
            { field: 'recid', type: 'text', html: { label: 'ID', attr: 'size="10" readonly' } },
            { field: 'fname', type: 'text', required: true, html: { label: 'First Name', attr: 'size="40" maxlength="40"' } },
            { field: 'lname', type: 'text', required: true, html: { label: 'Last Name', attr: 'size="40" maxlength="40"' } },
            { field: 'email', type: 'email', html: { label: 'Email', attr: 'size="30"' } },
            { field: 'sdate', type: 'date', html: { label: 'Date', attr: 'size="10"' } }
        ],
        actions: {
            Reset() {
                this.clear()
            },
            Save() {
                let errors = this.validate()
                if (errors.length > 0) return
                if (this.recid == 0) {
                    grid.add(w2utils.extend({ recid: grid.records.length + 1 }, this.record))
                    grid.selectNone()
                    this.clear()
                } else {
                    grid.set(this.recid, this.record)
                    grid.selectNone()
                    this.clear()
                }
            }
        }
    }
}

// initialization in memory
let layout = new w2layout(config.layout)
let grid = new w2grid(config.grid)
let form = new w2form(config.form)

window.openPopup = function() {
    w2popup.open({
        title: 'Popup',
        width: 900,
        height: 600,
        showMax: true,
        body: '<div id="main" style="position: absolute; left: 2px; right: 2px; top: 0px; bottom: 3px;"></div>'
    })
    .then(e => {
        layout.render('#w2ui-popup #main')
        layout.html('left', grid)
        layout.html('main', form)
    })
}
</script>

</body>
</html>
