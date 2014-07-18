<?php
$cmd = "MYSQL_ROOTPASS=b191wkm ntdc -v -m root:b191wkm -t /var/www/html/adamtest http://localhost/vanillafudge.manifest";
set_time_limit(0);

$handle = popen($cmd, "r");

if (ob_get_level() == 0) {
    ob_start();
}

while (!feof($handle)) {
    $buffer = fgets($handle);
    $buffer = trim(htmlspecialchars($buffer));

    echo $buffer . "<br />";
    echo str_pad('', 4096);

    ob_flush();
    flush();
}

pclose($handle);
ob_end_flush();




//function execute($cmd, $stdin = null) {
//    set_time_limit(0);
//    
//    $proc = proc_open(
//        $cmd, 
//        array(
//            0 => array('pipe', 'r'), 
//            1 => array('pipe', 'w'), 
//            2 => array('pipe', 'w')),
//        $pipes
//    );
//
//    fwrite($pipes[0], $stdin);
//    fclose($pipes[0]);
//    
//    $handle = $pipes[1];//= popen($cmd, "r");
//
//    if (ob_get_level() == 0) {
//        ob_start();
//    }
//
//    while (!feof($handle)) {
//        $buffer = fgets($handle);
//        $buffer = trim(htmlspecialchars($buffer));
//
//        echo $buffer . "<br />";
//        echo str_pad('', 4096);
//
//        ob_flush();
//        flush();
//    }
//
//    pclose($handle);
//    ob_end_flush();
//}

// Execute shell command, only $cmd is needed for input 
//function execute($cmd, $stdin = null) {
//    $proc = proc_open(
//        $cmd, 
//        array(
//            0 => array('pipe', 'r'), 
//            1 => array('pipe', 'w'), 
//            2 => array('pipe', 'w')),
//        $pipes
//    );
//
//    fwrite($pipes[0], $stdin);
//    fclose($pipes[0]);
//    
//    $stdout = stream_get_contents($pipes[1]);
//    fclose($pipes[1]);
//
//    $stderr = stream_get_contents($pipes[2]);
//    fclose($pipes[2]);
//
//    return array('stdout' => $stdout, 'stderr' => $stderr, 'return' => proc_close($proc));
//}
?>