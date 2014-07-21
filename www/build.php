<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

$path = $_GET['name'];
$path_manifest = $path . ".manifest";

// the command to be executed to build
$cmd = "MYSQL_ROOTPASS=b191wkm ntdc -v -m root:b191wkm -t /var/www/html/adamtest http://localhost/" . basename($path_manifest);

chdir("/var/www/html/DrupalMake/www/");

// a value to uniquely (hopefully) identify the build job, so status updates can be gotten through the polling of progress.php
$hash = md5(uniqid(rand(), true));

// say goodbye to the browser; work will be continued whilst updates are shown via polling
ob_end_clean();
header("Connection: close");
ignore_user_abort(true);
ob_start();

// Assign variables to be used in template files and the display the page
$smarty->assign('hash', $hash);
$smarty->display('build.tpl');

// say goodbye to the browser further
$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();

// change to a directory in which a file can be downloaded (temporarily) with no fears of lacking permission to do so
chdir("/var/tmp");

// the relevant unique keys to identify information on the level of progress in APC (caching)
$apc_progress_key = 'PROGRESS_' . $hash;
$apc_complete_key = 'COMPLETE_' . $hash;

// record that the task is existant but not complete
apc_add($apc_complete_key, false, 1000);

// read lines from shell execution of $cmd
$proc = proc_open(
    $cmd, 
    array(
        0 => array('pipe', 'r'), 
        1 => array('pipe', 'w'), 
        2 => array('pipe', 'w')
    ),
    $pipes
);

$stdin = null;

fwrite($pipes[0], $stdin);
fclose($pipes[0]);

// while possible, read from stdout and cache read lines, so they can be picked up through polling
// TODO read stdout and stderr simultaneously
while (!feof($pipes[1])) {
    $buffer = fgets($pipes[1]);
    $buffer = trim(htmlspecialchars($buffer));
    
    // put line into store
    if (!apc_exists($apc_progress_key)) {
        apc_add($apc_progress_key, array(), 1000);
        // apparently this is 1000 seconds but unreliable results were had when the value was 10, which is odd, as it is polled every 1 second
    }
    
    // append new lines to the pre-existing cached lines
    $linesSoFar = apc_fetch($apc_progress_key);
    $linesSoFar[] = $buffer;
    apc_store($apc_progress_key, $linesSoFar, 1000);
}

fclose($pipes[1]);

// this should read the stderr output, however, this does not appear to be working :(
while (!feof($pipes[2])) {
    $buffer = fgets($pipes[2]);
    $buffer = trim(htmlspecialchars($buffer));
    
    // put line into store
    if (!apc_exists($apc_progress_key)) {
        apc_add($apc_progress_key, array(), 1000);
    }
    
    // append new lines to the pre-existing cached lines
    $linesSoFar = apc_fetch($apc_progress_key);
    $linesSoFar[] = $buffer;
    apc_store($apc_progress_key, $linesSoFar, 1000);
}

// clear-up
fclose($pipes[2]);
proc_close($proc);

// let it be known that the task is completed
apc_store($apc_complete_key, true, 3000);

?>