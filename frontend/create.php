<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare the product data
    $data = [
        'id' => (int) $_POST['id'],
        'name' => $_POST['name'],
        'price' => (float) $_POST['price'],
        'description' => $_POST['description']
    ];

    // Convert the data to JSON format
    $jsonData = json_encode($data);

    // Define the path to the products.json file
    $productsFilePath = '../api/products.json';

    // Read existing products from the file
    if (file_exists($productsFilePath)) {
        $existingData = file_get_contents($productsFilePath);
        $products = json_decode($existingData, true);
    } else {
        $products = [];
    }

    // Append the new product to the products array
    $products[] = $data;

    // Write the updated products array to the file
    file_put_contents($productsFilePath, json_encode($products, JSON_PRETTY_PRINT));

    // Prepare the HTTP context for the API request
    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n",
            "method" => "POST",
            "content" => $jsonData
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents('https://test223-six.vercel.app/api/products', false, $context);

    // Redirect to index.php
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="styling.css">
</head>

<body>
    <div class="container">
        <h1>Add New Product</h1>
        <form method="POST">
            <div class="form-group">
                <label for="id">Product ID:</label>
                <input type="number" name="id" id="id" required>
            </div>
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="price">Price:</label>
                <input type="number" step="0.01" name="price" id="price" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" id="description" required></textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Add Product</button>
            </div>
        </form>
    </div>
</body>

</html>