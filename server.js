const express = require('express');
const bodyParser = require('body-parser');
const { Pool } = require('pg');

const app = express();
const port = 3000;

// Verbindung zur PostgreSQL-Datenbank
const pool = new Pool({
    user: 'postgres',
    host: 'localhost',
    database: 'KUNDEN',
    password: 'erdush123',
    port: 5432,
});

const cors = require('cors');
app.use(cors());

// Middleware
app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

// Statischen Dateien dienen (für Ihr HTML, CSS, JS, etc.)
app.use(express.static('path_to_your_static_files'));

// Route für den Login
//app.post('/login', async(req, res) => {
//    const { benutzername, password } = req.body;
//    try {
//        const result = await pool.query('SELECT * FROM Kundendaten WHERE benutzername = $1 AND password = $2', [benutzername, password]);
//       if (result.rows.length > 0) {
//          // Benutzer gefunden
//           res.redirect('/hauptseite.html');
//        } else {
//            // Benutzer nicht gefunden oder Passwort falsch
//            res.send('Login fehlgeschlagen');
//        }
//    } catch (err) {
//        console.error(err);
//        res.send('Ein Fehler ist aufgetreten');
//    }
//});
app.post('/login', async(req, res) => {
    res.send('Login Route erreicht');
});

app.listen(port, () => {
    console.log(`Server läuft auf http://localhost:${port}`);
});