const { Client } = require('pg')

const client = new Client({
    host: "localhost",
    user: "postgres",
    port: 5432,
    password: "erdush123",
    database: "KUNDEN"
})

client.connect();

client.query("Select * From Kundendaten"), (err, res) => {
    if (!err) {
        console.log(res.rows);
    } else {
        console.log(err.mesage);
    }
    client.end;
}