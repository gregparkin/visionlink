!DOCTYPE html>
<html>
<head>
    <title>W2UI Demo: popup/1</title>
    <link rel="stylesheet" type="text/css" href="https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.min.css">
</head>
<body>

<button class="w2ui-btn" onclick="popup1()">Simple popup</button>
<button class="w2ui-btn" onclick="popup2()">Popup with buttons and event listeners</button>

<script type="module">
    import { w2popup } from 'https://rawgit.com/vitmalina/w2ui/master/dist/w2ui.es6.min.js'

    window.popup1 = function() {
        w2popup.open({
            title: 'Popup Title',
            text: 'This is text inside the popup'
        })
    }

    window.popup2 = function() {
        w2popup.open({
            title: 'Popup Title',
            text: 'This is text inside the popup',
            actions: ['Ok', 'Cancel'],
            width: 500,
            height: 300,
            modal: true,
            showClose: true,
            showMax: true,
            onMax(evt) {
                console.log('max', evt)
            },
            onMin(evt) {
                console.log('min', evt)
            },
            onKeydown(evt) {
                console.log('keydown', evt)
            }
        })
            .then((evt) => {
                console.log('popup ready')
            })
            .close(evt => {
                console.log('popup clsoed')
            })
            .ok((evt) => {
                console.log('ok', evt)
                w2popup.close()
            })
            .cancel((evt) => {
                console.log('cancel', evt)
                w2popup.close()
            })
    }
</script>