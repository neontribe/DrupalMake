<?php
// Imports and Declarations
include('libs/Smarty.class.php');
include('includes/repo_functions.php');
define("OAUTH_TOKEN", "d5588f96e85a798c3cac9c2cb6e73b46b5437611");
$smarty = new Smarty();

$repositories = $_GET['repo'];
$repos = array();
$error = "";

// Check if no checkboxes were selected, if none were, tell the user
if (count($repositories) < 1) {
    $error = "You didn't select any repositories!<br /><a href='.\' title='Go back'>Go back</a>";
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
$smarty->display('repos.tpl');
?>