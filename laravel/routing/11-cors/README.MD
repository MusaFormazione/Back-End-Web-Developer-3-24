# 11 — CORS (Cross-Origin Resource Sharing)

Obiettivo: permettere alle API di essere chiamate da domini diversi (frontend separato).

Configurazione (Laravel 12)
- File: config/cors.php
- Middleware: \Fruitcake\Cors\HandleCors è abilitato globalmente

Chiavi principali in config/cors.php
```php
return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000','http://127.0.0.1:5173'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
```

Gestione preflight
- Le richieste OPTIONS vengono gestite dal middleware. Puoi definire Route::options('/endpoint', fn () => response('',204)) se necessario.

Esempio (Sakila API)
```php
// routes/api.php
use App\Http\Controllers\Api\ActorController;
Route::get('/actors', [ActorController::class, 'index']);
```

Best practice
- In produzione restringi allowed_origins ai domini reali.
- Evita '*" insieme a supports_credentials=true.
- Versiona l'API: prefix api/v1.

Esercizi
1) Configura CORS per permettere richieste dal tuo frontend (porta 3000/5173).
2) Testa una richiesta fetch dal browser verso /api/films e verifica gli header Access-Control-Allow-*.
3) Prova a impostare supports_credentials=true e spiega le implicazioni su cookie/SameSite.
