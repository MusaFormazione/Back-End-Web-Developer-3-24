# 03 — Route methods (GET, POST, PUT, PATCH, DELETE, OPTIONS)

Obiettivo: usare i metodi della facade Route per mappare i verbi HTTP.

Metodi principali
- Route::get(), Route::post(), Route::put(), Route::patch(), Route::delete(), Route::options()
- Route::match(['get','post'], 'uri', ...)
- Route::any('uri', ...) — da evitare in produzione salvo casi specifici

Esempi (Sakila)
```php
use App\Http\Controllers\ActorController;

// Elenco attori
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');

// Creazione
Route::post('/actors', [ActorController::class, 'store'])->name('actors.store');

// Aggiornamento (PUT/PATCH)
Route::put('/actors/{actor}', [ActorController::class, 'update'])->name('actors.update');
Route::patch('/actors/{actor}', [ActorController::class, 'partialUpdate'])->name('actors.partial');

// Eliminazione
Route::delete('/actors/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');

// OPTIONS per CORS/preflight sulle API
Route::options('/actors', fn () => response('', 204));
```

Note
- HTML forms supportano nativamente solo GET/POST: per PUT/PATCH/DELETE usa @method('PUT') nei form Blade.
- Usa Resource Controllers: Route::resource('actors', ActorController::class) per CRUD completo.

Esercizi
1) Crea un Resource Controller per Category e monta Route::resource('categories', CategoryController::class).
2) Aggiungi una rotta Route::match(['get','post'],'/search/films', ...) che gestisca sia submit GET che POST.
3) Implementa PATCH per l'aggiornamento parziale del cognome di un attore.
