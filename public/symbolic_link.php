<?php $target = '/storage/app/public/';

$shortcut = '/public/storage';
var_dump(symlink($target, $shortcut));
exit;


// $target = '/home4/xhbj650a/public_html/storage/app/public/'; 

// $shortcut = '/home4/xhbj650a/public_html/public/storage';
// var_dump(symlink($target, $shortcut));
// exit;


?>
