<?php
// Imports and Declarations
include('libs/Smarty.class.php');
include('includes/repo_functions.php');
define("OAUTH_TOKEN", "d5588f96e85a798c3cac9c2cb6e73b46b5437611");
$smarty = new Smarty();

$repos = array();
$branch = array();
$checked = array();

// This loops through each repo and gets it name and adds it to an array if based on the output of the infoFile function above
$json_decoded = fetchRepos();
for ($i = 0; $i < count($json_decoded); $i++) {
    $name = $json_decoded[$i]['name'];
    $name_exists = infoFile($name);

    if ($name_exists == false) {
        
    } else {
        $branch[] = $name;
    }
}

$repos[$repo] = $branch;

// Assign variables to be used in template files and the display the page
$smarty->assign('checked', $checked);
$smarty->assign('repos', $repos);
$smarty->display('index2.tpl');
?>