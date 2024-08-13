const express = require('express');
const app = express();

app.use(express.json());
app.use(require('cors')());

let products = [];

app.get('https://test223-six.vercel.app', (req, res) => res.json(products));

app.post('/api/products', (req, res) => {
    const newProduct = { id: products.length + 1, ...req.body };
    products.push(newProduct);
    res.status(201).json(newProduct);
});

app.put('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    const product = products.find(p => p.id === id);
    if (product) {
        Object.assign(product, req.body);
        res.json(product);
    } else {
        res.status(404).send('Product not found');
    }
});

app.delete('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    products = products.filter(p => p.id !== id);
    res.status(204).send();
});

app.listen(3000, () => console.log("Server ready on port 3000."));

module.exports = app;
