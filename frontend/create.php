<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => (int) $_POST['id'],
        'name' => $_POST['name'],
        'price' => (float) $_POST['price'],
        'description' => $_POST['description']
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/json\r\n",
            "method" => "POST",
            "content" => json_encode($data)
        ]
    ];

    $context = stream_context_create($options);
    file_get_contents('https://test223-six.vercel.app/api/products', false, $context);

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