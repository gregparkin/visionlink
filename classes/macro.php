<?php

$name = $_SERVER['PHP_SELF'];
$name = preg_replace('#\/#mui', '', $name);

$file = file_get_contents($name);

// get defined macros
preg_match_all('#\#macro\h+(\w+)\h+(.*)$#mui', $file, $matches, PREG_SET_ORDER);

foreach ($matches as $m) {
    // delete macro definition
    $file = str_replace($m[0], '', $file);
    // substitute macro => value
    $file = str_replace($m[1], $m[2], $file);
}

// save processed file
$new_name = '/var/tmp/' . $name . '.pr';
file_put_contents($new_name, $file);

include_once $new_name;
exit;

