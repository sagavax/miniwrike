<?php

session_start();

$postData = file_get_contents('php://input');

// Decode the JSON data
$data = json_decode($postData, true);

if (isset($data['project_id'])) {
    // Store the project_id in the PHP session
    $_SESSION['project_id'] = $data['project_id'];
    
    // Return a success response
    echo json_encode(['status' => 'success', 'message' => 'Project ID stored in session.']);
} else {
    // Return an error response
    echo json_encode(['status' => 'error', 'message' => 'No project ID provided.']);
}