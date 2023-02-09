<?php
require_once __DIR__ . '/autoload.php';

if (session_id() == '')
    session_start();

$lib = new library();        // classes/library.php

$lib->debug_start('index.txt');
    date_default_timezone_set('America/Denver');

// Parse QUERY_STRING if it exists
$my_request = array();
$method = "all";

if (isset($_SERVER['QUERY_STRING']))
{
    parse_str($_SERVER['QUERY_STRING'], $my_request);  // Parses URL parameter options into an array called $my_request
    $input_count = count($my_request);                        // Get the count of the number of $my_request array elements.
    $lib->debug1(__FILE__, __LINE__, "input_count = %d", $input_count);
    $lib->debug_r1(__FILE__, __LINE__, $my_request, "my_request");

    if (isset($my_request['method']))
        $method = $my_request['method'];
}

$lib->debug1(__FILE__, __LINE__, "method = %s", $method);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vision Link</title>
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
    <script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>

<div id="grid" style="width: 800px; height: 400px;"></div>

<script type="module">
    import { w2grid, w2alert } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

    let base_url = window.location.origin;

    function reset() {
        //window.location.reload('visionlink.test');
        //window.location.replace('visionlink.test');
        // window.location.assign(‘https://www.ExampleURL.com/’);
        window.location.assign('http://visionlink.test');
    }

    function nearest() {
        //base_url = base_url + '?method=nearest';
        window.location.assign('http://visionlink.test?method=nearest');
        //window.location.reload(base_url);
    }

    function farthest() {
        //base_url = base_url + '?method=farthest';
        window.location.assign('http://visionlink.test?method=farthest');
        //window.location.reload(base_url);
    }

    document.getElementById("myReset").onclick = reset;
    document.getElementById("myNearest").onclick = nearest;
    document.getElementById("myFarthest").onclick = farthest;

    let grid = new w2grid({
        name:     'grid',
        theme:    'metro',
        url:      'ajax_server.php',
        method:   'POST',
        postData: {action: '<?php echo $method; ?>',},
        box:      '#grid',
        recid:    '1',
        show: {
            toolbar: true,
            footer: true,
            toolbarAdd: true,
            toolbarDelete: true,
            toolbarSave: true,
            toolbarEdit: true
        },
        searches: [
            { field: 'id',    label: 'id',    type: 'text' },
            { field: 'name',  label: 'Name',  type: 'text' },
            { field: 'x',     label: 'X',     type: 'text' },
            { field: 'y',     label: 'Y',     type: 'text' }
        ],
        columns: [
            { field: 'id', text: 'ID', size: '50px', sortable: true, attr: 'align=center' },
            { field: 'name', text: 'Name', size: '30%', sortable: true },
            { field: 'x', text: 'x', size: '30%', sortable: true },
            { field: 'y', text: 'y', size: '40%' }
        ],
        onAdd: function (event) {
            newRecordPopup();
            this.grid.refresh();
        },
        onEdit: function (event) {
            var grid = this;
            var sel = grid.getSelection();
            var id = grid.get(sel[0])['id'];
            var name = grid.get(sel[0])['name'];
            var x = grid.get(sel[0])['x'];
            var y = grid.get(sel[0])['y'];
            updateRecordPopup(id, name, x, y);
        },
        onDelete: function (event) {
            console.log('delete has default behavior');

            var grid = this;
            var sel = grid.getSelection();
            var id = grid.get(sel[0])['id'];

            this.postData = {
                action: 'delete',
                id:     id
            }
        },
        onSave: function (event) {
            w2alert('save');
        }
    })
</script>

<script type="module">
    import { w2form, query, w2ui, w2popup } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

    window.newRecordPopup = function() {
        if (!w2ui.foo) {
            new w2form({
                name: 'new_record',
                style: 'border: 0px; background-color: transparent;',
                fields: [
                    { field: 'name', type: 'text', required: true, html: { label: 'Name' } },
                    { field: 'x', type: 'text', required: true, html: { label: 'X' } },
                    { field: 'y', type: 'text', required: true, html: { label: 'Y' } }
                ],
                actions: {
                    Reset(event) {
                        this.clear()
                    },
                    Save(event) {
                        if (this.validate().length == 0) {
                            // Everything is validated, let's save the record.
                            console.log(this.getValue('name'));
                            console.log(this.getValue('x'));
                            console.log(this.getValue('y'));

                            // retrieve form data
                            //var data = form.record;

                            $.ajax({
                                url: 'ajax_server.php',
                                data: {
                                    action: 'insert',
                                    name: this.getValue('name'),
                                    x:    this.getValue('x'),
                                    y:    this.getValue('y')
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                },
                                error: function (error) {
                                    console.log(`Error ${error}`);
                                }
                            });

                            w2popup.close();
                            location.reload();
                        }
                    },
                    Cancel(event) {
                        w2popup.close();
                    }
                }
            });
        }

        w2popup.open({
            title   : 'Add Record',
            body    : '<div id="form" style="width: 100%; height: 100%;"></div>',
            style   : 'padding: 15px 0px 0px 0px',
            width   : 500,
            height  : 280,
            showMax : true,
            async onToggle(event) {
                await event.complete
                w2ui.new_record.resize();
            }
        })
            .then((event) => {
                w2ui.new_record.render('#form')
            });
    }

    window.updateRecordPopup = function(id, name, x, y) {
        if (!w2ui.foo) {
            new w2form({
                name: 'update_record',
                style: 'border: 0px; background-color: transparent;',
                fields: [
                    {field: 'id', type: 'int', required: true, readonly: false, html: {label: 'ID'}},
                    {field: 'name', type: 'text', required: true, html: {label: 'Name'}},
                    {field: 'x', type: 'text', required: true, html: {label: 'X'}},
                    {field: 'y', type: 'text', required: true, html: {label: 'Y'}}
                ],
                record: {
                    id: id,
                    name: name,
                    x: x,
                    y: y
                },
                actions: {
                    Save(event) {
                        if (this.validate().length == 0) {
                            // Everything is validated, let's save the record.
                            console.log(this.getValue('id'));
                            console.log(this.getValue('name'));
                            console.log(this.getValue('x'));
                            console.log(this.getValue('y'));

                            // retrieve form data
                            //var data = form.record;

                            $.ajax({
                                url: 'ajax_server.php',
                                data: {
                                    action: 'update',
                                    id: this.getValue('id'),
                                    name: this.getValue('name'),
                                    x: this.getValue('x'),
                                    y: this.getValue('y')
                                },
                                dataType: "json",
                                success: function (data) {
                                    console.log(data);
                                },
                                error: function (error) {
                                    console.log(`Error ${error}`);
                                }
                            });

                            w2popup.close();
                            location.reload();
                        }
                    },
                    Cancel(event) {
                        w2popup.close();
                    }
                }
            });
        }
        w2popup.open({
            title: 'Update Record',
            body: '<div id="form" style="width: 100%; height: 100%;"></div>',
            style: 'padding: 15px 0px 0px 0px',
            width: 500,
            height: 280,
            showMax: true,
            async onToggle(event) {
                await event.complete
                w2ui.update_record.resize();
            }
        })
            .then((event) => {
                w2ui.update_record.render('#form')
            });
    }
</script>
<div style="width: 800px; height: 400px;">
    <br>
    <center>
        <button id='myReset' onclick="reset()">Reset</button>
        <button id='myNearest' onclick="nearest()">Nearest points at distance 1.4</button>
        <button id='myFarthest' onclick="farthest()">Farthest points at distance 2.2</button>
    </center>
</div>
</body>
</html>