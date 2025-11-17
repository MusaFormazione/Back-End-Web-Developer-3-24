# 06 — Parametri di route

Obiettivo: usare parametri obbligatori/opzionali e constraints.

Tipi di parametri
- Obbligatori: {id}
- Opzionali: {id?} (gestisci default nell'handler)
- Constraints: where(), whereNumber(), whereAlpha(), whereUuid(), whereIn()

Esempi (Sakila)
```php
// Parametro obbligatorio numerico
Route::get('/actors/{id}', function (int $id) {
    return "Actor ID: $id";
})->whereNumber('id');

// Parametro opzionale
Route::get('/films/{year?}', function (?int $year) {
    return $year ? "Film del $year" : 'Tutti i film';
})->whereNumber('year');

// Regex custom
Route::get('/categories/{name}', function (string $name) {
    return ucfirst($name);
})->where('name', '[A-Za-z_\-]+');

// Pattern globale in AppServiceProvider::boot
use Illuminate\Support\Facades\Route as RouteFacade;
RouteFacade::pattern('actor', '[0-9]+');
```

Accesso ai parametri
```php
public function show(Request $request) {
    $id = $request->route('id');
}
```

Esercizi
1) Crea GET /films/year/{year} con whereNumber e mostra i film di quell'anno.
2) Definisci /categories/{name} con constraint alfabetico e gestisci 404 se non trovato.
3) Imposta un pattern globale per 'film' come numerico e testalo in due rotte diverse.
