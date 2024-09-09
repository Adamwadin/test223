const fs = require('fs');
const express = require("express");
const app = express();

app.use(express.json());
app.use(require('cors')());


const productsFilePath = path.join(__dirname, 'products.json');

let products = [
    { id: 1, name: 'meeeeep', price: 1.99, description: "hejsansvensjan" },
    { id: 2, name: 'moooop', price: 0.99, description: "meeoppp" }
];

const findProductById = id => products.find(p => p.id === id);

app.get('/', (req, res) => res.json(products));

app.get('/api/products', (req, res) => res.json(products));

app.get('/api/products/:id', (req, res) => {
    const product = findProductById(+req.params.id);
    res.json(product || {});
});

app.post('/api/products', (req, res) => {
    fs.readFile(productsFilePath, 'utf8', (err, data) => {
        if (err) {
            return res.status(500).json({ error: 'Error reading products file' });
        }

        let products;
        try {
            products = JSON.parse(data);
        } catch (parseError) {
            return res.status(500).json({ error: 'Error parsing products data' });
        }

        const newProduct = { id: products.length + 1, ...req.body };
        products.push(newProduct);

        fs.writeFile(productsFilePath, JSON.stringify(products, null, 2), 'utf8', (writeError) => {
            if (writeError) {
                return res.status(500).json({ error: 'Error writing to products file' });
            }

            res.status(201).json(newProduct);
        });
    });
});
app.put('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    const product = findProductById(id);
    if (product) Object.assign(product, req.body);
    res.json(product || {});
});

app.delete('/api/products/:id', (req, res) => {
    products = products.filter(p => p.id !== +req.params.id);
    res.status(204).send();
});

app.listen(3000, () => console.log("Server ready on port 3000."));

module.exports = app;
