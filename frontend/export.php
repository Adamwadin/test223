<?php
$url = 'http://localhost:3000/api/products';
$products = json_decode(file_get_contents($url), true);

$format = $_GET['format'] ?? 'csv';

if ($format === 'xml') {
    header('Content-Type: application/xml');
    $xml = new SimpleXMLElement('<products/>');
    array_walk(
        $products,
        fn($product) => $xml->addChild('product')
            ->addChild('id', $product['id'])
            ->addChild('name', $product['name'])
            ->addChild('price', $product['price'])
            ->addChild('image', $product['image'] ?? '')
    );
    echo $xml->asXML();
} else {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="products.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Name', 'Price', 'Image']);
    array_walk($products, fn($product) => fputcsv($output, [
        $product['id'],
        $product['name'],
        $product['price'],
        $product['image'] ?? ''
    ]));
    fclose($output);
}
?>