import mysql from 'mysql2/promise';

process.argv;

const [,,userName, password] = process.argv;

const connection = await mysql.createConnection({
    host: 'localhost',
    user: userName,
    password: password,
    //database: 'sakila',
    port: 3307
});

console.log(`Connection id: ${connection.threadId}`)

connection.threadId

const [results] = await connection.query('SELECT first_name, last_name FROM sakila.actor LIMIT 5;');

console.table(results);

connection.end();