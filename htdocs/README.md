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