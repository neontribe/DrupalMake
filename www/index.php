<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

$makefiles = array();

// Seach $modify_directory (Set in config.php) for all .make files and put them in an array to generate dropdown list
foreach (glob($modify_directory) as $filename) {
    $makefiles[$filename] = $filename;
}
// Assign variables to be used in template files and the display the page
$smarty->assign('makefiles', $makefiles);
$smarty->display('index.tpl');
?>