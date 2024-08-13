<?php


//METODO: get data from api
$ch = curl_init();

$url = "https://test223-six.vercel.app/";
curl_setopt($ch, CURLOPT_URL, $url);

// Set the option to return the response as a string instead of outputting it directly
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$headers = [
    "Content-Type: application/json"
];
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    echo 'cURL Error: ' . curl_error($ch);
} else {
    header('Content-type: text/csv');

    $data = json_decode($response, true);

    echo ("id,name\n");

    foreach ($data as $row) {
        echo ($row['id'] . "," . $row['name'] . "\n");
    }
}

curl_close($ch);
?>