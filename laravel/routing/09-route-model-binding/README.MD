# 09 — Route Model Binding

Obiettivo: risolvere automaticamente i parametri di route in modelli Eloquent.

Tipi
- Implicito: {actor} -> Actor $actor (per chiave primaria)
- Esplicito: definisci come risolvere (per colonne custom, es. film_id)
- Scoped bindings: vincola il figlio al genitore nelle rotte annidate

Esempi (Sakila)
```php
use App\Models\Actor;
use App\Http\Controllers\ActorController;

// Implicito: {actor} risolto per PK (actor_id se definito nel modello)
Route::get('/actors/{actor}', [ActorController::class, 'show']);

// Controller
public function show(Actor $actor) {
    return view('actors.show', compact('actor'));
}

// Esplicito: bind per Film cercando per film_id (colonna custom)
use Illuminate\Support\Facades\Route;
Route::bind('film', function ($value) {
    return \App\Models\Film::where('film_id', $value)->firstOrFail();
});
Route::get('/films/{film}', [\App\Http\Controllers\FilmController::class, 'show']);

// Scoped bindings
Route::scopeBindings()->group(function () {
    Route::get('/actors/{actor}/films/{film}', [\App\Http\Controllers\ActorFilmController::class, 'show']);
});
```

Note
- 404 automatico se il modello non viene trovato.
- Per cambiare la chiave di route del modello, imposta getRouteKeyName() nel modello.

Esercizi
1) Implementa show(Actor $actor) e verifica il 404 per ID inesistente.
2) Imposta getRouteKeyName() su Film per usare 'film_id' o 'slug' e aggiorna la rotta.
3) Aggiungi una rotta annidata /categories/{category}/films/{film} con scoped bindings.
