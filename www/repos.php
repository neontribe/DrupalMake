<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);

// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/repo_functions.php');

$smarty = new Smarty();

$repos = array();
$branch = array();
$checked = array();
$update = $_GET['update']; // whether cached values should be used or not

// names of NeonTribe GitHub repositories applicable to be included as an array of strings
$repos = repos($update);

// Assign variables to be used in template files and the display the page
$smarty->assign('checked', $checked);
$smarty->assign('repos', $repos);
$smarty->display('repos.tpl');
?>