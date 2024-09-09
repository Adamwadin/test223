<?php
$id = $_GET['id'];
$url = "http://localhost:3000/api/products/$id";

$productData = file_get_contents($url);
$product = json_decode($productData, true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'id' => $id,
        'name' => $_POST['name'],
        'price' => $_POST['price'],
        'description' => $_POST['description'],
    ];

    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'PUT',
            'content' => json_encode($data),
        ],
    ];

    $context = stream_context_create($options);
    file_get_contents($url, false, $context);

    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="styling.css">
</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <form method="POST">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>"
                    required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" id="description" name="description"
                    value="<?php echo htmlspecialchars($product['description']); ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn">Update Product</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>

</html>