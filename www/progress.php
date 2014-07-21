<?php

/*
 * Handle requests from logger-console.js for updates on progress
 */

header('Content-Type: application/json');

// the id of the ongoing (hopefully) job
$id = $_GET['id'];

// if the id is invalid...
if ($id == "" || !apc_exists('COMPLETE_' . $id)) {
    // complain
    exit('{ error: "Invalid ID (this is a web server error)!" }');
}

// the data - soon to be in the form of JSON - to be returned
$data = array(
    "complete" => apc_fetch('COMPLETE_' . $id)
);

// current cached lines of progress
// TODO not be reliant that this is in fact existent
$data["progress"] = apc_fetch('PROGRESS_' . $id);

// return data as JSOn
echo json_encode($data);

// if the task is complete
if ($data['complete']) {
    // remove all traces of existence
    apc_delete('PROGRESS_' . $id);
} else {
    // refresh line buffer to empty to have more lines appended
    apc_store('PROGRESS_' . $id, array(), 1000);
}

?>