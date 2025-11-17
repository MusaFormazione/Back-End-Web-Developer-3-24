# 01 — Basi del routing

Obiettivo: capire cos'è il routing in Laravel 12, dove si definiscono le route e come funzionano.

Dove si definiscono le route
- routes/web.php: rotte per il web (HTML, sessioni, CSRF). Middleware group: web
- routes/api.php: rotte API (stateless, JSON). Middleware group: api. Prefisso automatico /api

Esempi minimi
```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// routes/api.php
use Illuminate\Support\Facades\Route;

Route::get('/status', fn () => response()->json(['ok' => true]));
```

Concetti chiave
- Una route mappa Metodo + URI -> Azione (closure o Controller@metodo)
- Middleware: logica eseguita prima/dopo l'azione (auth, throttle, ecc.)
- Output tipico: HTML (web) o JSON (api)

Esercizi
1) Crea una route GET /hello che restituisce un semplice blade con "Ciao Sakila".
2) Aggiungi una route API GET /ping che ritorna { "pong": true }.
3) Apri php artisan route:list e individua le due nuove route create.
