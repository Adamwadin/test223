<?php
$id = $_GET['id'];
$url = "https://test223-six.vercel.app/api/products/$id";

$options = [
    'http' => [
        'method' => 'DELETE',
    ],
];
$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);
header('Location: index.php');
?>