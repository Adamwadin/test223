<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    $url = "http://localhost:3000/api/products/$id"; // Adjust URL if needed

    $options = [
        'http' => [
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    // Optionally check if the request was successful
    if ($result === false) {
        // Handle the error if needed
        // For simplicity, we just redirect
        header('Location: index.php?error=delete');
        exit;
    }
}

header('Location: index.php');
exit;
