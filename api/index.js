const express = require('express');
const app = express();
const db = require('./db');  

app.use(express.json());
app.use(require('cors')());

const findProductById = (id, callback) => {
    db.query('SELECT * FROM xml WHERE id = ?', [id], (err, results) => {
        if (err) {
        return callback(err);
        }
        callback(null, results[0]);
    });
    }
  

app.get('/', (req, res) => {
  db.query('SELECT * FROM xml', (err, results) => {
    res.json(results || []);
  });
});

app.get('/api/products', (req, res) => {
  db.query('SELECT * FROM xml', (err, results) => {
    res.json(results || []);
  });
});

app.get('/api/products/:id', (req, res) => {
  const id = +req.params.id;
  findProductById(id, (err, product) => {
    res.json(product || {});
  });
});

app.post('/api/products', (req, res) => {
  const { name, price, description } = req.body;
  db.query('INSERT INTO xml (name, price, description) VALUES (?, ?, ?)', [name, price, description], (err, results) => {
    const newProduct = { id: results.insertId, name, price, description };
    res.status(201).json(newProduct);
  });
});

app.put('/api/products/:id', (req, res) => {
    const id = +req.params.id;
    const { name, price, description } = req.body;
    db.query('UPDATE xml SET name = ?, price = ?, description = ? WHERE id = ?', [name, price, description, id], (err, results) => {
        res.json({ id, name, price, description });
    });
    });
  
  
  

app.delete('/api/products/:id', (req, res) => {
  const id = +req.params.id;
  db.query('DELETE FROM xml WHERE id = ?', [id], (err, results) => {
    res.status(204).send();
  });
});

app.listen(3000, () => console.log('Server ready on port 3000.'));

module.exports = app;
