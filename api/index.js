const express = require("express");
const fs = require("fs");
const path = require("path");
const app = express();

app.use(express.json());
app.use(require('cors')());

const dataFilePath = path.join(__dirname, 'products.json');

let products = [];

// Read products from file
const loadProducts = () => {
    if (fs.existsSync(dataFilePath)) {
        const fileContent = fs.readFileSync(dataFilePath);
        products = JSON.parse(fileContent);
    } else {
        products = [
            { id: 1, name: 'meeeeep', price: 1.99, description: "hejsansvensjan" },
            { id: 2, name: 'moooop', price: 0.99, description: "meeoppp" }
        ];
        saveProducts();
    }
};

// Save products to file
const saveProducts = () => {
    fs.writeFileSync(dataFilePath, JSON.stringify(products, null, 2));
};

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
    saveProducts();  // Save to file
    res.status(201).json(newProduct);
});

app.put('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    const product = findProductById(id);
    if (product) {
        Object.assign(product, req.body);
        saveProducts();  // Save to file
    }
    res.json(product || {});
});

app.delete('/api/products/:id', (req, res) => {
    products = products.filter(p => p.id !== +req.params.id);
    saveProducts();  // Save to file
    res.status(204).send();
});

app.listen(3000, () => {
    loadProducts();  // Load products from file on startup
    console.log("Server ready on port 3000.");
});

module.exports = app;
