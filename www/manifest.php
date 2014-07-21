<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

$name = $_GET['name'];

// Assign variables to be used in template files and the display the page
$smarty->assign('PROJECT_NAME', $name);
$smarty->display('manifest.tpl');
?>