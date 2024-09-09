<?php
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id) {
    $url = "http://localhost:3000/api/products/$id";

    $options = [
        'http' => [
            'method' => 'DELETE',
        ],
    ];

    $context = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result === false) {
        header('Location: index.php?error=delete');
        exit;
    }
}

header('Location: index.php');
exit;
