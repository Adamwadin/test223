<?php
$url = 'https://test223-six.vercel.app';
$products = json_decode(file_get_contents($url), true);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <link rel="stylesheet" href="/styling.css">
</head>

<body>
    <div class="container">
        <h1>Product List</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                    <a href="export.php?format=csv" class="btn">Export as CSV</a>
                    <a href="export.php?format=xml" class="btn">Export as XML</a>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= htmlspecialchars($product['id']) ?></td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['price']) ?></td>
                        <td>
                            <?php if ($product['image']): ?>
                                <img src="<?= htmlspecialchars($product['image']) ?>"
                                    alt="<?= htmlspecialchars($product['name']) ?>" width="50">
                            <?php else: ?>
                                No Image
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn">Edit</a>
                            <a href="delete.php?id=<?= htmlspecialchars($product['id']) ?>"
                                class="btn delete-btn">Delete</a>


                        </td>
                    </tr>

                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="create.php" class="btn">Add New Product</a>
    </div>
    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', event => {
                if (!confirm('Säker på att du vill ta bort <?php echo $product['name']; ?>?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
</body>

</html>