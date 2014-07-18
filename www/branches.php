<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/repo_functions.php');
$smarty = new Smarty();

$repositories = $_GET['repo'];
$isModify;
$repos = array();
$error = "";

if($_GET['modify'] == "YES") {
    $isModify = "YES";
    $file_name = $_GET['file_name'];
    $file_name_raw = substr($file_name, 0, -5);
    $smarty->assign('file_name', $file_name_raw);
} else {
    $isModify = "NO";
}

// Check if no checkboxes were selected, if none were, tell the user
if (count($repositories) < 1) {
    $error = "<div class='error'>You didn't select any repositories!<br /><a onclick='goBack()' title='Go back'>Go back</a></div>";
}

// Loops through each repository, adds branches to an array to be used to generate the dropdown box of branches
foreach ($repositories as $repo) {
    $branch = array();

    $json_decoded = fetchBranches($repo);
    for ($i = 0; $i < count($json_decoded); $i++) {
        $name = $json_decoded[$i]['name'];
        $branch[] = $name;
    }

    $repos[$repo] = $branch;
}

// Assign variables to be used in template files and the display the page
$smarty->assign('error', $error);
$smarty->assign('repositories', $repositories);
$smarty->assign('branches', $repos);
$smarty->assign('modify', $isModify);
$smarty->display('branches.tpl');
?>