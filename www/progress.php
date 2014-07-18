<?php

header('Content-Type: application/json');

$id = $_GET['id'];

if ($id == "" || !apc_exists('COMPLETE_' . $id)) {
    exit('{ error: "Invalid ID (this is a web server error)!" }');
}

$data = array(
    "complete" => apc_fetch('COMPLETE_' . $id)
);

$data["progress"] = apc_fetch('PROGRESS_' . $id);

echo json_encode($data);

if ($data->complete) {
    apc_delete('PROGRESS_' . $id);
} else {
    apc_store('PROGRESS_' . $id, array(), 1000);
}

?>