<?php
require_once __DIR__ . '/autoload.php';

if (session_id() == '')
    session_start();

$lib = new library();        // classes/library.php

$lib->debug_start('index.txt');
    date_default_timezone_set('America/Denver');

$lib->debug_r1(__FILE__, __LINE__, $_POST, "_POST");
$lib->debug_r1(__FILE__, __LINE__, $_GET, "_GET");
$lib->debug_r1(__FILE__, __LINE__, $_REQUEST, "_REQUEST");
$lib->debug_r1(__FILE__, __LINE__, $_SERVER, "_SERVER");
$lib->debug_r1(__FILE__, __LINE__, $_SESSION, "_SESSION");
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

    let grid = new w2grid({
        name:     'grid',
        theme:    'metro',
        url:      'ajax_server.php',
        method:   'POST',
        postData: {action: 'all',},
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

            let val = '/edit_points.php';
            let url = val.concat("?id=", id, "&name=", name, "&x=", x, "&y=", y);

            location.href = url;

            //updateRecordPopup(id, name, x, y);
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

    // This is the Edit screen
    window.updateRecordPopup = function(id, name, x, y) {

        let val = '/ajax_server.php?action=distance';
        let url = val.concat("&id=", id, "&name=", name, "&x=", x, "&y=", y);

        let distanceData;

        fetch(url)
            .then((response) => response.json())
            .then((data) => distanceData = data);

        let html1 =
            '<div class="w2ui-page page-0">' +
            ' <div class="w2ui-label">ID:</div>' +
            '   <input name="id" type="test" size="25" disabled/>' +
            ' </div>' +
            ' <div class="w2ui-label">Name:</div>' +
            '   <input name="name" type="text" size="35"/>' +
            ' </div>' +
            ' <div class="w2ui-label">X:</div>' +
            '   <input name="x" type="text" size="35"/>' +
            ' </div>' +
            ' <div class="w2ui-label">Y:</div>' +
            '   <input name="y" type="text" size="35"/>' +
            ' </div>';

        // Loop through the return data and add a table to the form
        // for nearest 1.4 values.



        let html3 =
            '</div>' +
            '<div class="w2ui-buttons">'+
            '	<input type="button" value="Reset" name="reset">'+
            '	<input type="button" value="Save" name="save">'+
            '</div>';

        let html = html1 - html3;

        if (!w2ui.foo) {
            new w2form({
                name: 'edit_popup',
                style: 'border: 0px; background-color: transparent;',
                formHTML: html,
                fields: [
                    {field: 'id', type: 'int', required: false},
                    {field: 'name', type: 'text', required: true},
                    {field: 'x', type: 'text', required: true},
                    {field: 'y', type: 'text', required: true}
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
            title: 'Edit Record',
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
            .then((evt) => {
                console.log('popup ready')
            })
    }
</script>

</body>
</html>