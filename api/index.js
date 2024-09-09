const express = require("express");
const fs = require('fs');
const path = require('path');
const app = express();

app.use(express.json());
app.use(require('cors')());

const productsPath = path.join(__dirname, 'products.json');

// Function to read products from the file
const readProductsFromFile = () => {
    if (fs.existsSync(productsPath)) {
        const data = fs.readFileSync(productsPath);
        return JSON.parse(data);
    }
    return [];
};

// Function to write products to the file
const writeProductsToFile = (products) => {
    fs.writeFileSync(productsPath, JSON.stringify(products, null, 2));
};

// Initialize products array from the file or use default
let products = readProductsFromFile();

const findProductById = id => products.find(p => p.id === id);

app.get('/', (req, res) => res.json(products));

app.get('/api/products', (req, res) => res.json(products));

app.get('/api/products/:id', (req, res) => {
    const product = findProductById(+req.params.id);
    res.json(product || {});
});

app.post('/api/products', (req, res) => {
    const newProduct = { id: products.length + 1, ...req.body };
    products.push(newProduct);

    try {
        writeProductsToFile(products);
        res.status(201).json(newProduct);
    } catch (err) {
        console.error('Error writing to products.json:', err);
        res.status(500).json({ message: 'Internal server error' });
    }
});

app.put('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    const product = findProductById(id);
    if (product) {
        Object.assign(product, req.body);

        try {
            writeProductsToFile(products);
            res.json(product);
        } catch (err) {
            console.error('Error writing to products.json:', err);
            res.status(500).json({ message: 'Internal server error' });
        }
    } else {
        res.status(404).json({ message: 'Product not found' });
    }
});

app.delete('/api/products/:id', (req, res) => {
    products = products.filter(p => p.id !== +req.params.id);

    try {
        writeProductsToFile(products);
        res.status(204).send();
    } catch (err) {
        console.error('Error writing to products.json:', err);
        res.status(500).json({ message: 'Internal server error' });
    }
});

app.listen(3000, () => console.log("Server ready on port 3000."));

module.exports = app;
