<?php

// Comunicare con l'utente a terminale:
// STDIN in PHP è un canale di input standard, usato per leggere dati dalla tastiera quando esegui lo script da riga di comando.

echo "Dammi un valore: " . PHP_EOL;

// Questa riga blocca l'esecuzione finché l'utente non digita qualcosa e preme Invio, poi salva quel testo (con \n alla fine) nella variabile $input.
$value = fgets(STDIN); // o trim(fgets(STDIN)) che elimina eventuali spazi o altri caratteri di formattazione attorno alla valore trasmesso

// Quando l'utente invia un elemento, questo viene assegnato alla variabile $value, ed è disponibile nel resto dello script
echo "Mi hai dato $value";




