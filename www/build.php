<?php
// Imports and Declarations
include(__DIR__ . '/libs/Smarty.class.php');
include(__DIR__ . '/includes/config.php');
$smarty = new Smarty;

$path = $_GET['name'];
$path_manifest = $path . ".manifest";

$cmd = "MYSQL_ROOTPASS=b191wkm ntdc -v -m root:b191wkm -t /var/www/html/adamtest http://localhost/" . basename($path_manifest);

chdir("/var/www/html/DrupalMake/www/");

$hash = md5(uniqid(rand(), true));

ob_end_clean();
header("Connection: close");
ignore_user_abort(true);
ob_start();

// Assign variables to be used in template files and the display the page
$smarty->assign('hash', $hash);
$smarty->display('build.tpl');

$size = ob_get_length();
header("Content-Length: $size");
ob_end_flush();
flush();

chdir("/var/tmp");

$apc_progress_key = 'PROGRESS_' . $hash;
$apc_complete_key = 'COMPLETE_' . $hash;

apc_add($apc_complete_key, false);

// read lines from execution
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

while (!feof($pipes[1])) {
    $buffer = fgets($pipes[1]);
    $buffer = trim(htmlspecialchars($buffer));
    
    // put line into store
    if (!apc_exists($apc_progress_key)) {
        apc_add($apc_progress_key, array(), 1000);
    }
    
    $linesSoFar = apc_fetch($apc_progress_key);
    $linesSoFar[] = $buffer;
    apc_store($apc_progress_key, $linesSoFar, 1000);
}

fclose($pipes[1]);

while (!feof($pipes[2])) {
    $buffer = fgets($pipes[2]);
    $buffer = trim(htmlspecialchars($buffer));
    
    // put line into store
    if (!apc_exists($apc_progress_key)) {
        apc_add($apc_progress_key, array(), 1000);
    }
    
    $linesSoFar = apc_fetch($apc_progress_key);
    $linesSoFar[] = $buffer;
    apc_store($apc_progress_key, $linesSoFar, 1000);
}

fclose($pipes[2]);
proc_close($proc);

apc_store($apc_complete_key, true, 3000);

?>