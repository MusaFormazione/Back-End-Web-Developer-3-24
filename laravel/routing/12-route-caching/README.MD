# 12 — Route caching

Obiettivo: velocizzare il bootstrap dell'app serializzando le definizioni di route per l'ambiente di produzione.

Comandi
- php artisan route:cache   // crea la cache (production)
- php artisan route:clear   // rimuove la cache

Linee guida
- Evita closure nelle route se vuoi abilitare la cache: usa metodi di controller.
- Ricrea la cache dopo ogni modifica alle route durante il deploy.
- Combina con altre cache per massime performance: config:cache, view:cache.

Esempio pipeline deploy
```bash
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Esempio (Sakila)
```php
// routes/web.php — usare controller methods
use App\Http\Controllers\ActorController;
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
```

Diagnostica
- Se route:cache fallisce, cerca closure in routes/*.php o binding dinamici non serializzabili.
- Usa php artisan route:list per verificare le route effettive dopo la cache.

Esercizi
1) Rimuovi le closure dalle tue route e sostituiscile con controller; attiva route:cache.
2) Misura il tempo di risposta a caldo (senza/with cache) per /actors.
3) Scrivi uno script di deploy che includa config:cache, route:cache e view:cache.
