<?php
$url = "http://localhost:3000/api/products";

$response = file_get_contents($url);
$products = json_decode($response, true);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="styling.css">
</head>

<body>
    <div class="container">
        <h1>Product List</h1>
        <?php if (!empty($products)): ?>
            <a class="btn" href="export.php?format=csv">Export as CSV</a>
            <a class="btn" href="export.php?format=xml">Export as XML</a>
            <a class="btn" href="create.php">Add Product</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td>
                                <a href="edit.php?id=<?php echo $product['id']; ?>">Edit</a>
                                <a href="delete.php?id=<?php echo $product['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No products found.</p>
        <?php endif; ?>
    </div>
</body>

</html>