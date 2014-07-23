<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/repo_functions.php');

require $drush_path . '/commands/make/make.utilities.inc';
require $drush_path . '/includes/drupal.inc';

session_start();

//$update = $_GET['update'];

$file = $_POST['file'];
$file_name = substr($file, strrpos($file, '/') + 1);
$file_contents = file_get_contents($file);
$parsed_file = make_parse_info_file($file);

$neontribe_repos = array();
$detected_repos = array();
$libraries = $parsed_file['libraries'];
$neon_project_name;

// Get all Neontribe repos and place them in an array as $array[Repo Name]
$json_decoded = fetchRepos();
for ($i = 0; $i < count($json_decoded); $i++) {
    $name = $json_decoded[$i]['name'];
    $neon_project_name = $name;
    $neontribe_repos[$name] = $name;
}

// Get the project names from the make file
foreach($parsed_file['projects'] as $key => $value) {
    $detected_repos[$key] = $key;
}

// $neon_projects gives repos that match in the neontabs repo
$neon_projects = array_intersect($neontribe_repos, $detected_repos);

$projects = $parsed_file['projects'];

$o_projects = array();
$handle = fopen($file, "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        //  is the line a comment or a header
        if (substr($line, 0, 1) === ';' || substr($line, 0, 4) === 'core' || substr($line, 0, 3) === 'api' || substr($line, 0, 9) == 'libraries') {
            // if so, ignore
            continue;
        }
        
        // is the project described in the line a neon tribe project?
        $found = false;
        foreach ($neon_projects as $frank) {
            if (strpos($line, $frank) != FALSE) {
                $found = true;
            }
        }
        // if so, ignore, these should be detected
        if ($found) {
            continue;
        }
        
        // ignore blank lines
        if ($line == "\n") {
            continue;
        }
        
        // append the line
        $o_projects[$line] = $line;
    }
} else {
} 
fclose($handle);

function remove_empty_lines($string) {
    return preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);
}

// Assign variables to be used in template files and the display the page
$_SESSION['libraries'] = $libraries;
$_SESSION['core'] = $parsed_file['core'];
$_SESSION['api'] = $parsed_file['api'];
$_SESSION['file'] = $o_projects;

$neon_projects_names = array();
foreach ($neon_projects as $neon_projects_key) {
    $neon_projects_names[] = $neon_projects[$neon_projects_key];
}

// all relevant NeonTribe GitHub repositories
// TODO don't assume that cache should be used
$repos = repos(false);

// every relevant NeonTribe GitHub repository that is not currently detected
$other_repos = array_diff($repos, $neon_projects_names);

$smarty = new Smarty;
$smarty->assign('file_name', $file_name);
$smarty->assign('file_contents', print_r($file_contents, true));
$smarty->assign('neon_projects', $neon_projects);
$smarty->assign('repos', $other_repos);
$smarty->display('read.tpl');
?>