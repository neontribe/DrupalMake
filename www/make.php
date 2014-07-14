<?php
//header("Content-Type:text/plain");
include('libs/Smarty.class.php');

// Retrieve infomation from form
$projectname = $_GET['projectname'];
$repo_name = $_GET['repo'];
$branches = array();

// For each repo name, get select value, put in array as $array[reponame][branch]
foreach ($repo_name as $branch) {
    $name = $_GET[$branch];
    $branches[$branch] = $name;
}

// Assign variables to be used in template files and the display the page
$smarty = new Smarty;
$smarty->assign('PROJECT_NAME', $projectname);

$smarty->assign('REPO_NAME', $repo_name);
$smarty->assign('REPO_BRANCH', $branches);

$smarty->display('template.tpl');
?>