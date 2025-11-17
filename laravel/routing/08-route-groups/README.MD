# 08 — Route groups

Obiettivo: condividere middleware, prefissi di URI e nome, e namespace tra più route.

Esempi (Sakila)
```php
use App\Http\Controllers\ActorController;

// Gruppo admin protetto
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
        Route::get('/actors/create', [ActorController::class, 'create'])->name('actors.create');
        Route::post('/actors', [ActorController::class, 'store'])->name('actors.store');
    });

// Group per controller
Route::controller(ActorController::class)->group(function () {
    Route::get('/actors', 'index');
    Route::get('/actors/{actor}', 'show');
});

// Subdomain routing
Route::domain('api.example.com')->group(function () {
    Route::get('/films', [\App\Http\Controllers\Api\FilmController::class, 'index']);
});
```

Note
- I gruppi possono essere annidati: i prefissi (URI e name) si concatenano.
- Per API versioning: Route::prefix('api/v1')->group(...).

Esercizi
1) Crea un gruppo admin con prefix admin e name admin., aggiungi CRUD categories.
2) Crea un gruppo api/v1 e sposta dentro gli endpoint Film e Actor JSON.
3) Usa Route::scopeBindings() in un gruppo annidato per /actors/{actor}/films/{film}.
