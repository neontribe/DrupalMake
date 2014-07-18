<?php
// header("Content-type: text/plain");
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

// Retrieve infomation from form
$projectname = $_GET['projectname'];
$repo_name = $_GET['repo'];
$modify = $_GET['modify'];
$template = $config_default_template;
$branches = array();

if ($modify == "YES") {
    // Get other projects
    // Assign new variables
    $template = $config_modify_template;
    session_start();

    $libraries = $_SESSION['libraries'];
    $core = $_SESSION['core'];
    $api = $_SESSION['api'];
    $file = $_SESSION['file'];
    
    $library_name = array();
    $library_type = array();
    $library_url = array();
    $library_dir_name = array();
    
    // Get the library information
    foreach($libraries as $key => $value) {
        $library_name[$key] = $key;
        $library_type[$key] = $libraries[$key]['download']['type'];
        $library_url[$key] = $libraries[$key]['download']['url'];
        $library_dir_name[$key] = $libraries[$key]['directory_name'];
    }
    
//    $dummydata = array();
//    for ($i=0; $i<5; $i++) {
//      $new = new stdClass();
//      $new->type = 'git';
//      $new->url = 'http://example.com/' . $i;
//      $new->branch = 'foobranch' . $i;
//      $new->subdir = 'custom';
//      $dummydata[] = $new;
//    }$smarty->assign('dd', $dummydata);
    
    // Set template variables
    $smarty->assign('CORE', $core);
    $smarty->assign('API', $api);
    
    $smarty->assign('LIBRARY_NAME', $library_name);
    $smarty->assign('LIBRARY_TYPE', $library_type);
    $smarty->assign('LIBRARY_URL', $library_url);
    $smarty->assign('LIBRARY_DIR_NAME', $library_dir_name);
    
    $smarty->assign('OTHER_PROJECTS', $file);
    
    //print_r($other_projects);
}

// Check if no project name was entered, if none were, tell the user
if ($projectname == "Enter project name" || $projectname == "") {
    $error = "<div class='error'>You didn't enter a project name!<br /><a onclick='goBack()' title='Go back'>Go back</a></div>";
}

// For each repo name, get select value, put in array as $array[reponame][branch]
foreach ($repo_name as $branch) {
    $name = $_GET[$branch];
    $branches[$branch] = $name;
}

// Assign variables to be used in template files and the display the page
$smarty->assign('error', $error);
$smarty->assign('PROJECT_NAME', $projectname);

$smarty->assign('REPO_NAME', $repo_name);
$smarty->assign('REPO_BRANCH', $branches);

$smarty->display($template);
?>