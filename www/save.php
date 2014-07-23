<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

$name = $_POST['name'];
$overwrite = $_POST['overwrite'];
$file = $_POST['file'];
$isNew = $_POST['new'];
$type = $_POST['type'];

$response = "";

if ($type == "manifest") {
    // generate a manifest from provided values
    $save_path = __DIR__ . "/manifest/";
    
    $projectname = $_POST['projectname'];
    $remoteurl = $_POST['remoteurl'];
    $remotepath = $_POST['remotepath'];
    $profile = $_POST['profile'];
    $sitename = $_POST['sitename'];
    $settingsmodule = $_POST['settingsmodule'];
    
    $make_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . 'make/' . $projectname . '.make';
    
    $manifest = 
    "makefile=" . $make_url . "
remoteUrl=" . $remoteurl . "
remotePath=" . $remotepath . "
profile=" . $profile . "
sitename=" . $sitename . "
settings_module=" . $settingsmodule;
    
    $file = $manifest;
    $path = $save_path . $projectname . "." . $type;
    $path_no_extention = $save_path . $projectname;
    
    $name = $projectname;
} else if ($type == "make") {
    $save_path = __DIR__ . "/make/";
    $path = $save_path . $name . "." . $type;
    $path_no_extention = $save_path . $name;
} else {
    // TODO account for incorrect type
}

if ($isNew == "NO") {
    if (file_exists($path) && $overwrite) {
        // overwrite potentially pre-existing file and save manifest
        $fp = fopen($path, "wb");
        fwrite($fp, $file);
        fclose($fp);
        $response = "File Overwritten";
    } else if (file_exists($path) && !$overwrite) {
        // request the user to confirm overwrite or go back
        $response = "File already exists, <a onclick='goBack()' title='Go back'>Go Back</a>";
    } else {
        // no conflicts, save file
        $fp = fopen($path, "wb");
        fwrite($fp, $file);
        fclose($fp);
        $response = "File Saved";
    }
} else {
    // no conflicts, save file
    $fp = fopen($path, "wb");
    fwrite($fp, $file);
    fclose($fp);
    $response = "File Saved";
}

// Assign variables to be used in template files and the display the page
$smarty->assign('name', $name);
$smarty->assign('response', $response);
$smarty->assign('file', $file);
$smarty->assign('path', $path_no_extention);
$smarty->assign('type', $type);

$smarty->display('save.tpl');
?>