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
<center><h1>Vision Link - trial challenge</h1><h3>Greg Parkin</h3></center>


<div style="padding: 20px 0px">
    <button class="w2ui-btn" onclick="openPopup()">Open Popup</button>
</div>

<p>
    I spent most of my time working on getting MacOS Ventura apache httpd and postgres working on my
    Mac-Book Air using the new M2 arm64 chip. LAMP will no longer work properly in Ventura.<br><br>

    I setup an Apache virtual host (vhost) for a local web server called: visionlin.test<br><br>

    There is a folder here with a file in it called private/visionlink. This file contains the postgres
    database connection information. The table "point" has been created per the instructions and I have
    written a small API to load the information in the Grid.<br><br>

    Contents of the private/visionlink file looks like this:<br><br>
    HOST=127.0.0.1<br>
    PORT=5432<br>
    DBNAME=visionlink<br>
    USER=visionlink<br>
    PASSWORD=trialtask<br>
    <br><br>

    Take a lookup at the classes folder for postgres.php, library.php and SqlFormatter.php<br><br>

    I decide to include the grid and the edit form in a w2ui popup dialog box. I ran out of time connecting
    it up to use a Ajax script I built for it. See: (ajax_server.php). There is also a curl script
    called server/test_ajax_server where you can test it.
    <br><br>

    You can all test it in your browser using the following URL options:<br><br>

    INSERT:<br>
    http://visionlink.test/ajax_server.php?action=insert&name=P&x=10&y=16
    <br><br>

    ALL:<br>
    http://visionlink.test/ajax_server.php?action=all
    <br><br><br>

    GET:
    http://visionlink.test/ajax_server.php?action=get&id=9
    <br><br>

    UPDATE:<br>
    http://visionlink.test/ajax_server.php?action=update&id=9&name=Z&x=4&y=2
    <br><br>

    DELETE:<br>
    http://visionlink.test/ajax_server.php?action=delete&id=9
    <br><br>

    There are a lot of unused .php programs, css, js, and image files, along with some frameworks I was wanted
    to try, such as DataTables, Editor-PHP, node_modules, and so on.
</p>

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
            { field: 'recid',   text: 'ID',   size: '25%', sortable: true, searchable: true },
            { field: 'name', text: 'Name', size: '25%', sortable: true, searchable: true },
            { field: 'x',    text: 'X',    size: '25%', sortable: true, searchable: true },
            { field: 'y',    text: 'Y',    size: '25%', sortable: true, searchable: true  }
        ],
        records: [
            <?php
            $pg = new postgres("visionlink");
            $pg->sql("select * from point order by name", array());
            $do_comman = false;
            while ($pg->fetch())
            {
                if ($do_comma)
                    printf(",\n");

                $do_comma = true;

                printf("{ recid: %d, name: '%s', x: '%d', y: '%d' }",
                   $pg->id, $pg->name, $pg->x, $pg->y);
            }
            ?>
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
            { field: 'recid', type: 'text', required: true, html: { label: 'ID',   attr: 'size="10" maxlength="10"' } },
            { field: 'name',  type: 'text', required: true, html: { label: 'Name', attr: 'size="40" maxlength="40"' } },
            { field: 'x',     type: 'text', required: true, html: { label: 'X',    attr: 'size="40" maxlength="40"' } },
            { field: 'y',     type: 'text', required: true, html: { label: 'Y',    attr: 'size="40" maxlength="40"' } }
        ],
        actions: {
            Add() {
                this.clear();
            },
            Save() {
                let errors = this.validate()
                if (errors.length > 0) return
                if (this.recid == 0) {
                    grid.add(w2utils.extend({ id: grid.records.length + 1 }, 0))
                    grid.selectNone()
                    this.clear()
                } else {
                    grid.set(this.recid, this.record)
                    grid.selectNone()
                    this.clear()
                }
            },
            Delete() {
                this.clear()
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
        title: 'Vision Link',
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
